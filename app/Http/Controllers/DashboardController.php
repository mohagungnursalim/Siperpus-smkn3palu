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
        $total_denda = $this->dashboardRepository->getTotalDenda();        
        // Mengambil data peminjaman per bulan
        $chartData = $this->dashboardRepository->getChartData();

        // Mengirim data peminjaman per bulan ke view
        return view('dashboard.dashboard.index', compact('total_buku', 'total_anggota', 'buku_dipinjam', 'buku_dikembalikan', 'total_denda', 'chartData'));
     }
}
