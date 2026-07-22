#!/bin/bash
# ============================================================
# deploy.sh — Skrip deploy PDAM Chatbot ke VPS
# Jalankan script ini di VPS setelah upload kode:
#   chmod +x deploy.sh && sudo ./deploy.sh
# ============================================================

set -e  # Hentikan jika ada perintah yang gagal

echo "╔══════════════════════════════════════════════╗"
echo "║       PDAM Chatbot - VPS Deployment          ║"
echo "╚══════════════════════════════════════════════╝"

# ── Konfigurasi — EDIT SESUAI VPS KAMU ────────────────────
APP_DIR="/var/www/pdam-chatbot"
LOG_DIR="/var/log/pdam-chatbot"
SERVICE_NAME="pdam-chatbot"
NGINX_CONF_SOURCE="$APP_DIR/backend/nginx-chatbot.conf"
# ──────────────────────────────────────────────────────────

echo ""
echo "▶ [1/7] Membuat direktori aplikasi dan log..."
mkdir -p "$APP_DIR/backend"
mkdir -p "$LOG_DIR"
chown www-data:www-data "$LOG_DIR"

echo ""
echo "▶ [2/7] Membuat Python virtual environment..."
cd "$APP_DIR/backend"
if [ ! -d "venv" ]; then
    python3 -m venv venv
    echo "  → Virtual environment dibuat."
else
    echo "  → Virtual environment sudah ada, skip."
fi

echo ""
echo "▶ [3/7] Menginstall Python dependencies..."
source venv/bin/activate
pip install --upgrade pip -q
pip install -r requirements.txt -q
deactivate
echo "  → Dependencies terinstall."

echo ""
echo "▶ [4/7] Memverifikasi file .env backend..."
if [ ! -f "$APP_DIR/backend/.env" ]; then
    echo "  ⚠ FILE .env TIDAK DITEMUKAN!"
    echo "  → Salin .env.example ke .env dan isi dengan nilai produksi:"
    echo "     cp $APP_DIR/backend/.env.example $APP_DIR/backend/.env"
    echo "     nano $APP_DIR/backend/.env"
    exit 1
fi
echo "  → File .env ditemukan."

echo ""
echo "▶ [5/7] Menginstall systemd service..."
cp "$APP_DIR/backend/pdam-chatbot.service" "/etc/systemd/system/$SERVICE_NAME.service"
systemctl daemon-reload
systemctl enable "$SERVICE_NAME"
systemctl restart "$SERVICE_NAME"
sleep 2
if systemctl is-active --quiet "$SERVICE_NAME"; then
    echo "  ✅ Service '$SERVICE_NAME' berjalan."
else
    echo "  ❌ Service gagal berjalan. Cek log dengan:"
    echo "     journalctl -u $SERVICE_NAME -n 30"
    exit 1
fi

echo ""
echo "▶ [6/7] Petunjuk konfigurasi Nginx..."
echo "  → Tambahkan isi file berikut ke server block Nginx Laravel kamu:"
echo "     $NGINX_CONF_SOURCE"
echo "  → Kemudian jalankan: sudo nginx -t && sudo systemctl reload nginx"

echo ""
echo "▶ [7/7] Petunjuk update .env Laravel..."
echo "  → Di direktori Laravel, edit file .env dan ubah:"
echo "     CHATBOT_API_URL=https://pdampurbalingga.co.id/chatbot-api"
echo "  → Kemudian jalankan:"
echo "     php artisan config:clear"
echo "     php artisan view:clear"
echo "     php artisan cache:clear"

echo ""
echo "╔══════════════════════════════════════════════╗"
echo "║  ✅ Deployment selesai! Verifikasi manual:   ║"
echo "║  curl http://127.0.0.1:8001/docs             ║"
echo "║  systemctl status pdam-chatbot               ║"
echo "╚══════════════════════════════════════════════╝"
