<?php


namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Repositories\AnggotaRepository;

class AnggotaController extends Controller
{
    protected $anggotaRepository;

    public function __construct(AnggotaRepository $anggotaRepository)
    {
        $this->anggotaRepository = $anggotaRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $anggotas = $this->anggotaRepository->getAllAnggota();

        if (request('search')) {
            $anggotas = $this->anggotaRepository->searchAnggota(request('search'));
        }

        return view('dashboard.anggota.index', compact('anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|unique:anggota,telepon',
            'email' => 'required|string|email|unique:anggota,email',
        ]);

        $data = $request->all();
        $this->anggotaRepository->storeAnggota($data);

        return redirect('/dashboard/anggota')->with('success', 'Anggota berhasil diregistrasi!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|unique:anggota,telepon,' . $id,
            'email' => 'required|string|email|unique:anggota,email,' . $id,
        ]);

        $data = $request->all();
        $this->anggotaRepository->updateAnggota($data, $id);

        return redirect('/dashboard/anggota')->with('success', 'Anggota berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->anggotaRepository->deleteAnggota($id);

        return redirect('/dashboard/anggota')->with('success', 'Anggota berhasil dihapus!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implementasi form untuk membuat anggota jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        // Implementasi form untuk mengedit anggota jika diperlukan
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        // Implementasi tampilan untuk menampilkan detail anggota jika diperlukan
    }

    /**
     * Display the specified resource.
     */
    public function cetakKartu($id)
    {
        // Panggil metode cetakKartu dari repository
        return $this->anggotaRepository->cetakKartu($id);
    }
}
