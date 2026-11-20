from datetime import datetime, timedelta
import mysql.connector
import os
import cv2

#inisialisasi database
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="anpr"
)
cursor = db.cursor()

#fungsi untuk simpan image kendaraan dan platnomor ke folder images
def simpan(gambar, folder , nama_file):
    os.makedirs(folder, exist_ok=True)
    path_gambar = os.path.join(folder, nama_file).replace("\\", "/")
    gambar = cv2.resize(gambar, None, fx=4, fy=4, interpolation=cv2.INTER_CUBIC)
    cv2.imwrite(path_gambar, gambar)
    return(path_gambar)

#fungsi untuk simpan kendaraan dan platnomor ke database untuk transaksi parkir
def insert_db(plat_text, jenis_kendaraan, kendaraan_img, plat_img):
    waktu = datetime.now().strftime("%Y%m%d_%H%M%S_%f")
    path_kendaraan = f"images/kendaraan/{waktu}.jpg"
    path_platnomor = f"images/plat/{waktu}.jpg"

    cv2.imwrite(f"./laravel/public/{path_kendaraan}", cv2.resize(kendaraan_img, None, fx=4, fy=4, interpolation=cv2.INTER_CUBIC))
    cv2.imwrite(f"./laravel/public/{path_platnomor}", cv2.resize(plat_img, None, fx=4, fy=4, interpolation=cv2.INTER_CUBIC))

    sql_command = """
        INSERT INTO transaksi_parkir(platnomor, jenis_kendaraan, gambar_kendaraan, gambar_plat, waktu_masuk, waktu_keluar, durasi_parkir, total_biaya)
        VALUES (%s, %s, %s, %s, NOW(), %s, %s, %s)
    """
    data = (plat_text, jenis_kendaraan, path_kendaraan, path_platnomor, None, None, None)
    cursor.execute(sql_command, data)
    db.commit()

#fungsi untuk update data transaksi parkir
def update_db(plat_text, jenis_kendaraan):
    cursor.execute("""
        SELECT waktu_masuk FROM transaksi_parkir
        WHERE platnomor = %s AND waktu_keluar IS NULL
    """, (plat_text,))
    hasil = cursor.fetchone()

    #hitung durasi dan total biaya parkir
    if not hasil:
        return False
    
    waktu_masuk = hasil[0]
    waktu_keluar = datetime.now()
    durasi_parkir = int((waktu_keluar - waktu_masuk).total_seconds() / 60)

    if durasi_parkir < 6:
        total_biaya = 0
    else:
        jam_parkir = (durasi_parkir + 59) // 60

        if jenis_kendaraan == "Motor":
            biaya = 2000
        elif jenis_kendaraan == "Mobil":
            biaya = 5000
        elif jenis_kendaraan == "Truk":
            biaya = 10000

        total_biaya = jam_parkir * biaya

    sql_command = """
            UPDATE transaksi_parkir
            SET waktu_keluar = %s, durasi_parkir = %s, total_biaya = %s
            WHERE platnomor = %s
            AND waktu_keluar IS NULL
        """
    data = (waktu_keluar, durasi_parkir, total_biaya, plat_text)
    cursor.execute(sql_command, data)
    db.commit()
    return cursor.rowcount > 0

#fungsi untuk jeda waktu update ke database
def cek_waktu_masuk(plat_text):
    cursor.execute(""" 
        SELECT waktu_masuk FROM transaksi_parkir
        WHERE platnomor = %s AND waktu_keluar IS NULL
        ORDER BY waktu_masuk DESC
        LIMIT 1
    """, (plat_text,))

    hasil = cursor.fetchone()

    if hasil:
        return datetime.now() - hasil[0] >= timedelta(minutes=6)

    else:
        return False
