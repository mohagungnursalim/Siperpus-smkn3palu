<?php

namespace App\Repositories;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Repositories\Interfaces\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getTotalBuku(): int
    {
        return Buku::count();
    }

    public function getTotalAnggota(): int
    {
        return Anggota::count();
    }

    public function getBukuDipinjam(): int
    {
        return Peminjaman::where('status', 'Dipinjam')->count();
    }

    public function getBukuDikembalikan(): int
    {
        return Peminjaman::where('status', 'Dikembalikan')->count();
    }

    public function getChartData(): array
    {
        $topBooks = DB::table('peminjaman_buku')
            ->select('buku_id', DB::raw('count(*) as total'))
            ->groupBy('buku_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $data = [['Buku', 'Jumlah Peminjaman', ['role' => 'style']]];
        foreach ($topBooks as $book) {
            $judulBuku = Buku::findOrFail($book->buku_id)->judul_buku;
            $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $data[] = [$judulBuku, $book->total, $randomColor];
        }

        return $data;
    }
}
