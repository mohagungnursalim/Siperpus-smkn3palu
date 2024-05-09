<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total_buku = Buku::count();
        $total_anggota = Anggota::count();
        $buku_dipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $buku_dikembalikan = Peminjaman::where('status', 'Dikembalikan')->count();

      // Ambil data jumlah peminjaman untuk setiap buku
        $top_books = DB::table('peminjaman_buku')
        ->select('buku_id', DB::raw('count(*) as total'))
        ->groupBy('buku_id')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        // Format data untuk grafik
        $data = [['Buku', 'Jumlah Peminjaman', ['role' => 'style']]];
        foreach ($top_books as $book) {
        // Ambil judul buku berdasarkan buku_id
        $judul_buku = \App\Models\Buku::findOrFail($book->buku_id)->judul_buku;

        // Buat warna acak
        $warna_acak = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

        // Tambahkan data ke array
        $data[] = [$judul_buku, $book->total, $warna_acak];
        }

        $chart_data_json = json_encode($data);
        return view('dashboard.dashboard.index',compact('total_buku','total_anggota', 'buku_dipinjam', 'buku_dikembalikan', 'chart_data_json'));
    }
}
