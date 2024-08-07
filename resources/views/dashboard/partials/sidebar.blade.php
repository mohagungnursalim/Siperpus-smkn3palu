<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-success"
    id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/dashboard">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets/img/smkn3palu.png') }}" class="navbar-brand-img" width="70px" height="80px" alt="main_logo">
            </div>
            <div class="d-flex justify-content-center">
                <span class="ms-1 font-weight-bold text-white">SIPERPUS</span>
            </div>
        </a>
    </div>


    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
         
            
            @if (Auth::user()->is_admin == false)
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        {{-- icon --}}
                        <span class="material-symbols-outlined">
                            bar_chart_4_bars
                        </span>
                    </div>

                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard/peminjaman') ? 'active' : '' }}" href="/dashboard/peminjaman">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        {{-- icon --}}

                        <span class="material-symbols-outlined">
                            cycle
                        </span>
                    </div>

                    <span class="nav-link-text ms-1">Peminjaman</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard/anggota') ? 'active' : '' }} "
                    href="/dashboard/anggota">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        {{-- icon --}}

                        <span class="material-symbols-outlined">
                            group
                        </span>
                    </div>

                    <span class="nav-link-text ms-1">Anggota</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{Request::is('dashboard/buku') ? 'active' : ''}} "
                    href="/dashboard/buku">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        {{-- icon --}}

                        <span class="material-symbols-outlined">
                            library_books
                        </span>
                    </div>

                    <span class="nav-link-text ms-1">Buku</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard/kategori') ? 'active' : '' }}"
                    href="/dashboard/kategori">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        {{-- icon --}}

                        <span class="material-symbols-outlined">
                            list
                        </span>
                    </div>

                    <span class="nav-link-text ms-1">Kategori</span>
                </a>
            </li>
            @endif
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">
                    ----------------Akun-------------------
                </h6>
            </li>
            

            @can('is_admin')
            <li class="nav-item">
                <a class="nav-link text-white {{Request::is('dashboard/user') ? 'active' : ''}}" 
                href="/dashboard/user">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined">
                            group_add
                        </span>
                    </div>
                    <span class="nav-link-text ms-1">Kelola Akun </span>
                </a>
            </li>
            @endcan
           

            <li class="nav-item">
                <a class="nav-link text-white {{Request::is('dashboard/profile') ?  'active' : ''}}" href="/dashboard/profile">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined">
                            account_circle
                        </span>
                    </div>
                    <span class="nav-link-text ms-1">Profil</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined">
                            move_item
                        </span>
                    </div>
                    <span class="nav-link-text ms-1">Keluar</span>
                </a>
            </li>



            <!-- Modal -->
            <div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Konfirmasi Keluar</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4>Dengan mengklik Keluar maka sesi masuk akun anda akan berakhir!</h3>
                        </div>
                        <form action="/logout" method="POST">
                            @csrf
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn bg-gradient-primary">Keluar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </ul>
    </div>
</aside>
