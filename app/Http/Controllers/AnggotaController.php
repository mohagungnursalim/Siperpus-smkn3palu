<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $anggotas = Anggota::oldest()->paginate(10)->WithQueryString();
       

        if (request('search')) {
            $anggotas = Anggota::where('nama_lengkap', 'like', '%' . request('search') . '%')->oldest()->paginate(10)->WithQueryString();
        } 

        return view('dashboard.anggota.index',compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:Teknik Konstruksi & Perumahan,Teknik Geospasial,Teknik Ketenagalistrikan,Teknik Mesin,Teknik Pengelasan & Fabrikasi Logam,Teknik Otomotif,Teknik Elektronika,Teknik Komputer Jaringan dan Telekomunikasi,Pengembangan Perangkat Lunak & Gim',
            'alamat' => 'required|string',
            'telepon' => 'required|unique:anggota,telepon',
            'email' => 'required|string|email|unique:anggota,email',
        ]);
    
        // Jika tidak ada kesalahan validasi, buat dan simpan data anggota ke dalam database
        Anggota::create([
            'nama_lengkap' => $request->nama_lengkap,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
        ]);
    
        return redirect('/dashboard/anggota')->with('success', 'Anggota berhasil diregistrasi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(anggota $anggota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota, $id)
    {
        // Temukan anggota yang ingin di-update
        $anggota = Anggota::findOrFail($id);

        // Perbandingkan nilai telepon dan email saat ini dengan nilai asli
        if ($request->telepon == $anggota->telepon && $request->email == $anggota->email) {
            // Jika nilai tidak berubah, lewati validasi unique
            $request->merge([
                'telepon' => $anggota->telepon,
                'email' => $anggota->email,
            ]);
        }
        // Validasi input yang diterima dari form
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:Teknik Konstruksi & Perumahan,Teknik Geospasial,Teknik Ketenagalistrikan,Teknik Mesin,Teknik Pengelasan & Fabrikasi Logam,Teknik Otomotif,Teknik Elektronika,Teknik Komputer Jaringan dan Telekomunikasi,Pengembangan Perangkat Lunak & Gim',
            'alamat' => 'required|string',
            'telepon' => 'required|unique:anggota,telepon,' . $anggota->id,
            'email' => 'required|string|email|unique:anggota,email,' . $anggota->id,
        ]);
      
        $anggota->update([
            'nama_lengkap' => $request->nama_lengkap,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
        ]);

        return redirect('/dashboard/anggota')->with('success', 'Anggota berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->delete();

        return redirect('/dashboard/anggota')->with('success', 'Anggota berhasil dihapus!');

    }
}