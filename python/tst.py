import os
import cv2

os.environ["OPENCV_FFMPEG_CAPTURE_OPTIONS"] = "rtsp_transport;tcp"
#inisialisasi main streaming dari IP CCTV
cctv_main = "rtsp://admin:L2034E56@192.168.1.13:554/cam/realmonitor?channel=1&subtype=0" #  <-- IP CCTV
kamera_main = cv2.VideoCapture(cctv_main, cv2.CAP_FFMPEG)

#inisialisasi sub streaming dari IP CCTV
cctv_sub = "rtsp://admin:L2034E56@192.168.1.13:554/cam/realmonitor?channel=1&subtype=1" #  <-- IP CCTV
kamera_sub = cv2.VideoCapture(cctv_sub, cv2.CAP_FFMPEG)

while True:
    ret, frame_main = kamera_main.read()

    if not ret:
        print("Gagal membaca Main Stream!")
        continue

    resize = cv2.resize(frame_main, (600, 600))
    cv2.imshow("Main Stream", resize)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

kamera_main.release()
cv2.destroyAllWindows()