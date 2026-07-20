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

class ComplaintRequest(BaseModel):
    ComplianerName: str
    ComplianerAddress: str
    PhoneNumber: str
    CompliantContent: str
    InputedBy: str = "web_chatbot"

class StatusRequest(BaseModel):
    ticket_number: str

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
        
        if db_result:
            # 3. Generate balasan natural (fungsi ini sudah menangani success, not_found, dan error)
            final_reply = generate_billing_response(user_msg, db_result, nolangg)
            return ChatResponse(reply=final_reply, intent=intent)
        else:
            return ChatResponse(reply="Maaf, terjadi kesalahan koneksi saat mengakses database tagihan.", intent=intent)
            
    elif intent == "GENERAL":
        return ChatResponse(reply=reply, intent=intent)
        
    elif intent == "LAPOR_KELUHAN":
        return ChatResponse(reply=reply, intent=intent)
        
    elif intent == "CEK_STATUS":
        from database import get_complaint_status
        import re
        ticket_match = re.search(r'\b\d{8}-\d+\b', user_msg)
        if ticket_match:
            ticket_number = ticket_match.group(0)
            result = get_complaint_status(ticket_number)
            if result:
                status_id = result.get("CompliantStatusId")
                status_name = "Dilaporkan"
                message = "Laporan Anda telah kami terima dan masuk dalam antrean sistem."
                
                if status_id == 2:
                    status_name = "Pengecekan"
                    message = "Petugas teknis kami sedang melakukan pengecekan di lokasi."
                elif status_id == 3:
                    status_name = "Pengerjaan"
                    message = "Laporan Anda sedang dalam proses perbaikan/pengerjaan oleh petugas lapangan."
                elif status_id == 4:
                    status_name = "Selesai"
                    message = "Laporan Anda sudah diselesaikan oleh petugas lapangan. Terima kasih."
                
                reply = (
                    f"🔍 **Hasil Pelacakan Laporan Keluhan**\n\n"
                    f"• Nomor Laporan: **{ticket_number}**\n"
                    f"• Status: **{status_name}**\n\n"
                    f"{message}"
                )
                return ChatResponse(reply=reply, intent=intent)
            else:
                reply = f"Nomor laporan **{ticket_number}** tidak ditemukan. Silakan periksa kembali nomor tiket Anda."
                return ChatResponse(reply=reply, intent=intent)
        else:
            return ChatResponse(reply="Format nomor tiket keluhan tidak valid.", intent=intent)
        
    elif intent == "ERROR":
        return ChatResponse(reply=reply, intent=intent)
        
    else:
        return ChatResponse(reply=reply if reply else "Maaf, saya tidak mengerti maksud Anda.", intent=intent)

@app.post("/api/complaints")
async def create_complaint_endpoint(request: ComplaintRequest):
    from database import create_complaint
    ticket = create_complaint(
        request.ComplianerName,
        request.ComplianerAddress,
        request.PhoneNumber,
        request.CompliantContent,
        request.InputedBy
    )
    if ticket:
        return {"status": "success", "ticket_number": ticket}
    else:
        raise HTTPException(status_code=500, detail="Gagal menyimpan laporan keluhan.")

@app.post("/api/complaints/status")
async def check_status_endpoint(request: StatusRequest):
    from database import get_complaint_status
    result = get_complaint_status(request.ticket_number)
    if result:
        status_id = result.get("CompliantStatusId")
        status_name = "Dilaporkan"
        message = "Laporan Anda telah kami terima dan masuk dalam antrean sistem."
        
        if status_id == 2:
            status_name = "Pengecekan"
            message = "Petugas teknis kami sedang melakukan pengecekan di lokasi."
        elif status_id == 3:
            status_name = "Pengerjaan"
            message = "Laporan Anda sedang dalam proses perbaikan/pengerjaan oleh petugas lapangan."
        elif status_id == 4:
            status_name = "Selesai"
            message = "Laporan Anda sudah diselesaikan oleh petugas lapangan. Terima kasih."
            
        return {
            "status_id": status_id,
            "status_name": status_name,
            "message": message
        }
    else:
        return {
            "status_id": None,
            "status_name": "Tidak Ditemukan",
            "message": "Nomor laporan tidak ditemukan. Silakan periksa kembali nomor tiket Anda."
        }

@app.post("/api/faqs/sync")
async def sync_faqs_endpoint():
    from ai_agent import load_faq_cache
    try:
        load_faq_cache()
        return {"status": "success", "message": "FAQ cache successfully reloaded from database."}
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal memuat ulang cache FAQ: {str(e)}")

if __name__ == "__main__":
    uvicorn.run("main:app", host="0.0.0.0", port=8001, reload=True)

