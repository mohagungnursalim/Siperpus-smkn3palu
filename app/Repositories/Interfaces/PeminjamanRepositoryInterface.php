<?php

namespace App\Repositories\Interfaces;

use App\Models\Peminjaman;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

interface PeminjamanRepositoryInterface
{
    public function getAllPeminjaman(): Paginator;
    
    public function searchPeminjaman(string $keyword): Paginator;

    public function storePeminjaman(array $data): void;

    public function updatePeminjaman(Peminjaman $peminjaman, array $data): bool;

    public function deletePeminjaman($id): bool;
}