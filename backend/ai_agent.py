import os
import requests
import json
import logging

logger = logging.getLogger(__name__)

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
        "stream": False,
        "options": {
            "repeat_penalty": 1.3,   # cegah pengulangan kata/frasa
            "temperature": 0.65,     # kreativitas sedang, lebih konsisten
            "top_p": 0.9,
        }
    }
    
    try:
        logger.info(f"[Ollama] Memanggil model '{MODEL_NAME}' | prompt: {prompt[:80]!r}...")
        response = requests.post(OLLAMA_API_URL, json=payload, timeout=120)
        response.raise_for_status()
        data = response.json()
        result = data.get("response", "").strip()
        if not result:
            logger.warning("[Ollama] Model mengembalikan respons KOSONG!")
        else:
            logger.info(f"[Ollama] Respons OK ({len(result)} karakter): {result[:100]!r}...")
        return result
    except requests.exceptions.ConnectionError:
        logger.error("[Ollama] ERROR: Aplikasi Ollama belum menyala atau belum di-install.")
        return None
    except requests.exceptions.Timeout:
        logger.error("[Ollama] ERROR: Request timeout setelah 120 detik.")
        return None
    except Exception as e:
        logger.error(f"[Ollama] ERROR tidak terduga: {e}")
        return None

def clean_chinese_characters(text: str) -> str:
    """Hapus semua karakter Hanzi/Mandarin dari teks jika AI mengalami kebocoran bahasa."""
    import re
    # Menghapus karakter dalam range Unicode CJK Unified Ideographs
    cleaned = re.sub(r'[\u4e00-\u9fff]+', '', text)
    # Bersihkan spasi ganda horizontal saja (tanpa menghapus enter/newline \n)
    return re.sub(r'[ \t]+', ' ', cleaned).strip()


def extract_intent(user_message: str):
    """
    [STEP 1] Menggunakan Ollama untuk mengekstrak intent dan nomor pelanggan.
    Tugasnya HANYA klasifikasi NLU — murni JSON output, bukan generate teks balasan.
    """
    system_instruction = """
Kamu adalah AI Klasifikasi NLU (Natural Language Understanding).
Tugasmu HANYA mengklasifikasikan pesan user ke dalam salah satu KATEGORI berikut:

KATEGORI:
- "SAPAAN": Jika user hanya menyapa (halo, hai, selamat pagi).
- "CARA_BAYAR": HANYA jika user bertanya TENTANG METODE ATAU TEMPAT PEMBAYARAN (contoh: "bayarnya dimana", "gimana cara bayar").
- "CEK_TAGIHAN": Jika user membahas "cek tagihan", "cara cek tagihan", "jumlah tagihan", atau menyebutkan angka nomor pelanggan.
- "OUT_OF_CONTEXT": Jika pesan SAMA SEKALI TIDAK ADA HUBUNGANNYA dengan PDAM (contoh: politik, presiden, koding, sejarah, matematika, cuaca).
- "LIHAT_NOMER": Jika user bertanya tentang nomor pelanggan pdam
- "LAPOR_KELUHAN": Jika user ingin mengadu, mengeluhkan layanan air mati, air keruh, pipa bocor, meteran rusak, atau ingin membuat pengaduan keluhan pelanggan.

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

CONTOH 8:
User: "lihat tagihan aku dong"
Output: {"intent": "CEK_TAGIHAN", "nolangg": null}

CONTOH 9:
User: "saya lupa nomor pelanggan saya, cara melihatnya gimana ya?"
Output: {"intent": "LIHAT_NOMER", "nolangg": null}

CONTOH 10:
User: "nomor pdam bisa dilihat di mana?"
Output: {"intent": "LIHAT_NOMER", "nolangg": null}

CONTOH 11:
User: "air di rumah saya mati sudah 3 hari"
Output: {"intent": "LAPOR_KELUHAN", "nolangg": null}

CONTOH 12:
User: "saya mau melaporkan keluhan pelanggan"
Output: {"intent": "LAPOR_KELUHAN", "nolangg": null}

CONTOH 13:
User: "air pdam keruh dan kotor sekali"
Output: {"intent": "LAPOR_KELUHAN", "nolangg": null}
"""
    # Prompting model untuk klasifikasi
    text_response = call_ollama(prompt=user_message, system_prompt=system_instruction)
    
    if text_response is None:
        return {"intent": "ERROR", "reply": "Maaf, sistem AI lokal (Ollama) sedang mati atau belum di-install."}

    # Bersihkan response dari karakter Mandarin jika bocor
    text_response = clean_chinese_characters(text_response)

    # Bersihkan markdown json jika AI tetap memberikannya
    if text_response.startswith("```json"):
        text_response = text_response[7:-3].strip()
    elif text_response.startswith("```"):
        text_response = text_response[3:-3].strip()

    # Ekstrak string JSON murni di antara { dan }
    import re
    start = text_response.find('{')
    end = text_response.rfind('}')
    if start != -1 and end != -1 and start < end:
        json_str = text_response[start:end+1]
    else:
        json_str = text_response

    intent = "OUT_OF_CONTEXT"
    nolangg = None
    parsed_successfully = False

    try:
        data = json.loads(json_str)
        # Bersihkan key dan value dari whitespace liar
        clean_data = {}
        for k, v in data.items():
            clean_k = k.strip()
            clean_v = v.strip() if isinstance(v, str) else v
            clean_data[clean_k] = clean_v
        
        intent = clean_data.get("intent", "OUT_OF_CONTEXT")
        nolangg = clean_data.get("nolangg")
        parsed_successfully = True
    except Exception as e:
        logger.warning(f"[extract_intent] Gagal parse JSON ({e}). Menggunakan regex fallback...")
        
        # Fallback 1: Cari kata kunci intent di dalam response mentah
        upper_resp = text_response.upper()
        if "CEK_TAGIHAN" in upper_resp:
            intent = "CEK_TAGIHAN"
        elif "LIHAT_NOMER" in upper_resp:
            intent = "LIHAT_NOMER"
        elif "CARA_BAYAR" in upper_resp:
            intent = "CARA_BAYAR"
        elif "SAPAAN" in upper_resp:
            intent = "SAPAAN"
        elif "LAPOR_KELUHAN" in upper_resp or "COMPLAINT" in upper_resp:
            intent = "LAPOR_KELUHAN"

    # Fallback tambahan berbasis kata kunci langsung dari input user untuk lapor keluhan
    user_msg_upper = user_message.upper()
    if any(keyword in user_msg_upper for keyword in ["LAPOR", "KELUHAN", "ADUAN", "KOMPLAIN", "MATI", "KERUH", "BOCOR", "RUSAK"]):
        intent = "LAPOR_KELUHAN"

    # Fallback 2: Cari nomor pelanggan (8 digit angka) dari pesan user secara mandiri
    # Ini sangat aman karena regex lebih terpercaya dibanding AI mengekstrak angka
    num_match = re.search(r'\b\d{8,}\b', user_message)
    if num_match and intent != "LAPOR_KELUHAN":
        nolangg = num_match.group(0)
        # Jika ada nomor pelanggan, pastikan intent dipaksa ke CEK_TAGIHAN
        intent = "CEK_TAGIHAN"

    # Buat dictionary data akhir
    data = {"intent": intent, "nolangg": nolangg}

    try:
        # [STEP 2a] Generate balasan natural via AI berdasarkan intent
        if intent == "SAPAAN":
            data["intent"] = "GENERAL"
            data["reply"] = generate_general_response(user_message, "SAPAAN")
        elif intent == "CARA_BAYAR":
            data["intent"] = "GENERAL"
            data["reply"] = generate_general_response(user_message, "CARA_BAYAR")
        elif intent == "OUT_OF_CONTEXT":
            data["intent"] = "GENERAL"
            data["reply"] = generate_general_response(user_message, "OUT_OF_CONTEXT")
        elif intent == "LIHAT_NOMER":
            data["intent"] = "GENERAL"
            data["reply"] = generate_general_response(user_message, "LIHAT_NOMER")
        elif intent == "LAPOR_KELUHAN":
            data["intent"] = "LAPOR_KELUHAN"
            data["reply"] = "Memulai alur pelaporan keluhan pelanggan..."
        elif intent == "CEK_TAGIHAN":
            if not data.get("nolangg"):
                data["intent"] = "CEK_TAGIHAN"
                data["reply"] = generate_general_response(user_message, "CEK_TAGIHAN")
            else:
                data["reply"] = "Sedang mengecek tagihan..."
                
        return data
    except Exception as e:
        logger.error(f"[extract_intent] Gagal memproses Step 2a: {e}")
        return {"intent": "GENERAL", "reply": "Maaf, terjadi kesalahan pemrosesan AI."}


def generate_general_response(user_message: str, intent: str) -> str:
    """
    [STEP 2a — Two-Step RAG] Generate balasan natural untuk intent umum.
    AI diberi konteks faktual yang sudah pasti benar → AI hanya menyusun kalimat.
    Jika AI gagal, fallback ke teks statis sebagai safety net.
    """
    # Konteks faktual yang diberikan ke AI (bukan dari memori AI — jadi anti-halusinasi)
    konteks_map = {
        "SAPAAN": (
            "User menyapa bot PDAM. Balas dengan hangat dan ramah sebagai Asisten Virtual "
            "PDAM Purbalingga. Sebutkan bahwa kamu bisa bantu cek tagihan dan info pembayaran."
        ),
        "CARA_BAYAR": (
            "User bertanya cara bayar tagihan PDAM. Informasi pembayaran yang BENAR dan harus "
            "kamu sampaikan: ATM (semua bank), Alfamart, Indomaret, Mobile Banking/Internet Banking, "
            "dan loket resmi PDAM Purbalingga. Sampaikan dengan jelas dan ramah."
        ),
        "OUT_OF_CONTEXT": (
            "User bertanya tentang topik yang SAMA SEKALI TIDAK berkaitan dengan PDAM, air, "
            "tagihan, atau pembayaran. "
            "WAJIB: Tolak dengan sopan dan jelaskan kamu HANYA bisa membantu layanan PDAM Purbalingga. "
            "LARANG KERAS: Jangan sarankan user untuk bertanya topik di luar PDAM. "
            "WAJIB diakhiri dengan: tawarkan bantuan cek tagihan atau info pembayaran PDAM."
        ),
        "LIHAT_NOMER": (
            "User bertanya cara melihat atau mencari tahu nomor pelanggan PDAM mereka yang lupa. "
            "Jelaskan bahwa nomor pelanggan PDAM Purbalingga dapat dilihat melalui beberapa cara berikut:\n"
            "1. Struk pembayaran bulan-bulan sebelumnya (tertera di bagian atas struk).\n"
            "2. Label/Stiker meteran air fisik yang terpasang di rumah (biasanya ada pelat besi kecil atau stiker bertuliskan nomor pelanggan/nomor seri meteran).\n"
            "3. Buku rekening/kartu pelanggan PDAM.\n"
            "4. Menghubungi Customer Service PDAM Purbalingga di kantor terdekat dengan membawa KTP pemilik meteran.\n"
            "Sampaikan langkah-langkah ini dengan terstruktur, jelas, dan ramah."
        ),
        "CEK_TAGIHAN": (
            "User ingin cek tagihan tapi BELUM memberikan nomor pelanggan. "
            "Minta nomor pelanggan dengan ramah. Nomor pelanggan biasanya 8 digit angka "
            "dan tertera di struk pembayaran atau kartu pelanggan PDAM."
        ),
    }

    konteks = konteks_map.get(intent, "")

    system_prompt = (
        "Kamu adalah Asisten Virtual PDAM Purbalingga yang ramah, sopan, dan profesional.\n"
        "ATURAN WAJIB:\n"
        "1. Balas HANYA dalam Bahasa Indonesia yang baik dan benar.\n"
        "2. DILARANG KERAS menggunakan kata atau karakter dalam Bahasa Mandarin/Cina/Inggris.\n"
        "3. Maksimal 3 kalimat — jangan bertele-tele.\n"
        "4. Gunakan emoji 1-2 saja, jangan berlebihan.\n"
        "5. JANGAN ulangi kata atau frasa yang sama dalam satu balasan.\n"
        "6. JANGAN menawarkan atau menyarankan topik yang tidak berhubungan dengan PDAM.\n"
        "7. JANGAN mencantumkan alamat kantor, nomor telepon, email, atau kontak layanan pelanggan jika tidak diberikan di dalam data/instruksi."
    )

    prompt = (
        f"Instruksi: {konteks}\n"
        f"Pesan user: \"{user_message}\"\n\n"
        "Tulis balasan singkat (maks 3 kalimat) dalam Bahasa Indonesia murni:"
    )

    response = call_ollama(prompt=prompt, system_prompt=system_prompt)

    # Fallback statis jika Ollama gagal/timeout
    if not response:
        fallbacks = {
            "SAPAAN":        "Halo! 👋 Saya Asisten Virtual PDAM Purbalingga. Ada yang bisa saya bantu? Saya siap membantu cek tagihan atau info pembayaran Anda 😊",
            "CARA_BAYAR":    "Untuk pembayaran tagihan air PDAM, Anda bisa menggunakan ATM, Alfamart, Indomaret, Mobile Banking, atau langsung di loket resmi PDAM terdekat. 💳",
            "OUT_OF_CONTEXT":"Mohon maaf, saya hanya dapat melayani pertanyaan seputar layanan PDAM Purbalingga seperti cek tagihan dan informasi pembayaran. 🙏",
            "LIHAT_NOMER":   "Jika Anda lupa nomor pelanggan PDAM Purbalingga, Anda bisa melihatnya di:\n1. Struk/kuitansi pembayaran bulan sebelumnya.\n2. Kartu pelanggan atau buku rekening PDAM.\n3. Plat besi/stiker kecil pada unit meteran air fisik di rumah Anda.\n4. Datang langsung ke kantor PDAM Purbalingga terdekat untuk menanyakannya pada petugas dengan membawa KTP pemilik. 😊",
            "CEK_TAGIHAN":   "Untuk mengecek tagihan Anda, mohon kirimkan nomor pelanggan Anda ya. 💧 Nomor pelanggan biasanya 8 digit dan tertera di struk pembayaran Anda.",
        }
        return fallbacks.get(intent, "Maaf, terjadi kesalahan sistem. Silakan coba lagi.")

    response = clean_chinese_characters(response)
    return response


def generate_billing_response(user_message: str, billing_data: dict, nolangg: str):
    """
    [STEP 2b — Two-Step RAG] Generate balasan tagihan menggunakan AI.
    
    Alur:
    1. Data tagihan diambil dari DB (100% akurat, bukan dari memori AI)
    2. Data tersebut diberikan sebagai KONTEKS ke AI
    3. AI hanya bertugas menyusun kalimat yang natural — bukan mengingat/mengarang data
    
    Dengan cara ini: akurasi data terjamin, gaya bahasa tetap natural.
    Jika AI gagal, fallback ke format Python statis sebagai safety net.
    """
    # ── Kasus: nomor pelanggan tidak ditemukan ──
    if billing_data.get("status") == "not_found":
        system_prompt = (
            "Kamu adalah Asisten Virtual PDAM Purbalingga yang ramah.\n"
            "ATURAN WAJIB:\n"
            "1. Sampaikan informasi dengan sopan dalam Bahasa Indonesia.\n"
            "2. DILARANG KERAS menulis menggunakan Bahasa Mandarin/Cina.\n"
            "3. Gunakan emoji secukupnya.\n"
            "4. JANGAN mencantumkan alamat kantor, nomor telepon, email, atau kontak layanan pelanggan palsu/fiktif."
        )
        prompt = (
            f"Nomor pelanggan {nolangg} tidak ditemukan di database PDAM Purbalingga.\n"
            "Buat balasan pendek yang sopan, minta user memeriksa kembali nomornya, "
            "dan sarankan menghubungi kantor PDAM jika masih tidak ditemukan:"
        )
        response = call_ollama(prompt=prompt, system_prompt=system_prompt)
        if response:
            return clean_chinese_characters(response)
        return (
            f"Maaf, Nomor Pelanggan {nolangg} tidak ditemukan di sistem kami. 😔\n"
            "Harap periksa kembali nomor Anda atau hubungi kantor PDAM Purbalingga terdekat."
        )

    # ── Kasus: error database ──
    if billing_data.get("status") != "success":
        return "Maaf, gagal memproses data tagihan dari database. Silakan coba beberapa saat lagi."

    data_list = billing_data.get("data", [])

    # ── Kasus: pelanggan ada, tagihan lunas (tidak ada tunggakan) ──
    if not data_list:
        nama = billing_data.get("nama", "Pelanggan")
        system_prompt = (
            "Kamu adalah Asisten Virtual PDAM Purbalingga yang ramah.\n"
            "ATURAN WAJIB:\n"
            "1. Sampaikan kabar baik dengan antusias dalam Bahasa Indonesia.\n"
            "2. DILARANG KERAS menulis menggunakan Bahasa Mandarin/Cina.\n"
            "3. Gunakan emoji secukupnya."
        )
        prompt = (
            f"Data pelanggan:\n"
            f"- Nama: {nama}\n"
            f"- Nomor Pelanggan: {nolangg}\n"
            f"- Status tagihan: LUNAS (tidak ada tagihan tertunggak sama sekali)\n\n"
            "Buat balasan pendek yang menyenangkan karena pelanggan tidak memiliki tunggakan:"
        )
        response = call_ollama(prompt=prompt, system_prompt=system_prompt)
        if response:
            return clean_chinese_characters(response)
        return (
            f"Hore! 🎉 Tidak ada tagihan tertunggak untuk Bapak/Ibu {nama} "
            f"(Nomor: {nolangg}). Tagihan Anda sudah lunas! Terima kasih. 🙏"
        )

    # ── Kasus: ada tagihan tertunggak ──
    # Siapkan data terstruktur (Python yang hitung angkanya — bukan AI!)
    nama   = data_list[0].get("nama", "Pelanggan")
    alamat = data_list[0].get("alamat", "-")

    bulan_dict = {
        "01": "Januari", "02": "Februari", "03": "Maret",    "04": "April",
        "05": "Mei",      "06": "Juni",     "07": "Juli",     "08": "Agustus",
        "09": "September","10": "Oktober",  "11": "November", "12": "Desember"
    }

    rincian_lines = []
    total_semua = 0.0
    for row in data_list:
        periode_raw = str(row.get("PERIODE", ""))
        if len(periode_raw) == 6:
            tahun  = periode_raw[:4]
            bulan  = periode_raw[4:]
            periode_str = f"{bulan_dict.get(bulan, bulan)} {tahun}"
        else:
            periode_str = periode_raw

        total = float(row.get("TOTAL", 0))
        total_semua += total
        rupiah_format = f"{total:,.0f}".replace(",", ".")
        rincian_lines.append(f"  💧 {periode_str}: Rp {rupiah_format}")

    total_format   = f"{total_semua:,.0f}".replace(",", ".")
    rincian_text   = "\n".join(rincian_lines)

    # Berikan data ke AI — AI hanya menyusun kalimat, TIDAK menghitung ulang
    system_prompt = (
        "Kamu adalah Asisten Virtual PDAM Purbalingga yang ramah dan profesional.\n"
        "Tugasmu: Sampaikan informasi tagihan berdasarkan data yang sudah diberikan.\n"
        "ATURAN WAJIB:\n"
        "1. Gunakan PERSIS angka yang ada di data — JANGAN ubah, tambah, atau kurangi angka apapun.\n"
        "2. Tampilkan semua rincian periode yang ada di data.\n"
        "3. Gunakan Bahasa Indonesia yang hangat dan profesional.\n"
        "4. DILARANG KERAS menulis dalam Bahasa lain selain Bahasa Indonesia.\n"
        "5. Akhiri dengan informasi cara pembayaran.\n"
        "6. Gunakan emoji secukupnya agar terasa ramah.\n"
        "7. JANGAN mencantumkan alamat kantor, nomor telepon, email, atau kontak layanan pelanggan jika tidak diberikan di dalam data."
    )

    prompt = (
        f"Data tagihan dari database PDAM (GUNAKAN PERSIS DATA INI):\n"
        f"- Nama Pelanggan : {nama}\n"
        f"- Nomor Pelanggan: {nolangg}\n"
        f"- Alamat         : {alamat}\n"
        f"- Rincian Tagihan Belum Lunas:\n{rincian_text}\n"
        f"- Total Keseluruhan: Rp {total_format}\n\n"
        f"Pesan asli dari user: \"{user_message}\"\n\n"
        "Buat balasan yang natural dan informatif berdasarkan data di atas:"
    )

    response = call_ollama(prompt=prompt, system_prompt=system_prompt)

    # Fallback Python statis jika AI gagal/timeout
    if not response:
        logger.warning("[generate_billing_response] AI gagal → menggunakan PYTHON STATIS sebagai fallback")
        reply  = f"Halo Bpk/Ibu {nama},\n"
        reply += f"Berikut rincian tagihan air untuk Nomor Pelanggan {nolangg} ({alamat}):\n\n"
        reply += rincian_text + "\n\n"
        reply += f"💰 Total Tagihan: Rp {total_format}\n\n"
        reply += "Silakan lakukan pembayaran melalui ATM, Alfamart, atau loket resmi terdekat. Terima kasih! 🙏"
        return reply

    # Bersihkan karakter mandarin jika tergenerasi secara tidak sengaja
    response = clean_chinese_characters(response)

    logger.info(f"[generate_billing_response] ✅ AI berhasil generate respons ({len(response)} karakter)")
    return response
