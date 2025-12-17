@extends('admin.layout')

@section('title', 'Dashboard Admin - UP2D Pasundan')

@push('styles')
<style>
    .content-header h1 {
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 4px;
    }

    .content-header span {
        color: #64748b;
    }

    .card-analytics {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        display: flex;
        flex-direction: column;
        gap: 10px;
        border: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-analytics:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.12);
    }

    .card-analytics small {
        color: #64748b;
        font-weight: 500;
    }

    .card-analytics h2 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
    }

    .card-analytics .icon-badge {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .icon-badge.blue { background: rgba(11, 133, 215, 0.12); color: #0b85d7; }
    .icon-badge.green { background: rgba(34, 197, 94, 0.12); color: #22c55e; }
    .icon-badge.yellow { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
    .icon-badge.red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
    .icon-badge.purple { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }

    .section-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.05);
        border: none;
        height: 100%;
    }

    .section-card h5 {
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Graph styles */
    .graph-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 16px 35px rgba(15, 23, 42, .06);
        border: none;
        overflow: hidden;
    }

    .graph-title {
        font-weight: 600;
        margin-bottom: 12px;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        height: 120px;
        padding: 4px 8px 8px;
        overflow: hidden;
    }

    .bar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        flex: 1;
    }

    .bar {
        width: 100%;
        max-width: 28px;
        border-radius: 8px;
        background: linear-gradient(180deg, #0c58d0 0%, #78a5ff 100%);
        min-height: 4px;
    }

    .bar.report {
        background: linear-gradient(180deg, #f59e0b 0%, #fcd34d 100%);
    }

    .bar-label {
        font-size: 12px;
        color: #64748b;
    }

    .bar-value {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
    }

    /* Tables */
    .data-table {
        width: 100%;
    }

    .data-table thead th {
        font-weight: 600;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 8px;
        font-size: 14px;
        color: #64748b;
    }

    .data-table tbody td {
        padding: 12px 8px;
        font-size: 14px;
        vertical-align: middle;
    }

    .data-table tbody tr {
        background: #f8fbff;
    }

    .data-table tbody tr:nth-of-type(even) {
        background: #eef6ff;
    }

    .badge-soft {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 600;
    }

    .badge-soft.green { background: #dcfce7; color: #14532d; }
    .badge-soft.yellow { background: #fef9c3; color: #854d0e; }
    .badge-soft.red { background: #fee2e2; color: #7f1d1d; }
    .badge-soft.blue { background: #dbeafe; color: #1e40af; }
    .badge-soft.gray { background: #f1f5f9; color: #475569; }

    /* Alert cards */
    .alert-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #fef2f2;
        border-radius: 12px;
        margin-bottom: 8px;
        border-left: 4px solid #ef4444;
    }

    .alert-item .alert-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fee2e2;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alert-item .alert-content {
        flex: 1;
    }

    .alert-item .alert-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .alert-item .alert-desc {
        font-size: 12px;
        color: #64748b;
    }

    /* Status indicators */
    .status-bar-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .status-bar-label {
        min-width: 120px;
        font-size: 14px;
    }

    .status-bar-track {
        flex: 1;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .status-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .status-bar-fill.green { background: #22c55e; }
    .status-bar-fill.yellow { background: #f59e0b; }
    .status-bar-fill.red { background: #ef4444; }

    .status-bar-value {
        min-width: 40px;
        text-align: right;
        font-weight: 600;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <button class="btn btn-outline-dark btn-sm d-lg-none mb-3" id="toggleSidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h1>Dashboard</h1>
        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y · H:i') }}</span>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="dropdown me-2">
            <button class="btn btn-light position-relative shadow-none" data-bs-toggle="dropdown">
                <i class="fa-solid fa-bell fa-lg"></i>
                @php
                    $totalNotifications = $unitsNeedingAttention->count() + $pendingUsers->count() + $newPeminjaman->count() + $newReports->count();
                @endphp
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="{{ $totalNotifications > 0 ? '' : 'display:none;' }}">
                    <span id="notificationCount">{{ $totalNotifications }}</span>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end p-3" style="min-width: 360px; max-height: 450px; overflow-y: auto;">
                {{-- Pending Users Section --}}
                <div id="pendingUsersSection">
                    @if($pendingUsers->count() > 0)
                    <li class="fw-bold mb-2 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-user-plus me-1"></i> Ada User Baru</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="dismissNotification('pendingUsers', {{ $pendingUsers->count() }})" title="Abaikan sementara">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </li>
                    @foreach($pendingUsers->take(3) as $user)
                    <li class="alert-item mb-2" style="background: #e0e7ff; border-left-color: #6366f1;">
                        <div class="alert-icon" style="background: #c7d2fe; color: #4f46e5;"><i class="fa-solid fa-user"></i></div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $user->name }}</div>
                            <div class="alert-desc">{{ $user->email }} - Menunggu persetujuan</div>
                        </div>
                    </li>
                    @endforeach
                    @if($pendingUsers->count() > 3)
                    <li class="text-center mb-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">Lihat semua ({{ $pendingUsers->count() }})</a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    @endif
                </div>

                {{-- New Peminjaman Section --}}
                <div id="newPeminjamanSection">
                    @if($newPeminjaman->count() > 0)
                    <li class="fw-bold mb-2 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-key me-1 text-success"></i> Peminjaman Aktif</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="dismissNotification('newPeminjaman', {{ $newPeminjaman->count() }})" title="Abaikan sementara">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </li>
                    @foreach($newPeminjaman->take(3) as $p)
                    <li class="alert-item mb-2" style="background: #dcfce7; border-left-color: #22c55e;">
                        <div class="alert-icon" style="background: #bbf7d0; color: #16a34a;"><i class="fa-solid fa-key"></i></div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $p->userPemohon->name ?? 'N/A' }}</div>
                            <div class="alert-desc">{{ $p->unit->nopol ?? 'N/A' }} - {{ $p->tujuan_penggunaan ?? '' }}</div>
                        </div>
                    </li>
                    @endforeach
                    @if($newPeminjaman->count() > 3)
                    <li class="text-center mb-2">
                        <a href="{{ route('admin.peminjaman') }}" class="btn btn-sm btn-outline-success">Lihat semua ({{ $newPeminjaman->count() }})</a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    @endif
                </div>

                {{-- New Reports Section (Non-dismissable like tax warning) --}}
                @if($newReports->count() > 0)
                <li class="fw-bold mb-2">
                    <i class="fa-solid fa-file-alt me-1 text-warning"></i> Unit Rusak/Perbaikan
                </li>
                    @foreach($newReports->take(3) as $r)
                    <li class="alert-item mb-2" style="background: #fef9c3; border-left-color: #f59e0b;">
                        <div class="alert-icon" style="background: #fde68a; color: #d97706;"><i class="fa-solid fa-file-alt"></i></div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $r->userPelapor->name ?? 'N/A' }}</div>
                            <div class="alert-desc">{{ $r->unit->nopol ?? 'N/A' }} - {{ Str::limit($r->keterangan ?? '', 30) }}</div>
                        </div>
                    </li>
                @endforeach
                @if($newReports->count() > 3)
                <li class="text-center mb-2">
                    <a href="{{ route('admin.report') }}" class="btn btn-sm btn-outline-warning">Lihat semua ({{ $newReports->count() }})</a>
                </li>
                @endif
                @endif

                {{-- Units Needing Attention Section --}}
                @if($unitsNeedingAttention->count() > 0)
                <li class="fw-bold mb-2">Unit Perlu Perhatian</li>
                @foreach($unitsNeedingAttention->take(3) as $unit)
                <li class="alert-item mb-2">
                    <div class="alert-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="alert-content">
                        <div class="alert-title">{{ $unit->nopol ?? $unit->nama_unit }}</div>
                        <div class="alert-desc">Pajak/KIR akan habis dalam 1 bulan</div>
                    </div>
                </li>
                @endforeach
                @endif

                {{-- Empty State --}}
                <li id="emptyNotification" class="text-center text-muted py-3" style="{{ $totalNotifications > 0 ? 'display:none;' : '' }}">
                    <i class="fa-solid fa-check-circle fa-2x mb-2 d-block text-success"></i>
                    Tidak ada notifikasi
                </li>
            </ul>
        </div>
        
        <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex">
            <select class="form-select form-select-sm shadow-none" name="filter" onchange="this.form.submit()" style="min-width: 125px;">
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="UPS" {{ $filter == 'UPS' ? 'selected' : '' }}>UPS</option>
                <option value="UKB" {{ $filter == 'UKB' ? 'selected' : '' }}>UKB</option>
                <option value="DETEKSI" {{ $filter == 'DETEKSI' ? 'selected' : '' }}>Deteksi</option>
            </select>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Total Unit {{ $filter != 'all' ? $filter : '' }}</small>
                <span class="icon-badge blue"><i class="fa-solid fa-car"></i></span>
            </div>
            <h2>{{ $totalUnits }}</h2>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Total Peminjaman</small>
                <span class="icon-badge purple"><i class="fa-solid fa-key"></i></span>
            </div>
            <h2>{{ $totalPeminjaman }}</h2>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Total Laporan Anomali</small>
                <span class="icon-badge yellow"><i class="fa-solid fa-triangle-exclamation"></i></span>
            </div>
            <h2>{{ $totalReports }}</h2>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Unit Standby</small>
                <span class="icon-badge green"><i class="fa-solid fa-circle-check"></i></span>
            </div>
            <h2>{{ $totalStandby }}</h2>
        </div>
    </div>
</div>

<!-- Status Unit & Unit by Type -->
<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="section-card">
            <h5><i class="fa-solid fa-chart-pie me-2"></i>Status Unit</h5>
            
            @php
                $maxStatus = max($totalStandby, $totalDigunakan, $totalTidakSiap, 1);
            @endphp
            
            <div class="status-bar-container">
                <span class="status-bar-label">Standby</span>
                <div class="status-bar-track">
                    <div class="status-bar-fill green" style="width: {{ ($totalStandby / $maxStatus) * 100 }}%"></div>
                </div>
                <span class="status-bar-value">{{ $totalStandby }}</span>
            </div>
            
            <div class="status-bar-container">
                <span class="status-bar-label">Digunakan</span>
                <div class="status-bar-track">
                    <div class="status-bar-fill yellow" style="width: {{ ($totalDigunakan / $maxStatus) * 100 }}%"></div>
                </div>
                <span class="status-bar-value">{{ $totalDigunakan }}</span>
            </div>
            
            <div class="status-bar-container">
                <span class="status-bar-label">Tidak Siap Operasi</span>
                <div class="status-bar-track">
                    <div class="status-bar-fill red" style="width: {{ ($totalTidakSiap / $maxStatus) * 100 }}%"></div>
                </div>
                <span class="status-bar-value">{{ $totalTidakSiap }}</span>
            </div>
            
            <hr class="my-3">
            
            <h6 class="fw-semibold mb-3">Kondisi Unit</h6>
            @php
                $maxKondisi = max($kondisiBaik, $kondisiRusak, $kondisiPerbaikan, 1);
            @endphp
            
            <div class="status-bar-container">
                <span class="status-bar-label">Baik</span>
                <div class="status-bar-track">
                    <div class="status-bar-fill green" style="width: {{ ($kondisiBaik / $maxKondisi) * 100 }}%"></div>
                </div>
                <span class="status-bar-value">{{ $kondisiBaik }}</span>
            </div>
            
            <div class="status-bar-container">
                <span class="status-bar-label">Rusak</span>
                <div class="status-bar-track">
                    <div class="status-bar-fill red" style="width: {{ ($kondisiRusak / $maxKondisi) * 100 }}%"></div>
                </div>
                <span class="status-bar-value">{{ $kondisiRusak }}</span>
            </div>
            
            <div class="status-bar-container">
                <span class="status-bar-label">Perbaikan</span>
                <div class="status-bar-track">
                    <div class="status-bar-fill yellow" style="width: {{ ($kondisiPerbaikan / $maxKondisi) * 100 }}%"></div>
                </div>
                <span class="status-bar-value">{{ $kondisiPerbaikan }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="section-card">
            <h5><i class="fa-solid fa-boxes-stacked me-2"></i>Unit per Tipe</h5>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-center p-3 rounded-3" style="background: rgba(11, 133, 215, 0.08);">
                        <div class="fs-1 fw-bold text-primary">{{ $unitsByType['UPS'] }}</div>
                        <div class="text-muted">UPS</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3 rounded-3" style="background: rgba(34, 197, 94, 0.08);">
                        <div class="fs-1 fw-bold text-success">{{ $unitsByType['UKB'] }}</div>
                        <div class="text-muted">UKB</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3 rounded-3" style="background: rgba(245, 158, 11, 0.08);">
                        <div class="fs-1 fw-bold text-warning">{{ $unitsByType['DETEKSI'] }}</div>
                        <div class="text-muted">Deteksi</div>
                    </div>
                </div>
            </div>
            
            <hr class="my-3">
            
            <h6 class="fw-semibold mb-3">Status Peminjaman</h6>
            <div class="d-flex gap-3">
                <div class="flex-fill text-center p-2 rounded-3" style="background: #fef9c3;">
                    <div class="fs-4 fw-bold" style="color: #854d0e;">{{ $peminjamanAktif }}</div>
                    <small class="text-muted">Aktif</small>
                </div>
                <div class="flex-fill text-center p-2 rounded-3" style="background: #dcfce7;">
                    <div class="fs-4 fw-bold" style="color: #14532d;">{{ $peminjamanSelesai }}</div>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
            
            <h6 class="fw-semibold mb-3 mt-3">Status Laporan Anomali</h6>
            <div class="d-flex gap-3">
                <div class="flex-fill text-center p-2 rounded-3" style="background: #fee2e2;">
                    <div class="fs-4 fw-bold" style="color: #7f1d1d;">{{ $reportsPending }}</div>
                    <small class="text-muted">Pending</small>
                </div>
                <div class="flex-fill text-center p-2 rounded-3" style="background: #dcfce7;">
                    <div class="fs-4 fw-bold" style="color: #14532d;">{{ $reportsSelesai }}</div>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Charts -->
<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="graph-card">
            <div class="graph-title"><i class="fa-solid fa-chart-bar me-2"></i>Peminjaman (7 Hari Terakhir)</div>
            @php
                $maxPeminjaman = max(array_merge($weeklyPeminjaman, [1]));
            @endphp
            <div class="bar-chart">
                @foreach($weeklyLabels as $index => $label)
                <div class="bar-col">
                    <div class="bar" style="height: {{ ($weeklyPeminjaman[$index] / $maxPeminjaman) * 100 }}px"></div>
                    <div class="bar-value">{{ $weeklyPeminjaman[$index] }}</div>
                    <div class="bar-label">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="graph-card">
            <div class="graph-title"><i class="fa-solid fa-chart-bar me-2"></i>Laporan Anomali (7 Hari Terakhir)</div>
            @php
                $maxReports = max(array_merge($weeklyReports, [1]));
            @endphp
            <div class="bar-chart">
                @foreach($weeklyLabels as $index => $label)
                <div class="bar-col">
                    <div class="bar report" style="height: {{ ($weeklyReports[$index] / $maxReports) * 100 }}px"></div>
                    <div class="bar-value">{{ $weeklyReports[$index] }}</div>
                    <div class="bar-label">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Recent Tables -->
<div class="row g-3">
    <div class="col-xl-6">
        <div class="section-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Peminjaman Terbaru</h5>
                <a href="{{ route('admin.peminjaman') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            
            @if($recentPeminjaman->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pemohon</th>
                            <th>Unit</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPeminjaman as $p)
                        <tr>
                            <td>{{ $p->userPemohon->name ?? 'N/A' }}</td>
                            <td><span class="badge-soft blue">{{ $p->unit->nopol ?? 'N/A' }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_mobilisasi)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $badgeClass = match($p->status_peminjaman) {
                                        'Sedang Digunakan' => 'yellow',
                                        'Selesai' => 'green',
                                        'Cancel' => 'red',
                                        default => 'gray'
                                    };
                                @endphp
                                <span class="badge-soft {{ $badgeClass }}">{{ $p->status_peminjaman }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                <p class="mb-0">Belum ada data peminjaman</p>
            </div>
            @endif
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="section-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa-solid fa-triangle-exclamation me-2"></i>Laporan Anomali Terbaru</h5>
                <a href="{{ route('admin.report') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            
            @if($recentReports->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Unit</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentReports as $r)
                        <tr>
                            <td>{{ $r->userPelapor->name ?? 'N/A' }}</td>
                            <td><span class="badge-soft blue">{{ $r->unit->nopol ?? 'N/A' }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($r->tgl_kejadian)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    // Reports don't have status column, use no_ba as indicator
                                    $hasBA = !empty($r->no_ba);
                                    $badgeClass = $hasBA ? 'green' : 'yellow';
                                    $statusText = $hasBA ? 'Selesai' : 'Pending';
                                @endphp
                                <span class="badge-soft {{ $badgeClass }}">{{ $statusText }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                <p class="mb-0">Belum ada laporan anomali</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-refresh dashboard setiap 5 menit
    setTimeout(function() {
        location.reload();
    }, 300000);

    // Notification counts from server
    const notificationCounts = {
        pendingUsers: {{ $pendingUsers->count() }},
        newPeminjaman: {{ $newPeminjaman->count() }},
        newReports: {{ $newReports->count() }},
        unitsNeedingAttention: {{ $unitsNeedingAttention->count() }}
    };

    // Check dismissed notifications on page load
    document.addEventListener('DOMContentLoaded', function() {
        ['pendingUsers', 'newPeminjaman'].forEach(function(type) {
            if (sessionStorage.getItem('dismissed_' + type) === 'true') {
                hideNotificationSection(type);
            }
        });
    });

    // Generic dismiss notification function
    function dismissNotification(type, count) {
        sessionStorage.setItem('dismissed_' + type, 'true');
        hideNotificationSection(type);
    }

    // Hide notification section and update badge count
    function hideNotificationSection(type) {
        const sectionMap = {
            pendingUsers: 'pendingUsersSection',
            newPeminjaman: 'newPeminjamanSection'
        };
        
        const section = document.getElementById(sectionMap[type]);
        if (section) {
            section.style.display = 'none';
        }

        // Calculate remaining count (newReports and unitsNeedingAttention are non-dismissable)
        let totalRemaining = notificationCounts.unitsNeedingAttention + notificationCounts.newReports;
        
        ['pendingUsers', 'newPeminjaman'].forEach(function(t) {
            if (sessionStorage.getItem('dismissed_' + t) !== 'true') {
                totalRemaining += notificationCounts[t];
            }
        });
        
        const countElement = document.getElementById('notificationCount');
        const badgeElement = document.querySelector('.notification-badge');
        
        if (countElement && badgeElement) {
            countElement.textContent = totalRemaining;
            if (totalRemaining === 0) {
                badgeElement.style.display = 'none';
                const emptyNotif = document.getElementById('emptyNotification');
                if (emptyNotif) {
                    emptyNotif.style.display = '';
                }
            }
        }
    }
</script>
@endpush
