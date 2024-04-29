@extends('dashboard.layouts.main')
@section('judul-halaman')
    My Dashboard
@endsection

@section('konten')

<div class="container">
    <h3>Dashboard</h3>
</div>

<div class="row">
    <div class="col-lg-3 col-6 text-center">
      <div class="border border-light border-1 border-radius-md py-3">
        <h6 class="text-primary text-gradient mb-0">Anggota</h6>
        <h4 class="font-weight-bolder"><span class="small">$ </span></h4>
      </div>
    </div>
    <div class="col-lg-3 col-6 text-center">
      <div class="border border-light border-1 border-radius-md py-3">
        <h6 class="text-primary text-gradient mb-0">Buku</h6>
        <h4 class="font-weight-bolder"><span class="small">$ </span></h4>
      </div>
    </div>
    <div class="col-lg-3 col-6 text-center mt-4 mt-lg-0">
      <div class="border border-light border-1 border-radius-md py-3">
        <h6 class="text-primary text-gradient mb-0">Peminjaman</h6>
        <h4 class="font-weight-bolder"><span class="small">$ </span></h4>
      </div>
    </div>
    <div class="col-lg-3 col-6 text-center mt-4 mt-lg-0">
        <div class="border border-light border-1 border-radius-md py-3">
          <h6 class="text-primary text-gradient mb-0">Dikembalikan</h6>
          <h4 class="font-weight-bolder"><span class="small">$ </span></h4>
        </div>
      </div>
</div>

@endsection