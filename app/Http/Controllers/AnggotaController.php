<?php

namespace App\Http\Controllers;

use App\Models\anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        return view('dashboard.anggota.index');
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
                'alamat' => 'required|string',
                'telepon' => 'required|integer',
                'email' => 'required|string|email|unique:anggota,email',
            ]);

            // Membuat dan menyimpan data anggota ke dalam database
            Anggota::create([
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
            ]);

            return redirect('/dashboard/anggota')->with('success','Anggota berhasil diregistrasi!');

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
    public function update(Request $request, anggota $anggota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(anggota $anggota)
    {
        //
    }
}
