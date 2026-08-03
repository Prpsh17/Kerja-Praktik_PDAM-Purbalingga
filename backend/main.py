from fastapi import FastAPI, HTTPException, Security, Request
from fastapi.middleware.cors import CORSMiddleware
from fastapi.security.api_key import APIKeyHeader
from pydantic import BaseModel, Field, field_validator
from slowapi import Limiter, _rate_limit_exceeded_handler
from slowapi.util import get_remote_address
from slowapi.errors import RateLimitExceeded
import uvicorn
import os
import re
import logging
from dotenv import load_dotenv
from database import get_unpaid_billing
from ai_agent import extract_intent, generate_billing_response, check_thank_you, check_greeting

load_dotenv()

# ─────────────────────────────────────────────
# Logger
# ─────────────────────────────────────────────
logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

# ─────────────────────────────────────────────
# Rate Limiter (celah #2, #3 — slowapi)
# ─────────────────────────────────────────────
limiter = Limiter(key_func=get_remote_address)

app = FastAPI(
    title="PDAM Chatbot API",
    # Sembunyikan docs di production (opsional, aktifkan saat development saja)
    # docs_url=None,
    # redoc_url=None,
)

# Daftarkan rate limiter ke app state
app.state.limiter = limiter
app.add_exception_handler(RateLimitExceeded, _rate_limit_exceeded_handler)

# ─────────────────────────────────────────────
# CORS — Lebih ketat (celah #5)
# ─────────────────────────────────────────────
_raw_origins = [
    os.getenv("ALLOWED_ORIGIN_1", "http://localhost:8000"),
    os.getenv("ALLOWED_ORIGIN_2", ""),
    os.getenv("ALLOWED_ORIGIN_3", ""),
]
# Filter string kosong agar tidak menjadi wildcard tidak sengaja
allowed_origins = [o.strip() for o in _raw_origins if o.strip()]

app.add_middleware(
    CORSMiddleware,
    allow_origins=allowed_origins,
    allow_credentials=False,       # Diubah: tidak perlu cookie/session
    allow_methods=["POST", "GET"], # Diubah: hanya metode yang dipakai
    allow_headers=["Content-Type", "X-Admin-Key"], # Diubah: hanya header yang diperlukan
)

# ─────────────────────────────────────────────
# Admin API Key Auth (celah #1)
# ─────────────────────────────────────────────
ADMIN_API_KEY = os.getenv("ADMIN_API_KEY", "").strip()
api_key_header = APIKeyHeader(name="X-Admin-Key", auto_error=False)

async def verify_admin_key(api_key: str = Security(api_key_header)):
    """Dependency: validasi header X-Admin-Key untuk endpoint admin."""
    if not ADMIN_API_KEY:
        logger.error("ADMIN_API_KEY belum dikonfigurasi di .env!")
        raise HTTPException(status_code=503, detail="Endpoint admin tidak tersedia.")
    if api_key != ADMIN_API_KEY:
        logger.warning(f"Percobaan akses admin dengan key tidak valid: {str(api_key)[:8]}...")
        raise HTTPException(status_code=403, detail="Akses ditolak. API Key tidak valid.")

# ─────────────────────────────────────────────
# Validasi format nomor pelanggan (celah #8)
# ─────────────────────────────────────────────
NOLANGG_PATTERN = re.compile(r'^\d{7,12}$')

def validate_nolangg(nolangg: str) -> bool:
    """Memvalidasi bahwa nomor pelanggan hanya terdiri dari 7–12 digit angka."""
    return bool(NOLANGG_PATTERN.match(nolangg))

# ─────────────────────────────────────────────
# Pydantic Models
# ─────────────────────────────────────────────
class ChatRequest(BaseModel):
    message: str = Field(..., min_length=1, max_length=1000)

class ChatResponse(BaseModel):
    reply: str
    intent: str

class ComplaintRequest(BaseModel):
    # Celah #2: tambah batas panjang dan validasi format
    ComplianerName: str = Field(..., min_length=3, max_length=100)
    ComplianerAddress: str = Field(..., min_length=5, max_length=300)
    PhoneNumber: str = Field(..., min_length=8, max_length=15)
    CompliantContent: str = Field(..., min_length=10, max_length=2000)
    # Celah #9: InputedBy DIHAPUS dari model — di-hardcode di server

    @field_validator('PhoneNumber')
    @classmethod
    def validate_phone(cls, v: str) -> str:
        """Hanya perbolehkan digit, spasi, tanda +, dan tanda -."""
        if not re.match(r'^[0-9+\-\s]+$', v):
            raise ValueError('Nomor HP tidak valid. Hanya boleh berisi angka, +, -, atau spasi.')
        # Buang karakter non-digit untuk pengecekan panjang aktual
        digits_only = re.sub(r'\D', '', v)
        if len(digits_only) < 8 or len(digits_only) > 15:
            raise ValueError('Nomor HP harus memiliki 8 hingga 15 digit.')
        return v.strip()

    @field_validator('ComplianerName', 'ComplianerAddress', 'CompliantContent')
    @classmethod
    def strip_whitespace(cls, v: str) -> str:
        return v.strip()

class StatusRequest(BaseModel):
    ticket_number: str = Field(..., min_length=5, max_length=20)

    @field_validator('ticket_number')
    @classmethod
    def validate_ticket(cls, v: str) -> str:
        """Format tiket: DDMMYYYY-NNN (contoh: 01082026-001)."""
        if not re.match(r'^\d{8}-\d{1,5}$', v):
            raise ValueError('Format nomor tiket tidak valid.')
        return v.strip()

# ─────────────────────────────────────────────
# Endpoints
# ─────────────────────────────────────────────

@app.post("/api/chat", response_model=ChatResponse)
@limiter.limit("10/minute")  # Celah #3: maks 10 pesan per menit per IP
async def chat_endpoint(request: Request, body: ChatRequest):
    user_msg = body.message

    # 0. Cek ucapan terima kasih secara lokal (hemat token & respon instan)
    thank_you_reply = check_thank_you(user_msg)
    if thank_you_reply:
        return ChatResponse(reply=thank_you_reply, intent="GENERAL")

    # Cek ucapan sapaan/halo secara lokal
    greeting_reply = check_greeting(user_msg)
    if greeting_reply:
        return ChatResponse(reply=greeting_reply, intent="GENERAL")

    # 1. Ekstrak Intent menggunakan AI
    ai_result = extract_intent(user_msg)
    intent = ai_result.get("intent", "GENERAL")
    nolangg = ai_result.get("nolangg")
    reply = ai_result.get("reply", "")

    # 2. Proses berdasarkan Intent
    if intent == "CEK_TAGIHAN":
        if not nolangg:
            return ChatResponse(reply=reply, intent=intent)

        # Celah #8: Validasi format nolangg sebelum query ke database
        if not validate_nolangg(str(nolangg)):
            logger.warning(f"Format nolangg tidak valid diterima dari AI: {nolangg!r}")
            return ChatResponse(
                reply="Format nomor pelanggan tidak valid. Nomor pelanggan terdiri dari 7-12 digit angka.",
                intent="ERROR"
            )

        db_result = get_unpaid_billing(nolangg)
        if db_result:
            final_reply = generate_billing_response(user_msg, db_result, nolangg)
            return ChatResponse(reply=final_reply, intent=intent)
        else:
            return ChatResponse(
                reply="Maaf, terjadi kesalahan koneksi saat mengakses database tagihan.",
                intent=intent
            )

    elif intent == "GENERAL":
        return ChatResponse(reply=reply, intent=intent)

    elif intent == "LAPOR_KELUHAN":
        return ChatResponse(reply=reply, intent=intent)

    elif intent == "CEK_STATUS":
        from database import get_complaint_status
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
        return ChatResponse(
            reply=reply if reply else "Maaf, saya tidak mengerti maksud Anda.",
            intent=intent
        )


@app.post("/api/complaints")
@limiter.limit("3/minute")  # Celah #2: maks 3 laporan per menit per IP (anti-spam)
async def create_complaint_endpoint(request: Request, body: ComplaintRequest):
    from database import create_complaint
    try:
        ticket = create_complaint(
            body.ComplianerName,
            body.ComplianerAddress,
            body.PhoneNumber,
            body.CompliantContent,
            "web_chatbot"  # Celah #9: hardcode di server, tidak dari input user
        )
        if ticket:
            return {"status": "success", "ticket_number": ticket}
        else:
            logger.error("create_complaint mengembalikan None — gagal insert ke DB.")
            raise HTTPException(status_code=500, detail="Gagal menyimpan laporan keluhan.")
    except HTTPException:
        raise
    except Exception as e:
        # Celah #6: log detail ke server, pesan generik ke client
        logger.error(f"Error di create_complaint_endpoint: {e}")
        raise HTTPException(status_code=500, detail="Gagal menyimpan laporan keluhan.")


@app.post("/api/complaints/status")
@limiter.limit("20/minute")  # Rate limit ringan untuk pengecekan status
async def check_status_endpoint(request: Request, body: StatusRequest):
    from database import get_complaint_status
    try:
        result = get_complaint_status(body.ticket_number)
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
    except Exception as e:
        # Celah #6: log detail ke server, pesan generik ke client
        logger.error(f"Error di check_status_endpoint: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil status laporan.")


@app.post("/api/faqs/sync")
@limiter.limit("5/minute")  # Rate limit tambahan
async def sync_faqs_endpoint(request: Request, _: None = Security(verify_admin_key)):
    """
    Celah #1: Endpoint admin — hanya bisa dipanggil dengan header X-Admin-Key yang benar.
    Contoh: curl -X POST http://... -H 'X-Admin-Key: your_secret_key'
    """
    from ai_agent import load_faq_cache
    try:
        load_faq_cache()
        return {"status": "success", "message": "FAQ cache successfully reloaded from database."}
    except Exception as e:
        # Celah #6: log detail ke server, pesan generik ke client
        logger.error(f"Error saat sync FAQ cache: {e}")
        raise HTTPException(status_code=500, detail="Gagal memuat ulang cache FAQ.")


if __name__ == "__main__":
    # Celah #4: host="127.0.0.1" (bukan 0.0.0.0), reload=False di production
    uvicorn.run("main:app", host="127.0.0.1", port=8001, reload=False)
