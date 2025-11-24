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

    .trend-up {
        color: #028f61;
        font-weight: 600;
    }

    .trend-down {
        color: #dc2626;
        font-weight: 600;
    }

    .card-analytics .icon-badge {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: rgba(11, 38, 77, 0.08);
        color: var(--accent-color);
    }

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

    .filter-group .form-label {
        font-weight: 600;
        color: #0f172a;
    }

    .filter-group .form-control,
    .filter-group .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
    }

    .btn-check-status {
        background: var(--primary-color);
        border: none;
        padding: 11px 24px;
        font-weight: 600;
        border-radius: 12px;
        color: #fff;
    }

    .datatable-card .dataTables_wrapper .dataTables_length,
    .datatable-card .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .datatable-card table.dataTable tbody tr {
        background-color: rgba(11, 133, 215, 0.06);
    }

    .datatable-card table.dataTable tbody tr:nth-of-type(even) {
        background-color: rgba(11, 133, 215, 0.12);
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .status-completed {
        background: #22c55e;
    }

    .status-pending {
        background: #f97316;
    }

    .status-route {
        background: #ef4444;
    }

    .status-unit-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .status-bar {
        height: 8px;
        border-radius: 4px;
        flex: 1;
        margin: 0 12px;
    }

    .status-bar.green {
        background: #22c55e;
    }

    .status-bar.red {
        background: #ef4444;
    }

    .status-bar.yellow {
        background: #f59e0b;
    }

    .admin-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 12px;
        background: #f8fafc;
        margin-bottom: 12px;
    }

    .admin-profile img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="content-header mb-4">
    <button class="btn btn-outline-dark btn-sm d-lg-none mb-3" id="toggleSidebar">
        <i class="fa-solid fa-bars"></i>
    </button>
    <h1>Dashboard</h1>
    <span>Minggu, 01 Nov 2025 · 12:30 AM</span>
</div>

<div class="row g-3">
    <div class="col-xl-4 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Total Unit</small>
                <span class="icon-badge"><i class="fa-solid fa-car"></i></span>
            </div>
            <h2>126</h2>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Total Lending</small>
                <span class="icon-badge"><i class="fa-solid fa-key"></i></span>
            </div>
            <h2>14</h2>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card-analytics">
            <div class="d-flex justify-content-between align-items-start">
                <small>Total Maintenance</small>
                <span class="icon-badge"><i class="fa-solid fa-wrench"></i></span>
            </div>
            <h2>18</h2>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-8">
        <div class="section-card datatable-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Live Lending Status</h5>
                <a href="#" class="text-primary text-decoration-none">View all</a>
            </div>
            <div class="table-responsive">
                <table id="liveLoanTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>No. Car</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="https://i.pravatar.cc/32?img=32" class="rounded-circle" alt="User" width="32" height="32">
                                Darby Day
                            </td>
                            <td>DK 8113 DE</td>
                            <td>UPS</td>
                            <td><span class="status-dot status-completed"></span>Sedang Digunakan</td>
                            <td><button class="btn btn-sm"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="https://i.pravatar.cc/32?img=12" class="rounded-circle" alt="User" width="32" height="32">
                                Helt Diven
                            </td>
                            <td>DK 8005 DE</td>
                            <td>UPS</td>
                            <td><span class="status-dot status-completed"></span>Sedang Digunakan</td>
                            <td><button class="btn btn-sm"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="https://i.pravatar.cc/32?img=5" class="rounded-circle" alt="User" width="32" height="32">
                                Helt Diven
                            </td>
                            <td>B 9132 KCF</td>
                            <td>UPS</td>
                            <td><span class="status-dot status-completed"></span>Sedang Digunakan</td>
                            <td><button class="btn btn-sm"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                        </tr>
                        @foreach(range(1,5) as $index)
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="https://i.pravatar.cc/32?img={{ $index + 10 }}" class="rounded-circle" alt="User" width="32" height="32">
                                User {{ $index }}
                            </td>
                            <td>DK {{ 8000 + $index }} DE</td>
                            <td>UPS</td>
                            <td><span class="status-dot status-completed"></span>Sedang Digunakan</td>
                            <td><button class="btn btn-sm"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="section-card">
            <h5>Status Unit</h5>
            <small class="text-muted d-block mb-3">Updated 15/07/2025 | 04.00 PM</small>
            <div class="status-unit-item">
                <span><span class="status-dot status-completed"></span>Sedang Digunakan</span>
                <div class="status-bar green" style="width: 20px;"></div>
                <span class="fw-bold">2</span>
            </div>
            <div class="status-unit-item">
                <span><span class="status-dot" style="background: #ef4444;"></span>Tidak Siap Operasi</span>
                <div class="status-bar red" style="width: 40px;"></div>
                <span class="fw-bold">4</span>
            </div>
            <div class="status-unit-item">
                <span><span class="status-dot" style="background: #f59e0b;"></span>Stand By</span>
                <div class="status-bar yellow" style="width: 120px;"></div>
                <span class="fw-bold">12</span>
            </div>
        </div>
        <div class="section-card mt-3">
            <h5>Operations Admin</h5>
            <div class="admin-profile">
                <img src="https://i.pravatar.cc/48?img=68" alt="Admin">
                <div>
                    <div class="fw-bold">Raihan Nurazhar</div>
                    <small class="text-muted">Assistant Manager</small>
                </div>
            </div>
            <div class="admin-profile">
                <img src="https://i.pravatar.cc/48?img=47" alt="Admin">
                <div>
                    <div class="fw-bold">Sofiatu Zahra</div>
                    <small class="text-muted">Admin</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        const options = {
            responsive: true,
            paging: false,
            ordering: false,
            info: false,
            searching: false
        };
        $('#liveLoanTable').DataTable(options);
    });
</script>
@endpush
