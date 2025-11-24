<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - UP2D Pasundan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 240px;
            --primary-color: #0c58d0;
            --primary-dark: #0f172a;
            --accent-color: #0b264d;
            --bg-soft: #f5f8ff;
            --table-row-even: #e8f5ff;
            --table-row-odd: #f5fbff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-soft);
            color: #0f172a;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-dark);
            color: #fff;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }

        .sidebar .brand img {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            background: #fff;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #e2e8f0;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(22, 163, 255, 0.16);
            color: #fff;
        }

        .sidebar .nav-section {
            margin-top: 24px;
        }

        .sidebar .logout-btn {
            margin-top: auto;
            padding-top: 32px;
        }

        .content-wrapper {
            flex: 1;
            padding: 32px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
        }

        .card {
            border-radius: 20px;
            border: none;
            background: #fff;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        }

        .card-body {
            padding: 24px 28px;
        }

        table.dataTable thead th {
            border-bottom: none;
            font-weight: 600;
        }

        table.dataTable tbody tr:nth-of-type(odd) {
            background-color: var(--table-row-odd);
        }

        table.dataTable tbody tr:nth-of-type(even) {
            background-color: var(--table-row-even);
        }

        table.dataTable td,
        table.dataTable th {
            vertical-align: middle;
        }

        .badge-status {
            border-radius: 999px;
            padding: 6px 16px;
            font-weight: 600;
            color: #fff;
        }

        .badge-status.green {
            background-color: #22c55e;
        }

        .badge-status.red {
            background-color: #ef4444;
        }

        .badge-status.yellow {
            background-color: #f59e0b;
        }

        .btn-add {
            background: var(--primary-dark);
            color: #fff;
            padding: 10px 18px;
            font-weight: 600;
            border-radius: 12px;
            border: none;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-action.edit {
            background: rgba(37, 99, 235, 0.12);
            color: #2563eb;
        }

        .btn-action.delete {
            background: rgba(220, 38, 38, 0.12);
            color: #dc2626;
        }

        .btn-action.info {
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header,
        .modal-footer {
            border: none;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid #dbe2ef;
            padding: 12px 16px;
        }

        .form-label {
            font-weight: 600;
            color: #0f172a;
        }

        .btn-primary {
            background: var(--primary-dark);
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .btn-outline-secondary {
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .unit-type-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid transparent;
        }

        .unit-type-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .tab-button {
            padding: 10px 20px;
            border: none;
            background: transparent;
            color: #64748b;
            font-weight: 500;
            border-radius: 8px 8px 0 0;
            cursor: pointer;
        }

        .tab-button.active {
            background: var(--primary-dark);
            color: #fff;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                z-index: 1040;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                height: 100%;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content-wrapper {
                padding: 24px 16px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar" id="sidebar">
            <div class="">
                <img
                src="{{ asset('assets/image/Logo.png') }}"
                alt="UP2D Pasundan Logo"
                class=""
            />
            </div>
            <nav class="nav flex-column gap-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.units') ? 'active' : '' }}" href="{{ url('admin/units') }}">
                    <i class="fa-solid fa-car-battery"></i> Units
                </a>
                <a class="nav-link {{ request()->routeIs('admin.peminjaman') ? 'active' : '' }}" href="{{ url('admin/peminjaman') }}">
                    <i class="fa-solid fa-clipboard-list"></i> Peminjaman
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ url('admin/users') }}">
                    <i class="fa-solid fa-users"></i> Users
                </a>
            </nav>
            <div class="nav-section">
                <small class="text-uppercase text-white-50 d-block mb-2">Report</small>
                <nav class="nav flex-column gap-2">
                    <a class="nav-link {{ request()->routeIs('admin.report') ? 'active' : '' }}" href="{{ url('admin/report') }}">
                        <i class="fa-solid fa-file-lines"></i> Car Report
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.maintenance') ? 'active' : '' }}" href="{{ url('admin/maintenance') }}">
                        <i class="fa-solid fa-screwdriver-wrench"></i> Maintenance
                    </a>
                </nav>
            </div>
            <div class="logout-btn">
                <a class="nav-link" href="{{ url('logout') }}">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
            </div>
        </aside>
        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function () {
            $('#toggleSidebar').on('click', function () {
                $('#sidebar').toggleClass('open');
            });
        });
    </script>
    @stack('scripts')
</body>

</html>

