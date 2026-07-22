# File: backend/seed_faq.py
import os
import json
import time
import requests
import mysql.connector
from dotenv import load_dotenv
from faq_data import FAQ_LIST

load_dotenv()

DB_HOST = os.getenv("DB_HOST", "localhost")
DB_PORT = int(os.getenv("DB_PORT", 3307))
DB_USER = os.getenv("DB_USER", "root")
DB_PASSWORD = os.getenv("DB_PASSWORD", "")
DB_NAME = os.getenv("DB_NAME", "pdam_billing")

OPENROUTER_API_KEY = os.getenv("OPENROUTER_API_KEY", "").strip()
OPENROUTER_EMBEDDING_MODEL = os.getenv("OPENROUTER_EMBEDDING_MODEL", "nvidia/nemotron-3-embed-1b:free").strip()

def get_db_connection():
    return mysql.connector.connect(
        host=DB_HOST,
        port=DB_PORT,
        user=DB_USER,
        password=DB_PASSWORD,
        database=DB_NAME
    )

def create_table_if_not_exists():
    print("Checking / creating tbl_faq database table...")
    conn = get_db_connection()
    cursor = conn.cursor()
    
    create_query = """
    CREATE TABLE IF NOT EXISTS tbl_faq (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        keywords TEXT,
        embedding LONGTEXT NOT NULL
    );
    """
    cursor.execute(create_query)
    conn.commit()
    cursor.close()
    conn.close()
    print("tbl_faq is ready.")

def get_embedding_from_openrouter(text: str):
    """Panggil OpenRouter Embeddings API untuk mendapatkan representasi vektor."""
    if not OPENROUTER_API_KEY:
        raise ValueError("OPENROUTER_API_KEY tidak dikonfigurasi di file .env!")
        
    url = "https://openrouter.ai/api/v1/embeddings"
    headers = {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
    }
    payload = {
        "model": OPENROUTER_EMBEDDING_MODEL,
        "input": text
    }
    
    # Coba beberapa kali jika terjadi kegagalan/rate limit
    for attempt in range(3):
        try:
            response = requests.post(url, json=payload, headers=headers, timeout=30)
            response.raise_for_status()
            data = response.json()
            embedding = data["data"][0]["embedding"]
            return embedding
        except Exception as e:
            print(f"[Attempt {attempt+1}] Gagal memanggil API embedding: {e}")
            if attempt < 2:
                time.sleep(2)
            else:
                raise e

def seed_data():
    conn = get_db_connection()
    cursor = conn.cursor()
    
    # Ambil data pertanyaan yang sudah ada di database
    print("Mengecek data FAQ yang sudah ada di database...")
    cursor.execute("SELECT question FROM tbl_faq")
    existing_questions = {row[0] for row in cursor.fetchall()}
    
    print(f"Starting seeding of {len(FAQ_LIST)} FAQ items using model '{OPENROUTER_EMBEDDING_MODEL}'...")
    
    for index, item in enumerate(FAQ_LIST):
        question = item["question"]
        answer = item["answer"]
        keywords_str = ",".join(item["keywords"])
        
        if question in existing_questions:
            print(f"[{index+1}/{len(FAQ_LIST)}] Skipping embedding (already exists), updating answer/keywords for: '{question[:40]}...'")
            try:
                update_query = """
                UPDATE tbl_faq SET answer = %s, keywords = %s WHERE question = %s
                """
                cursor.execute(update_query, (answer, keywords_str, question))
                conn.commit()
            except Exception as e:
                print(f"  -> ERROR updating '{question}': {e}")
            continue
            
        print(f"[{index+1}/{len(FAQ_LIST)}] Generating embedding for new FAQ: '{question[:40]}...'")
        
        try:
            embedding_vector = get_embedding_from_openrouter(question)
            embedding_json = json.dumps(embedding_vector)
            
            insert_query = """
            INSERT INTO tbl_faq (question, answer, keywords, embedding)
            VALUES (%s, %s, %s, %s)
            """
            cursor.execute(insert_query, (question, answer, keywords_str, embedding_json))
            conn.commit()
            print(f"  -> Successfully saved with vector size: {len(embedding_vector)} dimensions.")
            
        except Exception as e:
            print(f"  -> ERROR seeding '{question}': {e}")
            
        # Jeda waktu kecil agar tidak melampaui rate limit OpenRouter
        time.sleep(1.5)
        
    cursor.close()
    conn.close()
    print("FAQ Seeding completed successfully!")

if __name__ == "__main__":
    create_table_if_not_exists()
    seed_data()
