<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition()
    {
        $tanggalPeminjaman = $this->faker->dateTimeBetween('-1 year', 'now');
        $tanggalPengembalian = (clone $tanggalPeminjaman)->modify('+1 week');
        
        // Hanya tentukan tanggal dikembalikan jika statusnya Dikembalikan
        $status = $this->faker->randomElement(['Dipinjam', 'Dikembalikan']);
        $tanggalDikembalikan = $status === 'Dikembalikan' ? $this->faker->dateTimeBetween($tanggalPeminjaman, 'now') : null;

        return [
            'anggota_id' => \App\Models\Anggota::factory(), // Mengasumsikan Anda memiliki factory untuk Anggota
            'kode_peminjaman' => Str::random(10),
            'tanggal_peminjaman' => $tanggalPeminjaman,
            'tanggal_pengembalian' => $tanggalPengembalian,
            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'denda' => $this->faker->randomFloat(2, 0, 10000), // Denda dalam bentuk desimal
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
