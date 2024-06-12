<?php

namespace App\Repositories;

use App\Models\Anggota;
use Dompdf\Dompdf;
use Dompdf\Options;

class AnggotaRepository
{
    public function getAllAnggota()
    {
        return Anggota::oldest()->simplePaginate(10)->withQueryString();
    }

    public function searchAnggota($keyword)
    {
        return Anggota::where('nama_lengkap', 'like', '%' . $keyword . '%')->oldest()->simplePaginate(10)->withQueryString();
    }

    public function storeAnggota($data)
    {
        return Anggota::create($data);
    }

    public function updateAnggota($data, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->update($data);
        return $anggota;
    }

    public function deleteAnggota($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return $anggota;
    }

    public function cetakKartu($id)
    {
        // Temukan anggota berdasarkan ID
        $anggota = Anggota::findOrFail($id);

        // Konversi tampilan kartu anggota ke dalam bentuk HTML
        $html = view('dashboard.anggota.kartu', compact('anggota'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Buat instance Dompdf
        $dompdf = new Dompdf($options);

        // Muat HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Atur ukuran dan orientasi halaman
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Tampilkan PDF dalam browser atau unduh
        return $dompdf->stream('kartu_anggota_' . $anggota->nama_lengkap . '.pdf');
    }
}
