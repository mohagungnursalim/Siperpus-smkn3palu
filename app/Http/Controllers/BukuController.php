<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::with('kategori')->oldest();
        $kategories = Kategori::oldest()->get();

        if (request('search')) {
            $bukus->with('kategori')->where('judul_buku', 'like' , '%' . request('search') . '%' );
        }

        $bukus = $bukus->cursorPaginate(2)->WithQueryString();

        // dd($bukus);
        return view('dashboard.buku.index',compact('bukus','kategories'));
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
            'kode_buku' => 'required|string|max:100',
            'judul_buku' => 'required|string',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'jumlah' => 'required|numeric',
            'kategori' => 'required|exists:kategori,id',

        ]);

        // Buat dan simpan data buku ke dalam database
        $buku = Buku::create([
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->tahun_terbit,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah' => $request->jumlah
        ]);

            // Tambahkan kategori buku
        if ($request->has('kategori')) {
            $buku->kategori()->attach($request->kategori);
        }
    
        return redirect('/dashboard/buku')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'kode_buku' => 'required|string|max:100',
            'judul_buku' => 'required|string',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'jumlah' => 'required|numeric',
            'kategori' => 'required|exists:kategori,id',
        ]);
    
        // Temukan buku yang ingin di-update
        $buku = Buku::findOrFail($id);
    
        // Perbarui data buku
        $buku->update([
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->tahun_terbit,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah' => $request->jumlah
        ]);
    
        // Hapus kategori buku yang terhubung sebelumnya
        $buku->kategori()->detach();
    
        // Tambahkan kategori buku yang baru
        if ($request->has('kategori')) {
            $buku->kategori()->attach($request->kategori);
        }
    
        return redirect('/dashboard/buku')->with('success', 'Buku berhasil diperbarui!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete($buku);

        return redirect('/dashboard/buku')->with('success', 'Buku berhasil dihapus!');
    }
}
