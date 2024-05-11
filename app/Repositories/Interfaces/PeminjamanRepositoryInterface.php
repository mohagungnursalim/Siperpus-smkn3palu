<?php

namespace App\Repositories\Interfaces;

use App\Models\Peminjaman;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;

interface PeminjamanRepositoryInterface
{
    public function getAllPeminjaman(): CursorPaginator;

    public function searchPeminjaman(string $keyword): CursorPaginator;

    public function storePeminjaman(array $data): void;

    public function updatePeminjaman(Peminjaman $peminjaman, array $data): bool;

    public function deletePeminjaman($id): bool;
}