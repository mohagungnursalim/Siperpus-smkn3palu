<?php

namespace App\Providers;

use App\Repositories\AnggotaRepository;
use App\Repositories\BukuRepository;
use App\Repositories\Interfaces\AnggotaRepositoryInterface;
use App\Repositories\Interfaces\BukuRepositoryInterface;
use App\Repositories\Interfaces\KategoriRepositoryInterface;
use App\Repositories\KategoriRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(KategoriRepositoryInterface::class, KategoriRepository::class);
        $this->app->bind(BukuRepositoryInterface::class, BukuRepository::class);
        $this->app->bind(AnggotaRepositoryInterface::class, AnggotaRepository::class);
    }
}
