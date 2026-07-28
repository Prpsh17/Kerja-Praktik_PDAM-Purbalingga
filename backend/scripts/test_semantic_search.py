# File: backend/test_semantic_search.py
import os
import sys
import json
from dotenv import load_dotenv

# Tambahkan direktori parent (backend) ke sys.path
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))

# Paksa environment agar terbaca
load_dotenv()

from ai_agent import get_matching_faq, load_faq_cache

def test_search():
    # Muat cache FAQ terlebih dahulu
    print("Loading FAQ cache...")
    load_faq_cache()
    
    test_queries = [
        "bagaimana cara daftar pelanggan baru?",
        "air di rumah saya keruh banget nih cokelat warnanya",
        "kantor pdam purbalingga buka hari apa aja?",
        "gimana cara melacak keluhan saya?",
        "pdam purbalingga lokasinya ada di mana ya?",
        "pdam buka dari jam berapa y"
    ]
    
    print("\n--- MENJALANKAN PENGUJIAN SEMANTIC SEARCH ---")
    for query in test_queries:
        print(f"\nPertanyaan User: '{query}'")
        matched = get_matching_faq(query)
        if matched:
            print(f"  -> FAQ Terdeteksi: '{matched['question']}'")
            print(f"  -> ID FAQ: {matched.get('id')}")
        else:
            print("  -> FAQ Terdeteksi: Tidak ada kecocokan (Fallback LLM/Umum)")

if __name__ == "__main__":
    test_search()
