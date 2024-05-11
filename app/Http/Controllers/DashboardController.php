<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\DashboardRepositoryInterface;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardRepositoryInterface $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index(): View
    {
        $total_buku = $this->dashboardRepository->getTotalBuku();
        $total_anggota = $this->dashboardRepository->getTotalAnggota();
        $buku_dipinjam = $this->dashboardRepository->getBukuDipinjam();
        $buku_dikembalikan = $this->dashboardRepository->getBukuDikembalikan();
        $chart_data_json = json_encode($this->dashboardRepository->getChartData());

        return view('dashboard.dashboard.index', compact('total_buku', 'total_anggota', 'buku_dipinjam', 'buku_dikembalikan', 'chart_data_json'));
    }
}
