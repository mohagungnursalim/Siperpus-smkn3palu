<?php

namespace App\Repositories\Interfaces;

interface BukuRepositoryInterface
{
    public function getAllBuku();
    public function searchBuku($keyword);
    public function storeBuku($data);
    public function updateBuku($data, $id);
    public function deleteBuku($id);
}