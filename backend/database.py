import mysql.connector
from mysql.connector import Error, pooling
import os
import logging
from dotenv import load_dotenv

load_dotenv()

# ─────────────────────────────────────────────
# Logger (celah #7: ganti semua print() ke logger)
# ─────────────────────────────────────────────
logger = logging.getLogger(__name__)

# Inisialisasi Connection Pool (dieksekusi sekali saat modul dimuat)
try:
    db_pool = pooling.MySQLConnectionPool(
        pool_name="pdam_pool",
        pool_size=10,
        pool_reset_session=True,
        host=os.getenv("DB_HOST", "localhost"),
        port=int(os.getenv("DB_PORT", 3307)),
        user=os.getenv("DB_USER", "root"),
        password=os.getenv("DB_PASSWORD", ""),
        database=os.getenv("DB_NAME", "pdam_billing")
    )
    logger.info("MySQL Connection Pool berhasil diinisialisasi.")
except Error as e:
    logger.error(f"Error initializing MySQL Connection Pool: {e}")
    db_pool = None

def get_db_connection():
    if not db_pool:
        logger.error("Database pool is not initialized.")
        return None
    try:
        connection = db_pool.get_connection()
        return connection
    except Error as e:
        logger.error(f"Error getting connection from pool: {e}")
        return None

def get_unpaid_billing(nolangg: str):
    connection = get_db_connection()
    if not connection:
        return None

    try:
        cursor = connection.cursor(dictionary=True)

        # 1. Cek apakah nomor pelanggan terdaftar
        check_user_query = "SELECT nama FROM tbl_pelanggan WHERE nolangg = %s"
        cursor.execute(check_user_query, (nolangg,))
        user = cursor.fetchone()

        if not user:
            return {
                "status": "not_found",
                "message": f"Nomor Pelanggan {nolangg} tidak ditemukan di sistem kami silahkan cek kembali nomer pelanggan anda.",
                "data": []
            }

        # 2. Jika pelanggan ada, cek tagihan yang belum lunas
        query = """
            SELECT p.nama, p.alamat, b.PERIODE, b.M3, b.TOTAL, b.DENDA 
            FROM tbl_pelanggan p
            JOIN tbl_bppl b ON p.nolangg = b.NOLANGG
            WHERE p.nolangg = %s AND b.TGLLUNAS IS NULL
        """
        cursor.execute(query, (nolangg,))
        result = cursor.fetchall()

        if not result:
            return {
                "status": "success",
                "message": f"Tidak ada tagihan tertunggak untuk nomor pelanggan {nolangg}.",
                "data": [],
                "nama": user["nama"]
            }

        return {"status": "success", "data": result}

    except Error as e:
        logger.error(f"Error executing get_unpaid_billing query: {e}")
        return {"status": "error", "message": "Terjadi kesalahan sistem saat mengambil data tagihan."}
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

def create_complaint(name: str, address: str, phone: str, content: str, inputed_by: str = "web_chatbot"):
    connection = get_db_connection()
    if not connection:
        return None
    try:
        # ─────────────────────────────────────────────
        # Celah #10: Fix race condition ticket number
        # Gunakan transaksi + SELECT ... FOR UPDATE untuk mencegah
        # dua request bersamaan mendapat nomor tiket yang sama.
        # ─────────────────────────────────────────────
        connection.start_transaction()
        cursor = connection.cursor()

        from datetime import datetime
        date_str = datetime.now().strftime("%d%m%Y")

        # Lock baris yang akan dihitung agar request lain menunggu
        count_query = """
            SELECT COUNT(*) as total
            FROM customercomplaint
            WHERE DATE(DateCompliant) = CURDATE()
            FOR UPDATE
        """
        cursor.execute(count_query)
        count_result = cursor.fetchone()
        daily_count = count_result[0] if count_result else 0
        sequence = str(daily_count + 1).zfill(3)
        ticket_number = f"{date_str}-{sequence}"

        # Insert complaint
        query = """
            INSERT INTO customercomplaint (
                DateCompliant, Number, ComplianerName, ComplianerAddress, PhoneNumber, 
                CompliantContent, CompliantStatusId, InputedDate, isDeleted, 
                UpdatedDate, InputedBy, CompliantTypeId
            ) VALUES (
                NOW(), %s, %s, %s, %s, 
                %s, 1, NOW(), 0, 
                NOW(), %s, 1
            )
        """
        cursor.execute(query, (ticket_number, name, address, phone, content, inputed_by))
        connection.commit()
        logger.info(f"Complaint berhasil dibuat dengan nomor tiket: {ticket_number}")
        return ticket_number

    except Error as e:
        logger.error(f"Error creating complaint: {e}")
        try:
            connection.rollback()
        except Exception:
            pass
        return None
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

def get_complaint_status(ticket_number: str):
    connection = get_db_connection()
    if not connection:
        return None
    try:
        cursor = connection.cursor(dictionary=True)
        query = """
            SELECT CompliantStatusId, CompliantContent, ComplianerName 
            FROM customercomplaint 
            WHERE Number = %s 
            LIMIT 1
        """
        cursor.execute(query, (ticket_number,))
        result = cursor.fetchone()
        return result
    except Error as e:
        logger.error(f"Error getting complaint status: {e}")
        return None
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

def get_all_faqs():
    connection = get_db_connection()
    if not connection:
        return None
    try:
        cursor = connection.cursor(dictionary=True)
        query = "SELECT id, question, answer, keywords, embedding FROM tbl_faq"
        cursor.execute(query)
        result = cursor.fetchall()
        return result
    except Error as e:
        logger.error(f"Error fetching FAQs: {e}")
        return None
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

def insert_faq_with_embedding(question: str, answer: str, keywords: str, embedding_json: str):
    connection = get_db_connection()
    if not connection:
        return False
    try:
        cursor = connection.cursor()
        query = """
            INSERT INTO tbl_faq (question, answer, keywords, embedding)
            VALUES (%s, %s, %s, %s)
        """
        cursor.execute(query, (question, answer, keywords, embedding_json))
        connection.commit()
        return True
    except Error as e:
        logger.error(f"Error inserting FAQ: {e}")
        return False
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

def truncate_faqs():
    connection = get_db_connection()
    if not connection:
        return False
    try:
        cursor = connection.cursor()
        cursor.execute("TRUNCATE TABLE tbl_faq")
        connection.commit()
        return True
    except Error as e:
        logger.error(f"Error truncating FAQs: {e}")
        return False
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
