from datetime import datetime
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

#fungsi untuk simpan kendaraan dan platnomor ke database
def insert_db(plat_text, confidence, kendaraan_img, plat_img):
    sql_command = """
        INSERT INTO deteksi(platnomor_text, confidence, kendaraan_path, platnomor_path, date)
        VALUES (%s, %s, %s, %s, NOW())
    """
    data = (plat_text, confidence, kendaraan_img, plat_img)
    cursor.execute(sql_command, data)
    db.commit()