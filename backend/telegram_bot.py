import os
import logging
from dotenv import load_dotenv
from telegram import Update
from telegram.ext import (
    Application,
    CommandHandler,
    MessageHandler,
    filters,
    ContextTypes,
)
from ai_agent import extract_intent, generate_billing_response
from database import get_unpaid_billing

# ─────────────────────────────────────────────
# Setup
# ─────────────────────────────────────────────
load_dotenv()

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

TELEGRAM_BOT_TOKEN = os.getenv("TELEGRAM_BOT_TOKEN")


def clean_reply(text: str) -> str:
    """Bersihkan formatting Markdown dari output AI agar aman dikirim ke Telegram tanpa parse_mode."""
    import re
    # Hapus **bold**, *italic*, `code`, __underline__
    text = re.sub(r'\*\*(.*?)\*\*', r'\1', text)   # **bold** → teks biasa
    text = re.sub(r'__(.*?)__',     r'\1', text)   # __underline__ → teks biasa
    text = re.sub(r'\*(.*?)\*',     r'\1', text)   # *italic* → teks biasa
    text = re.sub(r'`(.*?)`',       r'\1', text)   # `code` → teks biasa
    return text.strip()

# ─────────────────────────────────────────────
# Handler: /start
# ─────────────────────────────────────────────
async def start_command(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    """Mengirim pesan sambutan ketika user mengetik /start."""
    user_name = update.effective_user.first_name or "Pelanggan"
    welcome_text = (
        f"👋 Halo, {user_name}!\n\n"
        "Saya adalah *Asisten Virtual PDAM Purbalingga* 💧\n\n"
        "Saya bisa membantu Anda:\n"
        "• Cek tagihan air berdasarkan nomor pelanggan\n"
        "• Informasi cara pembayaran tagihan\n\n"
        "Silakan kirim pesan Anda, atau ketik nomor pelanggan langsung untuk cek tagihan.\n\n"
        "_Contoh: \"cek tagihan 01010007\"_"
    )
    await update.message.reply_text(welcome_text, parse_mode="Markdown")


# ─────────────────────────────────────────────
# Handler: /help
# ─────────────────────────────────────────────
async def help_command(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    """Menampilkan panduan penggunaan bot."""
    help_text = (
        "📋 *Panduan Penggunaan Bot PDAM*\n\n"
        "*Perintah tersedia:*\n"
        "/start — Memulai bot & menampilkan sambutan\n"
        "/help  — Menampilkan panduan ini\n\n"
        "*Cara cek tagihan:*\n"
        "Ketik pesan seperti salah satu contoh berikut:\n"
        "• `cek tagihan 01010007`\n"
        "• `tagihan saya nomor 01010007`\n"
        "• `01010007` _(kirim nomor pelanggan langsung)_\n\n"
        "*Cara bayar tagihan:*\n"
        "Tanya saja: _\"bagaimana cara bayar tagihan?\"_"
    )
    await update.message.reply_text(help_text, parse_mode="Markdown")


# ─────────────────────────────────────────────
# Handler: Pesan teks biasa
# ─────────────────────────────────────────────
async def handle_message(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    """Memproses semua pesan teks masuk dari user."""
    user_msg = update.message.text
    chat_id = update.effective_chat.id

    logger.info(f"[Chat {chat_id}] Pesan masuk: {user_msg}")

    # Kirim indikator 'mengetik...' agar UX terasa responsif
    await context.bot.send_chat_action(chat_id=chat_id, action="typing")

    # 1. Ekstrak intent menggunakan AI (Ollama lokal)
    ai_result = extract_intent(user_msg)
    intent = ai_result.get("intent", "GENERAL")
    nolangg = ai_result.get("nolangg")
    reply = ai_result.get("reply", "")

    logger.info(f"[Chat {chat_id}] Intent: {intent} | NoLangg: {nolangg}")

    # 2. Proses berdasarkan intent
    if intent == "CEK_TAGIHAN":
        if not nolangg:
            # AI sudah membuatkan balasan meminta nomor pelanggan
            await update.message.reply_text(clean_reply(reply))
            return

        # Ada nomor pelanggan → cari di database
        await context.bot.send_chat_action(chat_id=chat_id, action="typing")
        db_result = get_unpaid_billing(nolangg)

        if db_result:
            final_reply = generate_billing_response(user_msg, db_result, nolangg)
            await update.message.reply_text(clean_reply(final_reply))
        else:
            await update.message.reply_text(
                "⚠️ Maaf, terjadi kesalahan koneksi saat mengakses database tagihan.\n"
                "Silakan coba beberapa saat lagi."
            )

    elif intent in ("GENERAL", "ERROR"):
        await update.message.reply_text(clean_reply(reply))

    else:
        fallback = reply if reply else "Maaf, saya tidak mengerti maksud Anda. Silakan coba lagi."
        await update.message.reply_text(clean_reply(fallback))


# ─────────────────────────────────────────────
# Handler: Error global
# ─────────────────────────────────────────────
async def error_handler(update: object, context: ContextTypes.DEFAULT_TYPE) -> None:
    """Mencatat error yang tidak tertangani."""
    logger.error(f"Update {update} menyebabkan error: {context.error}")


# ─────────────────────────────────────────────
# Main
# ─────────────────────────────────────────────
def main() -> None:
    if not TELEGRAM_BOT_TOKEN:
        logger.error(
            "TELEGRAM_BOT_TOKEN tidak ditemukan di file .env!\n"
            "Tambahkan: TELEGRAM_BOT_TOKEN=your_token_here"
        )
        return

    logger.info("🚀 Bot PDAM Telegram sedang berjalan (mode polling)...")

    # Bangun aplikasi bot
    application = Application.builder().token(TELEGRAM_BOT_TOKEN).build()

    # Daftarkan handler
    application.add_handler(CommandHandler("start", start_command))
    application.add_handler(CommandHandler("help", help_command))
    application.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, handle_message))
    application.add_error_handler(error_handler)

    # Mulai polling (blokir sampai Ctrl+C ditekan)
    application.run_polling(allowed_updates=Update.ALL_TYPES)


if __name__ == "__main__":
    main()
