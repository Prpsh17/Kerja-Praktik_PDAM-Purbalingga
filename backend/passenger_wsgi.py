"""
passenger_wsgi.py
─────────────────────────────────────────────
Entry point untuk cPanel Python App (Phusion Passenger).

Phusion Passenger menggunakan antarmuka WSGI, sementara FastAPI
adalah aplikasi ASGI. File ini menjembatani keduanya menggunakan
library a2wsgi (ASGIMiddleware).

Cara kerja:
  Internet → Apache (cPanel) → Passenger → passenger_wsgi.py → FastAPI

CATATAN: File ini hanya dipakai saat deploy di cPanel.
         Untuk pengembangan lokal, tetap jalankan: python main.py
─────────────────────────────────────────────
"""

import sys
import os

# ── Pastikan direktori backend ada di Python path ──────────────────
# cPanel menjalankan Passenger dari direktori yang mungkin berbeda,
# sehingga kita perlu mendaftarkan direktori ini secara eksplisit.
APP_DIR = os.path.dirname(os.path.abspath(__file__))
if APP_DIR not in sys.path:
    sys.path.insert(0, APP_DIR)

# ── Muat variabel environment dari .env ────────────────────────────
# dotenv harus dimuat SEBELUM import apapun dari aplikasi,
# agar semua konfigurasi (DB, API Keys, dll.) sudah tersedia.
from dotenv import load_dotenv
load_dotenv(os.path.join(APP_DIR, '.env'))

# ── Import aplikasi FastAPI ─────────────────────────────────────────
from main import app as fastapi_app

# ── Jembatan ASGI → WSGI untuk Phusion Passenger ───────────────────
# Passenger mengharapkan objek WSGI bernama 'application'.
# a2wsgi mengonversi ASGI app (FastAPI) menjadi WSGI yang kompatibel.
from a2wsgi import ASGIMiddleware

application = ASGIMiddleware(fastapi_app)
