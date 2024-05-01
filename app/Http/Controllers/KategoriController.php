<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategories = Kategori::oldest()->paginate(10)->WithQueryString();

        if (request('search')) {
            $kategories = Kategori::where('nama_kategori', 'like' , '%' . request('search') . '%' )->oldest()->paginate(10)->WithQueryString();
        }

        return view('dashboard.kategori.index',compact('kategories'));
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
            'nama_kategori' => 'required|string|max:25',
        ]);
    
        // Jika tidak ada kesalahan validasi, buat dan simpan data anggota ke dalam database
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,

        ]);
    
        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kategori $kategori, $id)
    {
        // mencari kategori berdasarkan id
        $kategori = Kategori::findOrFail($id);

          // Validasi input yang diterima dari form
          $request->validate([
            'nama_kategori' => 'required|string|max:25',
        ]);
    
        // Jika tidak ada kesalahan validasi, buat dan simpan data kategori ke dalam database
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,

        ]);
    
        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kategori $kategori,$id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
