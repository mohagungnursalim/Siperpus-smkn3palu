<?php

namespace App\Repositories\Interfaces;

interface DashboardRepositoryInterface
{
    public function getTotalBuku(): int;

    public function getTotalAnggota(): int;

    public function getBukuDipinjam(): int;

    public function getBukuDikembalikan(): int;

    public function getChartData(): array;
}
