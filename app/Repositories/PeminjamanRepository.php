<?php

namespace App\Repositories;

use App\Models\Peminjaman;
use App\Repositories\Interfaces\PeminjamanRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\CursorPaginator;

class PeminjamanRepository implements PeminjamanRepositoryInterface
{
    public function getAllPeminjaman(): CursorPaginator
    {
        return Peminjaman::with('bukus', 'anggota')->oldest()->cursorPaginate(10)->withQueryString();
    }

    public function searchPeminjaman(string $keyword): CursorPaginator
    {
        return Peminjaman::with('bukus', 'anggota')
            ->where('kode_peminjaman', 'like', '%' . $keyword . '%')
            ->orWhereHas('anggota', function ($query) use ($keyword) {
                $query->where('nama_lengkap', 'like', '%' . $keyword . '%');
            })->orWhereHas('bukus', function ($query) use ($keyword) {
                $query->where('judul_buku', 'like', '%' . $keyword . '%');
            })->oldest()->cursorPaginate(10)->withQueryString();
    }

    public function storePeminjaman(array $data): void
    {
         // Dapatkan tahun sekarang
         $tahun_sekarang = date('Y');
        
         // Dapatkan bulan sekarang
         $bulan_sekarang = date('m');
         
         // Dapatkan nomor urut terakhir dari tabel peminjaman
         $nomor_urut_terakhir = Peminjaman::max('id');
         
         // Jika belum ada data peminjaman, nomor urut dimulai dari 1
         if (!$nomor_urut_terakhir) {
             $nomor_urut_terakhir = 0;
         }
         
         // Tambahkan 1 ke nomor urut terakhir untuk mendapatkan nomor urut berikutnya
         $nomor_urut_berikutnya = $nomor_urut_terakhir + 1;
         
         // Format nomor urut dengan padding nol di depan jika diperlukan
         $nomor_urut_format = str_pad($nomor_urut_berikutnya, 2, '0', STR_PAD_LEFT);
         
         // Buat kode peminjaman dengan format yang diinginkan
         $kode_peminjaman = 'P' . $tahun_sekarang . $bulan_sekarang . $nomor_urut_format;
        // Buat dan simpan data peminjaman ke dalam database
        $peminjaman = Peminjaman::create([
            'anggota_id' => $data['anggota_id'],
            'kode_peminjaman' => $kode_peminjaman,
            'tanggal_peminjaman' => $data['tanggal_peminjaman'],
            'tanggal_pengembalian' => $data['tanggal_pengembalian'],
        ]);

        // Attach buku_id ke tabel peminjaman_buku
        $peminjaman->bukus()->attach($data['buku_id']);
    }

    public function updatePeminjaman(Peminjaman $peminjaman, array $data): bool
    {
        // Hitung perbedaan hari antara tanggal pengembalian dan tanggal dikembalikan
        $tanggalPeminjaman = Carbon::parse($peminjaman->tanggal_peminjaman);
        $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);
        $tanggalDikembalikan = Carbon::parse($data['tanggal_dikembalikan']);

        // Inisialisasi variabel denda
        $denda = 0;

         // Periksa apakah tanggal dikembalikan berada di antara tanggal peminjaman dan tanggal pengembalian
        if ($tanggalDikembalikan->between($tanggalPeminjaman, $tanggalPengembalian)) {
            // Jika ya, set denda menjadi 0
            $denda = 0;
        // Periksa apakah tanggal peminjaman sama dengan tanggal dikembalikan
        } elseif ($tanggalPeminjaman->equalTo($tanggalDikembalikan)){
            // jika ya,set denda menjadi 0
            $denda = 0;
        } else {
            // Jika tidak, hitung perbedaan hari dan tentukan denda
            $perbedaanHari = $tanggalPengembalian->diffInDays($tanggalDikembalikan);
            // Hitung denda berdasarkan tarif denda per hari
            $tarifDendaPerHari = 1000;
            $denda = $perbedaanHari * $tarifDendaPerHari;
        }

        // Perbarui data peminjaman
        $peminjaman->update([
            'anggota_id' => $data['anggota_id'],
            'tanggal_peminjaman' => $data['tanggal_peminjaman'],
            'tanggal_pengembalian' => $data['tanggal_pengembalian'],
            'tanggal_dikembalikan' => $data['tanggal_dikembalikan'],
            'denda' => $denda, // Simpan denda yang dihitung
            'status' => $data['status']
        ]);

        // Sinkronkan buku_id ke tabel pivot peminjaman_buku
        $peminjaman->bukus()->sync($data['buku_id']);

        // Kembalikan true karena pembaruan berhasil
        return true;
    }

    public function deletePeminjaman($id): bool
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return $peminjaman->delete();
    }
}
