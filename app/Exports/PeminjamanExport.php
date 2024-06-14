<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Repositories\PeminjamanRepository;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;
    protected $peminjamanRepository;

    public function __construct($bulan, $tahun, PeminjamanRepository $peminjamanRepository)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->peminjamanRepository = $peminjamanRepository;
    }

    public function collection()
    {
        return $this->peminjamanRepository->getPeminjamanByMonthAndYear($this->bulan, $this->tahun);
    }

    public function headings(): array
    {
        return [
            'Nama Anggota',
            'Buku Dipinjam',
            'Kode Peminjaman',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Denda',
            'Status'
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->anggota->nama_lengkap,
            $peminjaman->bukus->map(function($buku) {
                return $buku->judul_buku;
            })->join(', '), // Menggabungkan judul buku yang dipinjam
            $peminjaman->kode_peminjaman,
            $peminjaman->tanggal_peminjaman,
            $peminjaman->tanggal_pengembalian,
            $peminjaman->denda,
            $peminjaman->status
        ];
    }
}
