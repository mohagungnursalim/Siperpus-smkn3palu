<?php

namespace App\Repositories;

use App\Models\kategori;
use App\Repositories\Interfaces\KategoriRepositoryInterface;

class KategoriRepository implements KategoriRepositoryInterface

{
    public function getAllKategori()
    {
        return kategori::oldest()->simplePaginate(10)->withQueryString();
    }

    public function searchKategori($keyword)
    {
        return kategori::where('nama_kategori', 'like', '%' . $keyword . '%')->oldest()->simplePaginate(10)->withQueryString();
    }

    public function getKategoriById($id)
    {
        return Kategori::findOrFail($id);
    }

    public function createKategori($data)
    {
        return Kategori::create($data);
    }

    public function updateKategori($data, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($data);
        return $kategori; 
    }

    public function deleteKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        
        return $kategori;
    }

}