from flask import Flask, Response
import threading
import time

#inisialisasi variabel
app = Flask(__name__)
frame_terbaru = None

#tempat tampung frame paling terbaru dari tangkapan kamera
def update_frame(frame):
    global frame_terbaru
    frame_terbaru = frame

#memperbarui frame pada tempat tampung setiap proses berulang
@app.route('/video')
def video():
    def generate():
        while True:
            if frame_terbaru is not None:
                yield (
                    b'--frame\r\n'
                    b'Content-Type: image/jpeg\r\n\r\n' +
                    frame_terbaru + b'\r\n'
                )
            time.sleep(0.03)

    return Response(
        generate(),
        mimetype='multipart/x-mixed-replace; boundary=frame'
    )

#mengaktifkan streaming pada localhost
def jalankan_flask():
    app.run(host='0.0.0.0', port=5000, threaded=True, use_reloader=False)