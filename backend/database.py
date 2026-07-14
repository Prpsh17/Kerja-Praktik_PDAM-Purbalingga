import mysql.connector
from mysql.connector import Error
import os
from dotenv import load_dotenv

load_dotenv()

def get_db_connection():
    try:
        connection = mysql.connector.connect(
            host=os.getenv("DB_HOST", "localhost"),
            port=int(os.getenv("DB_PORT", 3307)),
            user=os.getenv("DB_USER", "root"),
            password=os.getenv("DB_PASSWORD", ""),
            database=os.getenv("DB_NAME", "pdam_billing")
        )
        return connection
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
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
            return {"status": "not_found", "message": f"Nomor Pelanggan {nolangg} tidak ditemukan di sistem kami silahkan cek kembali nomer pelanggan anda.", "data": []}
            
        # 2. Jika pelanggan ada, cek tagihan yang belum lunas
        query = """
            SELECT p.nama, p.alamat, b.PERIODE, b.M3, b.TOTAL, b.DENDA 
            FROM tbl_pelanggan p
            JOIN tbl_bppl b ON p.nolangg = b.NOLANGG
            WHERE p.nolangg = %s AND b.TGLLUNAS IS NULL
        """
        cursor.execute(query, (nolangg,))
        result = cursor.fetchall()
        
        # Format the result nicely
        if not result:
            return {"status": "success", "message": f"Tidak ada tagihan tertunggak untuk nomor pelanggan {nolangg}.", "data": [], "nama": user["nama"]}
            
        return {"status": "success", "data": result}
        
    except Error as e:
        print(f"Error executing query: {e}")
        return {"status": "error", "message": "Terjadi kesalahan sistem saat mengambil data tagihan."}
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
