@extends('adminlte::page')

@section('title', 'Dashboard Admin - Pondok')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
@if($transaksiBaruCount ?? 0 > 0)
<div class="container-fluid">
    <div class="alert alert-warning alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
        Ada <strong>{{ $transaksiBaruCount }}</strong> permohonan baru menunggu verifikasi.
        <a href="{{ route('admin.transaksi.index', ['status' => 1]) }}" class="btn btn-sm btn-primary">Cek Sekarang !</a>
    </div>
</div>
@endif

<div class="container-fluid">
    <div class="row">
        {{-- Bagian Info Boxes --}}

        {{-- 1. New Orders (Info Box Biru) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $newOrdersToday }}</h3>
                    <p>Permohonan Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['tgl_dari' => now()->toDateString(), 'tgl_sampai' => now()->toDateString()]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-lime">
                <div class="inner">
                    <h3>{{ $transaksiVerifikasi }}</h3>
                    <p>Permohonan Diverifikasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clone"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 2]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 1. Proses (Info Box Ungu) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $transaksiProses }}</h3>
                    <p>Permohonan Diproses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 3]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 2. Bounce Rate (Info Box Hijau) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $transaksiSelesai }}</h3>
                    <p>Permohonan Selesai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-square"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 4]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 3. User Registrations (Info Box Kuning) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $transaksiUlang }}</h3>
                    <p>Pengajuan Ulang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-undo"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 6]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 4. Unique Visitors (Info Box Merah) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $transaksiTolak }}</h3>
                    <p>Permohonan Ditolak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-window-close"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 5]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $transaksiKomplain }}</h3>
                    <p>Komplain</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 7]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $transaksiDibatalkan }}</h3>
                    <p>Permohonan Dibatalkan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ban"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['status' => 8]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $pengguna }}</h3>
                    <p>Jumlah Pengguna</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="{{ route('admin.user.index', ['active' => 1]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> -->
    </div>

    <div class="row">
        {{-- Kolom Kiri: Sales Chart --}}
        <section class="col-lg-6 connectedSortable">
            <div class="card card-light">
                <div class="card-header">
                    <h3 class="card-title"><b>Grafik Permohonan</b></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        {{-- Kolom Kanan: Latest Members --}}
        <section class="col-lg-6 connectedSortable">
            <div class="card card-dark">
                <div class="card-header bg-dark">
                    <h3 class="card-title text-white"><b>Latest Members</b></h3>
                    <div class="card-tools">
                        <span class="badge badge-danger">{{ $newMembersCount }} New Members</span>
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool text-white" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="users-list clearfix">
                        @foreach($latestMembers as $member)
                            <li>
                                <img src="{{ $member->avatar_url }}" alt="User Image" class="img-circle" style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #adb5bd;">
                                <a class="users-list-name font-weight-bold text-truncate d-block mt-2 text-dark" href="{{ route('admin.user.index', ['nama' => $member->name]) }}" title="{{ $member->name }}">
                                    {{ Str::limit($member->name, 10) }}
                                </a>
                                <span class="users-list-date text-muted text-xs">
                                    @if($member->created_at->isToday())
                                        Today
                                    @elseif($member->created_at->isYesterday())
                                        Yesterday
                                    @else
                                        {{ $member->created_at->translatedFormat('d M') }}
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('admin.user.index') }}" class="font-weight-bold text-primary">View All Users</a>
                </div>
                <!-- /.card-footer -->
            </div>
        </section>
    </div>

    {{-- Baris Ketiga (Chat & Graph Lain) dapat ditambahkan di sini --}}

</div>
@stop

{{-- ... section CSS dan JS --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');

    // Data dari PHP -> ubah ke JSON
    const chartData = @json($data);

    // Pisahkan label dan nilai
    const labels = chartData.map(item => item.keterangan);
    const values = chartData.map(item => item.total);

    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Berdasarkan Jenis Dokumen', // <-- ini legend di atas grafik
                data: values,
                backgroundColor: [
                    '#007bff', // primary
                    '#28a745', // success
                    '#ffc107', // warning
                    '#dc3545', // danger
                    '#17a2b8', // info
                    '#6f42c1'  // purple
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#333',
                        font: { size: 13 }
                    }
                },
                tooltip: {
                    callbacks: {
                        // Tooltip title → tampilkan nama dokumen
                        title: (context) => 'Dokumen : ' + context[0].label,
                        // Tooltip body → ubah label “Total” menjadi lebih deskriptif
                        label: (context) => 'Jumlah : ' + context.parsed.y
                    },
                    backgroundColor: '#222',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Fix Chart.js resize issue on card expand
    $(document).on('expanded.lte.cardwidget', '.card', function () {
        setTimeout(function () {
            if (typeof salesChart !== 'undefined') {
                salesChart.resize();
                salesChart.update();
            }
        }, 350); 
    });

    // Fallback click listener untuk merender ulang chart ketika tombol minimize/maximize ditekan
    document.addEventListener('click', function (event) {
        const btn = event.target.closest('[data-card-widget="collapse"]');
        if (btn) {
            setTimeout(function () {
                if (typeof salesChart !== 'undefined') {
                    salesChart.resize();
                    salesChart.update();
                }
            }, 350);
        }
    });
});
</script>

@section('css')
<style>
    .users-list {
        list-style: none;
        margin: 0;
        padding: 15px;
    }
    .users-list > li {
        float: left;
        padding: 10px;
        text-align: center;
        width: 25%;
    }
    .users-list > li img {
        border-radius: 50%;
        max-width: 100%;
        height: auto;
    }
    .users-list-name {
        color: #495057;
        font-size: 14px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .users-list-date {
        color: #748290;
        font-size: 12px;
    }
</style>
@stop
