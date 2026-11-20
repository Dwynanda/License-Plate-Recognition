
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkir IN - ANPR Parking</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
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

        /* MAIN */
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            font-size: 32px;
            color: #2563eb;
        }

        .header h1 {
            font-size: 25px;
            margin-bottom: 6px;
        }

        .header p {
            font-size: 13px;
            color: #64748b;
        }

        .breadcrumb {
            font-size: 12px;
            color: #64748b;
        }

        .breadcrumb a {
            color: #1e293b;
            text-decoration: none;
        }

        /* STATISTICS */
        .statistik-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .statistik {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border-radius: 12px;
            min-width: 0;
        }

        .statistik:nth-child(1) {
            background: #dbeafe;
            border: 1px solid #bfdbfe;
        }

        .statistik:nth-child(2) {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
        }

        .statistik:nth-child(3) {
            background: #ede9fe;
            border: 1px solid #ddd6fe;
        }

        .statistik-icon {
            font-size: 35px;
            width: 55px;
            text-align: center;
            flex-shrink: 0;
        }

        .statistik:nth-child(1) .statistik-icon {
            color: #2563eb;
        }

        .statistik:nth-child(2) .statistik-icon {
            color: #0d9488;
        }

        .statistik:nth-child(3) .statistik-icon {
            color: #7c3aed;
        }

        .statistik h3 {
            font-size: 13px;
            font-weight: normal;
            margin-bottom: 7px;
        }

        .statistik h2 {
            font-size: 25px;
            overflow-wrap: anywhere;
        }

        .statistik p {
            font-size: 11px;
            color: #64748b;
            margin-top: 6px;
        }

        /* TABLE CARD */
        .tabel-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .tabel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .tabel-header h3 {
            font-size: 17px;
        }

        .filter-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-container input,
        .filter-container select {
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            outline: none;
            font-size: 12px;
            background: white;
        }

        .filter-container input {
            width: 180px;
        }

        .filter-container input:focus,
        .filter-container select:focus {
            border-color: #2563eb;
        }

        .filter-container button {
            padding: 9px 14px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            font-size: 12px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            min-width: 950px;
        }

        thead {
            background: #f8fafc;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            white-space: nowrap;
        }

        th {
            color: #64748b;
            font-weight: bold;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        td img {
            width: 110px;
            height: 48px;
            object-fit: contain;
            border-radius: 6px;
        }

        .jenis {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .jenis-mobil {
            background: #dbeafe;
            color: #2563eb;
        }

        .jenis-motor {
            background: #dcfce7;
            color: #15803d;
        }

        .jenis-lain {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-masuk {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .kosong {
            color: #94a3b8;
            padding: 30px;
        }

        /* PAGINATION */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: #64748b;
            font-size: 12px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            min-width: 30px;
            text-align: center;
            padding: 7px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            text-decoration: none;
            color: #334155;
            font-size: 12px;
        }

        .pagination .active span {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .pagination .disabled span {
            color: #cbd5e1;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .statistik-container {
                grid-template-columns: repeat(2, 1fr);
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

            .menu-title,
            .sidebar-bottom {
                display: none;
            }

            .menu a {
                padding: 10px;
            }

            .statistik-container {
                grid-template-columns: 1fr;
            }

            .filter-container {
                width: 100%;
            }

            .filter-container input {
                flex: 1;
                min-width: 120px;
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
            <a href="/">
                <span class="menu-icon">⌂</span>
                Dashboard
            </a>

            <a href="/parkir-in" class="{{ request()->is('parkir-in') ? 'active' : '' }}">
                <span class="menu-icon">...</span>
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

        <div class="sidebar-bottom">
            <div class="online">
                <span class="online-dot"></span>
                Sistem Online
            </div>
            <p id="waktu-sidebar"></p>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER -->
        <div class="header">

            <div class="header-left">
                <div class="header-icon">⇥</div>

                <div>
                    <h1>Parkir IN</h1>
                    <p>Kendaraan yang masuk ke area parkir</p>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="/">⌂ Dashboard</a>
                &nbsp;›&nbsp; Parkir IN
            </div>

        </div>

        <!-- STATISTIK -->
        <div class="statistik-container">

            <div class="statistik">
                <div class="statistik-icon">🚘</div>

                <div>
                    <h3>Total Masuk Hari Ini</h3>
                    <h2>{{ $total_masuk }}</h2>
                    <p>Jumlah kendaraan masuk hari ini</p>
                </div>
            </div>

            <div class="statistik">
                <div class="statistik-icon">◷</div>

                <div>
                    <h3>Rata-rata Waktu Parkir</h3>
                    <h2>{{ intdiv($rata_durasi, 60) }} jam {{ $rata_durasi % 60 }} menit</h2>
                    <p>Rata-rata durasi kendaraan keluar hari ini</p>
                </div>
            </div>

            <div class="statistik">
                <div class="statistik-icon">🚙</div>

                <div>
                    <h3>Kendaraan Aktif</h3>
                    <h2>{{ $kendaraan_parkir }}</h2>
                    <p>Kendaraan yang masih berada di area parkir</p>
                </div>
            </div>

        </div>

        <!-- DAFTAR PARKIR IN -->
        <div class="tabel-container">

            <div class="tabel-header">

                <h3>🚘 &nbsp; Daftar Parkir IN</h3>

                <form action="/parkir-in" method="GET" class="filter-container">

                    <input
                        type="text"
                        name="cari"
                        placeholder="Cari plat nomor..."
                        value="{{ request('cari') }}"
                    >

                    <select name="jenis">
                        <option value="">Semua Jenis</option>
                        <option value="Mobil" {{ request('jenis') == 'Mobil' ? 'selected' : '' }}>
                            Mobil
                        </option>
                        <option value="Motor" {{ request('jenis') == 'Motor' ? 'selected' : '' }}>
                            Motor
                        </option>
                        <option value="Bus" {{ request('jenis') == 'Bus' ? 'selected' : '' }}>
                            Bus
                        </option>
                        <option value="Truk" {{ request('jenis') == 'Truk' ? 'selected' : '' }}>
                            Truk
                        </option>
                    </select>

                    <button type="submit">Cari</button>

                </form>

            </div>

            <div class="table-wrapper">

                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar Kendaraan</th>
                            <th>Gambar Plat</th>
                            <th>Plat Nomor</th>
                            <th>Jenis Kendaraan</th>
                            <th>Waktu Masuk</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($parkir_in as $index => $data)

                            <tr>
                                <td>{{ $parkir_in->firstItem() + $index }}</td>

                                <td>
                                    <img
                                        src="{{ asset($data->gambar_kendaraan) }}"
                                        alt="Gambar kendaraan"
                                    >
                                </td>

                                <td>
                                    <img
                                        src="{{ asset($data->gambar_plat) }}"
                                        alt="Gambar plat"
                                    >
                                </td>

                                <td>
                                    <strong>{{ $data->platnomor }}</strong>
                                </td>

                                <td>
                                    @php
                                        $jenis = strtolower($data->jenis_kendaraan ?? '');
                                        $classJenis = $jenis === 'mobil'
                                            ? 'jenis-mobil'
                                            : ($jenis === 'motor' ? 'jenis-motor' : 'jenis-lain');
                                    @endphp

                                    <span class="jenis {{ $classJenis }}">
                                        {{ $data->jenis_kendaraan }}
                                    </span>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($data->waktu_masuk)->format('d/m/Y H:i:s') }}
                                </td>

                                <td>
                                    <span class="badge-masuk">● Masuk</span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="kosong">
                                    Belum ada kendaraan yang sedang parkir.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>

            <!-- PAGINATION -->
            <div class="pagination-container">

                <div class="pagination-info">
                    @if ($parkir_in->total() > 0)
                        Menampilkan {{ $parkir_in->firstItem() }}–{{ $parkir_in->lastItem() }}
                        dari {{ $parkir_in->total() }} data
                    @else
                        Tidak ada data
                    @endif
                </div>

                <div class="pagination">
                    {{ $parkir_in->onEachSide(1)->links('pagination::simple-bootstrap-5') }}
                </div>

            </div>

        </div>

    </main>
</div>

<script>
    // Waktu sidebar
    function updateWaktu() {
        const sekarang = new Date();

        document.getElementById('waktu-sidebar').textContent =
            sekarang.toLocaleTimeString('id-ID', {
                hour12: false
            }) + ' • ' +
            sekarang.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            });
    }

    updateWaktu();
    setInterval(updateWaktu, 1000);

    // Auto refresh halaman
    setInterval(function() {
        location.reload();
    }, 8000);
</script>

</body>
</html>
