<aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
        id="sidenav-main">

        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
                target="_blank">
                <img src="{{asset('assets/img/logo-ct.png')}}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Material Dashboard 2</span>
            </a>
        </div>


        <hr class="horizontal light mt-0 mb-2">

        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
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
                    <a class="nav-link text-white {{ Request::is('dashboard/anggota') ? 'active' : '' }} " href="/dashboard/anggota">

                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                           {{-- icon --}}
                           
                           <span class="material-symbols-outlined">
                            group
                            </span>
                        </div>

                        <span class="nav-link-text ms-1">Anggota</span>                    
                    </a>
                </li>


            </ul>
        </div>
    </aside>