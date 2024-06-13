<?php

namespace App\Repositories\Interfaces;

interface AnggotaRepositoryInterface
{
    public function getAllAnggota();
    public function searchAnggota($keyword);
    public function storeAnggota($data);
    public function updateAnggota($data, $id);
    public function findAnggotaById($data, $id);
    public function deleteAnggota($id);
    public function cetakKartu($id);
}
