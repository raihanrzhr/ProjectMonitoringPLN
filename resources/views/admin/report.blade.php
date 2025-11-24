@extends('admin.layout')

@section('title', 'Pelaporan Unit - UP2D Pasundan')

@push('styles')
<style>
    .tab-button {
        padding: 10px 20px;
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 500;
        border-radius: 8px 8px 0 0;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tab-button.active {
        background: var(--primary-dark);
        color: #fff;
    }

    .table-container {
        display: none;
    }

    .table-container.active {
        display: block;
    }

    .report-photo {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        object-fit: cover;
    }

    .upload-control {
        border: 1px dashed #94a3b8;
        border-radius: 14px;
        padding: 16px;
        text-align: center;
        background: #f8fafc;
    }
    .table-responsive { overflow-x: auto; }
    table th, table td { white-space: nowrap; vertical-align: middle !important; }
    table .text-center .d-flex { gap: .5rem; }
    .dataTables_length, .dataTables_filter { margin-bottom: 1rem; }
    .dataTables_length label, .dataTables_filter label { font-weight: 600; }
    @media (max-width: 1000px) {
        .table-responsive { font-size: 13px; }
        .dataTables_length, .dataTables_filter { font-size: 13px; }
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <button class="btn btn-outline-dark btn-sm d-lg-none" id="toggleSidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h1 class="mb-1">Pelaporan Unit</h1>
        <span class="text-muted">Laporan kondisi unit terbaru</span>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex gap-2 mb-3">
            <button class="tab-button active" onclick="switchTable('UPS')">Tabel UPS</button>
            <button class="tab-button" onclick="switchTable('UKB')">Tabel UKB</button>
            <button class="tab-button" onclick="switchTable('Deteksi')">Tabel Deteksi</button>
        </div>

        <!-- UPS Table -->
        <div id="tableUPS" class="table-container active">
            <div class="table-responsive">
                <table id="reportUPSTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama Pelapor</th>
                            <th>Unit</th>
                            <th>Jenis dan Kapasitas</th>
                            <th>Merk dan Nopol Unit</th>
                            <th>Kondisi</th>
                            <th>Tanggal Kejadian</th>
                            <th>Lokasi Penggunaan</th>
                            <th>No. BA</th>
                            <th>Posko Pelaksana</th>
                            <th>UP3</th>
                            <th>Keterangan</th>
                            <th>Keperluan Anggaran</th>
                            <th>Bukti Foto</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1,8) as $index)
                        <tr>
                            <td>Sofiatu Zahra</td>
                            <td>UPS</td>
                            <td>MOBILE - 250 KVA</td>
                            <td>TESCOM - DK 8005 DE</td>
                            <td><span class="badge-status red">Rusak</span></td>
                            <td>17/08/2025</td>
                            <td>IPDN Jatinangor</td>
                            <td>003/OPSISDIST/UP2DJB/2024</td>
                            <td>Bandung Raya</td>
                            <td>Sumedang</td>
                            <td>Ban Bocor</td>
                            <td>Rp 247.972.446,00</td>
                            <td>
                                <img class="report-photo" src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=120&q=80" alt="Bukti Foto">
                            </td>
                            <td class="text-center">
                                <button class="btn-action edit btn-edit-report" data-bs-toggle="modal" data-bs-target="#editReportUPSModal" data-nama="Sofiatu Zahra" data-unit="UPS" data-jenis="Mobile - 250 KVA" data-merk-nopol="Tescom - DK 8005 DE" data-kondisi="Rusak" data-tanggal="2025-08-17" data-lokasi="IPDN Jatinangor" data-no-ba="003/OPSISDIST/UP2DJB/2024" data-posko="Bandung Raya" data-up3="Sumedang" data-keterangan="Ban Bocor" data-anggaran="247972446">
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

        <!-- UKB Table -->
        <div id="tableUKB" class="table-container">
            <div class="table-responsive">
                <table id="reportUKBTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama Pelapor</th>
                            <th>Unit</th>
                            <th>Type & Panjang Kabel</th>
                            <th>Merk dan Nopol Unit</th>
                            <th>Jenis & Volume UKB</th>
                            <th>Kondisi</th>
                            <th>Tanggal Kejadian</th>
                            <th>Lokasi Penggunaan</th>
                            <th>No. BA</th>
                            <th>Posko Pelaksana</th>
                            <th>UP3</th>
                            <th>Keterangan</th>
                            <th>Keperluan Anggaran</th>
                            <th>Bukti Foto</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1,8) as $index)
                        <tr>
                            <td>Sofiatu Zahra</td>
                            <td>UKB</td>
                            <td>95 mm - 4 x 75</td>
                            <td>150 mm - 4 x 50</td>
                            <td>Karavan - 2 Set</td>
                            <td><span class="badge-status red">Rusak</span></td>
                            <td>17/08/2025</td>
                            <td>IPDN Jatinangor</td>
                            <td>003/OPSISDIST/UP2DJB/2024</td>
                            <td>Bandung Raya</td>
                            <td>Sumedang</td>
                            <td>Ban Bocor</td>
                            <td>Rp 247.972.446,00</td>
                            <td>
                                <img class="report-photo" src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=120&q=80" alt="Bukti Foto">
                            </td>
                            <td class="text-center">
                                <button class="btn-action edit btn-edit-report" data-bs-toggle="modal" data-bs-target="#editReportUKBModal" data-nama="Sofiatu Zahra" data-unit="UKB" data-type-kabel="95 mm - 4 x 75" data-merk-nopol="150 mm - 4 x 50" data-jenis-volume="Karavan - 2 Set" data-kondisi="Rusak" data-tanggal="2025-08-17" data-lokasi="IPDN Jatinangor" data-no-ba="003/OPSISDIST/UP2DJB/2024" data-posko="Bandung Raya" data-up3="Sumedang" data-keterangan="Ban Bocor" data-anggaran="247972446">
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

        <!-- Deteksi Table -->
        <div id="tableDeteksi" class="table-container">
            <div class="table-responsive">
                <table id="reportDeteksiTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama Pelapor</th>
                            <th>Unit</th>
                            <th>Fitur & Type Deteksi</th>
                            <th>Merk dan Nopol Unit</th>
                            <th>Kondisi</th>
                            <th>Tanggal Kejadian</th>
                            <th>Lokasi Penggunaan</th>
                            <th>No. BA</th>
                            <th>Posko Pelaksana</th>
                            <th>UP3</th>
                            <th>Keterangan</th>
                            <th>Keperluan Anggaran</th>
                            <th>Bukti Foto</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1,8) as $index)
                        <tr>
                            <td>Sofiatu Zahra</td>
                            <td>DETEKSI</td>
                            <td>Assesment & Deteksi - Mobil</td>
                            <td>BAUR - B 9193 KCG</td>
                            <td><span class="badge-status red">Rusak</span></td>
                            <td>17/08/2025</td>
                            <td>IPDN Jatinangor</td>
                            <td>003/OPSISDIST/UP2DJB/2024</td>
                            <td>Bandung Raya</td>
                            <td>Sumedang</td>
                            <td>Ban Bocor</td>
                            <td>Rp 247.972.446,00</td>
                            <td>
                                <img class="report-photo" src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=120&q=80" alt="Bukti Foto">
                            </td>
                            <td class="text-center">
                                <button class="btn-action edit btn-edit-report" data-bs-toggle="modal" data-bs-target="#editReportDeteksiModal" data-nama="Sofiatu Zahra" data-unit="Deteksi" data-fitur-type="Assesment & Deteksi - Mobil" data-merk-nopol="BAUR - B 9193 KCG" data-kondisi="Rusak" data-tanggal="2025-08-17" data-lokasi="IPDN Jatinangor" data-no-ba="003/OPSISDIST/UP2DJB/2024" data-posko="Bandung Raya" data-up3="Sumedang" data-keterangan="Ban Bocor" data-anggaran="247972446">
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

<!-- Edit UPS Modal -->
<div class="modal fade" id="editReportUPSModal" tabindex="-1" aria-labelledby="editReportUPSModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReportUPSModalLabel">Edit Pelaporan UPS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReportUPSForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelapor</label>
                        <input type="text" class="form-control" id="reportUPSNama">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="reportUPSUnit">
                            <option>UPS</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis & Kapasitas</label>
                        <select class="form-select" id="reportUPSJenis">
                            <option>Mobile - 250 KVA</option>
                            <option>Portable - 110 KVA</option>
                            <option>Portable - 30 KVA</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Merk dan Nopol Unit</label>
                        <select class="form-select" id="reportUPSMerkNopol">
                            <option>Tescom - DK 8005 DE</option>
                            <option>Schneider - B 9196 ECC</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" id="reportUPSKondisi">
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="reportUPSTanggal">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Penggunaan</label>
                        <input type="text" class="form-control" id="reportUPSLokasi">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. BA</label>
                        <input type="text" class="form-control" id="reportUPSNoBA">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Posko Pelaksanaan</label>
                        <input type="text" class="form-control" id="reportUPSPosko">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">UP3</label>
                        <input type="text" class="form-control" id="reportUPSUP3">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="reportUPSKeterangan"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keperluan Anggaran</label>
                        <input type="text" class="form-control" id="reportUPSAnggaran" placeholder="Rp 0,00">
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">Bukti Foto</label>
                        <div class="upload-control">
                            <button type="button" class="btn btn-secondary mb-2">Upload File</button>
                            <small class="text-muted d-block">File.jpg</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editReportUPSForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit UKB Modal -->
<div class="modal fade" id="editReportUKBModal" tabindex="-1" aria-labelledby="editReportUKBModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReportUKBModalLabel">Edit Pelaporan UKB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReportUKBForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelapor</label>
                        <input type="text" class="form-control" id="reportUKBNama">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="reportUKBUnit">
                            <option>UKB</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Type & Panjang Kabel</label>
                        <select class="form-select" id="reportUKBTypeKabel">
                            <option>95 mm - 4 x 75</option>
                            <option>1C x 60SQMM - 6 x 200</option>
                            <option>150 mm - 4 x 50</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Merk dan Nopol UKB</label>
                        <select class="form-select" id="reportUKBMerkNopol">
                            <option>150 mm - 4 x 50</option>
                            <option>NULL - D 8934 FH</option>
                            <option>NYYHY - NULL</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis & Volume UKB</label>
                        <select class="form-select" id="reportUKBJenisVolume">
                            <option>Karavan - 2 Set</option>
                            <option>NULL - 1 Set</option>
                            <option>Mobile - 2 Set</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" id="reportUKBKondisi">
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="reportUKBTanggal">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Penggunaan</label>
                        <input type="text" class="form-control" id="reportUKBLokasi">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. BA</label>
                        <input type="text" class="form-control" id="reportUKBNoBA">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Posko Pelaksanaan</label>
                        <input type="text" class="form-control" id="reportUKBPosko">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">UP3</label>
                        <input type="text" class="form-control" id="reportUKBUP3">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="reportUKBKeterangan"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keperluan Anggaran</label>
                        <input type="text" class="form-control" id="reportUKBAnggaran" placeholder="Rp 0,00">
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">Bukti Foto</label>
                        <div class="upload-control">
                            <button type="button" class="btn btn-secondary mb-2">Upload File</button>
                            <small class="text-muted d-block">File.jpg</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editReportUKBForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Deteksi Modal -->
<div class="modal fade" id="editReportDeteksiModal" tabindex="-1" aria-labelledby="editReportDeteksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReportDeteksiModalLabel">Edit Pelaporan Deteksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReportDeteksiForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelapor</label>
                        <input type="text" class="form-control" id="reportDeteksiNama">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="reportDeteksiUnit">
                            <option>UPS</option>
                            <option>Deteksi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fitur & Type Deteksi</label>
                        <select class="form-select" id="reportDeteksiFiturType">
                            <option>Assesment & Deteksi - Mobil</option>
                            <option>Deteksi - Mobil</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" id="reportDeteksiKondisi">
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Merk dan Nopol Unit</label>
                        <select class="form-select" id="reportDeteksiMerkNopol">
                            <option>BAUR - B 9193 KCG</option>
                            <option>CENTRIX - D 8657 ES</option>
                            <option>CENTIX - D 8656 ES</option>
                            <option>MEGGER - NULL</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="reportDeteksiTanggal">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Penggunaan</label>
                        <input type="text" class="form-control" id="reportDeteksiLokasi">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. BA</label>
                        <input type="text" class="form-control" id="reportDeteksiNoBA">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Posko Pelaksanaan</label>
                        <input type="text" class="form-control" id="reportDeteksiPosko">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">UP3</label>
                        <input type="text" class="form-control" id="reportDeteksiUP3">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="reportDeteksiKeterangan"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keperluan Anggaran</label>
                        <input type="text" class="form-control" id="reportDeteksiAnggaran" placeholder="Rp 0,00">
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">Bukti Foto</label>
                        <div class="upload-control">
                            <button type="button" class="btn btn-secondary mb-2">Upload File</button>
                            <small class="text-muted d-block">File.jpg</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editReportDeteksiForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let upsTable, ukbTable, deteksiTable;

    $(function () {
        // Initialize DataTables
        upsTable = $('#reportUPSTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
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

        ukbTable = $('#reportUKBTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
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

        deteksiTable = $('#reportDeteksiTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
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

        // Edit UPS
        $(document).on('click', '#tableUPS .btn-edit-report', function () {
            const button = $(this);
            $('#reportUPSNama').val(button.data('nama'));
            $('#reportUPSUnit').val(button.data('unit'));
            $('#reportUPSJenis').val(button.data('jenis'));
            $('#reportUPSMerkNopol').val(button.data('merk-nopol'));
            $('#reportUPSKondisi').val(button.data('kondisi'));
            $('#reportUPSTanggal').val(button.data('tanggal'));
            $('#reportUPSLokasi').val(button.data('lokasi'));
            $('#reportUPSNoBA').val(button.data('no-ba'));
            $('#reportUPSPosko').val(button.data('posko'));
            $('#reportUPSUP3').val(button.data('up3'));
            $('#reportUPSKeterangan').val(button.data('keterangan'));
            const anggaran = button.data('anggaran');
            if (anggaran) {
                $('#reportUPSAnggaran').val('Rp ' + new Intl.NumberFormat('id-ID').format(anggaran) + ',00');
            }
        });

        // Edit UKB
        $(document).on('click', '#tableUKB .btn-edit-report', function () {
            const button = $(this);
            $('#reportUKBNama').val(button.data('nama'));
            $('#reportUKBUnit').val(button.data('unit'));
            $('#reportUKBTypeKabel').val(button.data('type-kabel'));
            $('#reportUKBMerkNopol').val(button.data('merk-nopol'));
            $('#reportUKBJenisVolume').val(button.data('jenis-volume'));
            $('#reportUKBKondisi').val(button.data('kondisi'));
            $('#reportUKBTanggal').val(button.data('tanggal'));
            $('#reportUKBLokasi').val(button.data('lokasi'));
            $('#reportUKBNoBA').val(button.data('no-ba'));
            $('#reportUKBPosko').val(button.data('posko'));
            $('#reportUKBUP3').val(button.data('up3'));
            $('#reportUKBKeterangan').val(button.data('keterangan'));
            const anggaran = button.data('anggaran');
            if (anggaran) {
                $('#reportUKBAnggaran').val('Rp ' + new Intl.NumberFormat('id-ID').format(anggaran) + ',00');
            }
        });

        // Edit Deteksi
        $(document).on('click', '#tableDeteksi .btn-edit-report', function () {
            const button = $(this);
            $('#reportDeteksiNama').val(button.data('nama'));
            $('#reportDeteksiUnit').val(button.data('unit'));
            $('#reportDeteksiFiturType').val(button.data('fitur-type'));
            $('#reportDeteksiKondisi').val(button.data('kondisi'));
            $('#reportDeteksiMerkNopol').val(button.data('merk-nopol'));
            $('#reportDeteksiTanggal').val(button.data('tanggal'));
            $('#reportDeteksiLokasi').val(button.data('lokasi'));
            $('#reportDeteksiNoBA').val(button.data('no-ba'));
            $('#reportDeteksiPosko').val(button.data('posko'));
            $('#reportDeteksiUP3').val(button.data('up3'));
            $('#reportDeteksiKeterangan').val(button.data('keterangan'));
            const anggaran = button.data('anggaran');
            if (anggaran) {
                $('#reportDeteksiAnggaran').val('Rp ' + new Intl.NumberFormat('id-ID').format(anggaran) + ',00');
            }
        });
    });

    function switchTable(type) {
        // Hide all tables
        $('.table-container').removeClass('active');
        $('.tab-button').removeClass('active');

        // Show selected table
        if (type === 'UPS') {
            $('#tableUPS').addClass('active');
            $('.tab-button:first').addClass('active');
        } else if (type === 'UKB') {
            $('#tableUKB').addClass('active');
            $('.tab-button:nth-child(2)').addClass('active');
        } else if (type === 'Deteksi') {
            $('#tableDeteksi').addClass('active');
            $('.tab-button:last').addClass('active');
        }
    }
</script>
@endpush
