@extends('admin.layout')

@section('title', 'Units - UP2D Pasundan')

@push('styles')
<style>
    .unit-type-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 2px solid transparent;
        padding: 24px;
        text-align: center;
        border-radius: 16px;
        background: #fff;
    }

    .unit-type-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-color);
    }

    .unit-type-icon {
        width: 80px;
        height: 80px;
        background: #f0f0f0;
        border-radius: 12px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }

    .detail-value {
        background: #e0f2fe;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 600;
        color: #0f172a;
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
        <h1 class="mb-1">Units</h1>
        <span class="text-muted">Data unit UPS dan detail operasional</span>
    </div>
    <button class="btn-add d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#selectUnitTypeModal">
        <i class="fa-solid fa-plus"></i> Add Unit
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="unitsTable" class="table table-borderless align-middle">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Kondisi</th>
                        <th>Merk</th>
                        <th>Type / Model / No Seri</th>
                        <th>NOPOL</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>UPS</td>
                        <td><span class="badge-status green">Baik</span></td>
                        <td>Tescom</td>
                        <td>DS3250T/183906</td>
                        <td>DK 8005 DE</td>
                        <td>UID Jabar (UP3 BDG)</td>
                        <td><span class="badge-status green">Sedang digunakan</span></td>
                        <td>Normal, Dummyload 80% OK</td>
                        <td class="text-center">
                            <button class="btn-action info btn-view-detail" data-unit-type="UPS" data-unit="UPS" data-jenis="Mobile" data-kva="250" data-kondisi="Baik" data-merk="Tescom" data-model="DS3250T/183906" data-nopol="DK 8005 DE" data-lokasi="UID Jabar (UP3 BDG)" data-status="Sedang digunakan" data-keterangan="Normal, Dummyload 80% OK" data-merk-battery="ZEUS" data-jumlah-battery="120" data-kapasitas-battery="120">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-action edit btn-edit-unit ms-2" data-bs-toggle="modal" data-bs-target="#editUnitUPSModal" data-unit="UPS" data-jenis="Mobile" data-kva="250" data-kondisi="Baik" data-merk="Tescom" data-model="DS3250T/183906" data-nopol="DK 8005 DE" data-lokasi="UID Jabar (UP3 BDG)" data-status="Sedang digunakan" data-keterangan="Normal, Dummyload 80% OK" data-merk-battery="ZEUS" data-jumlah-battery="120" data-kapasitas-battery="120">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>UPS</td>
                        <td><span class="badge-status red">Rusak</span></td>
                        <td>Tescom</td>
                        <td>DS3250T/183906</td>
                        <td>DK 8005 DE</td>
                        <td>UID Jabar (UP3 BDG)</td>
                        <td><span class="badge-status red">Tidak Siap Operasi</span></td>
                        <td>Normal, Dummyload 80% OK</td>
                        <td class="text-center">
                            <button class="btn-action info btn-view-detail" data-unit-type="UPS" data-unit="UPS" data-jenis="Mobile" data-kva="250" data-kondisi="Rusak" data-merk="Tescom" data-model="DS3250T/183906" data-nopol="DK 8005 DE" data-lokasi="UID Jabar (UP3 BDG)" data-status="Tidak Siap Operasi" data-keterangan="Normal, Dummyload 80% OK" data-merk-battery="ZEUS" data-jumlah-battery="120" data-kapasitas-battery="120">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-action edit btn-edit-unit ms-2" data-bs-toggle="modal" data-bs-target="#editUnitUPSModal" data-unit="UPS" data-jenis="Mobile" data-kva="250" data-kondisi="Rusak" data-merk="Tescom" data-model="DS3250T/183906" data-nopol="DK 8005 DE" data-lokasi="UID Jabar (UP3 BDG)" data-status="Tidak Siap Operasi" data-keterangan="Normal, Dummyload 80% OK" data-merk-battery="ZEUS" data-jumlah-battery="120" data-kapasitas-battery="120">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>UPS</td>
                        <td><span class="badge-status red">Rusak</span></td>
                        <td>Schneider</td>
                        <td>OG-GVM1200KH/U21814000578</td>
                        <td>B 9196 ECC</td>
                        <td>Workshop PT MEJ</td>
                        <td><span class="badge-status red">Tidak Siap Operasi</span></td>
                        <td>Perlu pengecekan, ganti batt bank 1</td>
                        <td class="text-center">
                            <button class="btn-action info btn-view-detail" data-unit-type="UPS" data-unit="UPS" data-jenis="Mobile" data-kva="200" data-kondisi="Rusak" data-merk="Schneider" data-model="OG-GVM1200KH/U21814000578" data-nopol="B 9196 ECC" data-lokasi="Workshop PT MEJ" data-status="Tidak Siap Operasi" data-keterangan="Perlu pengecekan, ganti batt bank 1" data-merk-battery="ROCKET" data-jumlah-battery="80" data-kapasitas-battery="220">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-action edit btn-edit-unit ms-2" data-bs-toggle="modal" data-bs-target="#editUnitUPSModal" data-unit="UPS" data-jenis="Mobile" data-kva="200" data-kondisi="Rusak" data-merk="Schneider" data-model="OG-GVM1200KH/U21814000578" data-nopol="B 9196 ECC" data-lokasi="Workshop PT MEJ" data-status="Tidak Siap Operasi" data-keterangan="Perlu pengecekan, ganti batt bank 1" data-merk-battery="ROCKET" data-jumlah-battery="80" data-kapasitas-battery="220">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>UKB</td>
                        <td><span class="badge-status green">Baik</span></td>
                        <td>-</td>
                        <td>1C X 60SQMM</td>
                        <td>D 8934 FH</td>
                        <td>Bandung Timur</td>
                        <td><span class="badge-status yellow">Stand By</span></td>
                        <td>-</td>
                        <td class="text-center">
                            <button class="btn-action info btn-view-detail" data-unit-type="UKB" data-unit="UKB" data-kondisi="Baik" data-merk="-" data-panjang="6 x 200" data-volume="1" data-jenis="-" data-model="1C X 60SQMM" data-nopol="D 8934 FH" data-lokasi="Bandung Timur" data-status="Stand By" data-keterangan="-" data-bpkb="Ada" data-stnk="Ada" data-pajak-tahunan="15/02/2024" data-pajak-5tahunan="15/02/2024" data-kir="Ada" data-masa-berlaku-kir="-" data-service="15/02/2024" data-dokumentasi="www.xxxx.com">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-action edit btn-edit-unit ms-2" data-bs-toggle="modal" data-bs-target="#editUnitUKBModal" data-unit="UKB" data-kondisi="Baik" data-merk="-" data-panjang="6 x 200" data-volume="1" data-jenis="Karavan" data-model="1C X 60SQMM" data-nopol="D 8934 FH" data-lokasi="Bandung Timur" data-status="Stand By" data-keterangan="-" data-bpkb="Ada" data-stnk="Ada" data-pajak-tahunan="15/02/2024" data-pajak-5tahunan="15/02/2024" data-kir="Ada" data-masa-berlaku-kir="-" data-service="15/02/2024" data-dokumentasi="www.xxxx.com">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Deteksi</td>
                        <td><span class="badge-status green">Baik</span></td>
                        <td>BAUR</td>
                        <td>Mobil</td>
                        <td>B 9193 KCG</td>
                        <td>Posko Bogor Raya</td>
                        <td><span class="badge-status yellow">-</span></td>
                        <td>-</td>
                        <td class="text-center">
                            <button class="btn-action info btn-view-detail" data-unit-type="Deteksi" data-unit="Deteksi" data-kondisi="Baik" data-merk="BAUR" data-fitur="Assesment dan Deteksi" data-model="Mobil" data-nopol="B 9193 KCG" data-lokasi="Posko Bogor Raya" data-status="-" data-keterangan="-" data-bpkb="-" data-stnk="Ada" data-pajak-tahunan="24/10/2023" data-pajak-5tahunan="-" data-kir="-" data-masa-berlaku-kir="-" data-service="15/02/2024" data-dokumentasi="www.xxxx.com">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-action edit btn-edit-unit ms-2" data-bs-toggle="modal" data-bs-target="#editUnitDeteksiModal" data-unit="Deteksi" data-kondisi="Baik" data-merk="BAUR" data-fitur="Assesment dan Deteksi" data-model="Mobil" data-nopol="B 9193 KCG" data-lokasi="Posko Bogor Raya" data-status="-" data-keterangan="-" data-bpkb="-" data-stnk="Ada" data-pajak-tahunan="24/10/2023" data-pajak-5tahunan="-" data-kir="-" data-masa-berlaku-kir="-" data-service="15/02/2024" data-dokumentasi="www.xxxx.com">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Select Unit Type Modal -->
<div class="modal fade" id="selectUnitTypeModal" tabindex="-1" aria-labelledby="selectUnitTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectUnitTypeModalLabel">Select a Unit to Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted mb-4">Units you add here will appear in your table units immediately</p>
                <div class="row g-3">
                    <div class="col-4">
                        <div class="unit-type-card" onclick="openCreateModal('UPS')">
                            <div class="unit-type-icon">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <h6 class="fw-bold mb-0">UPS</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="unit-type-card" onclick="openCreateModal('UKB')">
                            <div class="unit-type-icon">
                                <i class="fa-solid fa-plug"></i>
                            </div>
                            <h6 class="fw-bold mb-0">UKB</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="unit-type-card" onclick="openCreateModal('Deteksi')">
                            <div class="unit-type-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Deteksi</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create UPS Modal -->
<div class="modal fade" id="createUnitUPSModal" tabindex="-1" aria-labelledby="createUnitUPSModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUnitUPSModalLabel">Add Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUnitUPSForm" class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>UPS</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Mobile</option>
                            <option>Portable</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">KVA</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>10</option>
                            <option>30</option>
                            <option>100</option>
                            <option>200</option>
                            <option>250</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" placeholder="Isi Merk" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Model / No Seri</label>
                        <input type="text" class="form-control" placeholder="Isi Model/No. Seri" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" placeholder="XX 0000 XX" required>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" placeholder="Isi Lokasi" required>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Sedang digunakan</option>
                            <option>Tidak Siap Operasi</option>
                            <option>Standby</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="Isi Keterangan" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Merk Battery</label>
                        <input type="text" class="form-control" placeholder="Merk" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Battery</label>
                        <input type="number" class="form-control" placeholder="000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" placeholder="000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan STNK</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan STNK</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Mobil Terakhir</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" placeholder="Isi Link Dokumentasi" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createUnitUPSForm" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Create UKB Modal -->
<div class="modal fade" id="createUnitUKBModal" tabindex="-1" aria-labelledby="createUnitUKBModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUnitUKBModalLabel">Add Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUnitUKBForm" class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>UKB</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" placeholder="Isi Merk" required>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Panjang</label>
                        <input type="text" class="form-control" placeholder="Isi Pj." required>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Volume</label>
                        <input type="text" class="form-control" placeholder="Isi Vol." required>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Jenis</label>
                        <input type="text" class="form-control" placeholder="Isi Jenis" required>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Type / Model / No Seri</label>
                        <input type="text" class="form-control" placeholder="Isi Type" required>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" placeholder="XX 0000 XX" required>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" placeholder="Isi Lokasi" required>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Sedang digunakan</option>
                            <option>Tidak Siap Operasi</option>
                            <option>Standby</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="Isi Keterangan" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan STNK</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan STNK</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Mobil Terakhir</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" placeholder="Isi Link Dokumentasi" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createUnitUKBForm" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Deteksi Modal -->
<div class="modal fade" id="createUnitDeteksiModal" tabindex="-1" aria-labelledby="createUnitDeteksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUnitDeteksiModalLabel">Add Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUnitDeteksiForm" class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Deteksi</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Merk</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>BAUR</option>
                            <option>MEGGER</option>
                            <option>CENTRIX</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Fitur</label>
                        <input type="text" class="form-control" placeholder="Isi Fitur" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Type / Model / No Seri</label>
                        <input type="text" class="form-control" placeholder="Isi Type" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" placeholder="XX 0000 XX" required>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" placeholder="Isi Lokasi" required>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Sedang digunakan</option>
                            <option>Tidak Siap Operasi</option>
                            <option>Standby</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="Isi Keterangan" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan STNK</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan STNK</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Mobil Terakhir</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" placeholder="Isi Link Dokumentasi" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createUnitDeteksiForm" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit UPS Modal -->
<div class="modal fade" id="editUnitUPSModal" tabindex="-1" aria-labelledby="editUnitUPSModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitUPSModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUnitUPSForm" class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="editUPSUnit">
                            <option>UPS</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-select" id="editUPSJenis">
                            <option>Mobile</option>
                            <option>Portable</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">KVA</label>
                        <select class="form-select" id="editUPSKva">
                            <option>10</option>
                            <option>30</option>
                            <option>100</option>
                            <option>200</option>
                            <option>250</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" id="editUPSKondisi">
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="editUPSMerk">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Model / No Seri</label>
                        <input type="text" class="form-control" id="editUPSModel">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" id="editUPSNopol">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="editUPSLokasi">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="editUPSStatus">
                            <option>Sedang digunakan</option>
                            <option>Tidak Siap Operasi</option>
                            <option>Standby</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="editUPSKeterangan"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Merk Battery</label>
                        <input type="text" class="form-control" id="editUPSMerkBattery">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Battery</label>
                        <input type="number" class="form-control" id="editUPSJumlahBattery">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="editUPSKapasitasBattery">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <select class="form-select" id="editUPSBpkb">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <select class="form-select" id="editUPSStnk">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan STNK</label>
                        <input type="date" class="form-control" id="editUPSPajakTahunan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan STNK</label>
                        <input type="date" class="form-control" id="editUPSPajak5Tahunan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <select class="form-select" id="editUPSKir">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" id="editUPSMasaBerlakuKir">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Mobil Terakhir</label>
                        <input type="date" class="form-control" id="editUPSService">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" id="editUPSDokumentasi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editUnitUPSForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit UKB Modal -->
<div class="modal fade" id="editUnitUKBModal" tabindex="-1" aria-labelledby="editUnitUKBModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitUKBModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUnitUKBForm" class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="editUKBUnit">
                            <option>UKB</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" id="editUKBKondisi">
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="editUKBMerk">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Panjang</label>
                        <input type="text" class="form-control" id="editUKBPanjang">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Volume</label>
                        <input type="text" class="form-control" id="editUKBVolume">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Jenis</label>
                        <input type="text" class="form-control" id="editUKBJenis">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Type / Model / No Seri</label>
                        <input type="text" class="form-control" id="editUKBModel">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" id="editUKBNopol">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="editUKBLokasi">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="editUKBStatus">
                            <option>Sedang digunakan</option>
                            <option>Tidak Siap Operasi</option>
                            <option>Stand By</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="editUKBKeterangan"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <select class="form-select" id="editUKBBpkb">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <select class="form-select" id="editUKBStnk">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan STNK</label>
                        <input type="date" class="form-control" id="editUKBPajakTahunan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan STNK</label>
                        <input type="date" class="form-control" id="editUKBPajak5Tahunan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <select class="form-select" id="editUKBKir">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" id="editUKBMasaBerlakuKir">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Mobil Terakhir</label>
                        <input type="date" class="form-control" id="editUKBService">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" id="editUKBDokumentasi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editUnitUKBForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Deteksi Modal -->
<div class="modal fade" id="editUnitDeteksiModal" tabindex="-1" aria-labelledby="editUnitDeteksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitDeteksiModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUnitDeteksiForm" class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="editDeteksiUnit">
                            <option>Deteksi</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" id="editDeteksiKondisi">
                            <option>Baik</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="editDeteksiMerk">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label">Fitur</label>
                        <input type="text" class="form-control" id="editDeteksiFitur">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Type/Model/No Seri</label>
                        <input type="text" class="form-control" id="editDeteksiModel">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" id="editDeteksiNopol">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="editDeteksiLokasi">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="editDeteksiStatus">
                            <option>-</option>
                            <option>Sedang digunakan</option>
                            <option>Tidak Siap Operasi</option>
                            <option>Standby</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="editDeteksiKeterangan"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <select class="form-select" id="editDeteksiBpkb">
                            <option>-</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <select class="form-select" id="editDeteksiStnk">
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan STNK</label>
                        <input type="date" class="form-control" id="editDeteksiPajakTahunan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan STNK</label>
                        <input type="date" class="form-control" id="editDeteksiPajak5Tahunan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <select class="form-select" id="editDeteksiKir">
                            <option>-</option>
                            <option>Ada</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" id="editDeteksiMasaBerlakuKir">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Mobil Terakhir</label>
                        <input type="date" class="form-control" id="editDeteksiService">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" id="editDeteksiDokumentasi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editUnitDeteksiForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Unit Modal -->
<div class="modal fade" id="detailUnitModal" tabindex="-1" aria-labelledby="detailUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailUnitModalLabel">Detail Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailUnitContent">
                <!-- Content will be dynamically loaded -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#unitsTable').DataTable({
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
        $('.btn-edit-unit').on('click', function () {
            const button = $(this);
            const unit = button.data('unit');

                if (unit === 'UPS') {
                $('#editUPSUnit').val(button.data('unit'));
                $('#editUPSJenis').val(button.data('jenis'));
                $('#editUPSKva').val(button.data('kva'));
                $('#editUPSKondisi').val(button.data('kondisi'));
                $('#editUPSMerk').val(button.data('merk'));
                $('#editUPSModel').val(button.data('model'));
                $('#editUPSNopol').val(button.data('nopol'));
                $('#editUPSLokasi').val(button.data('lokasi'));
                $('#editUPSStatus').val(button.data('status'));
                $('#editUPSKeterangan').val(button.data('keterangan'));
                $('#editUPSMerkBattery').val(button.data('merk-battery'));
                $('#editUPSJumlahBattery').val(button.data('jumlah-battery'));
                $('#editUPSKapasitasBattery').val(button.data('kapasitas-battery'));
                $('#editUPSBpkb').val(button.data('bpkb'));
                $('#editUPSStnk').val(button.data('stnk'));
                $('#editUPSPajakTahunan').val(button.data('pajak-tahunan'));
                $('#editUPSPajak5Tahunan').val(button.data('pajak-5tahunan'));
                $('#editUPSKir').val(button.data('kir'));
                $('#editUPSMasaBerlakuKir').val(button.data('masa-berlaku-kir'));
                $('#editUPSService').val(button.data('service'));
                $('#editUPSDokumentasi').val(button.data('dokumentasi'));
                } else if (unit === 'UKB') {
                $('#editUKBUnit').val(button.data('unit'));
                $('#editUKBKondisi').val(button.data('kondisi'));
                $('#editUKBMerk').val(button.data('merk'));
                $('#editUKBPanjang').val(button.data('panjang'));
                $('#editUKBVolume').val(button.data('volume'));
                $('#editUKBJenis').val(button.data('jenis'));
                $('#editUKBModel').val(button.data('model'));
                $('#editUKBNopol').val(button.data('nopol'));
                $('#editUKBLokasi').val(button.data('lokasi'));
                $('#editUKBStatus').val(button.data('status'));
                $('#editUKBKeterangan').val(button.data('keterangan'));
                $('#editUKBBpkb').val(button.data('bpkb'));
                $('#editUKBStnk').val(button.data('stnk'));
                $('#editUKBPajakTahunan').val(button.data('pajak-tahunan'));
                $('#editUKBPajak5Tahunan').val(button.data('pajak-5tahunan'));
                $('#editUKBKir').val(button.data('kir'));
                $('#editUKBMasaBerlakuKir').val(button.data('masa-berlaku-kir'));
                $('#editUKBService').val(button.data('service'));
                $('#editUKBDokumentasi').val(button.data('dokumentasi'));
            } else if (unit === 'Deteksi') {
                $('#editDeteksiUnit').val(button.data('unit'));
                $('#editDeteksiKondisi').val(button.data('kondisi'));
                $('#editDeteksiMerk').val(button.data('merk'));
                $('#editDeteksiFitur').val(button.data('fitur'));
                $('#editDeteksiModel').val(button.data('model'));
                $('#editDeteksiNopol').val(button.data('nopol'));
                $('#editDeteksiLokasi').val(button.data('lokasi'));
                $('#editDeteksiStatus').val(button.data('status'));
                $('#editDeteksiKeterangan').val(button.data('keterangan'));
                $('#editDeteksiBpkb').val(button.data('bpkb'));
                $('#editDeteksiStnk').val(button.data('stnk'));
                $('#editDeteksiPajakTahunan').val(button.data('pajak-tahunan'));
                $('#editDeteksiPajak5Tahunan').val(button.data('pajak-5tahunan'));
                $('#editDeteksiKir').val(button.data('kir'));
                $('#editDeteksiMasaBerlakuKir').val(button.data('masa-berlaku-kir'));
                $('#editDeteksiService').val(button.data('service'));
                $('#editDeteksiDokumentasi').val(button.data('dokumentasi'));
            }
        });

        // View Detail -> redirect to page with persisted data
        $('.btn-view-detail').on('click', function () {
            const button = $(this);
            const payload = button.data();
            try {
                localStorage.setItem('unitDetailPayload', JSON.stringify(payload));
            } catch (e) {}
            window.location.href = '/admin/unit-detail';
        });
    });

    function openCreateModal(type) {
        $('#selectUnitTypeModal').modal('hide');
        setTimeout(() => {
            if (type === 'UPS') {
                $('#createUnitUPSModal').modal('show');
            } else if (type === 'UKB') {
                $('#createUnitUKBModal').modal('show');
            } else if (type === 'Deteksi') {
                $('#createUnitDeteksiModal').modal('show');
            }
        }, 300);
    }
</script>
@endpush
