@extends('admin.layout')

@section('title', 'Peminjaman - UP2D Pasundan')

@push('styles')
    <style>
        :root {
            --primary-dark: #0f172a;
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

        .badge-ups {
            background-color: #3b82f6;
            color: #fff;
        }

        .badge-ukb {
            background-color: #10b981;
            color: #fff;
        }

        .badge-deteksi {
            background-color: #f59e0b;
            color: #fff;
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

        /* Page Header Sticky */
        .page-header-sticky {
            position: sticky;
            top: 0;
            background: var(--bg-soft, #f5f8ff);
            z-index: 100;
            padding-bottom: 16px;
        }

        /* Scrollable Content Wrapper - X and Y */
        .scrollable-content-wrapper {
            max-height: calc(100vh - 190px);
            max-width: calc(100vw - 305px);
            overflow-y: auto;
            overflow-x: auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
        }

        /* Mobile responsive - when sidebar is hidden */
        @media (max-width: 991.98px) {
            .scrollable-content-wrapper {
                max-width: 100%;
                max-height: calc(100vh - 200px);
                overflow-x: auto;
                overflow-y: auto;
            }

            .scrollable-content-wrapper > .card {
                min-width: 800px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header-sticky d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-outline-dark btn-sm d-lg-none" id="toggleSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="mb-1">Peminjaman Unit</h1>
            <span class="text-muted">Daftar permintaan dan riwayat peminjaman unit</span>
        </div>
    </div>

    <div class="scrollable-content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="peminjamanTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Peralatan</th>
                            <th>Kapasitas / Panjang / Fitur</th>
                            <th>Tgl Mobilisasi/Install</th>
                            <th>Event</th>
                            <th>Tgl Demob/Uninstall</th>
                            <th>Nopol</th>
                            <th>Kegiatan</th>
                            <th>Tamu VIP/VVIP</th>
                            <th>Lokasi</th>
                            <th>Posko Pelaksana</th>
                            <th>UP3</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $item)
                            @php
                                $tipePeralatan = $item->unit->tipe_peralatan ?? '-';

                                // Determine kapasitas/panjang/fitur based on equipment type
                                if ($tipePeralatan === 'UPS') {
                                    $kapasitasPanjangFitur = $item->unit->detailUps->kapasitas_kva ?? '-';
                                    if ($kapasitasPanjangFitur !== '-')
                                        $kapasitasPanjangFitur .= ' KVA';
                                } elseif ($tipePeralatan === 'UKB') {
                                    $kapasitasPanjangFitur = $item->unit->detailUkb->panjang_kabel_m ?? '-';
                                    if ($kapasitasPanjangFitur !== '-')
                                        $kapasitasPanjangFitur .= ' m';
                                } elseif ($tipePeralatan === 'Deteksi' || $tipePeralatan === 'DETEKSI') {
                                    $kapasitasPanjangFitur = $item->unit->detailDeteksi->fitur ?? '-';
                                } else {
                                    $kapasitasPanjangFitur = '-';
                                }

                                // Format dates
                                $tglMobilisasi = $item->tgl_mobilisasi
                                    ? \Carbon\Carbon::parse($item->tgl_mobilisasi)->format('d M Y')
                                    : '-';
                                $tglDemobilisasi = $item->tgl_demobilisasi
                                    ? \Carbon\Carbon::parse($item->tgl_demobilisasi)->format('d M Y')
                                    : '-';

                                // Event period
                                $eventMulai = $item->tgl_event_mulai
                                    ? \Carbon\Carbon::parse($item->tgl_event_mulai)->format('d M Y')
                                    : '-';
                                $eventSelesai = $item->tgl_event_selesai
                                    ? \Carbon\Carbon::parse($item->tgl_event_selesai)->format('d M Y')
                                    : '-';
                                $eventPeriod = ($eventMulai !== '-' || $eventSelesai !== '-')
                                    ? $eventMulai . ' – ' . $eventSelesai
                                    : '-';

                                // Badge class based on type
                                $badgeClass = match ($tipePeralatan) {
                                    'UPS' => 'badge-ups',
                                    'UKB' => 'badge-ukb',
                                    'Deteksi', 'DETEKSI' => 'badge-deteksi',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <tr>
                                <td>{{ $item->userPemohon->name ?? '-' }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ $tipePeralatan }}</span></td>
                                <td>{{ $kapasitasPanjangFitur }}</td>
                                <td>{{ $tglMobilisasi }}</td>
                                <td>{{ $eventPeriod }}</td>
                                <td>{{ $tglDemobilisasi }}</td>
                                <td>{{ $item->unit->nopol ?? '-' }}</td>
                                <td>{{ $item->kegiatan ?? '-' }}</td>
                                <td>{{ $item->Tamu_VIP ?? '-' }}</td>
                                <td>{{ $item->lokasi_tujuan ?? '-' }}</td>
                                <td>{{ $item->unit->lokasi ?? '-' }}</td>
                                <td>{{ $item->up3_id ?? '-' }}</td>
                                <td>
                                    @php
                                        $statusBadge = match ($item->status_peminjaman) {
                                            'Sedang Digunakan' => 'bg-primary',
                                            'Selesai' => 'bg-success',
                                            'Cancel' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">{{ $item->status_peminjaman ?? '-' }}</span>
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn-action edit btn-edit-loan" data-bs-toggle="modal"
                                        data-bs-target="#editLoanModal" data-id="{{ $item->peminjaman_id }}"
                                        data-nama="{{ $item->userPemohon->name ?? '' }}" data-peralatan="{{ $tipePeralatan }}"
                                        data-nopol="{{ $item->unit->nopol ?? '' }}" data-kegiatan="{{ $item->kegiatan ?? '' }}"
                                        data-lokasi="{{ $item->lokasi_tujuan ?? '' }}"
                                        data-tgl-mobilisasi="{{ $item->tgl_mobilisasi ? \Carbon\Carbon::parse($item->tgl_mobilisasi)->format('Y-m-d') : '' }}"
                                        data-tgl-demobilisasi="{{ $item->tgl_demobilisasi ? \Carbon\Carbon::parse($item->tgl_demobilisasi)->format('Y-m-d') : '' }}"
                                        data-event-mulai="{{ $item->tgl_event_mulai ? \Carbon\Carbon::parse($item->tgl_event_mulai)->format('Y-m-d') : '' }}"
                                        data-event-selesai="{{ $item->tgl_event_selesai ? \Carbon\Carbon::parse($item->tgl_event_selesai)->format('Y-m-d') : '' }}"
                                        data-tamu-vip="{{ $item->Tamu_VIP ?? '' }}" data-up3="{{ $item->up3_id ?? '' }}"
                                        data-status="{{ $item->status_peminjaman ?? '' }}"
                                        data-keterangan="{{ $item->keterangan ?? '' }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-action delete ms-2" data-id="{{ $item->peminjaman_id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editLoanModal" tabindex="-1" aria-labelledby="editLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLoanModalLabel">Edit Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editLoanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Informasi Peminjam -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-user me-2"></i>Informasi Peminjam
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" id="loanNama" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Peralatan</label>
                                <input type="text" class="form-control" id="loanPeralatan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nopol</label>
                                <input type="text" class="form-control" id="loanNopol" readonly>
                            </div>

                            <!-- Informasi Penggunaan -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-location-dot me-2"></i>Informasi
                                    Penggunaan</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi_tujuan" id="loanLokasi">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kegiatan</label>
                                <textarea class="form-control" rows="3" name="kegiatan" id="loanKegiatan"></textarea>
                            </div>

                            <!-- Jadwal & Pelaksana -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-calendar-days me-2"></i>Jadwal &
                                    Pelaksana</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mobilisasi</label>
                                <input type="date" class="form-control" name="tgl_mobilisasi" id="loanTglMobilisasi">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Demobilisasi</label>
                                <input type="date" class="form-control" name="tgl_demobilisasi" id="loanTglDemobilisasi">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Event Mulai</label>
                                <input type="date" class="form-control" name="tgl_event_mulai" id="loanEventMulai">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Event Selesai</label>
                                <input type="date" class="form-control" name="tgl_event_selesai" id="loanEventSelesai">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tamu VIP/VVIP</label>
                                <input type="text" class="form-control" name="Tamu_VIP" id="loanTamuVip">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">UP3</label>
                                <input type="text" class="form-control" name="up3_id" id="loanUp3">
                            </div>

                            <!-- Status -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-circle-info me-2"></i>Status &
                                    Keterangan</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status_peminjaman" id="loanStatus">
                                    <option value="Sedang Digunakan">Sedang Digunakan</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" rows="3" name="keterangan" id="loanKeterangan"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data peminjaman ini?</p>
                    <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            // Initialize single DataTable
            $('#peminjamanTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                scrollX: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            // Edit button handler
            $(document).on('click', '.btn-edit-loan', function () {
                const button = $(this);
                const id = button.data('id');

                // Set form action URL
                $('#editLoanForm').attr('action', '/admin/peminjaman/' + id);

                // Populate form fields
                $('#loanNama').val(button.data('nama'));
                $('#loanPeralatan').val(button.data('peralatan'));
                $('#loanNopol').val(button.data('nopol'));
                $('#loanLokasi').val(button.data('lokasi'));
                $('#loanKegiatan').val(button.data('kegiatan'));
                $('#loanTglMobilisasi').val(button.data('tgl-mobilisasi'));
                $('#loanTglDemobilisasi').val(button.data('tgl-demobilisasi'));
                $('#loanEventMulai').val(button.data('event-mulai'));
                $('#loanEventSelesai').val(button.data('event-selesai'));
                $('#loanTamuVip').val(button.data('tamu-vip'));
                $('#loanUp3').val(button.data('up3'));
                $('#loanStatus').val(button.data('status'));
                $('#loanKeterangan').val(button.data('keterangan'));
            });

            // Delete button handler
            $(document).on('click', '.btn-action.delete', function () {
                const id = $(this).data('id');
                // Set form action URL for delete
                $('#deleteForm').attr('action', '/admin/peminjaman/' + id);
                // Show confirmation modal
                $('#deleteConfirmModal').modal('show');
            });
        });
    </script>
@endpush