@extends('admin.layout')

@section('title', 'Peminjaman - UP2D Pasundan')

@push('styles')
    <style>
        :root {
            --primary-dark: #002d3c;
        }

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

        .table-responsive {
            overflow-x: auto;
        }

        table th,
        table td {
            white-space: nowrap;
            vertical-align: middle !important;
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

        @media (max-width: 1000px) {
            .table-responsive {
                font-size: 13px;
            }

            .dataTables_length,
            .dataTables_filter {
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
            <h1 class="mb-1">Peminjaman Unit</h1>
            <span class="text-muted">Daftar permintaan dan riwayat peminjaman unit</span>
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
                    <table id="peminjamanUPSTable" class="table table-borderless align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email / No. Telepon</th>
                                <th>Unit</th>
                                <th>Jenis & Kapasitas</th>
                                <th>Merk & Nopol Unit</th>
                                <th>Lokasi Penggunaan</th>
                                <th>Tujuan Penggunaan</th>
                                <th>Tanggal Mobilisasi</th>
                                <th>Tanggal Demobilisasi</th>
                                <th>Posko Pelaksana</th>
                                <th>UP3</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sofiatu Zahra</td>
                                <td>xxx@gmail.com</td>
                                <td>UPS</td>
                                <td>MOBILE - 250 KVA</td>
                                <td>TESCOM - DK 8005 DE</td>
                                <td>UP2D Jabar</td>
                                <td>Untuk membenarkan di UP2D Jabar</td>
                                <td>15/08/2025</td>
                                <td>17/08/2025</td>
                                <td>Disjaya</td>
                                <td>Disjaya</td>
                                <td class="text-center">
                                    <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                        data-bs-target="#editLoanUPSModal" data-nama="Sofiatu Zahra"
                                        data-email="xxx@gmail.com" data-unit="UPS" data-jenis="Mobile - 250 KVA"
                                        data-unit-tersedia="Tescom - DK 8005 DE" data-lokasi="UP2D Jabar"
                                        data-tujuan="Untuk membenarkan di UP2D Jabar" data-tgl-pinjam="2025-08-15"
                                        data-tgl-selesai="2025-08-17" data-posko="Disjaya" data-up3="Disjaya">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @foreach(range(1, 7) as $index)
                                <tr>
                                    <td>Raihan</td>
                                    <td>xxx@gmail.com</td>
                                    <td>UPS</td>
                                    <td>PORTABLE - 110 KVA</td>
                                    <td>TESCOM - DK 8005 DE</td>
                                    <td>GI Ujung Berung</td>
                                    <td>Untuk kunjungan GI</td>
                                    <td>10/10/2025</td>
                                    <td>11/10/2025</td>
                                    <td>Bandung Raya</td>
                                    <td>Bandung</td>
                                    <td class="text-center">
                                        <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                            data-bs-target="#editLoanUPSModal" data-nama="Raihan" data-email="xxx@gmail.com"
                                            data-unit="UPS" data-jenis="Portable - 110 KVA"
                                            data-unit-tersedia="Tescom - DK 8005 DE" data-lokasi="GI Ujung Berung"
                                            data-tujuan="Untuk kunjungan GI" data-tgl-pinjam="2025-10-10"
                                            data-tgl-selesai="2025-10-11" data-posko="Bandung Raya" data-up3="Bandung">
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
                    <table id="peminjamanUKBTable" class="table table-borderless align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email / No. Telepon</th>
                                <th>Unit</th>
                                <th>Type & Panjang Kabel</th>
                                <th>Merk & Nopol Unit</th>
                                <th>Jenis & Volume UKB</th>
                                <th>Lokasi Penggunaan</th>
                                <th>Tujuan Penggunaan</th>
                                <th>Tanggal Mobilisasi</th>
                                <th>Tanggal Demobilisasi</th>
                                <th>Posko Pelaksana</th>
                                <th>UP3</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sofiatu Zahra</td>
                                <td>xxx@gmail.com</td>
                                <td>UKB</td>
                                <td>95 mm - 4 x 75</td>
                                <td>NYYHY - NULL</td>
                                <td>Karavan - 2 Set</td>
                                <td>UP2D Jabar</td>
                                <td>Untuk membenarkan di UP2D Jabar</td>
                                <td>15/08/2025</td>
                                <td>17/08/2025</td>
                                <td>Disjaya</td>
                                <td>Disjaya</td>
                                <td class="text-center">
                                    <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                        data-bs-target="#editLoanUKBModal" data-nama="Sofiatu Zahra"
                                        data-email="xxx@gmail.com" data-unit="UKB" data-type-kabel="95 mm - 4 x 75"
                                        data-merk-nopol="NYYHY - NULL" data-jenis-volume="Karavan - 2 Set"
                                        data-lokasi="UP2D Jabar" data-tujuan="Untuk membenarkan di UP2D Jabar"
                                        data-tgl-pinjam="2025-08-15" data-tgl-selesai="2025-08-17" data-posko="Disjaya"
                                        data-up3="Disjaya">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @foreach(range(1, 7) as $index)
                                <tr>
                                    <td>Raihan</td>
                                    <td>xxx@gmail.com</td>
                                    <td>UKB</td>
                                    <td>1C x 60SQMM - 6 x 200</td>
                                    <td>NULL - D 8934 FH</td>
                                    <td>NULL - 1 Set</td>
                                    <td>GI Ujung Berung</td>
                                    <td>Untuk kunjungan GI</td>
                                    <td>10/10/2025</td>
                                    <td>11/10/2025</td>
                                    <td>Bandung Raya</td>
                                    <td>Bandung</td>
                                    <td class="text-center">
                                        <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                            data-bs-target="#editLoanUKBModal" data-nama="Raihan" data-email="xxx@gmail.com"
                                            data-unit="UKB" data-type-kabel="1C x 60SQMM - 6 x 200"
                                            data-merk-nopol="NULL - D 8934 FH" data-jenis-volume="NULL - 1 Set"
                                            data-lokasi="GI Ujung Berung" data-tujuan="Untuk kunjungan GI"
                                            data-tgl-pinjam="2025-10-10" data-tgl-selesai="2025-10-11" data-posko="Bandung Raya"
                                            data-up3="Bandung">
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
                    <table id="peminjamanDeteksiTable" class="table table-borderless align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email / No. Telepon</th>
                                <th>Unit</th>
                                <th>Fitur & Type Deteksi</th>
                                <th>Merk & Nopol Unit</th>
                                <th>Lokasi Penggunaan</th>
                                <th>Tujuan Penggunaan</th>
                                <th>Tanggal Mobilisasi</th>
                                <th>Tanggal Demobilisasi</th>
                                <th>Posko Pelaksana</th>
                                <th>UP3</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sofiatu Zahra</td>
                                <td>xxx@gmail.com</td>
                                <td>DETEKSI</td>
                                <td>Assesment & Deteksi - Mobil</td>
                                <td>BAUR - B 9193 KCG</td>
                                <td>UP2D Jabar</td>
                                <td>Untuk membenarkan di UP2D Jabar</td>
                                <td>15/08/2025</td>
                                <td>17/08/2025</td>
                                <td>Disjaya</td>
                                <td>Disjaya</td>
                                <td class="text-center">
                                    <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                        data-bs-target="#editLoanDeteksiModal" data-nama="Sofiatu Zahra"
                                        data-email="xxx@gmail.com" data-unit="Deteksi"
                                        data-fitur-type="Assesment & Deteksi - Mobil" data-merk-nopol="BAUR - B 9193 KCG"
                                        data-lokasi="UP2D Jabar" data-tujuan="Untuk membenarkan di UP2D Jabar"
                                        data-tgl-pinjam="2025-08-15" data-tgl-selesai="2025-08-17" data-posko="Disjaya"
                                        data-up3="Disjaya">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @foreach(range(1, 7) as $index)
                                <tr>
                                    <td>Raihan</td>
                                    <td>xxx@gmail.com</td>
                                    <td>DETEKSI</td>
                                    <td>Deteksi - Mobil</td>
                                    <td>CENTRIX - D 8657 ES</td>
                                    <td>GI Ujung Berung</td>
                                    <td>Untuk kunjungan GI</td>
                                    <td>10/10/2025</td>
                                    <td>11/10/2025</td>
                                    <td>Bandung Raya</td>
                                    <td>Bandung</td>
                                    <td class="text-center">
                                        <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                            data-bs-target="#editLoanDeteksiModal" data-nama="Raihan" data-email="xxx@gmail.com"
                                            data-unit="Deteksi" data-fitur-type="Deteksi - Mobil"
                                            data-merk-nopol="CENTRIX - D 8657 ES" data-lokasi="GI Ujung Berung"
                                            data-tujuan="Untuk kunjungan GI" data-tgl-pinjam="2025-10-10"
                                            data-tgl-selesai="2025-10-11" data-posko="Bandung Raya" data-up3="Bandung">
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
    <div class="modal fade" id="editLoanUPSModal" tabindex="-1" aria-labelledby="editLoanUPSModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLoanUPSModalLabel">Edit Peminjaman UPS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLoanUPSForm" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="loanUPSNama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email/No. Telepon</label>
                            <input type="text" class="form-control" id="loanUPSKontak">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select class="form-select" id="loanUPSUnit">
                                <option>UPS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis & Kapasitas</label>
                            <select class="form-select" id="loanUPSJenis">
                                <option>Mobile - 250 KVA</option>
                                <option>Portable - 110 KVA</option>
                                <option>Portable - 30 KVA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Merk dan Nopol Unit</label>
                            <select class="form-select" id="loanUPSUnitTersedia">
                                <option>Tescom - DK 8005 DE</option>
                                <option>Schneider - B 9196 ECC</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Penggunaan</label>
                            <input type="text" class="form-control" id="loanUPSLokasi">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tujuan Penggunaan</label>
                            <textarea class="form-control" rows="3" id="loanUPSTujuan"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="loanUPSTanggalPinjam">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="loanUPSTanggalSelesai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posko Pelaksanaan</label>
                            <input type="text" class="form-control" id="loanUPSPosko">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">UP3</label>
                            <input type="text" class="form-control" id="loanUPSUP3">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editLoanUPSForm" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit UKB Modal -->
    <div class="modal fade" id="editLoanUKBModal" tabindex="-1" aria-labelledby="editLoanUKBModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLoanUKBModalLabel">Edit Peminjaman UKB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLoanUKBForm" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="loanUKBNama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email/No. Telepon</label>
                            <input type="text" class="form-control" id="loanUKBKontak">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select class="form-select" id="loanUKBUnit">
                                <option>Deteksi</option>
                                <option>UKB</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type & Panjang Kabel</label>
                            <select class="form-select" id="loanUKBTypeKabel">
                                <option>1C x 60SQMM - 6 x 200</option>
                                <option>95 mm - 4 x 75</option>
                                <option>150 mm - 4 x 50</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Merk dan Nopol Unit</label>
                            <select class="form-select" id="loanUKBMerkNopol">
                                <option>NULL - D 8934 FH</option>
                                <option>NYYHY - NULL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis & Volume UKB</label>
                            <select class="form-select" id="loanUKBJenisVolume">
                                <option>Karavan - 1 Set</option>
                                <option>Karavan - 2 Set</option>
                                <option>Mobile - 2 Set</option>
                                <option>NULL - 1 Set</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Penggunaan</label>
                            <input type="text" class="form-control" id="loanUKBLokasi">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tujuan Penggunaan</label>
                            <textarea class="form-control" rows="3" id="loanUKBTujuan"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="loanUKBTanggalPinjam">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="loanUKBTanggalSelesai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posko Pelaksanaan</label>
                            <input type="text" class="form-control" id="loanUKBPosko">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">UP3</label>
                            <input type="text" class="form-control" id="loanUKBUP3">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editLoanUKBForm" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Deteksi Modal -->
    <div class="modal fade" id="editLoanDeteksiModal" tabindex="-1" aria-labelledby="editLoanDeteksiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLoanDeteksiModalLabel">Edit Peminjaman Deteksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLoanDeteksiForm" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="loanDeteksiNama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email/No. Telepon</label>
                            <input type="text" class="form-control" id="loanDeteksiKontak">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select class="form-select" id="loanDeteksiUnit">
                                <option>Deteksi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fitur & Type Deteksi</label>
                            <select class="form-select" id="loanDeteksiFiturType">
                                <option>Assesment & Deteksi - Mobil</option>
                                <option>Deteksi - Mobil</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Merk dan Nopol Unit</label>
                            <select class="form-select" id="loanDeteksiMerkNopol">
                                <option>BAUR - B 9193 KCG</option>
                                <option>CENTRIX - D 8657 ES</option>
                                <option>CENTIX - D 8656 ES</option>
                                <option>MEGGER - NULL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Penggunaan</label>
                            <input type="text" class="form-control" id="loanDeteksiLokasi">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tujuan Penggunaan</label>
                            <textarea class="form-control" rows="3" id="loanDeteksiTujuan"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="loanDeteksiTanggalPinjam">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="loanDeteksiTanggalSelesai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posko Pelaksanaan</label>
                            <input type="text" class="form-control" id="loanDeteksiPosko">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">UP3</label>
                            <input type="text" class="form-control" id="loanDeteksiUP3">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editLoanDeteksiForm" class="btn btn-primary">Edit</button>
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
            upsTable = $('#peminjamanUPSTable').DataTable({
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

            ukbTable = $('#peminjamanUKBTable').DataTable({
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

            deteksiTable = $('#peminjamanDeteksiTable').DataTable({
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
            $(document).on('click', '#tableUPS .btn-edit-loan', function () {
                const button = $(this);
                $('#loanUPSNama').val(button.data('nama'));
                $('#loanUPSKontak').val(button.data('email'));
                $('#loanUPSUnit').val(button.data('unit'));
                $('#loanUPSJenis').val(button.data('jenis'));
                $('#loanUPSUnitTersedia').val(button.data('unit-tersedia'));
                $('#loanUPSLokasi').val(button.data('lokasi'));
                $('#loanUPSTujuan').val(button.data('tujuan'));
                $('#loanUPSTanggalPinjam').val(button.data('tgl-pinjam'));
                $('#loanUPSTanggalSelesai').val(button.data('tgl-selesai'));
                $('#loanUPSPosko').val(button.data('posko'));
                $('#loanUPSUP3').val(button.data('up3'));
            });

            // Edit UKB
            $(document).on('click', '#tableUKB .btn-edit-loan', function () {
                const button = $(this);
                $('#loanUKBNama').val(button.data('nama'));
                $('#loanUKBKontak').val(button.data('email'));
                $('#loanUKBUnit').val(button.data('unit'));
                $('#loanUKBTypeKabel').val(button.data('type-kabel'));
                $('#loanUKBMerkNopol').val(button.data('merk-nopol'));
                $('#loanUKBJenisVolume').val(button.data('jenis-volume'));
                $('#loanUKBLokasi').val(button.data('lokasi'));
                $('#loanUKBTujuan').val(button.data('tujuan'));
                $('#loanUKBTanggalPinjam').val(button.data('tgl-pinjam'));
                $('#loanUKBTanggalSelesai').val(button.data('tgl-selesai'));
                $('#loanUKBPosko').val(button.data('posko'));
                $('#loanUKBUP3').val(button.data('up3'));
            });

            // Edit Deteksi
            $(document).on('click', '#tableDeteksi .btn-edit-loan', function () {
                const button = $(this);
                $('#loanDeteksiNama').val(button.data('nama'));
                $('#loanDeteksiKontak').val(button.data('email'));
                $('#loanDeteksiUnit').val(button.data('unit'));
                $('#loanDeteksiFiturType').val(button.data('fitur-type'));
                $('#loanDeteksiMerkNopol').val(button.data('merk-nopol'));
                $('#loanDeteksiLokasi').val(button.data('lokasi'));
                $('#loanDeteksiTujuan').val(button.data('tujuan'));
                $('#loanDeteksiTanggalPinjam').val(button.data('tgl-pinjam'));
                $('#loanDeteksiTanggalSelesai').val(button.data('tgl-selesai'));
                $('#loanDeteksiPosko').val(button.data('posko'));
                $('#loanDeteksiUP3').val(button.data('up3'));
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