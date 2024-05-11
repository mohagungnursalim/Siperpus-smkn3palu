<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
     
        $bukus = Buku::latest()->get();
        $anggotas = Anggota::latest()->get();
        $peminjamans = Peminjaman::with('bukus','anggota')->oldest();
        
        // Query pencarian berdasarkan kode_peminjaman,nama_lengkap & judul buku
        if (request('search')) {
            $peminjamans = Peminjaman::with('bukus', 'anggota')
                    ->where('kode_peminjaman', 'like', '%' . request('search') . '%')
                    ->orWhereHas('anggota', function ($query) {
                        $query->where('nama_lengkap', 'like', '%' . request('search') . '%');
                    })->orWhereHas('bukus', function ($query) {
                        $query->where('judul_buku', 'like', '%' . request('search') . '%');
                    })->oldest();
        } 

        $peminjamans = $peminjamans->cursorPaginate(10)->WithQueryString();
        return view('dashboard.peminjaman.index',compact('peminjamans','bukus','anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array', // Pastikan buku_id merupakan array
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
        ]);
    
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
            'anggota_id' => $request->anggota_id,
            'kode_peminjaman' => $kode_peminjaman,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);
    
        // Attach buku_id ke tabel peminjaman_buku
        $peminjaman->bukus()->attach($request->buku_id);
    
        return redirect('/dashboard/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array', // Pastikan buku_id merupakan array
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'status' => 'nullable', // Menambahkan aturan validasi untuk status
        ]);
    

       // Hitung perbedaan hari antara tanggal pengembalian dan tanggal dikembalikan
        $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);
        $tanggalDikembalikan = Carbon::parse($request->tanggal_dikembalikan);
        $perbedaanHari = $tanggalPengembalian->diffInDays($tanggalDikembalikan);

        // Hitung denda berdasarkan tarif denda per hari
        $tarifDendaPerHari = 1000;
        $denda = $perbedaanHari * $tarifDendaPerHari;

        // Perbarui data peminjaman
        $peminjaman->update([
            'anggota_id' => $request->anggota_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'tanggal_dikembalikan' => $request->tanggal_dikembalikan,
            'denda' => $denda, // Simpan denda yang dihitung
            'status' => $request->status
        ]);
        // Sinkronkan buku_id ke tabel pivot peminjaman_buku
        $peminjaman->bukus()->sync($request->buku_id);
    
        return redirect('/dashboard/peminjaman')->with('success', 'Peminjaman berhasil diperbarui!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect('/dashboard/peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
