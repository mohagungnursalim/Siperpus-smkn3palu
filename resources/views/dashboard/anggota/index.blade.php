@extends('dashboard.layouts.main')
@section('judul-halaman')
Anggota
@endsection

@section('konten')


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
                                    Tambah Anggota
                                </button>
                            </div>
                            
                            <form action="{{ route('anggota.index') }}" method="GET">
                            <div class="container">
                              <div class="row justify-content-end">
                                  <div class="col-lg-4">
                                      <div class="input-group input-group-outline my-3">

                                              <input type="text" name="search" placeholder="Cari Anggota.." class="form-control">
                                              <button type="submit">Search</button>

                                      </div>
                                  </div>
                              </div>
                          </div>
                          </form>
                          @if (request('search'))
                                <div class="d-flex justify-content-end">
                                   
                                    <a href="/dashboard/anggota" class="btn btn-secondary">Refresh</a>
                                    @php
                                    for ($i = 0; $i < 40; $i++) { 
                                        echo '&nbsp;';
                                    }
                                     @endphp
                                   
                                </div>
                            @endif
                          
                            @if (session('success'))
                            <div id="alertContainer" class="alert alert-success alert-dismissible text-white fade show" role="alert">
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
                            @if (session('error'))
                            <div id="alertContainer" class="alert alert-success alert-dismissible text-white fade show" role="alert">
                                <span class="alert-icon align-middle">
                                    <span class="material-icons text-md">
                                        thumb_up_off_alt
                                    </span>
                                </span>
                                <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                       @if ($anggotas->count())                         
                            <table class="table align-items-center mb-0">
                              <thead>
                                  <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Foto</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                          Nama Lengkap</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                          Kelas</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                          Jurusan</th>
                                      <th
                                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                          Alamat</th>
                                      <th
                                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                          Telepon</th>
                                      <th
                                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                          Terdaftar</th>
                                      <th class="text-secondary opacity-7"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($anggotas as $anggota)

                                  <tr>
                                    <td class="text-wrap text-sm align-middle text-center">
                                        @if($anggota->gambar)
                                        <img src="{{ asset('storage/' . $anggota->gambar) }}" alt="{{ $anggota->nama_lengkap }}"  style="width: 25px">
                                    @else
                                        Tidak ada gambar
                                    @endif    
                                    </td>
                                      <td class="text-wrap">
                                          <div class="d-flex px-2 py-1 text-center">
                                              <div class="d-flex flex-column justify-content-center">
                                                  <h6 class="mb-0 text-sm">{{$anggota->nama_lengkap}}</h6>
                                                  <p class="text-xs text-secondary mb-0"> {{$anggota->email}} </p>
                                              </div>
                                          </div>
                                      </td>
                                      <td class="text-wrap text-sm align-middle text-center">
                                          <span class="badge badge-sm bg-gradient-secondary">{{$anggota->kelas}}</span>
                                      </td>
                                      <td class="text-wrap">
                                          <p class="text-xs font-weight-bold mb-0">{{$anggota->jurusan}}</p>
                                      </td>
                                      <td class="text-wrap">
                                          <p class="text-xs font-weight-bold mb-0">{{$anggota->alamat}}</p>
                                      </td>
                                      <td class="align-middle text-center text-sm">
                                          <span
                                              class="badge badge-sm bg-gradient-secondary">{{$anggota->telepon}}</span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold">{{$anggota->created_at->format('d/m/Y')}}</span>
                                      </td>
                                      <td class="align-middle">
                                        <a href="{{ route('anggota.cetak-kartu', $anggota->id) }}" class="badge bg-gradient-success text-decoration-none text-white" style="border: 0ch">Kartu</a>
                                          <button class="badge bg-gradient-warning" style="border: 0ch"
                                              data-bs-toggle="modal"
                                              data-bs-target="#editModal{{$anggota->id}}">Edit</button>
                                          <button class="badge bg-gradient-danger" style="border: 0ch"
                                              data-bs-toggle="modal"
                                              data-bs-target="#deleteModal{{$anggota->id}}">Delete</button>
                                      </td>

                                  </tr>
                                
                                  @endforeach
                              </tbody>
                          </table>
                          
                              @else
                              <div class="container d-flex justify-content-center">
                                <h4 class="text-dark text-bold">Data tidak ditemukan! <span class="material-symbols-outlined">
                                  sentiment_dissatisfied
                                  </span></h4>
                              </div>
                              @endif
                          
                            
                            <div class="d-flex justify-content-center mb-3 mt-4">
                                @if ($anggotas->isEmpty())
                                    
                                @else
                                    @if ($anggotas->onFirstPage())
                                    <span class="btn btn-secondary disabled">Previous</span>
                                    @else
                                        <a href="{{ $anggotas->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                                    @endif
                        
                                    @if ($anggotas->hasMorePages())
                                        <a href="{{ $anggotas->nextPageUrl() }}" class="btn btn-primary">Next</a>
                                    @else
                                        <span class="btn btn-secondary disabled">Next</span>
                                    @endif
                                @endif
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
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrasi Anggota Baru</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <form method="post" action="{{ route('anggota.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-group input-group-outline @error('nama_lengkap') is-invalid @enderror mb-1">
                            <input type="text" name="nama_lengkap" value="{{old('nama_lengkap')}}" class="form-control">
                        </div>
                        @error('nama_lengkap')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        <label class="form-label">Foto Anggota</label>
                        <img  class="img-preview img-fluid mb-3 col-sm-5" style="width: 80px">
                        <div class="input-group input-group-outline @error('gambar') is-invalid @enderror mb-1">
                            <input onchange="previewImage()" type="file" id="image" name="gambar" value="{{old('gambar')}}" class="form-control">
                        </div>
                        @error('gambar')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        <label class="form-label">Kelas</label>
                        <div class="input-group input-group-outline @error('kelas') is-invalid @enderror mb-1">
                            <select name="kelas" class="form-control">
                                <option>--Pilih Kelas--</option>
                                <option value="X" @if(old('kelas')=='X' ) selected @endif>Kelas X</option>
                                <option value="XI" @if(old('kelas')=='XI' ) selected @endif>Kelas XI</option>
                                <option value="XII" @if(old('kelas')=='XII' ) selected @endif>Kelas XII</option>
                            </select>
                        </div>
                        @error('kelas')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        <label class="form-label">Jurusan</label>
                        <div class="input-group input-group-outline @error('jurusan') is-invalid @enderror mb-1">
                            <select name="jurusan" class="form-control">
                                <option>--Pilih Jurusan--</option>
                                <option value="Teknik Konstruksi & Perumahan"
                                    @if(old('jurusan')=='Teknik Konstruksi & Perumahan' ) selected @endif>Teknik
                                    Konstruksi & Perumahan</option>
                                <option value="Teknik Geospasial" @if(old('jurusan')=='Teknik Geospasial' ) selected
                                    @endif>Teknik Geospasial</option>
                                <option value="Teknik Ketenagalistrikan" @if(old('jurusan')=='Teknik Ketenagalistrikan'
                                    ) selected @endif>Teknik Ketenagalistrikan</option>
                                <option value="Teknik Mesin" @if(old('jurusan')=='Teknik Mesin' ) selected @endif>Teknik
                                    Mesin</option>
                                <option value="Teknik Pengelasan & Fabrikasi Logam"
                                    @if(old('jurusan')=='Teknik Pengelasan & Fabrikasi Logam' ) selected @endif>Teknik
                                    Pengelasan & Fabrikasi Logam</option>
                                <option value="Teknik Otomotif" @if(old('jurusan')=='Teknik Otomotif' ) selected @endif>
                                    Teknik Otomotif</option>
                                <option value="Teknik Elektronika" @if(old('jurusan')=='Teknik Elektronika' ) selected
                                    @endif>Teknik Elektronika</option>
                                <option value="Teknik Komputer Jaringan dan Telekomunikasi"
                                    @if(old('jurusan')=='Teknik Komputer Jaringan dan Telekomunikasi' ) selected @endif>
                                    Teknik Komputer Jaringan dan Telekomunikasi</option>
                                <option value="Pengembangan Perangkat Lunak & Gim"
                                    @if(old('jurusan')=='Pengembangan Perangkat Lunak & Gim' ) selected @endif>
                                    Pengembangan Perangkat Lunak & Gim</option>
                            </select>
                        </div>
                        @error('jurusan')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        <label class="form-label">Alamat</label>
                        <div class="input-group input-group-outline @error('alamat') is-invalid @enderror mb-1">
                            <input type="text" name="alamat" value="{{old('alamat')}}" class="form-control">
                        </div>
                        @error('alamat')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        <label class="form-label">Telepon</label>
                        <div class="input-group input-group-outline @error('telepon') is-invalid @enderror mb-1">
                            <input type="number" name="telepon" value="{{old('telepon')}}" class="form-control">
                        </div>
                        @error('telepon')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        <label class="form-label">Email</label>
                        <div class="input-group input-group-outline @error('email') is-invalid @enderror mb-1">
                            <input type="text" name="email" value="{{old('email')}}" class="form-control">
                        </div>
                        @error('email')
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

{{-- Modal Edit Anggota --}}
@foreach ($anggotas as $anggota)
<div class="modal fade" id="editModal{{$anggota->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Edit Data Anggota</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <form method="post" action="{{ url('/dashboard/anggota/' . $anggota->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-group input-group-outline @error('nama_lengkap') is-invalid @enderror mb-2">
                            <input type="text" required name="nama_lengkap" placeholder="Masukan nama lengkap.."
                                value="{{$anggota->nama_lengkap}}" class="form-control">
                        </div>
                        @error('nama_lengkap')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        
                        <label class="form-label">Foto Anggota</label>
                        @if($anggota->gambar)
                            <img src="{{ asset('storage/' . $anggota->gambar) }}" id="edit-preview{{ $anggota->id }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" style="width: 80px">
                        @else
                            <img src="#" id="edit-preview{{ $anggota->id }}" class="img-preview img-fluid mb-3 col-sm-5 d-none" style="width: 80px">
                        @endif
                        <div class="input-group input-group-outline @error('gambar') is-invalid @enderror mb-1">
                            <input onchange="editImage{{ $anggota->id }}()" type="file" id="editimage{{ $anggota->id }}" name="gambar" value="{{ old('gambar') }}" class="form-control" accept="image/*">
                        </div>
                        @error('gambar')
                            <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        


                        <label class="form-label">Kelas</label>
                        <div class="input-group input-group-outline @error('kelas') is-invalid @enderror mb-2">
                            <select name="kelas" class="form-control">
                                <option>--Pilih Kelas--</option>
                                <option selected value="{{ old('kelas',$anggota->kelas) }}">{{ $anggota->kelas }}
                                </option>
                                <option value="X">Kelas X</option>
                                <option value="XI">Kelas XI</option>
                                <option value="XII">Kelas XII</option>
                            </select>
                        </div>
                        @error('kelas')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror

                        <label class="form-label">Jurusan</label>
                        <div class="input-group input-group-outline @error('jurusan') is-invalid @enderror mb-2">
                            <select name="jurusan" class="form-control">
                                <option>--Pilih Jurusan--</option>
                                <option selected value="{{ old('jurusan',$anggota->jurusan) }}">{{ $anggota->jurusan }}
                                </option>
                                <option value="Teknik Konstruksi & Perumahan">Teknik Konstruksi & Perumahan</option>
                                <option value="Teknik Geospasial">Teknik Geospasial</option>
                                <option value="Teknik Ketenagalistrikan">Teknik Ketenagalistrikan</option>
                                <option value="Teknik Mesin">Teknik Mesin</option>
                                <option value="Teknik Pengelasan & Fabrikasi Logam">Teknik Pengelasan & Fabrikasi Logam
                                </option>
                                <option value="Teknik Otomotif">Teknik Otomotif</option>
                                <option value="Teknik Elektronika">Teknik Elektronika</option>
                                <option value="Teknik Komputer Jaringan dan Telekomunikasi">Teknik Komputer Jaringan dan
                                    Telekomunikasi</option>
                                <option value="Pengembangan Perangkat Lunak & Gim">Pengembangan Perangkat Lunak & Gim
                                </option>
                            </select>
                        </div>
                        @error('jurusan')
                        {{ $message }}
                        @enderror
                        <label class="form-label">Alamat</label>
                        <div class="input-group input-group-outline @error('alamat') is-invalid @enderror mb-2">
                            <input type="text" required name="alamat" placeholder="Masukan alamat.."
                                value="{{$anggota->alamat}}" class="form-control">
                        </div>
                        @error('alamat')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        <label class="form-label">Telepon</label>
                        <div class="input-group input-group-outline @error('telepon') is-invalid @enderror mb-2">
                            <input type="number" required name="telepon" placeholder="Masukan telepon.."
                                value="{{$anggota->telepon}}" class="form-control">
                        </div>
                        @error('telepon')
                        <p class="text-bold text-xs text-danger">{{ $message }}</p>
                        @enderror
                        <label class="form-label">Email</label>
                        <div class="input-group input-group-outline @error('email') is-invalid @enderror mb-2">
                            <input type="text" required name="email" placeholder="Masukan email.."
                                value="{{$anggota->email}}" class="form-control">
                        </div>
                        @error('email')
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
@endforeach

{{-- Modal Delete Anggota --}}
@foreach ($anggotas as $anggota)
<div class="modal fade" id="deleteModal{{$anggota->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Delete Data {{$anggota->nama_lengkap}}
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <p class="text-dark">Dengan mengklik Delete,maka keanggotaan dari
                        <b>{{ $anggota->nama_lengkap }}</b> akan terhapus secara permanen!</p>
                </div>
            </div>
            <form action="{{route('anggota.destroy', $anggota->id)}}" method="post">
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


<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{-- Show Input Modal--}}
@if ($errors->any())
<script>
    $(document).ready(function () {
        $('#inputModal').modal('show');
    });

</script>
@endif

{{-- Menghilangkan alert --}}
<script>
  $(document).ready(function() {
      // Mengatur timeout untuk menghilangkan alert dalam 2 detik
      setTimeout(function() {
          $('#alertContainer').fadeOut('slow');
      }, 1200);
  });
</script>

{{-- Preview Gambar --}}
<script>
    function previewImage() {

        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();

        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function (oFREvent) {

            imgPreview.src = oFREvent.target.result;

        }
    }

</script>

{{-- edit image preview --}}
@foreach ($anggotas as $anggota)
<script>
    function editImage{{ $anggota->id }}() {
        const image = document.querySelector('#editimage{{ $anggota->id }}');
        const editPreview = document.querySelector('#edit-preview{{ $anggota->id }}');

        const file = image.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            editPreview.src = e.target.result;
            editPreview.classList.remove('d-none'); // Tampilkan gambar preview
        };

        if (file) {
            reader.readAsDataURL(file); // Membaca file yang dipilih
        }
    }
</script>
@endforeach
