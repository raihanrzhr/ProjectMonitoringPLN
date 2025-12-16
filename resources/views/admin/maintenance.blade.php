@extends('admin.layout')

@section('title', 'Maintenance - UP2D Pasundan')

@push('styles')
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
            background-color: #22c55e;
            color: #fff;
            border-radius: 999px;
            padding: 6px 16px;
            font-weight: 600;
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
        }

        .btn-action.edit {
            background: rgba(37, 99, 235, 0.12);
            color: #2563eb;
        }

        .btn-action.delete {
            background: rgba(220, 38, 38, 0.12);
            color: #dc2626;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            border: none;
            padding-bottom: 0;
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

        .modal-footer {
            border: none;
            padding-top: 0;
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
@endpush

@section('content')


    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-outline-dark btn-sm d-lg-none" id="toggleSidebar"><i
                    class="fa-solid fa-bars"></i></button>
            <h1 class="mb-1">Maintenance</h1>
            <span class="text-muted">Kelola riwayat perawatan unit</span>
        </div>
        <button class="btn-add d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#createMaintenanceModal">
            <i class="fa-solid fa-plus"></i> Add Maintenance
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="maintenanceTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Item Pekerjaan</th>
                            <th>NOPOL</th>
                            <th>Mobil</th>
                            <th>No. Notdin</th>
                            <th>Tanggal Notdin</th>
                            <th>ACC KU</th>
                            <th>Tanggal Eksekusi</th>
                            <th>Nilai Pekerjaan</th>
                            <th>Keterangan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1, 8) as $index)
                            <tr>
                                <td>Perbaikan rem, Penggantian oli, Penggantian seal roda depan dan roda belakang</td>
                                <td>D 8021 ZF</td>
                                <td>UPS 200 KVA BDG</td>
                                <td>520</td>
                                <td>03/07/2023</td>
                                <td><span class="badge-status">OK</span></td>
                                <td>03/07/2023</td>
                                <td>Rp 1.550.000,00</td>
                                <td>Sumber 3 fasa masih digunakan up3, rencana minggu 1 sep 23</td>
                                <td class="text-center">
                                    <button class="btn-action edit btn-edit-maintenance" data-bs-toggle="modal"
                                        data-bs-target="#editMaintenanceModal"
                                        data-item="Perbaikan rem, Penggantian oli, Penggantian seal roda depan dan roda belakang"
                                        data-nopol="D 8021 ZF" data-mobil="UPS 200 KVA BDG" data-notdin="520"
                                        data-tanggal-notdin="2023-07-03" data-acc="OK" data-tanggal-eksekusi="2023-07-03"
                                        data-nilai="1550000"
                                        data-keterangan="Sumber 3 fasa masih digunakan up3, rencana minggu 1 sep 23">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createMaintenanceModal" tabindex="-1" aria-labelledby="createMaintenanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMaintenanceModalLabel">Create Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createMaintenanceForm" class="row g-3">
                        <!-- Informasi Pekerjaan -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-wrench me-2"></i>Informasi Pekerjaan</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Item Pekerjaan</label>
                            <textarea class="form-control" rows="2" placeholder="Deskripsi pekerjaan maintenance"
                                required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">NOPOL</label>
                            <input type="text" class="form-control" placeholder="XX 0000 XX" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Mobil</label>
                            <input type="text" class="form-control" placeholder="Nama/Tipe Mobil" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">No. Notdin</label>
                            <input type="text" class="form-control" placeholder="Nomor Notdin" required>
                        </div>

                        <!-- Status & Jadwal -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-calendar-check me-2"></i>Status & Jadwal
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Tanggal Notdin</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">ACC KU</label>
                            <select class="form-select" required>
                                <option value="" selected disabled>Pilih Status</option>
                                <option>OK</option>
                                <option>Pending</option>
                                <option>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Tanggal Eksekusi</label>
                            <input type="date" class="form-control" required>
                        </div>

                        <!-- Anggaran & Keterangan -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-money-bill me-2"></i>Anggaran & Keterangan
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Nilai Pekerjaan</label>
                            <input type="text" class="form-control" placeholder="Rp 0" required>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-12">
                            <label class="form-label required">Keterangan</label>
                            <textarea class="form-control" rows="2" placeholder="Keterangan tambahan" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createMaintenanceForm" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editMaintenanceModal" tabindex="-1" aria-labelledby="editMaintenanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMaintenanceModalLabel">Edit Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMaintenanceForm" class="row g-3">
                        <!-- Informasi Pekerjaan -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-wrench me-2"></i>Informasi Pekerjaan</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Item Pekerjaan</label>
                                <textarea class="form-control" rows="2" id="editItemPekerjaan"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">NOPOL</label>
                                <input type="text" class="form-control" id="editNopol">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Mobil</label>
                                <input type="text" class="form-control" id="editMobil">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">No. Notdin</label>
                                <input type="text" class="form-control" id="editNoNotdin">
                            </div>

                            <!-- Status & Jadwal -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-calendar-check me-2"></i>Status & Jadwal</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Tanggal Notdin</label>
                                <input type="date" class="form-control" id="editTanggalNotdin">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">ACC KU</label>
                                <select class="form-select" id="editAccKu">
                                    <option>OK</option>
                                    <option>Pending</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Tanggal Eksekusi</label>
                                <input type="date" class="form-control" id="editTanggalEksekusi">
                            </div>

                            <!-- Anggaran & Keterangan -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-money-bill me-2"></i>Anggaran & Keterangan</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Nilai Pekerjaan</label>
                                <input type="text" class="form-control" id="editNilaiPekerjaan">
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-12">
                                <label class="form-label required">Keterangan</label>
                                <textarea class="form-control" rows="2" id="editKeterangan"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="editMaintenanceForm" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function () {
            $('#maintenanceTable').DataTable({
                responsive: true,
                pageLength: 8,
                lengthMenu: [5, 8, 10, 25],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                }
            });

            $('#toggleSidebar').on('click', function () {
                $('#sidebar').toggleClass('open');
            });

            $('.btn-edit-maintenance').on('click', function () {
                const button = $(this);
                $('#editItemPekerjaan').val(button.data('item'));
                $('#editNopol').val(button.data('nopol'));
                $('#editMobil').val(button.data('mobil'));
                $('#editNoNotdin').val(button.data('notdin'));
                $('#editTanggalNotdin').val(button.data('tanggal-notdin'));
                $('#editAccKu').val(button.data('acc'));
                $('#editTanggalEksekusi').val(button.data('tanggal-eksekusi'));
                $('#editNilaiPekerjaan').val(`Rp ${Number(button.data('nilai')).toLocaleString('id-ID')},00`);
                $('#editKeterangan').val(button.data('keterangan'));
            });
        });
    </script>
@endpush