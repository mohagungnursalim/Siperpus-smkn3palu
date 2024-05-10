<?php

namespace App\Repositories\Interfaces;

interface KategoriRepositoryInterface 

{

    public function getAllKategori();
    public function searchKategori($keyword);
    public function createKategori($data);
    public function updateKategori($data, $id);
    public function deleteKategori($id);
}