<?php

namespace App\Repositories;

use App\Models\Buku;

class BukuRepository
{
    public function getAllBuku()
    {
        return Buku::with('kategori')->oldest()->cursorPaginate(10)->withQueryString();
    }

    public function searchBuku($keyword)
    {
        return Buku::with('kategori')->where('judul_buku', 'like', '%' . $keyword . '%')->oldest()->cursorPaginate(10)->withQueryString();
    }

    public function storeBuku($data)
    {
        $buku = Buku::create($data);
        if (isset($data['kategori'])) {
            $buku->kategori()->attach($data['kategori']);
        }
        return $buku;
    }

    public function updateBuku($data, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($data);

        $buku->kategori()->detach();
        if (isset($data['kategori'])) {
            $buku->kategori()->attach($data['kategori']);
        }
        return $buku;
    }

    public function deleteBuku($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return $buku;
    }
}