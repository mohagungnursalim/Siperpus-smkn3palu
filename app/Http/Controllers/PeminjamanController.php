<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Repositories\Interfaces\PeminjamanRepositoryInterface;
use Carbon\Carbon;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{

    protected $peminjamanRepository;

    public function __construct(PeminjamanRepositoryInterface $peminjamanRepository)
    {
        $this->peminjamanRepository = $peminjamanRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bukus = Buku::latest()->get();
        $anggotas = Anggota::latest()->get();
        $peminjamans = $this->peminjamanRepository->getAllPeminjaman()->withQueryString();
        
        if ($request->has('search')) {
            $peminjamans = $this->peminjamanRepository->searchPeminjaman($request->search)->withQueryString();
        } 
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
        $validasi = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array', // Pastikan buku_id merupakan array
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
        ]);
    
        // Panggil metode storePeminjaman dari repository untuk melakukan insert data
        $this->peminjamanRepository->storePeminjaman($validasi);

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
        $validatedData = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array', // Pastikan buku_id merupakan array
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'tanggal_dikembalikan' => 'required|date', // Pastikan tanggal_dikembalikan disertakan dalam validasi
            'status' => 'required', // Menambahkan aturan validasi untuk status
        ]);

        // Panggil metode updatePeminjaman dari repository untuk melakukan pembaruan data
        $this->peminjamanRepository->updatePeminjaman($peminjaman, $validatedData);

        // Redirect ke halaman dashboard dengan pesan sukses
        return redirect('/dashboard/peminjaman')->with('success', 'Peminjaman berhasil diperbarui!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->peminjamanRepository->deletePeminjaman($id);
        return redirect('/dashboard/peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
    }

    // public function exportExcel(Request $request)
    // {
    //     $bulan = $request->input('bulan', now()->month); // Default ke bulan ini jika tidak ada input
    //     $tahun = $request->input('tahun', now()->year); // Default ke tahun ini jika tidak ada input

    //     return Excel::download(new PeminjamanExport($bulan, $tahun, $this->peminjamanRepository), 'laporan-bulanan.xlsx');
    // }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', now()->month); // Default ke bulan ini jika tidak ada input
        $tahun = $request->input('tahun', now()->year); // Default ke tahun ini jika tidak ada input

        return Excel::download(new PeminjamanExport($bulan, $tahun, $this->peminjamanRepository), 'laporan-bulanan.xlsx');
    }
}
