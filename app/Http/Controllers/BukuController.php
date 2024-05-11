<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Repositories\BukuRepository;

class BukuController extends Controller
{
    protected $bukuRepository;

    public function __construct(BukuRepository $bukuRepository)
    {
        $this->bukuRepository = $bukuRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = $this->bukuRepository->getAllBuku();
        $kategories = Kategori::oldest()->get();

        if (request('search')) {
            $bukus = $this->bukuRepository->searchBuku(request('search'));
        }

        return view('dashboard.buku.index', compact('bukus', 'kategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|string|max:100',
            'judul_buku' => 'required|string',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'jumlah' => 'required|numeric',
            'kategori' => 'required|exists:kategori,id',
        ]);

        $data = $request->all();
        $this->bukuRepository->storeBuku($data);

        return redirect('/dashboard/buku')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_buku' => 'required|string|max:100',
            'judul_buku' => 'required|string',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'jumlah' => 'required|numeric',
            'kategori' => 'required|exists:kategori,id',
        ]);

        $data = $request->all();
        $this->bukuRepository->updateBuku($data, $id);

        return redirect('/dashboard/buku')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->bukuRepository->deleteBuku($id);

        return redirect('/dashboard/buku')->with('success', 'Buku berhasil dihapus!');
    }
}
