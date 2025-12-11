@extends('admin.layout')

@section('title', 'Pelaporan Unit - UP2D Pasundan')

@push('styles')
    <style>
        .tab-button {
            padding: 12px 24px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .tab-button:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            transform: translateY(-2px);
        }

        .tab-button.active {
            background: #fff;
            color: var(--primary-dark);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .table-container {
            display: none;
        }

        .table-container.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .report-photo {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .report-photo:hover {
            transform: scale(1.1);
        }

        .upload-control {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .upload-control:hover {
            border-color: var(--primary-dark);
            background: #f0f5ff;
        }

        /* Scroll Wrapper Styling */
        .table-scroll-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            padding: 16px;
            position: relative;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 8px;
            scrollbar-width: auto;
            scrollbar-color: #1a3a4a #e2e8f0;
        }

        .table-responsive::-webkit-scrollbar {
            height: 14px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: linear-gradient(90deg, #334155, #475569);
            border-radius: 10px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #0f2937, #1a4a5e);
            border-radius: 10px;
            border: 2px solid #475569;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #001a24, #0f2937);
        }

        table.table {
            margin-bottom: 0;
        }

        table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        table thead th {
            border: none !important;
            padding: 14px 12px !important;
            font-weight: 600;
            color: #334155;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            vertical-align: middle !important;
        }

        table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        table tbody tr:hover {
            background-color: #f8fafc;
        }

        table tbody td {
            padding: 14px 12px !important;
            vertical-align: middle !important;
            white-space: nowrap;
            color: #475569;
        }

        table .text-center .d-flex {
            gap: .5rem;
        }

        .dataTables_wrapper {
            padding: 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.5rem;
        }

        .dataTables_length label,
        .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            color: #475569;
            font-size: 14px;
            margin: 0;
        }

        .dataTables_length select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 32px 8px 12px;
            font-size: 14px;
            color: #334155;
            background-color: #fff;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23475569' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .dataTables_length select:hover {
            border-color: #94a3b8;
        }

        .dataTables_length select:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(0, 45, 60, 0.1);
        }

        .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 14px;
            min-width: 200px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .dataTables_filter input:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(0, 45, 60, 0.1);
        }

        .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            margin: 0 2px;
        }

        .dataTables_paginate .paginate_button.current {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
            color: #fff !important;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-action.edit {
            background: #e0f2fe;
            color: #0284c7;
            border: none;
        }

        .btn-action.edit:hover {
            background: #0284c7;
            color: #fff;
            transform: scale(1.1);
        }

        .btn-action.delete {
            background: #fee2e2;
            color: #dc2626;
            border: none;
        }

        .btn-action.delete:hover {
            background: #dc2626;
            color: #fff;
            transform: scale(1.1);
        }

        @media (max-width: 1000px) {
            .table-responsive {
                font-size: 13px;
            }

            .dataTables_length,
            .dataTables_filter {
                font-size: 13px;
            }

            .tab-button {
                padding: 10px 16px;
                font-size: 13px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-outline-dark btn-sm d-lg-none" id="toggleSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="mb-1" style="color: var(--primary-dark); font-weight: 700;">Pelaporan Unit</h1>
            <span class="text-muted">Laporan kondisi unit terbaru</span>
        </div>
    </div>

    <!-- Main Card Wrapper -->
    <div class="card shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
        <!-- Card Header with Gradient -->
        <div class="card-header border-0 py-3"
            style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a4a5e 100%);">
            <div class="d-flex gap-2 flex-wrap">
                <button class="tab-button active" onclick="switchTable('UPS')">
                    <i class="fa-solid fa-bolt me-2"></i>Tabel UPS
                </button>
                <button class="tab-button" onclick="switchTable('UKB')">
                    <i class="fa-solid fa-plug me-2"></i>Tabel UKB
                </button>
                <button class="tab-button" onclick="switchTable('Deteksi')">
                    <i class="fa-solid fa-search me-2"></i>Tabel Deteksi
                </button>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4" style="background-color: #fafbfc;">

            <!-- UPS Table -->
            <div id="tableUPS" class="table-container active">
                <div class="table-scroll-wrapper">
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
                                @foreach(range(1, 8) as $index)
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
                                            <img class="report-photo"
                                                src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=120&q=80"
                                                alt="Bukti Foto">
                                        </td>
                                        <td class="text-center">
                                            <button class="btn-action edit btn-edit-report" data-bs-toggle="modal"
                                                data-bs-target="#editReportUPSModal" data-nama="Sofiatu Zahra" data-unit="UPS"
                                                data-jenis="Mobile - 250 KVA" data-merk-nopol="Tescom - DK 8005 DE"
                                                data-kondisi="Rusak" data-tanggal="2025-08-17" data-lokasi="IPDN Jatinangor"
                                                data-no-ba="003/OPSISDIST/UP2DJB/2024" data-posko="Bandung Raya"
                                                data-up3="Sumedang" data-keterangan="Ban Bocor" data-anggaran="247972446">
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

            <!-- UKB Table -->
            <div id="tableUKB" class="table-container">
                <div class="table-scroll-wrapper">
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
                                @foreach(range(1, 8) as $index)
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
                                            <img class="report-photo"
                                                src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=120&q=80"
                                                alt="Bukti Foto">
                                        </td>
                                        <td class="text-center">
                                            <button class="btn-action edit btn-edit-report" data-bs-toggle="modal"
                                                data-bs-target="#editReportUKBModal" data-nama="Sofiatu Zahra" data-unit="UKB"
                                                data-type-kabel="95 mm - 4 x 75" data-merk-nopol="150 mm - 4 x 50"
                                                data-jenis-volume="Karavan - 2 Set" data-kondisi="Rusak"
                                                data-tanggal="2025-08-17" data-lokasi="IPDN Jatinangor"
                                                data-no-ba="003/OPSISDIST/UP2DJB/2024" data-posko="Bandung Raya"
                                                data-up3="Sumedang" data-keterangan="Ban Bocor" data-anggaran="247972446">
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

            <!-- Deteksi Table -->
            <div id="tableDeteksi" class="table-container">
                <div class="table-scroll-wrapper">
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
                                @foreach(range(1, 8) as $index)
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
                                            <img class="report-photo"
                                                src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=120&q=80"
                                                alt="Bukti Foto">
                                        </td>
                                        <td class="text-center">
                                            <button class="btn-action edit btn-edit-report" data-bs-toggle="modal"
                                                data-bs-target="#editReportDeteksiModal" data-nama="Sofiatu Zahra"
                                                data-unit="Deteksi" data-fitur-type="Assesment & Deteksi - Mobil"
                                                data-merk-nopol="BAUR - B 9193 KCG" data-kondisi="Rusak"
                                                data-tanggal="2025-08-17" data-lokasi="IPDN Jatinangor"
                                                data-no-ba="003/OPSISDIST/UP2DJB/2024" data-posko="Bandung Raya"
                                                data-up3="Sumedang" data-keterangan="Ban Bocor" data-anggaran="247972446">
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

    </div>

    <!-- Edit UPS Modal -->
    <div class="modal fade" id="editReportUPSModal" tabindex="-1" aria-labelledby="editReportUPSModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="editReportUKBModal" tabindex="-1" aria-labelledby="editReportUKBModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="editReportDeteksiModal" tabindex="-1" aria-labelledby="editReportDeteksiModalLabel"
        aria-hidden="true">
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