from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import uvicorn
from database import get_unpaid_billing
from ai_agent import extract_intent, generate_billing_response

app = FastAPI(title="PDAM Chatbot API")

# Setup CORS agar Frontend Laravel bisa memanggil API ini
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Dalam production, ganti dengan URL Laravel, misal ["http://localhost:8000"]
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

class ChatRequest(BaseModel):
    message: str

class ChatResponse(BaseModel):
    reply: str
    intent: str

@app.post("/api/chat", response_model=ChatResponse)
async def chat_endpoint(request: ChatRequest):
    user_msg = request.message
    
    # 1. Ekstrak Intent menggunakan Gemini
    ai_result = extract_intent(user_msg)
    intent = ai_result.get("intent", "GENERAL")
    nolangg = ai_result.get("nolangg")
    reply = ai_result.get("reply", "")
    
    # 2. Proses berdasarkan Intent
    if intent == "CEK_TAGIHAN":
        if not nolangg:
            # AI sudah membuat balasan meminta nomor pelanggan
            return ChatResponse(reply=reply, intent=intent)
            
        # Jika ada nomor pelanggan, cari di database
        db_result = get_unpaid_billing(nolangg)
        
        if db_result and db_result.get("status") == "success":
            # 3. Generate balasan natural menggunakan Gemini
            final_reply = generate_billing_response(user_msg, db_result, nolangg)
            return ChatResponse(reply=final_reply, intent=intent)
        else:
            return ChatResponse(reply="Maaf, terjadi kesalahan saat mengakses database tagihan.", intent=intent)
            
    elif intent == "GENERAL":
        return ChatResponse(reply=reply, intent=intent)
        
    elif intent == "ERROR":
        return ChatResponse(reply=reply, intent=intent)
        
    else:
        return ChatResponse(reply=reply if reply else "Maaf, saya tidak mengerti maksud Anda.", intent=intent)

if __name__ == "__main__":
    uvicorn.run("main:app", host="0.0.0.0", port=8001, reload=True)
