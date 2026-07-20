import os
import requests
import json
import logging
from dotenv import load_dotenv

load_dotenv()

try:
    from faq_data import FAQ_LIST
except ImportError:
    FAQ_LIST = []

logger = logging.getLogger(__name__)

# Konfigurasi OpenRouter
OPENROUTER_API_KEY = os.getenv("OPENROUTER_API_KEY", "").strip()
OPENROUTER_MODEL = os.getenv("OPENROUTER_MODEL", "google/gemma-4-31b-it:free").strip()
OPENROUTER_EMBEDDING_MODEL = os.getenv("OPENROUTER_EMBEDDING_MODEL", "nvidia/nemotron-3-embed-1b:free").strip()

def call_llm(prompt: str, system_prompt: str = ""):
    """Fungsi helper untuk menembak API OpenRouter (Cloud)."""
    if not OPENROUTER_API_KEY:
        logger.error("[OpenRouter] ERROR: OPENROUTER_API_KEY tidak dikonfigurasi di berkas .env!")
        return None
        
    url = "https://openrouter.ai/api/v1/chat/completions"
    headers = {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
        "HTTP-Referer": "http://localhost:8001",
        "X-Title": "PDAM Purbalingga Chatbot"
    }
    payload = {
        "model": OPENROUTER_MODEL,
        "messages": [
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.65,
    }
    try:
        logger.info(f"[OpenRouter] Memanggil model '{OPENROUTER_MODEL}'...")
        response = requests.post(url, json=payload, headers=headers, timeout=120)
        response.raise_for_status()
        data = response.json()
        choices = data.get("choices", [])
        if choices:
            result = choices[0].get("message", {}).get("content", "").strip()
            logger.info(f"[OpenRouter] Respons OK ({len(result)} karakter)")
            return result
        else:
            logger.warning("[OpenRouter] Model mengembalikan pilihan kosong!")
            return None
    except requests.exceptions.HTTPError as http_err:
        error_detail = http_err.response.text
        try:
            error_json = http_err.response.json()
            error_detail = json.dumps(error_json, indent=2)
        except Exception:
            pass
        logger.error(f"[OpenRouter] HTTP ERROR {http_err.response.status_code}:\n{error_detail}")
        return None
    except Exception as e:
        logger.error(f"[OpenRouter] Gagal memanggil API: {e}.")
        return None


def get_openrouter_embedding(text: str) -> list:
    """Panggil OpenRouter Embeddings API untuk mendapatkan representasi vektor."""
    if not OPENROUTER_API_KEY:
        logger.error("[OpenRouter] ERROR: OPENROUTER_API_KEY tidak dikonfigurasi di berkas .env!")
        return []
        
    url = "https://openrouter.ai/api/v1/embeddings"
    headers = {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
        "HTTP-Referer": "http://localhost:8001",
        "X-Title": "PDAM Purbalingga Chatbot"
    }
    payload = {
        "model": OPENROUTER_EMBEDDING_MODEL,
        "input": text
    }
    try:
        logger.info(f"[OpenRouter] Memanggil embedding model '{OPENROUTER_EMBEDDING_MODEL}'...")
        response = requests.post(url, json=payload, headers=headers, timeout=60)
        response.raise_for_status()
        data = response.json()
        embedding = data["data"][0]["embedding"]
        logger.info(f"[OpenRouter] Embedding OK ({len(embedding)} dimensi)")
        return embedding
    except requests.exceptions.HTTPError as http_err:
        error_detail = http_err.response.text
        try:
            error_json = http_err.response.json()
            error_detail = json.dumps(error_json, indent=2)
        except Exception:
            pass
        logger.error(f"[OpenRouter] HTTP ERROR {http_err.response.status_code}:\n{error_detail}")
        return []
    except Exception as e:
        logger.error(f"[OpenRouter] Gagal mengambil embedding: {e}")
        return []


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
- "FAQ": Jika user menanyakan info umum seputar layanan PDAM (contoh: syarat pasang baru, ganti nama rekening, denda keterlambatan, pemutusan air, jam operasional kantor).

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

CONTOH 14:
User: "apa saja syarat pasang baru pdam?"
Output: {"intent": "FAQ", "nolangg": null}

CONTOH 15:
User: "kantor pdam purbalingga buka jam berapa?"
Output: {"intent": "FAQ", "nolangg": null}
"""
    # Prompting model untuk klasifikasi
    text_response = call_llm(prompt=user_message, system_prompt=system_instruction)
    
    if text_response is None:
        return {"intent": "ERROR", "reply": "Maaf, sistem kecerdasan buatan (OpenRouter) sedang bermasalah atau belum dikonfigurasi."}

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
        elif "FAQ" in upper_resp:
            intent = "FAQ"
        elif "LAPOR_KELUHAN" in upper_resp or "COMPLAINT" in upper_resp:
            intent = "LAPOR_KELUHAN"

    user_msg_upper = user_message.upper()
    
    # 1. Cek apakah ada kata kunci dari FAQ database (Prioritas lebih tinggi dari fallback keluhan kasar)
    is_faq_keyword_matched = False
    for item in FAQ_CACHE:
        if any(keyword in user_msg_upper for keyword in [k.upper() for k in item["keywords"]]):
            is_faq_keyword_matched = True
            break
            
    if is_faq_keyword_matched and intent not in ["CEK_TAGIHAN", "LIHAT_NOMER", "CARA_BAYAR"]:
        intent = "FAQ"

    # 2. Cek apakah pesan mengandung indikator pertanyaan (FAQ / tanya jawab umum)
    tanya_words = ["KENAPA", "KOK", "MENGAPA", "BAGAIMANA", "APAKAH", "SOLUSI", "CARA", "SYARAT", "ESTIMASI", "INFO"]
    is_asking = any(q_word in user_msg_upper for q_word in tanya_words)
    
    # Override ke FAQ jika user sedang mengajukan pertanyaan tetapi AI salah mengklasifikasikan sebagai LAPOR_KELUHAN
    if is_asking and intent == "LAPOR_KELUHAN":
        intent = "FAQ"
    
    # 3. Fallback tambahan berbasis kata kunci langsung dari input user untuk lapor keluhan
    # Hanya aktif jika user TIDAK sedang bertanya (is_asking == False) dan tidak cocok kata kunci FAQ
    if intent not in ["CEK_TAGIHAN", "LIHAT_NOMER", "CARA_BAYAR", "FAQ"]:
        # Kata "lapor" seringkali muncul dalam "laporan" (pelacakan status/laporan selesai),
        # sehingga kita bedakan dengan mengecek "laporan" secara khusus
        is_tracking_or_status = any(phrase in user_msg_upper for phrase in ["CEK LAPORAN", "STATUS LAPORAN", "TIKET LAPORAN", "LAPORAN SELESAI"])
        
        if not is_tracking_or_status and not is_asking:
            complaint_keywords = ["KELUHAN", "ADUAN", "KOMPLAIN", "MATI", "KERUH", "BOCOR", "RUSAK", "MELAPORKAN"]
            has_lapor = "LAPOR" in user_msg_upper and "LAPORAN" not in user_msg_upper
            if "MELAPORKAN" in user_msg_upper:
                has_lapor = True
                
            if has_lapor or any(keyword in user_msg_upper for keyword in complaint_keywords):
                intent = "LAPOR_KELUHAN"

    # 1. Cari nomor tiket keluhan terlebih dahulu (misal: 19122021-1)
    ticket_match = re.search(r'\b\d{8}-\d+\b', user_message)
    if ticket_match:
        intent = "CEK_STATUS"
        nolangg = None
    else:
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
        elif intent == "FAQ":
            data["intent"] = "GENERAL"
            data["reply"] = generate_faq_response(user_message)
        elif intent == "LAPOR_KELUHAN":
            data["intent"] = "LAPOR_KELUHAN"
            data["reply"] = "Memulai alur pelaporan keluhan pelanggan..."
        elif intent == "CEK_STATUS":
            data["intent"] = "CEK_STATUS"
            data["reply"] = "Sedang mengecek status laporan keluhan..."
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
            "PDAM Purbalingga. Tanyakan apakah ada yang bisa di bantu oleh kamu ke user tentang pdam dengan ceria"
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

    response = call_llm(prompt=prompt, system_prompt=system_prompt)

    # Fallback statis jika OpenRouter gagal/timeout
    if not response:
        fallbacks = {
            "SAPAAN":        "Halo! 👋 Saya Asisten Virtual PDAM Purbalingga. Ada yang bisa saya bantu? Saya siap membantu cek tagihan atau info pembayaran Anda 😊",
            "CARA_BAYAR":    "Untuk pembayaran tagihan air PDAM, Anda bisa menggunakan ATM, Alfamart, Indomaret, Mobile Banking, atau langsung di loket resmi PDAM terdekat. 💳",
            "OUT_OF_CONTEXT":"Mohon maaf, saya hanya dapat melayani pertanyaan seputar layanan PDAM Purbalingga seperti cek tagihan dan informasi pembayaran. 🙏",
            "LIHAT_NOMER":   "Jika Anda lupa nomor pelanggan PDAM Purbalingga, Anda bisa melihatnya di:\n1. Struk/kuitansi pembayaran bulan sebelumnya.\n2. Kartu pelanggan atau buku rekening PDAM.\n3. Plat besi/stiker kecil pada unit meteran air fisik di rumah Anda.\n4. Datang langsung ke kantor PDAM Purbalingga terdekat untuk menanyakannya pada petugas dengan membawa KTP pemilik. 😊",
            "CEK_TAGIHAN":   "Pelanggan dapat mengecek estimasi atau jumlah tagihan secara mandiri melalui:\n1. Aplikasi mobile resmi PDAM atau portal website pelanggan.\n2. Aplikasi e-commerce (Tokopedia, Shopee, dll) dan dompet digital (Dana, GoPay, OVO).\n3. Layanan mobile banking atau ATM bank yang bekerja sama.\n4. Minimarket terdekat (Indomaret, Alfamart) dengan memberikan Nomor Pelanggan/Nomor Sambungan ke kasir.\n5. Atau anda bisa ketikan nomor pelanggan anda di sini dan saya akan bantu cek tagihan air anda "
        }
        return fallbacks.get(intent, "Maaf, terjadi kesalahan sistem. Silakan coba lagi.")

    response = clean_chinese_characters(response)
    return response

def cosine_similarity(v1, v2):
    if not v1 or not v2 or len(v1) != len(v2):
        return 0.0
    dot_product = sum(a * b for a, b in zip(v1, v2))
    norm_a = sum(a * a for a in v1) ** 0.5
    norm_b = sum(b * b for b in v2) ** 0.5
    if norm_a == 0.0 or norm_b == 0.0:
        return 0.0
    return dot_product / (norm_a * norm_b)

# Cache global untuk FAQ dan embedding-nya
FAQ_CACHE = []

def load_faq_cache():
    """Muat FAQ dari database MySQL ke dalam memori RAM, beserta representasi vektornya."""
    global FAQ_CACHE
    try:
        from database import get_all_faqs
        db_faqs = get_all_faqs()
        if db_faqs:
            temp_cache = []
            for item in db_faqs:
                try:
                    embedding_vector = json.loads(item["embedding"])
                    temp_cache.append({
                        "id": item["id"],
                        "question": item["question"],
                        "answer": item["answer"],
                        "keywords": item["keywords"].split(",") if item["keywords"] else [],
                        "embedding": embedding_vector
                    })
                except Exception as ex:
                    logger.error(f"[load_faq_cache] Gagal mem-parsing embedding FAQ ID {item.get('id')}: {ex}")
            
            if temp_cache:
                FAQ_CACHE = temp_cache
                logger.info(f"[load_faq_cache] Berhasil memuat {len(FAQ_CACHE)} FAQ dengan embedding dari database.")
                return
        logger.warning("[load_faq_cache] Database tbl_faq kosong. Menggunakan fallback faq_data.py...")
    except Exception as e:
        logger.error(f"[load_faq_cache] Error saat memuat FAQ dari database: {e}")
        
    # Fallback ke faq_data.py jika database kosong/error
    FAQ_CACHE = []
    for item in FAQ_LIST:
        FAQ_CACHE.append({
            "id": None,
            "question": item["question"],
            "answer": item["answer"],
            "keywords": item["keywords"],
            "embedding": None
        })
    logger.info(f"[load_faq_cache] Berhasil memuat {len(FAQ_CACHE)} FAQ fallback dari faq_data.py.")

# Jalankan loading FAQ cache saat modul pertama kali di-import
load_faq_cache()

def get_matching_faq(user_message: str):
    """
    Mencocokkan pesan user dengan FAQ menggunakan Semantic Search (Cosine Similarity).
    Jika FAQ tidak memiliki embedding (misal fallback), gunakan keyword/SequenceMatcher.
    """
    global FAQ_CACHE
    if not FAQ_CACHE:
        load_faq_cache()
        
    user_msg_lower = user_message.lower()
    
    # 1. Coba Semantic Search terlebih dahulu jika model embedding dikonfigurasi & cache memiliki embedding
    has_embeddings = any(item["embedding"] is not None for item in FAQ_CACHE)
    if has_embeddings:
        try:
            user_vector = get_openrouter_embedding(user_message)
            if user_vector:
                best_match = None
                max_sim = 0.0
                
                for item in FAQ_CACHE:
                    if item["embedding"]:
                        sim = cosine_similarity(user_vector, item["embedding"])
                        if sim > max_sim:
                            max_sim = sim
                            best_match = item
                
                logger.info(f"[get_matching_faq] Hasil Semantic Search: kemiripan tertinggi = {max_sim:.4f}")
                # Ambang batas (threshold) kecocokan semantic search, misalnya 0.50
                if max_sim >= 0.50:
                    return best_match
        except Exception as e:
            logger.error(f"[get_matching_faq] Error saat semantic search: {e}")

    # 2. Fallback: Keyword Matching + SequenceMatcher (jika API embedding gagal atau data tidak ada embedding)
    logger.info("[get_matching_faq] Menggunakan fallback Keyword/SequenceMatcher.")
    best_match = None
    max_score = 0
    from difflib import SequenceMatcher
    
    for item in FAQ_CACHE:
        keyword_score = 0
        for keyword in item["keywords"]:
            if keyword.lower() in user_msg_lower:
                keyword_score += 2.0
        
        ratio = SequenceMatcher(None, user_msg_lower, item["question"].lower()).ratio()
        total_score = keyword_score + (ratio * 1.5)
        
        if total_score > max_score and total_score > 0.5:
            max_score = total_score
            best_match = item
            
    return best_match

def generate_faq_response(user_message: str) -> str:
    # 1. Cari FAQ yang paling cocok
    matched_faq = get_matching_faq(user_message)
    
    if not matched_faq:
        # Jika tidak ada FAQ yang sangat cocok, berikan semua pertanyaan FAQ sebagai konteks ke LLM
        context = "\n\n".join([f"Pertanyaan: {item['question']}\nJawaban: {item['answer']}" for item in FAQ_CACHE])
    else:
        context = f"Pertanyaan: {matched_faq['question']}\nJawaban: {matched_faq['answer']}"
        
    system_prompt = (
        "Kamu adalah Asisten Virtual PDAM Purbalingga yang ramah dan profesional.\n"
        "ATURAN WAJIB:\n"
        "1. Jawab pertanyaan user berdasarkan KONTEKS FAQ yang diberikan di bawah secara lengkap, ramah, dan instruktif.\n"
        "2. DILARANG KERAS menghilangkan langkah-langkah solusi teknis penting (seperti mengecek stop kran engkol meteran, melakukan pembilasan/flushing, dll) jika tertulis di dalam jawaban FAQ.\n"
        "3. JANGAN mengarang informasi di luar konteks FAQ.\n"
        "4. Jawab dalam Bahasa Indonesia murni yang jelas dan terstruktur.\n"
        "5. Gunakan emoji 1-2 saja."
    )
    
    prompt = (
        f"Konteks FAQ resmi:\n{context}\n\n"
        f"Pertanyaan pelanggan: \"{user_message}\"\n\n"
        "Tulis balasan singkat dalam Bahasa Indonesia murni berdasarkan konteks FAQ di atas:"
    )
    
    response = call_llm(prompt=prompt, system_prompt=system_prompt)
    
    # Fallback jika OpenRouter offline/timeout atau tidak menghasilkan respons yang baik
    if not response:
        if matched_faq:
            return matched_faq["answer"]
        else:
            return (
                "Maaf, saya tidak menemukan informasi yang tepat mengenai hal tersebut di data FAQ kami. 😔\n"
                "Anda dapat menanyakan hal lain seputar pasang baru, tarif air, balik nama, atau jam pelayanan kantor."
            )
            
    return clean_chinese_characters(response)

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
        response = call_llm(prompt=prompt, system_prompt=system_prompt)
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
        response = call_llm(prompt=prompt, system_prompt=system_prompt)
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

    response = call_llm(prompt=prompt, system_prompt=system_prompt)

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
