<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deteksi;

class DeteksiController extends Controller
{
    public function index()
    {
        $deteksi = Deteksi::orderBy('waktu_masuk', 'desc')->get();
        $plat_today = Deteksi::whereDate('waktu_masuk', today())->count();
        $total_plat = Deteksi::count();
        $parkir_in = Deteksi::whereNull('waktu_keluar')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        $parkir_out = Deteksi::whereNull('waktu_keluar')
            ->orderBy('waktu_keluar', 'desc')
            ->get();

        return view(('deteksi.index'), compact('deteksi', 'plat_today', 'total_plat', 'parkir_in', 'parkir_out'));

    }

    public function parkirin(Request $request)
    {
        $query = Deteksi::whereNull('waktu_keluar');
        $total_masuk = Deteksi::whereDate('waktu_masuk', today())->count();
        $kendaraan_parkir = Deteksi::whereNull('waktu_keluar')->count();
        $rata_durasi = Deteksi::whereNull('waktu_keluar')
            ->whereDate('waktu_keluar', today())
            ->avg('durasi_parkir');

        $rata_durasi = round($rata_durasi ?? 0);
        $parkir_in = $query->orderBy('waktu_masuk', 'desc')
            ->paginate(5)
            ->withQueryString();
           
        if ($request->filled('cari'))
            {
                $query->where('platnomor', 'like', '%' . $request->cari . '%');
            }

        if ($request->filled('jenis'))
            {
                $query->where('jenis', $request->jenis);
            }
        
        return view('deteksi.parkirin', compact('parkir_in', 'total_masuk', 'kendaraan_parkir', 'rata_durasi'));
    }
}
