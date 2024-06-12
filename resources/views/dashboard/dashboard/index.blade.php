@extends('dashboard.layouts.main')
@section('judul-halaman')
My Dashboard
@endsection

@section('konten')

<div class="container">
    <h3>Dashboard</h3>
</div>

<div class="container-fluid py-4">
    <div class="row">
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-symbols-outlined fa-3x text-white">
                            paid
                        </span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize text-bold text-dark">Pendapatan dari Denda</p>
                        <h4 class="mb-0">Rp{{ number_format($total_denda) }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-symbols-outlined fa-3x text-white">
                            auto_stories
                        </span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize text-bold text-dark">Total Buku</p>
                        <h4 class="mb-0">{{$total_buku}}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-symbols-outlined fa-3x text-white">
                            group
                        </span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize text-bold text-dark">Total Anggota</p>
                        <h4 class="mb-0"> {{$total_anggota}} </h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-symbols-outlined fa-3x text-white">
                            beenhere
                        </span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize text-bold text-dark">Peminjaman</p>
                        <h4 class="mb-0"> {{$buku_dipinjam}} </h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-3 col-sm-6 mt-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-symbols-outlined fa-3x text-white">
                            keyboard_return
                        </span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize text-bold text-dark">Telah Dikembalikan</p>
                        <h4 class="mb-0"> {{$buku_dikembalikan}} </h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                </div>
            </div>
        </div> --}}

    </div>

    <div class="row mt-4">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Mendapatkan data dari PHP
            const chartData = @json($chartData);

            // Mengonversi data ke format DataTable Google Charts
            const data = google.visualization.arrayToDataTable(chartData);

            
            const options = {
                title: 'Jumlah Peminjaman Per Bulan',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Bulan',
                    format: 'M-Y'
                },
                vAxis: {
                    title: 'Jumlah Peminjaman',
                    minValue: 0
                }
            };

            const chart = new google.visualization.LineChart(document.getElementById('loanChart'));

            chart.draw(data, options);
        }
    </script>

    <div id="loanChart" style="width: 100%; height: 500px;"></div>

    </div>

    @endsection
