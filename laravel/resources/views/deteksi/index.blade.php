<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANPR</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 30px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 25px;
        }

        h3 {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .konten-atas {
            display: flex;
            gap: 25px;
            align-items: stretch;
            margin-bottom: 25px;
        }

        .streaming {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .streaming img {
            width: 100%;
            max-width: 1000px;
            display: block;
            border-radius: 8px;
        }

        .panel-kanan {
            width: 280px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .statistik {
            flex: 1;
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .statistik h1 {
            font-size: 36px;
            color: #434b5a;
            margin-bottom: 0;
        }

        .tabel-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        thead {
            background-color: #1e293b;
            color: white;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            font-size: 14px;
        }

        td {
            font-size: 14px;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        td img {
            width: 200px;
            height: 130px;
            object-fit: contain;
            border-radius: 8px;
        }

        td:first-child {
            font-weight: bold;
            font-size: 16px;
        }

        .navbar {
            background-color: #1e293b;
            color: white;
            padding: 20px 30px;
            margin: -30px -30px 30px -30px;
        }

        .navbar h2 {
            font-size: 22px;
            font-weight: bold;
        }

        .stream-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            background-color: #0f172a;
            border-radius: 8px;
            overflow: hidden;
        }

        .stream-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .stream-offline {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #0f172a;
            color: white;
            gap: 10px;
        }

        .stream-offline p {
            color: #94a3b8;
            font-size: 14px;
        }

        .stream-offline.hidden {
            display: none;
        }
        
    </style>
</head>

<body>
    <nav class="navbar">
        <h2>ANPR Detection</h2>
    </nav>
    <div class="container">
        <div class="konten-atas">

        <div class="streaming">
            <div class="stream-wrapper">
                <img id="live-stream" src="http://127.0.0.1:5000/video">

                <div id="stream-offline" class="stream-offline">
                    <h2>STREAM OFFLINE</h2>
                    <p>Menunggu koneksi kamera...</p>
                </div>
            </div>
        </div>

        <div class="panel-kanan">
            <div class="statistik">
                <h3>Total Plat Terdeteksi</h3>
                <h1>{{ $total_plat }}</h1>
            </div>

            <div class="statistik">
                <h3>Plat Hari Ini</h3>
                <h1>{{ $plat_today }}</h1>
            </div>

            <div class="statistik">
                <h3>Waktu Sekarang</h3>
                <h1 id="jam">00:00:00</h1>
                <p id="tanggal"></p>
            </div>
        </div>

    </div>

        <div class="tabel-container">
            <table>
                <thead>
                    <tr>
                        <th>Platnomor</th>
                        <th>Kendaraan</th>
                        <th>Gambar Plat</th>
                        <th>Waktu Terdeteksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($deteksi as $data)
                        <tr>
                            <td>{{ $data->platnomor_text }}</td>
                            <td>
                                <img src="{{ asset($data->kendaraan_path) }}">
                            </td>
                            <td>
                                <img src="{{ asset($data->platnomor_path) }}">
                            </td>
                            <td>{{ $data->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>

<script>
    setInterval(function() {
        location.reload();
    }, 8000);
</script>

<script>
    function updateJam() {
        const sekarang = new Date();

        document.getElementById('jam').textContent =
            sekarang.toLocaleTimeString('id-ID', {
                hour12: false
            });

        document.getElementById('tanggal').textContent =
            sekarang.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
    }

    updateJam();
    setInterval(updateJam, 1000);
</script>

<script>
    const stream = document.getElementById('live-stream');
    const offline = document.getElementById('stream-offline');

    function cobaKoneksi() {
        stream.src = 'http://127.0.0.1:5000/video?t=' + Date.now();
    }

    stream.onload = function() {
        offline.classList.add('hidden');
    };

    stream.onerror = function() {
        offline.classList.remove('hidden');

        setTimeout(cobaKoneksi, 3000);
    };
</script>