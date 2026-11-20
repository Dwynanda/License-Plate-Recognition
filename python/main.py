import cv2
import time
import os
import numpy as np
from connection import db, cursor, simpan, insert_db
import threading
from streaming import update_frame, jalankan_flask
from ultralytics import YOLO
from difflib import SequenceMatcher
from fast_plate_ocr import LicensePlateRecognizer

#inisialisasi Thread untuk menjalankan streaming di web
threading.Thread(target=jalankan_flask, daemon=True).start()
os.environ["OPENCV_FFMPEG_CAPTURE_OPTIONS"] = "rtsp_transport;tcp"

#inisialisasi main streaming dari IP CCTV
cctv_main = "rtsp://admin:L2034E56@192.168.1.13:554/cam/realmonitor?channel=1&subtype=0" #  <-- IP CCTV
kamera_main = cv2.VideoCapture(cctv_main, cv2.CAP_FFMPEG)

#inisialisasi sub streaming dari IP CCTV
cctv_sub = "rtsp://admin:L2034E56@192.168.1.13:554/cam/realmonitor?channel=1&subtype=1" #  <-- IP CCTV
kamera_sub = cv2.VideoCapture(cctv_sub, cv2.CAP_FFMPEG)

#inisialisasi model deteksi, dan variabel-variabel
model_kendaraan = YOLO("./python/model/yolo11n.pt")
model_plat = YOLO("./python/model/best.pt")
ocr = LicensePlateRecognizer("cct-s-v2-global-model")

waktu_terakhir = 0
waktu_deteksi = 0.5
platnomor_list = set()
nomor_file = 0
nomor = 0

#inisialisasi format platnomor Indonesia
kode_plat = (
    "A", "B", "D", "E", "F", "G", "H", "K", "L", "M", "N", "P", "R", "S", "T", 
    "W", "Z", "AA", "AB", "AD", "AE", "AG", "BA", "BB", "BD", "BE", "BG", "BH", 
    "BK",  "BL", "BM", "BN", "BP", "DA", "DB", "DC", "DD", "DE", "DG", "DH", "DK", 
    "DL", "DM", "DN", "DR", "DT", "EA", "EB", "ED", "KB", "KH", "KT", "KU", "PA", "PB"
)

#proses deteksi menggunakan kamera
while True:
    ret, frame_sub = kamera_sub.read()
    if not ret:
        print("Gagal membaca streaming!")
        break

# deteksi kendaraan
    deteksi_kendaraan = model_kendaraan(frame_sub, classes=[2, 3, 5, 7, 67],verbose=False)
    hasil_kendaraan = deteksi_kendaraan[0].plot()
    for kendaraan in deteksi_kendaraan[0].boxes:
        kanan, atas, kiri, bawah = map(int, kendaraan.xyxy[0])
        # crop_kendaraan = frame_sub[atas:bawah, kanan:kiri]

    #deteksi platnomor
        waktu_sekarang = time.time()
        if waktu_sekarang - waktu_terakhir >= waktu_deteksi:
        # menyamakan posisi Main Stream dengan Sub Stream
            # posisi_video = kamera_sub.get(cv2.CAP_PROP_POS_MSEC)
            # kamera_main.set(cv2.CAP_PROP_POS_MSEC, posisi_video)
            #capture kendaraan menggunakan main streaming CCTV
            ret_main, frame_main = kamera_main.read()
            if not ret_main:
                print("Gagal membaca main streaming!")
                continue
            waktu_terakhir = waktu_sekarang

        # menghitung perbandingan resolusi kedua stream
            tinggi_sub, lebar_sub = frame_sub.shape[:2]
            tinggi_main, lebar_main = frame_main.shape[:2]
            skala_x = lebar_main / lebar_sub
            skala_y = tinggi_main / tinggi_sub

        # mengubah koordinat Sub Stream ke Main Stream
            kanan_main = int(kanan * skala_x)
            atas_main = int(atas * skala_y)
            kiri_main = int(kiri * skala_x)
            bawah_main = int(bawah * skala_y)

            crop_kendaraan = frame_main[atas_main:bawah_main, kanan_main:kiri_main]

            if nomor % 2 == 0:
                frame_sub_deteksi = crop_kendaraan
            else:
                frame_sub_deteksi = cv2.bitwise_not(crop_kendaraan)
            deteksi_plat = model_plat(frame_sub_deteksi, verbose=False)
            nomor += 1
            for platnomor in deteksi_plat[0].boxes:
                print("Plat terdeteksi")
                kanan, atas, kiri, bawah = map(int, platnomor.xyxy[0])
                crop_platnomor = crop_kendaraan[atas:bawah, kanan:kiri]

            #convert gambar platnomor menjadi text
                if crop_platnomor is not None and crop_platnomor.size > 0:
                    platnomor_img = crop_platnomor
                    platnomor_compiling = ocr.run(platnomor_img, return_confidence=True)
                    for hasil_compiling in platnomor_compiling:
                        platnomor_text = hasil_compiling.plate
                        score = float(np.mean(hasil_compiling.char_probs))
                else:   
                    continue
                    
            #validasi sistem bahwa platnomor dikenali atau tidak
                if platnomor_text.startswith(kode_plat) and score > 0.90:
                    if not any(SequenceMatcher(None, platnomor_text, char).ratio() > 0.80 for char in platnomor_list):
                    #jika dikenali, maka save image kendaraan dan platnomor ke folder images
                        nomor_file += 1
                        path_kendaraan = simpan(crop_kendaraan, "./laravel/public/images/kendaraan", f"{nomor_file}.jpg")
                        path_plat = simpan(crop_platnomor, "./laravel/public/images/plat", f"{nomor_file}.jpg")

                    #dan jika dikenali, menyimpan data kendaraan dan platnomor ke database
                        insert_db(platnomor_text, score, f"images/kendaraan/{nomor_file}.jpg", f"images/plat/{nomor_file}.jpg")
                        platnomor_list.add(platnomor_text)

                        print("Platnomor : ", platnomor_text)
                        print("Score : ", score)
                else:
                    continue
            waktu_terakhir = waktu_sekarang


#mengubah format tangkapan kamera menjadi bytes untuk bisa ditampilkan pada website
    _, buffer = cv2.imencode('.jpg', hasil_kendaraan)
    update_frame(buffer.tobytes())            

#menampilkan video dalam bentuk window, exit tekan "q"
    resize = cv2.resize(hasil_kendaraan, (800, 600))
    cv2.imshow("CCTV", resize)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

#menghentikan kerja kamera ketika proses berakhir
kamera_sub.release()
kamera_main.release()
cv2.destroyAllWindows()

# coba buat plat harini berapa terdeteksi dan berapa plat totalnya terdeteksi
# buat css nya