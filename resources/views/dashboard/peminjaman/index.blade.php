@extends('dashboard.layouts.main')
@section('judul-halaman')
Peminjaman
@endsection

@section('konten')

<!-- Include CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<div class="container">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">

                            <div class="container">
                                <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                    data-bs-target="#inputModal">
                                    Tambah Peminjaman
                                </button>
                            </div>

                            <form action="{{ route('peminjaman.index') }}" method="GET">
                                <div class="container">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-4">
                                            <div class="input-group input-group-outline my-3">

                                                <input type="text" name="search" placeholder="Cari pinjaman.."
                                                    class="form-control">
                                                <button type="submit">Search</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if (session('success'))
                            <div id="alertContainer" class="alert alert-success alert-dismissible text-white fade show"
                                role="alert">
                                <span class="alert-icon align-middle">
                                    <span class="material-icons text-md">
                                        thumb_up_off_alt
                                    </span>
                                </span>
                                <span class="alert-text"><strong>Success!</strong> {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            @if ($peminjamans->count())           
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kode Peminjaman
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Peminjam
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Buku Dipinjam
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Peminjaman
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Pengembalian
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Denda
                                        </th>

                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjamans as $peminjaman)

                                    <tr>
                                        <td class="text-wrap">
                                            <p class="text-xs font-weight-bold mb-0">{{$peminjaman->kode_peminjaman}}
                                            </p>
                                        </td>
                                        <td class="text-wrap">
                                            <div class="d-flex px-2 py-1 text-center">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ optional($peminjaman->anggota)->nama_lengkap }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            @foreach ($peminjaman->bukus as $index => $buku)
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $buku->judul_buku }}@if ($index < count($peminjaman->bukus) - 1),@endif
                                            </span>
                                            @endforeach
                                        </td>
                                        <td class="text-wrap">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ optional($peminjaman->tanggal_peminjaman)->format('d/M/Y') }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ optional($peminjaman->tanggal_pengembalian)->format('d/M/Y') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($peminjaman->status == 'Dipinjam')
                                            <small><button class="badge bg-secondary"
                                                    style="border: 0ch">{{ $peminjaman->status}}</button></small>
                                            @elseif ($peminjaman->status == 'Dikembalikan')
                                            <small><button class="badge bg-success"
                                                    style="border: 0ch">{{ $peminjaman->status}}</button></small>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{-- @if($denda > 0) --}}

                                                <span
                                                    class="text-secondary text-xs font-weight-bold">Rp{{ number_format($denda, 0, ',', '.') }}</span>
                                                {{-- @else
                                                <span class="text-secondary text-xs font-weight-bold">Rp0</span>
                                                @endif --}}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="badge bg-gradient-warning" style="border: 0ch"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{$peminjaman->id}}">Edit</button>
                                            <button class="badge bg-gradient-danger" style="border: 0ch"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{$peminjaman->id}}">Delete</button>
                                        </td>

                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>

                            @else
                            <div class="container d-flex justify-content-center">
                                <h4 class="text-dark text-bold">Data tidak ditemukan! <span
                                        class="material-symbols-outlined">
                                        sentiment_dissatisfied
                                    </span></h4>
                            </div>
                            @endif


                            <div class="d-flex justify-content-center mb-3 mt-4">
                                {{ $peminjamans->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Modal Tambah Anggota --}}
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah Peminjaman</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <form method="post" action="{{ route('peminjaman.store') }}">
                        @csrf
                        <label class="form-label">Nama Peminjam</label>
                        <div class="input-group input-group-outline @error('anggota_id') is-invalid @enderror mb-1">
                            <select name="anggota_id" style="width: 100%;" class="form-control">
                                <option>--Pilih Anggota--</option>
                                @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}">{{ $anggota->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('anggota_id')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        <label class="form-label">Buku</label>
                        <div class="input-group input-group-outline @error('buku_id') is-invalid @enderror mb-1">
                            <select id="buku" name="buku_id[]" multiple style="width: 100%;" class="form-control">
                                <option>--Pilih Buku--</option>
                                @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}">{{ $buku->judul_buku }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('buku_id')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        <label class="form-label">Tanggal Peminjaman</label>
                        <div
                            class="input-group input-group-outline @error('tanggal_peminjaman') is-invalid @enderror mb-1">
                            <input type="date" name="tanggal_peminjaman" value="{{old('tanggal_peminjaman')}}"
                                class="form-control">
                        </div>
                        @error('tanggal_peminjaman')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        <label class="form-label">Tanggal Pengembalian</label>
                        <div
                            class="input-group input-group-outline @error('tanggal_pengembalian') is-invalid @enderror mb-1">
                            <input type="date" name="tanggal_pengembalian" value="{{old('tanggal_pengembalian')}}"
                                class="form-control">
                        </div>
                        @error('tanggal_pengembalian')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn bg-gradient-info">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Peminjaman --}}
@foreach ($peminjamans as $peminjaman)
<div class="modal fade" id="editModal{{$peminjaman->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Edit Data Peminjaman</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="p-4">
                <form method="post" action="{{ route('peminjaman.update',$peminjaman->id) }}">
                    @csrf
                    @method('put')
                    <label class="form-label">Nama Peminjam</label>
                    <div class="input-group input-group-outline @error('anggota_id') is-invalid @enderror mb-1">
                        <select name="anggota_id" style="width: 100%;" class="form-control">
                            <option>--Pilih Anggota--</option>
                            @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id }}" {{ $peminjaman->anggota_id == $anggota->id ? 'selected' : '' }}>{{ $anggota->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('nama_lengkap')
                    <p class="text-bold text-xs text-danger">{{ $message }}</p>
                    @enderror
                    
                    <label class="form-label">Buku</label>
                    <div class="input-group input-group-outline @error('judul_buku') is-invalid @enderror mb-1">
                        <select name="buku_id[]" style="width: 100%;" multiple class="form-control editbuku">
                            @foreach($bukus as $buku)
                                @php
                                    $isSelected = in_array($buku->id, $peminjaman->bukus->pluck('id')->toArray());
                                @endphp
                                <option value="{{ $buku->id }}" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $buku->judul_buku }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('buku_id')
                    <p class="text-bold text-xs text-danger">{{ $message }}</p>
                    @enderror

                      {{-- Tanggal Peminjaman --}}
                      <input type="hidden" required name="tanggal_peminjaman" value="{{ $peminjaman->tanggal_peminjaman ? $peminjaman->tanggal_peminjaman->format('Y-m-d') : '' }}">  
                      <label class="form-label mt-1">Tanggal Peminjaman</label>
                      <div class="input-group mb-2">
                      <div class="input-group input-group-outline @error('tanggal_peminjaman') is-invalid @enderror mb-1">
                          <input type="date" required name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman', $peminjaman->tanggal_peminjaman ? $peminjaman->tanggal_peminjaman->format('Y-m-d') : '') }}"
                              class="form-control">
                      </div>
                      </div>
                      @error('tanggal_peminjaman')
                      <p class="text-bold text-xs text-danger">{{ $message }}</p>
                      @enderror

                    {{-- Tanggal Pengembalian --}}
                    <input type="hidden" required name="tanggal_pengembalian" value="{{ $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->format('Y-m-d') : '' }}">  
                    <label class="form-label mt-1">Tanggal Pengembalian</label>
                    <div class="input-group mb-2">
                    <div class="input-group input-group-outline @error('tanggal_pengembalian') is-invalid @enderror mb-1">
                        <input type="date" required name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->format('Y-m-d') : '') }}"
                            class="form-control">
                    </div>
                    </div>
                    @error('tanggal_pengembalian')
                    <p class="text-bold text-xs text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input"  name="status" value="Dikembalikan" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Tandai telah dikembalikan</label>
                    </div>
               
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn bg-gradient-info">Simpan</button>
        </div>
        </form>
    </div>
</div>
</div>
@endforeach

{{-- Modal Delete Anggota --}}
@foreach ($peminjamans as $peminjaman)
<div class="modal fade" id="deleteModal{{$peminjaman->id}}" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Delete Data
            </h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="p-4">
                <p class="text-dark">Dengan mengklik Delete,maka peminjaman dari
                    <b>{{ $peminjaman->anggota->nama_lengkap }}</b> akan terhapus secara permanen!</p>
            </div>
        </div>
        <form action="{{route('peminjaman.destroy', $peminjaman->id)}}" method="post">
            @csrf
            @method('delete')
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn bg-gradient-danger">Delete</button>
            </div>
        </form>
    </div>
</div>
</div>
@endforeach


<!-- Include JavaScript Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

{{-- Input --}}
<script>
    // Inisialisasi Select2
    $(document).ready(function () {
        $('#buku').select2({
            minimumInputLength: 1
        });
    });

</script>

{{-- Edit --}}
<script>
    // Inisialisasi Select2
    $(document).ready(function () {
        $('.editbuku').select2({
            minimumInputLength: 1
        });
    });

</script>


{{-- Show Input Modal --}}
@if ($errors->any())
<script>
    $(document).ready(function () {
        $('#inputModal').modal('show');
    });

</script>
@endif

{{-- Menghilangkan alert --}}
<script>
    $(document).ready(function () {
        // Mengatur timeout untuk menghilangkan alert dalam 2 detik
        setTimeout(function () {
            $('#alertContainer').fadeOut('slow');
        }, 1200);
    });

</script>
