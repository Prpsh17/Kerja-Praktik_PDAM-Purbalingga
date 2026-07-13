import os
import requests
import json

# Konfigurasi Ollama Local
OLLAMA_API_URL = "http://localhost:11434/api/generate"
# Rekomendasi model yang ringan untuk RAM 16GB dan VRAM 4GB
MODEL_NAME = "qwen2.5:3b"  # Anda juga bisa pakai "llama3.2:3b"

def call_ollama(prompt: str, system_prompt: str = ""):
    """Fungsi helper untuk menembak API lokal Ollama."""
    payload = {
        "model": MODEL_NAME,
        "prompt": prompt,
        "system": system_prompt,
        "stream": False
    }
    
    try:
        response = requests.post(OLLAMA_API_URL, json=payload, timeout=60)
        response.raise_for_status()
        data = response.json()
        return data.get("response", "").strip()
    except requests.exceptions.ConnectionError:
        print("Error: Aplikasi Ollama belum menyala atau belum di-install.")
        return None
    except Exception as e:
        print(f"Error calling Ollama: {e}")
        return None

def extract_intent(user_message: str):
    """
    Menggunakan Ollama untuk mengekstrak intent dan nomor pelanggan.
    Mengembalikan JSON string.
    """
    system_instruction = """
Kamu adalah AI Klasifikasi NLU (Natural Language Understanding).
Tugasmu HANYA mengklasifikasikan pesan user ke dalam salah satu KATEGORI berikut:

KATEGORI:
- "SAPAAN": Jika user hanya menyapa (halo, hai, selamat pagi).
- "CARA_BAYAR": HANYA jika user bertanya TENTANG METODE ATAU TEMPAT PEMBAYARAN (contoh: "bayarnya dimana", "gimana cara bayar").
- "CEK_TAGIHAN": Jika user membahas "cek tagihan", "cara cek tagihan", "jumlah tagihan", atau menyebutkan angka nomor pelanggan.
- "OUT_OF_CONTEXT": Jika pesan SAMA SEKALI TIDAK ADA HUBUNGANNYA dengan PDAM (contoh: politik, presiden, koding, sejarah, matematika, cuaca).

Output HANYA boleh berupa JSON murni dengan format:
{"intent": "NAMA_KATEGORI", "nolangg": "nomor_jika_ada_dan_berupa_angka_atau_null"}

CONTOH 1:
User: "hallo"
Output: {"intent": "SAPAAN", "nolangg": null}

CONTOH 2:
User: "siapa presiden indonesia"
Output: {"intent": "OUT_OF_CONTEXT", "nolangg": null}

CONTOH 3:
User: "apa itu looping"
Output: {"intent": "OUT_OF_CONTEXT", "nolangg": null}

CONTOH 4:
User: "tolong cek tagihan 01010007"
Output: {"intent": "CEK_TAGIHAN", "nolangg": "01010007"}

CONTOH 5:
User: "gimana cara bayarnya"
Output: {"intent": "CARA_BAYAR", "nolangg": null}

CONTOH 6: 
User: "cek tagihan bulan ini dong"
Output: {"intent": "CEK_TAGIHAN", "nolangg": null}

CONTOH 7:
User: "bagaimana cara cek tagihan"
Output: {"intent": "CEK_TAGIHAN", "nolangg": null}
"""
    
    # Prompting model
    text_response = call_ollama(prompt=user_message, system_prompt=system_instruction)
    
    if text_response is None:
        return {"intent": "ERROR", "reply": "Maaf, sistem AI lokal (Ollama) sedang mati atau belum di-install."}

    # Bersihkan markdown json jika AI tetap memberikannya
    if text_response.startswith("```json"):
        text_response = text_response[7:-3].strip()
    elif text_response.startswith("```"):
        text_response = text_response[3:-3].strip()
        
    try:
        data = json.loads(text_response)
        intent = data.get("intent", "OUT_OF_CONTEXT")
        
        # Hardcode respons berdasarkan klasifikasi agar 100% akurat dan anti-halusinasi
        if intent == "SAPAAN":
            data["intent"] = "GENERAL"
            data["reply"] = "Halo! Saya Asisten Virtual PDAM. Silakan ketik nomor pelanggan Anda untuk mengecek tagihan air bulan ini."
        elif intent == "CARA_BAYAR":
            data["intent"] = "GENERAL"
            data["reply"] = "Untuk pembayaran tagihan air PDAM, Anda bisa menggunakan ATM, Alfamart, Indomaret, Mobile Banking, atau langsung di loket resmi PDAM terdekat."
        elif intent == "OUT_OF_CONTEXT":
            data["intent"] = "GENERAL"
            data["reply"] = "Mohon maaf, saya adalah Asisten Virtual PDAM. Saya hanya dapat melayani pengecekan tagihan air dan layanan seputar PDAM."
        elif intent == "CEK_TAGIHAN":
            if not data.get("nolangg"):
                data["intent"] = "CEK_TAGIHAN"
                data["reply"] = "Mohon informasikan Nomor Pelanggan Anda (berupa angka) untuk pengecekan tagihan."
            else:
                data["reply"] = "Sedang mengecek tagihan..."
                
        return data
    except Exception as e:
        print(f"Error parsing JSON dari Ollama: {e}\nResponse Asli: {text_response}")
        # Fallback jika model membalas dengan teks biasa (bukan JSON)
        return {"intent": "GENERAL", "reply": text_response}

def generate_billing_response(user_message: str, billing_data: dict, nolangg: str):
    """
    Memformat data tagihan menggunakan kode Python (tanpa AI) agar 100% akurat, instan, dan bebas halusinasi.
    """
    if billing_data.get("status") != "success":
        return "Maaf, gagal memproses data tagihan dari database."
        
    data_list = billing_data.get("data", [])
    
    # Jika array data kosong
    if not data_list:
        return f"Hore! Tidak ada tagihan tertunggak untuk nomor pelanggan {nolangg}. Tagihan Anda sudah lunas bulan ini."
        
    # Ambil nama dan alamat dari record pertama
    nama = data_list[0].get("nama", "Pelanggan")
    alamat = data_list[0].get("alamat", "-")
    
    # Rangkai rincian bulan/periode
    rincian = []
    total_semua = 0
    for row in data_list:
        periode = str(row.get("PERIODE", ""))
        # Ubah 202606 menjadi Juni 2026 (Opsional, kalau ribet tampilkan saja apa adanya)
        total = float(row.get("TOTAL", 0))
        total_semua += total
        # Format angka menjadi rupiah e.g., 89650 -> 89.650
        rupiah_format = f"{total:,.0f}".replace(",", ".")
        rincian.append(f"• Periode {periode}: Rp {rupiah_format}")
        
    rincian_text = "\n".join(rincian)
    total_format = f"{total_semua:,.0f}".replace(",", ".")
    
    reply = f"Halo Bpk/Ibu *{nama}*,\n\n"
    reply += f"Berikut rincian tagihan air untuk Nomor Pelanggan {nolangg} ({alamat}):\n\n"
    reply += f"{rincian_text}\n\n"
    reply += f"**Total Tagihan: Rp {total_format}**\n\n"
    reply += "Silakan lakukan pembayaran melalui ATM, Alfamart, atau loket resmi terdekat. Terima kasih!"
    
    return reply
