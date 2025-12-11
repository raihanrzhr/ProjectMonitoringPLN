@extends('admin.layout')

@section('title', 'Units - UP2D Pasundan')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_length label,
        .dataTables_filter label {
            font-weight: 600;
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
            <h1 class="mb-1">Units</h1>
            <span class="text-muted">Data unit UPS dan detail operasional</span>
        </div>
        <button class="btn-add d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#selectUnitTypeModal">
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
                        @forelse($units as $unit)
                            <tr>
                                <td>{{ $unit->nama_unit }}</td>

                                <td>
                                    @php
                                        $badgeClass = match ($unit->kondisi_kendaraan) {
                                            'BAIK' => 'green',
                                            'RUSAK', 'PERBAIKAN' => 'red',
                                            default => 'yellow'
                                        };
                                    @endphp
                                    <span class="badge-status {{ $badgeClass }}">{{ $unit->kondisi_kendaraan }}</span>
                                </td>

                                <td>{{ $unit->merk_kendaraan ?? '-' }}</td>

                                <td>
                                    @if($unit->tipe_peralatan === 'UPS')
                                        {{ $unit->detailUps->model_no_seri ?? '-' }}
                                    @elseif($unit->tipe_peralatan === 'UKB')
                                        {{ $unit->detailUkb->type ?? '-' }}
                                    @elseif($unit->tipe_peralatan === 'DETEKSI')
                                        {{ $unit->detailDeteksi->type ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $unit->nopol }}</td>

                                <td>{{ $unit->lokasi }}</td>

                                <td>
                                    @php
                                        $statusClass = match ($unit->status) {
                                            'Digunakan' => 'green',
                                            'Tidak Siap Oprasi' => 'red',
                                            'Standby' => 'yellow',
                                            default => 'yellow'
                                        };
                                    @endphp
                                    <span class="badge-status {{ $statusClass }}">{{ $unit->status }}</span>
                                </td>

                                <td>{{ Str::limit($unit->catatan, 30) }}</td>

                                <td class="text-center">
                                    <a href="{{ route('admin.units.show', $unit->unit_id) }}"
                                        class="btn-action info btn-view-detail" title="Lihat Detail"
                                        data-unit-type="{{ $unit->tipe_peralatan }}" data-unit="{{ $unit->nama_unit }}"
                                        data-kondisi="{{ $unit->kondisi_kendaraan }}" data-merk="{{ $unit->merk_kendaraan }}"
                                        data-nopol="{{ $unit->nopol }}" data-lokasi="{{ $unit->lokasi }}"
                                        data-status="{{ $unit->status }}" data-keterangan="{{ $unit->catatan }}"
                                        data-bpkb="{{ $unit->status_bpkb ? 'Ada' : 'Tidak Ada' }}"
                                        data-stnk="{{ $unit->status_stnk ? 'Ada' : 'Tidak Ada' }}"
                                        data-pajak-tahunan="{{ $unit->pajak_tahunan }}"
                                        data-pajak-5tahunan="{{ $unit->pajak_5tahunan }}"
                                        data-kir="{{ $unit->status_kir ? 'Ada' : 'Tidak Ada' }}"
                                        data-masa-berlaku-kir="{{ $unit->masa_berlaku_kir }}"
                                        data-service="{{ $unit->tgl_service_terakhir }}"
                                        data-dokumentasi="{{ $unit->dokumentasi }}" @if($unit->tipe_peralatan === 'UPS')
                                            data-jenis="{{ $unit->detailUps->jenis_ups ?? '' }}"
                                            data-kva="{{ $unit->detailUps->kapasitas_kva ?? '' }}"
                                            data-model="{{ $unit->detailUps->model_no_seri ?? '' }}"
                                            data-merk-battery="{{ $unit->detailUps->batt_merk ?? '' }}"
                                            data-jumlah-battery="{{ $unit->detailUps->batt_jumlah ?? '' }}"
                                            data-kapasitas-battery="{{ $unit->detailUps->batt_kapasitas ?? '' }}"
                                        @elseif($unit->tipe_peralatan === 'UKB')
                                            data-panjang="{{ $unit->detailUkb->panjang_kabel_m ?? '' }}"
                                            data-volume="{{ $unit->detailUkb->volume ?? '' }}"
                                            data-jenis="{{ $unit->detailUkb->jenis_ukb ?? '' }}"
                                            data-model="{{ $unit->detailUkb->type ?? '' }}"
                                        @elseif($unit->tipe_peralatan === 'DETEKSI')
                                            data-fitur="{{ $unit->detailDeteksi->fitur ?? '' }}"
                                        data-model="{{ $unit->detailDeteksi->type ?? '' }}" @endif>
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <button class="btn-action edit btn-edit-unit ms-2" data-bs-toggle="modal"
                                        data-bs-target="#editUnit{{ $unit->tipe_peralatan == 'DETEKSI' ? 'Deteksi' : $unit->tipe_peralatan }}Modal"
                                        data-id="{{ $unit->unit_id }}" data-unit="{{ $unit->tipe_peralatan }}" {{-- Penting
                                        untuk JS switch case --}} data-kondisi="{{ $unit->kondisi_kendaraan }}"
                                        data-merk="{{ $unit->merk_kendaraan }}" data-nopol="{{ $unit->nopol }}"
                                        data-lokasi="{{ $unit->lokasi }}" data-status="{{ $unit->status }}"
                                        data-keterangan="{{ $unit->catatan }}"
                                        data-bpkb="{{ $unit->status_bpkb ? 'Ada' : 'Tidak Ada' }}"
                                        data-stnk="{{ $unit->status_stnk ? 'Ada' : 'Tidak Ada' }}"
                                        data-pajak-tahunan="{{ $unit->pajak_tahunan }}"
                                        data-pajak-5tahunan="{{ $unit->pajak_5tahunan }}"
                                        data-kir="{{ $unit->status_kir ? 'Ada' : 'Tidak Ada' }}"
                                        data-masa-berlaku-kir="{{ $unit->masa_berlaku_kir }}"
                                        data-service="{{ $unit->tgl_service_terakhir }}"
                                        data-dokumentasi="{{ $unit->dokumentasi }}" @if($unit->tipe_peralatan === 'UPS')
                                            data-jenis="{{ $unit->detailUps->jenis_ups ?? '' }}"
                                            data-kva="{{ $unit->detailUps->kapasitas_kva ?? '' }}"
                                            data-model="{{ $unit->detailUps->model_no_seri ?? '' }}"
                                            data-merk-battery="{{ $unit->detailUps->batt_merk ?? '' }}"
                                            data-jumlah-battery="{{ $unit->detailUps->batt_jumlah ?? '' }}"
                                            data-kapasitas-battery="{{ $unit->detailUps->batt_kapasitas ?? '' }}"
                                        @elseif($unit->tipe_peralatan === 'UKB')
                                            data-panjang="{{ $unit->detailUkb->panjang_kabel_m ?? '' }}"
                                            data-volume="{{ $unit->detailUkb->volume ?? '' }}"
                                            data-jenis="{{ $unit->detailUkb->jenis_ukb ?? '' }}"
                                            data-model="{{ $unit->detailUkb->type ?? '' }}"
                                        @elseif($unit->tipe_peralatan === 'DETEKSI')
                                            data-fitur="{{ $unit->detailDeteksi->fitur ?? '' }}"
                                        data-model="{{ $unit->detailDeteksi->type ?? '' }}" @endif>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('admin.units.destroy', $unit->unit_id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus unit ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete ms-2"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-box-open fa-2x mb-2"></i><br>
                                    Belum ada data unit yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.unit-archive') }}"
        class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 mt-3">
        <i class="fa-solid fa-box-archive"></i> Arsip Unit
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Select Unit Type Modal -->
    <div class="modal fade" id="selectUnitTypeModal" tabindex="-1" aria-labelledby="selectUnitTypeModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="createUnitUPSModal" tabindex="-1" aria-labelledby="createUnitUPSModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUnitUPSModalLabel">Add Unit UPS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.units.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe_peralatan" value="UPS">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Unit</label>
                                <select class="form-select" name="nama_unit" required>
                                    <option value="UPS" selected>UPS</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Jenis</label>
                                <input type="text" class="form-control" name="jenis_ups" placeholder="Jenis UPS" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">KVA</label>
                                <input type="number" class="form-control" name="kapasitas_kva" placeholder="KVA" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Kondisi</label>
                                <select class="form-select" name="kondisi_kendaraan" required>
                                    <option value="BAIK" selected>Baik</option>
                                    <option value="RUSAK">Rusak</option>
                                    <option value="PERBAIKAN">Perbaikan</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">Merk</label>
                                <input type="text" class="form-control" name="merk_kendaraan" placeholder="Isi Merk"
                                    required>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">Model / No Seri</label>
                                <input type="text" class="form-control" name="model_no_seri"
                                    placeholder="Isi Model/No. Seri" required>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">NOPOL</label>
                                <input type="text" class="form-control" name="nopol" placeholder="XX 0000 XX" required>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Isi Lokasi" required>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Standby" selected>Standby</option>
                                    <option value="Digunakan">Digunakan</option>
                                    <option value="Tidak Siap Oprasi">Tidak Siap Operasi</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="catatan" rows="3" placeholder="Isi Keterangan"
                                    required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Merk Battery</label>
                                <input type="text" class="form-control" name="batt_merk" placeholder="Merk" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah Battery</label>
                                <input type="number" class="form-control" name="batt_jumlah" placeholder="000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" name="batt_kapasitas" placeholder="000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">BPKB</label>
                                <select class="form-select" name="status_bpkb" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">STNK</label>
                                <select class="form-select" name="status_stnk" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pajak Tahunan STNK</label>
                                <input type="date" class="form-control" name="pajak_tahunan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pajak 5 Tahunan STNK</label>
                                <input type="date" class="form-control" name="pajak_5tahunan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">KIR</label>
                                <select class="form-select" name="status_kir" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Masa Berlaku KIR</label>
                                <input type="date" class="form-control" name="masa_berlaku_kir" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Service Mobil Terakhir</label>
                                <input type="date" class="form-control" name="tgl_service_terakhir" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dokumentasi</label>
                                <input type="text" class="form-control" name="dokumentasi"
                                    placeholder="Isi Link Dokumentasi" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create UKB Modal -->
    <div class="modal fade" id="createUnitUKBModal" tabindex="-1" aria-labelledby="createUnitUKBModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUnitUKBModalLabel">Add Unit UKB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.units.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe_peralatan" value="UKB">
                    <input type="hidden" name="kabel" value="-">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Unit</label>
                                <select class="form-select" name="nama_unit" required>
                                    <option value="UKB" selected>UKB</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Kondisi</label>
                                <select class="form-select" name="kondisi_kendaraan" required>
                                    <option value="BAIK" selected>Baik</option>
                                    <option value="RUSAK">Rusak</option>
                                    <option value="PERBAIKAN">Perbaikan</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Merk</label>
                                <input type="text" class="form-control" name="merk_kendaraan" placeholder="Isi Merk"
                                    required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Panjang (m)</label>
                                <input type="text" class="form-control" name="panjang_kabel_m" placeholder="Isi Pj."
                                    required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Volume</label>
                                <input type="text" class="form-control" name="volume" placeholder="Isi Vol." required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Jenis</label>
                                <input type="text" class="form-control" name="jenis_ukb" placeholder="Isi Jenis" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Type / Model / No Seri</label>
                                <input type="text" class="form-control" name="type" placeholder="Isi Type" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">NOPOL</label>
                                <input type="text" class="form-control" name="nopol" placeholder="XX 0000 XX" required>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Isi Lokasi" required>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Standby" selected>Standby</option>
                                    <option value="Digunakan">Sedang digunakan</option>
                                    <option value="Tidak Siap Oprasi">Tidak Siap Operasi</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="catatan" rows="3" placeholder="Isi Keterangan"
                                    required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">BPKB</label>
                                <select class="form-select" name="status_bpkb" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">STNK</label>
                                <select class="form-select" name="status_stnk" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pajak Tahunan STNK</label>
                                <input type="date" class="form-control" name="pajak_tahunan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pajak 5 Tahunan STNK</label>
                                <input type="date" class="form-control" name="pajak_5tahunan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">KIR</label>
                                <select class="form-select" name="status_kir" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Masa Berlaku KIR</label>
                                <input type="date" class="form-control" name="masa_berlaku_kir" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Service Mobil Terakhir</label>
                                <input type="date" class="form-control" name="tgl_service_terakhir" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dokumentasi</label>
                                <input type="text" class="form-control" name="dokumentasi"
                                    placeholder="Isi Link Dokumentasi" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Deteksi Modal -->
    <div class="modal fade" id="createUnitDeteksiModal" tabindex="-1" aria-labelledby="createUnitDeteksiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUnitDeteksiModalLabel">Add Unit Deteksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.units.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe_peralatan" value="DETEKSI">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Unit</label>
                                <select class="form-select" name="nama_unit" required>
                                    <option value="Deteksi" selected>Deteksi</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Kondisi</label>
                                <select class="form-select" name="kondisi_kendaraan" required>
                                    <option value="BAIK" selected>Baik</option>
                                    <option value="RUSAK">Rusak</option>
                                    <option value="PERBAIKAN">Perbaikan</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Merk</label>
                                <input type="text" class="form-control" name="merk_kendaraan" placeholder="Isi Merk"
                                    required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="form-label">Fitur</label>
                                <input type="text" class="form-control" name="fitur" placeholder="Isi Fitur" required>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">Type / Model / No Seri</label>
                                <input type="text" class="form-control" name="type" placeholder="Isi Type" required>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">NOPOL</label>
                                <input type="text" class="form-control" name="nopol" placeholder="XX 0000 XX" required>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Isi Lokasi" required>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Standby" selected>Standby</option>
                                    <option value="Digunakan">Sedang digunakan</option>
                                    <option value="Tidak Siap Oprasi">Tidak Siap Operasi</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="catatan" rows="3" placeholder="Isi Keterangan"
                                    required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">BPKB</label>
                                <select class="form-select" name="status_bpkb" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">STNK</label>
                                <select class="form-select" name="status_stnk" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pajak Tahunan STNK</label>
                                <input type="date" class="form-control" name="pajak_tahunan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pajak 5 Tahunan STNK</label>
                                <input type="date" class="form-control" name="pajak_5tahunan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">KIR</label>
                                <select class="form-select" name="status_kir" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Masa Berlaku KIR</label>
                                <input type="date" class="form-control" name="masa_berlaku_kir" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Service Mobil Terakhir</label>
                                <input type="date" class="form-control" name="tgl_service_terakhir" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dokumentasi</label>
                                <input type="text" class="form-control" name="dokumentasi"
                                    placeholder="Isi Link Dokumentasi" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit UPS Modal -->
    <div class="modal fade" id="editUnitUPSModal" tabindex="-1" aria-labelledby="editUnitUPSModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit UPS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Form Action akan diisi otomatis oleh Javascript --}}
                    <form id="editUnitUPSForm" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        {{-- Hidden input untuk menjaga konsistensi tipe --}}
                        <input type="hidden" name="tipe_peralatan" value="UPS">

                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Jenis</label>
                            {{-- Perhatikan penambahan name="..." --}}
                            <input type="text" class="form-control" id="editUPSJenis" name="jenis_ups">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">KVA</label>
                            <input type="number" class="form-control" id="editUPSKva" name="kapasitas_kva">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Kondisi</label>
                            <select class="form-select" id="editUPSKondisi" name="kondisi_kendaraan">
                                <option value="BAIK">Baik</option>
                                <option value="RUSAK">Rusak</option>
                                <option value="PERBAIKAN">Perbaikan</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Merk</label>
                            <input type="text" class="form-control" id="editUPSMerk" name="merk_kendaraan">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Model / No Seri</label>
                            <input type="text" class="form-control" id="editUPSModel" name="model_no_seri">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">NOPOL</label>
                            <input type="text" class="form-control" id="editUPSNopol" name="nopol">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="editUPSLokasi" name="lokasi">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editUPSStatus" name="status">
                                <option value="Digunakan">Digunakan</option>
                                <option value="Tidak Siap Oprasi">Tidak Siap Operasi</option>
                                <option value="Standby">Standby</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="3" id="editUPSKeterangan" name="catatan"></textarea>
                        </div>

                        {{-- Detail Spesifik UPS --}}
                        <div class="col-md-4">
                            <label class="form-label">Merk Battery</label>
                            <input type="text" class="form-control" id="editUPSMerkBattery" name="batt_merk">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Battery</label>
                            <input type="number" class="form-control" id="editUPSJumlahBattery" name="batt_jumlah">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="editUPSKapasitasBattery" name="batt_kapasitas">
                        </div>

                        {{-- Data Administrasi --}}
                        <div class="col-md-4">
                            <label class="form-label">BPKB</label>
                            <select class="form-select" id="editUPSBpkb" name="status_bpkb">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">STNK</label>
                            <select class="form-select" id="editUPSStnk" name="status_stnk">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pajak Tahunan</label>
                            <input type="date" class="form-control" id="editUPSPajakTahunan" name="pajak_tahunan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pajak 5 Tahunan</label>
                            <input type="date" class="form-control" id="editUPSPajak5Tahunan" name="pajak_5tahunan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">KIR</label>
                            <select class="form-select" id="editUPSKir" name="status_kir">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Masa Berlaku KIR</label>
                            <input type="date" class="form-control" id="editUPSMasaBerlakuKir" name="masa_berlaku_kir">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Service Terakhir</label>
                            <input type="date" class="form-control" id="editUPSService" name="tgl_service_terakhir">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dokumentasi</label>
                            <input type="text" class="form-control" id="editUPSDokumentasi" name="dokumentasi">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUnitUPSForm" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit UKB Modal -->
    <div class="modal fade" id="editUnitUKBModal" tabindex="-1" aria-labelledby="editUnitUKBModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit UKB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUnitUKBForm" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipe_peralatan" value="UKB">

                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Kondisi</label>
                            <select class="form-select" id="editUKBKondisi" name="kondisi_kendaraan">
                                <option value="BAIK">Baik</option>
                                <option value="RUSAK">Rusak</option>
                                <option value="PERBAIKAN">Perbaikan</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Merk</label>
                            <input type="text" class="form-control" id="editUKBMerk" name="merk_kendaraan">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Panjang (m)</label>
                            <input type="text" class="form-control" id="editUKBPanjang" name="panjang_kabel_m">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Volume</label>
                            <input type="text" class="form-control" id="editUKBVolume" name="volume">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="editUKBJenis" name="jenis_ukb">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Type / Model</label>
                            <input type="text" class="form-control" id="editUKBModel" name="type">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">NOPOL</label>
                            <input type="text" class="form-control" id="editUKBNopol" name="nopol">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="editUKBLokasi" name="lokasi">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editUKBStatus" name="status">
                                <option value="Digunakan">Digunakan</option>
                                <option value="Tidak Siap Oprasi">Tidak Siap Operasi</option>
                                <option value="Standby">Standby</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="3" id="editUKBKeterangan" name="catatan"></textarea>
                        </div>

                        {{-- Administrasi --}}
                        <div class="col-md-4">
                            <label class="form-label">BPKB</label>
                            <select class="form-select" id="editUKBBpkb" name="status_bpkb">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">STNK</label>
                            <select class="form-select" id="editUKBStnk" name="status_stnk">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pajak Tahunan</label>
                            <input type="date" class="form-control" id="editUKBPajakTahunan" name="pajak_tahunan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pajak 5 Tahunan</label>
                            <input type="date" class="form-control" id="editUKBPajak5Tahunan" name="pajak_5tahunan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">KIR</label>
                            <select class="form-select" id="editUKBKir" name="status_kir">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Masa Berlaku KIR</label>
                            <input type="date" class="form-control" id="editUKBMasaBerlakuKir" name="masa_berlaku_kir">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Service Terakhir</label>
                            <input type="date" class="form-control" id="editUKBService" name="tgl_service_terakhir">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dokumentasi</label>
                            <input type="text" class="form-control" id="editUKBDokumentasi" name="dokumentasi">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUnitUKBForm" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Deteksi Modal -->
    <div class="modal fade" id="editUnitDeteksiModal" tabindex="-1" aria-labelledby="editUnitDeteksiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit Deteksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUnitDeteksiForm" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipe_peralatan" value="DETEKSI">

                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Kondisi</label>
                            <select class="form-select" id="editDeteksiKondisi" name="kondisi_kendaraan">
                                <option value="BAIK">Baik</option>
                                <option value="RUSAK">Rusak</option>
                                <option value="PERBAIKAN">Perbaikan</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Merk</label>
                            <input type="text" class="form-control" id="editDeteksiMerk" name="merk_kendaraan">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Fitur</label>
                            <input type="text" class="form-control" id="editDeteksiFitur" name="fitur">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Type / Model</label>
                            <input type="text" class="form-control" id="editDeteksiModel" name="type">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">NOPOL</label>
                            <input type="text" class="form-control" id="editDeteksiNopol" name="nopol">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="editDeteksiLokasi" name="lokasi">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editDeteksiStatus" name="status">
                                <option value="Digunakan">Digunakan</option>
                                <option value="Tidak Siap Oprasi">Tidak Siap Operasi</option>
                                <option value="Standby">Standby</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="3" id="editDeteksiKeterangan" name="catatan"></textarea>
                        </div>

                        {{-- Administrasi --}}
                        <div class="col-md-4">
                            <label class="form-label">BPKB</label>
                            <select class="form-select" id="editDeteksiBpkb" name="status_bpkb">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">STNK</label>
                            <select class="form-select" id="editDeteksiStnk" name="status_stnk">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pajak Tahunan</label>
                            <input type="date" class="form-control" id="editDeteksiPajakTahunan" name="pajak_tahunan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pajak 5 Tahunan</label>
                            <input type="date" class="form-control" id="editDeteksiPajak5Tahunan" name="pajak_5tahunan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">KIR</label>
                            <select class="form-select" id="editDeteksiKir" name="status_kir">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Masa Berlaku KIR</label>
                            <input type="date" class="form-control" id="editDeteksiMasaBerlakuKir" name="masa_berlaku_kir">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Service Terakhir</label>
                            <input type="date" class="form-control" id="editDeteksiService" name="tgl_service_terakhir">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dokumentasi</label>
                            <input type="text" class="form-control" id="editDeteksiDokumentasi" name="dokumentasi">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUnitDeteksiForm" class="btn btn-primary">Simpan Perubahan</button>
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
            $(function () {             $('#unitsTable').DataTab                     le({
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
                        const btn = $(this);
                        const type = btn.data('unit'); // UPS, UKB, atau DETEKSI
                        const id = btn.data('id');     // ID dari database

                        // Setup URL Action Form (misal: /admin/units/1)
                        // Pastikan route 'admin.units.update' sudah ada di web.php
                        let url = "{{ route('admin.units.update', ':id') }}";
                        url = url.replace(':id', id);

                        // Helper untuk set value
                        const setVal = (id, val) => $(id).val(val).trigger('change');

                        if (type === 'UPS') {
                            $('#editUnitUPSForm').attr('action', url); // Set Action Form

                            setVal('#editUPSJenis', btn.data('jenis'));
                            setVal('#editUPSKva', btn.data('kva'));
                            setVal('#editUPSKondisi', btn.data('kondisi'));
                            setVal('#editUPSMerk', btn.data('merk'));
                            setVal('#editUPSModel', btn.data('model'));
                            setVal('#editUPSNopol', btn.data('nopol'));
                            setVal('#editUPSLokasi', btn.data('lokasi'));
                            setVal('#editUPSStatus', btn.data('status'));
                            setVal('#editUPSKeterangan', btn.data('keterangan'));
                            setVal('#editUPSMerkBattery', btn.data('merk-battery'));
                            setVal('#editUPSJumlahBattery', btn.data('jumlah-battery'));
                            setVal('#editUPSKapasitasBattery', btn.data('kapasitas-battery'));

                            // Administrasi
                            setVal('#editUPSBpkb', btn.data('bpkb'));
                            setVal('#editUPSStnk', btn.data('stnk'));
                            setVal('#editUPSPajakTahunan', btn.data('pajak-tahunan'));
                            setVal('#editUPSPajak5Tahunan', btn.data('pajak-5tahunan'));
                            setVal('#editUPSKir', btn.data('kir'));
                            setVal('#editUPSMasaBerlakuKir', btn.data('masa-berlaku-kir'));
                            setVal('#editUPSService', btn.data('service'));
                            setVal('#editUPSDokumentasi', btn.data('dokumentasi'));

                        } else if (type === 'UKB') {
                            $('#editUnitUKBForm').attr('action', url);

                            setVal('#editUKBKondisi', btn.data('kondisi'));
                            setVal('#editUKBMerk', btn.data('merk'));
                            setVal('#editUKBPanjang', btn.data('panjang'));
                            setVal('#editUKBVolume', btn.data('volume'));
                            setVal('#editUKBJenis', btn.data('jenis'));
                            setVal('#editUKBModel', btn.data('model'));
                            setVal('#editUKBNopol', btn.data('nopol'));
                            setVal('#editUKBLokasi', btn.data('lokasi'));
                            setVal('#editUKBStatus', btn.data('status'));
                            setVal('#editUKBKeterangan', btn.data('keterangan'));

                            setVal('#editUKBBpkb', btn.data('bpkb'));
                            setVal('#editUKBStnk', btn.data('stnk'));
                            setVal('#editUKBPajakTahunan', btn.data('pajak-tahunan'));
                            setVal('#editUKBPajak5Tahunan', btn.data('pajak-5tahunan'));
                            setVal('#editUKBKir', btn.data('kir'));
                            setVal('#editUKBMasaBerlakuKir', btn.data('masa-berlaku-kir'));
                            setVal('#editUKBService', btn.data('service'));
                            setVal('#editUKBDokumentasi', btn.data('dokumentasi'));

                        } else if (type === 'DETEKSI' || type === 'Deteksi') { // Handle case sensitivity
                            $('#editUnitDeteksiForm').attr('action', url);

                            setVal('#editDeteksiKondisi', btn.data('kondisi'));
                            setVal('#editDeteksiMerk', btn.data('merk'));
                            setVal('#editDeteksiFitur', btn.data('fitur'));
                            setVal('#editDeteksiModel', btn.data('model'));
                            setVal('#editDeteksiNopol', btn.data('nopol'));
                            setVal('#editDeteksiLokasi', btn.data('lokasi'));
                            setVal('#editDeteksiStatus', btn.data('status'));
                            setVal('#editDeteksiKeterangan', btn.data('keterangan'));

                            setVal('#editDeteksiBpkb', btn.data('bpkb'));
                            setVal('#editDeteksiStnk', btn.data('stnk'));
                            setVal('#editDeteksiPajakTahunan', btn.data('pajak-tahunan'));
                            setVal('#editDeteksiPajak5Tahunan', btn.data('pajak-5tahunan'));
                            setVal('#editDeteksiKir', btn.data('kir'));
                            setVal('#editDeteksiMasaBerlakuKir', btn.data('masa-berlaku-kir'));
                            setVal('#editDeteksiService', btn.data('service'));
                            setVal('#editDeteksiDokumentasi', btn.data('dokumentasi'));
                        }
                    });

                    // View Detail -> redirect to page with persisted data
                    $('.btn-view-detail').on('click', function () {
                        const button = $(this);
                        const payload = button.data();
                        try {
                            localStorage.setItem('unitDetailPayload', JSON.stringify(payload));
                        } catch (e) { }
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