
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANPR Parking System</title>

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
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #0f172a;
            color: white;
            padding: 25px 18px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 17px;
            font-weight: bold;
            padding: 5px 10px 35px;
            line-height: 1.4;
        }

        .brand-icon {
            background: #2563eb;
            width: 38px;
            height: 38px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .menu-title {
            color: #64748b;
            font-size: 11px;
            font-weight: bold;
            margin: 10px 10px 15px;
            letter-spacing: 1px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #cbd5e1;
            padding: 13px 14px;
            margin-bottom: 7px;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #2563eb;
            color: white;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: auto;
            background: #1e293b;
            border-radius: 10px;
            padding: 15px;
            font-size: 12px;
        }

        .online {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .online-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #22c55e;
        }

        .sidebar-bottom p {
            color: #94a3b8;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            gap: 20px;
        }

        .header h1 {
            font-size: 25px;
            margin-bottom: 7px;
        }

        .header p {
            color: #64748b;
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #dcfce7;
            color: #15803d;
            padding: 9px 13px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #22c55e;
            border-radius: 50%;
        }

        .tanggal {
            color: #64748b;
            font-size: 13px;
        }

        /* CONTENT GRID */
        .konten-utama {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 20px;
            margin-bottom: 25px;
            align-items: start;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            min-width: 0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 10px;
        }

        .card-header h3 {
            font-size: 16px;
        }

        .card-header span {
            font-size: 12px;
            color: #64748b;
        }

        /* CCTV STREAM */
        .stream-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            max-height: 260px;
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
            font-size: 13px;
        }

        .stream-offline.hidden {
            display: none;
        }

        .live-label {
            position: absolute;
            top: 12px;
            left: 12px;
            background-color: #dc2626;
            color: white;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
        }

        /* STATISTICS */
        .statistik-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .statistik {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .statistik h3 {
            font-size: 13px;
            color: #64748b;
            font-weight: normal;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .statistik h2 {
            font-size: 26px;
            color: #1e293b;
            overflow-wrap: anywhere;
        }

        .statistik p {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 8px;
        }

        /* TABLE */
        .tabel-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        thead {
            background-color: #f8fafc;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        th {
            color: #64748b;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        td img {
            width: 100px;
            height: 65px;
            object-fit: contain;
            border-radius: 6px;
        }

        .badge-masuk {
            background-color: #dcfce7;
            color: #15803d;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        .kosong {
            color: #94a3b8;
            padding: 25px;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .konten-utama {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 750px) {
            .sidebar {
                width: 190px;
            }

            .main-content {
                padding: 20px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 550px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .brand {
                padding-bottom: 15px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
            }

            .menu-title {
                display: none;
            }

            .menu a {
                padding: 10px;
            }

            .statistik-container {
                gap: 10px;
            }

            .statistik {
                padding: 15px;
            }

            .statistik h2 {
                font-size: 22px;
            }
        }

        @media (max-width: 380px) {
            .statistik-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            <div class="brand-icon">P</div>
            <div>
                CCTV<br>Parking System
            </div>
        </div>

        <div class="menu-title">MENU UTAMA</div>

        <nav class="menu">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <span class="menu-icon">...</span>
                Dashboard
            </a>

            <a href="/parkir-in" class="{{ request()->is('parkir-in') ? 'active' : '' }}">
                <span class="menu-icon">⇥</span>
                Parkir IN
            </a>

            <a href="#">
                <span class="menu-icon">⇤</span>
                Parkir OUT
            </a>

            <a href="#">
                <span class="menu-icon">▥</span>
                Laporan
            </a>

            <a href="#">
                <span class="menu-icon">⚙</span>
                Pengaturan
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER -->
        <div class="header">
            <div>
                <h1>Dashboard</h1>
                <p>Ringkasan aktivitas sistem parkir ANPR</p>
            </div>

            <div class="header-right">
                <div class="status">
                    <span class="status-dot"></span>
                    Sistem Online
                </div>

                <div class="tanggal" id="tanggal"></div>
            </div>
        </div>

        <!-- CCTV DAN STATISTIK -->
        <div class="konten-utama">

            <!-- LIVE STREAM CCTV -->
            <div class="card">
                <div class="card-header">
                    <h3>Live Stream CCTV</h3>
                    <span>Monitoring kamera</span>
                </div>

                <div class="stream-wrapper">
                    <img id="live-stream" src="http://127.0.0.1:5000/video">

                    <div class="live-label">LIVE</div>

                    <div id="stream-offline" class="stream-offline">
                        <h3>STREAM OFFLINE</h3>
                        <p>Menunggu koneksi kamera...</p>
                    </div>
                </div>
            </div>

            <!-- STATISTIK -->
            <div class="card">
                <div class="card-header">
                    <h3>Statistik Kendaraan</h3>
                </div>

                <div class="statistik-container">

                    <div class="statistik">
                        <h3>Total Plat Terdeteksi</h3>
                        <h2>{{ $total_plat }}</h2>
                        <p>Seluruh data dalam database</p>
                    </div>

                    <div class="statistik">
                        <h3>Plat Hari Ini</h3>
                        <h2>{{ $plat_today }}</h2>
                        <p>Plat terdeteksi hari ini</p>
                    </div>

                    <div class="statistik">
                        <h3>Kendaraan Masuk Hari Ini</h3>
                        <h2>—</h2>
                        <p>Data menunggu dari controller</p>
                    </div>

                    <div class="statistik">
                        <h3>Pendapatan Hari Ini</h3>
                        <h2>—</h2>
                        <p>Data menunggu dari controller</p>
                    </div>

                </div>
            </div>

        </div>

        <!-- TABEL DETEKSI TERBARU -->
        <div class="tabel-container">

            <div class="card-header">
                <h3>Deteksi Plat Terbaru</h3>
                <span>Data deteksi kendaraan</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Gambar Kendaraan</th>
                        <th>Gambar Plat</th>
                        <th>Waktu Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($deteksi as $data)
                        <tr>
                            <td>{{ $data->platnomor }}</td>

                            <td>
                                <img src="{{ asset($data->gambar_kendaraan) }}" alt="Gambar kendaraan">
                            </td>

                            <td>
                                <img src="{{ asset($data->gambar_plat) }}" alt="Gambar plat">
                            </td>

                            <td>{{ $data->waktu_masuk }}</td>

                            <td>
                                <span class="badge-masuk">Terdeteksi</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="kosong">
                                Belum ada data deteksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </main>
</div>

<script>
    // Jam dan tanggal
    function updateJam() {
        const sekarang = new Date();

        document.getElementById('tanggal').textContent =
            sekarang.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
    }

    updateJam();

    // Auto refresh dashboard
    setInterval(function() {
        location.reload();
    }, 8000);

    // Status live stream
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
</body>
</html>
