<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Repositories\KategoriRepository;
use App\Repositories\Interfaces\KategoriRepositoryInterface;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected KategoriRepositoryInterface $kategoriRepository;

    public function __construct(KategoriRepository $kategoriRepository)
    {
        $this->kategoriRepository = $kategoriRepository;
    }

    public function index()
    {
        if (request('search')) {
            $kategories = $this->kategoriRepository->searchKategori(request('search'));
        } else {
            $kategories = $this->kategoriRepository->getAllKategori();
        }

        return view('dashboard.kategori.index',compact('kategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ]);

        $this->kategoriRepository->createKategori($request->all());

        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:25',
        ]);

        $this->kategoriRepository->updateKategori($request->all(), $id);

        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->kategoriRepository->deleteKategori($id);

        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}