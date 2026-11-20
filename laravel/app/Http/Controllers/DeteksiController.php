<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deteksi;

class DeteksiController extends Controller
{
    public function index()
    {
        $deteksi = Deteksi::orderBy('date', 'desc')->get();
        $plat_today = Deteksi::whereDate('date', today())->count();
        $total_plat = Deteksi::count();

        return view(('deteksi.index'), compact('deteksi', 'plat_today', 'total_plat'));

    }
}
