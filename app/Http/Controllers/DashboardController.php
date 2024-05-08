<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_buku = Buku::count();
        $total_anggota = Anggota::count();
        $buku_dipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $buku_dikembalikan = Peminjaman::where('status', 'Dikembalikan')->count();
        return view('dashboard.dashboard.index',compact('total_buku','total_anggota', 'buku_dipinjam', 'buku_dikembalikan'));
    }
}
