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

    public function getTotalDenda(): int
    {
        return Peminjaman::sum('denda');
    }

    public function getChartData(): array
    {
        // Mengambil data peminjaman dan mengelompokkan berdasarkan bulan
        $monthlyLoans = DB::table('peminjaman')
            ->select(DB::raw('DATE_FORMAT(tanggal_peminjaman, "%m-%Y") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Menyusun data dalam format yang sesuai untuk chart
        $data = [['Bulan', 'Jumlah Peminjaman']];
        foreach ($monthlyLoans as $loan) {
            $data[] = [$loan->month, $loan->total];
        }

        return $data;
    }
}
