@extends('admin.layout')

@section('title', 'Arsip Unit - UP2D Pasundan')

@push('styles')
<style>
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
        <h1 class="mb-1">Arsip Unit</h1>
        <span class="text-muted">Unit yang telah dihapus dari daftar aktif</span>
    </div>
    <a href="{{ route('admin.units') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Units
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="unitArchiveTable" class="table table-borderless align-middle">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Kondisi</th>
                        <th>Merk</th>
                        <th>NOPOL</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Diarsipkan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archivedUnits as $unit)
                        <tr>
                            <td>{{ $unit->nama_unit }}</td>

                            <td>
                                @php
                                    $badgeClass = match($unit->kondisi_kendaraan) {
                                        'BAIK' => 'green',
                                        'RUSAK', 'PERBAIKAN' => 'red',
                                        default => 'yellow'
                                    };
                                @endphp
                                <span class="badge-status {{ $badgeClass }}">{{ $unit->kondisi_kendaraan }}</span>
                            </td>

                            <td>{{ $unit->merk_kendaraan ?? '-' }}</td>
                            <td>{{ $unit->nopol }}</td>
                            <td>{{ $unit->lokasi }}</td>

                            <td>
                                @php
                                    $statusClass = match($unit->status) {
                                        'Digunakan' => 'green',
                                        'Tidak Siap Oprasi' => 'red',
                                        'Standby' => 'yellow',
                                        default => 'yellow'
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">{{ $unit->status }}</span>
                            </td>

                            <td>{{ Str::limit($unit->catatan, 30) }}</td>
                            <td>{{ optional($unit->archived_at)->format('d/m/Y H:i') ?? '-' }}</td>

                            <td class="text-center">
                                <button class="btn-action info btn-view-archive"
                                    title="Lihat Detail Arsip"
                                    data-unit="{{ $unit->nama_unit }}"
                                    data-tipe="{{ $unit->tipe_peralatan }}"
                                    data-kondisi="{{ $unit->kondisi_kendaraan }}"
                                    data-merk="{{ $unit->merk_kendaraan }}"
                                    data-nopol="{{ $unit->nopol }}"
                                    data-lokasi="{{ $unit->lokasi }}"
                                    data-status="{{ $unit->status }}"
                                    data-keterangan="{{ $unit->catatan }}"
                                    data-bpkb="{{ $unit->status_bpkb ? 'Ada' : 'Tidak Ada' }}"
                                    data-stnk="{{ $unit->status_stnk ? 'Ada' : 'Tidak Ada' }}"
                                    data-pajak-tahunan="{{ $unit->pajak_tahunan }}"
                                    data-pajak-5tahunan="{{ $unit->pajak_5tahunan }}"
                                    data-kir="{{ $unit->status_kir ? 'Ada' : 'Tidak Ada' }}"
                                    data-masa-berlaku-kir="{{ $unit->masa_berlaku_kir }}"
                                    data-service="{{ $unit->tgl_service_terakhir }}"
                                    data-dokumentasi="{{ $unit->dokumentasi }}"
                                >
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-box-open fa-2x mb-2"></i><br>
                                Belum ada unit di arsip.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<!-- Detail Arsip Modal -->
<div class="modal fade" id="archiveDetailModal" tabindex="-1" aria-labelledby="archiveDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Arsip Unit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Unit</label>
                        <input type="text" class="form-control" id="archiveNama" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipe Peralatan</label>
                        <input type="text" class="form-control" id="archiveTipe" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kondisi</label>
                        <input type="text" class="form-control" id="archiveKondisi" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" id="archiveStatus" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="archiveMerk" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NOPOL</label>
                        <input type="text" class="form-control" id="archiveNopol" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="archiveLokasi" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" id="archiveKeterangan" readonly></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">BPKB</label>
                        <input type="text" class="form-control" id="archiveBPKB" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">STNK</label>
                        <input type="text" class="form-control" id="archiveSTNK" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KIR</label>
                        <input type="text" class="form-control" id="archiveKIR" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak Tahunan</label>
                        <input type="text" class="form-control" id="archivePajakTahunan" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak 5 Tahunan</label>
                        <input type="text" class="form-control" id="archivePajak5Tahunan" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="text" class="form-control" id="archiveMasaBerlakuKir" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Service Terakhir</label>
                        <input type="text" class="form-control" id="archiveService" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dokumentasi</label>
                        <input type="text" class="form-control" id="archiveDokumentasi" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#unitArchiveTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: { previous: "Previous", next: "Next" }
            }
        });

        $(document).on('click', '.btn-view-archive', function () {
            const b = $(this);
            $('#archiveNama').val(b.data('unit'));
            $('#archiveTipe').val(b.data('tipe'));
            $('#archiveKondisi').val(b.data('kondisi'));
            $('#archiveStatus').val(b.data('status'));
            $('#archiveMerk').val(b.data('merk'));
            $('#archiveNopol').val(b.data('nopol'));
            $('#archiveLokasi').val(b.data('lokasi'));
            $('#archiveKeterangan').val(b.data('keterangan'));
            $('#archiveBPKB').val(b.data('bpkb'));
            $('#archiveSTNK').val(b.data('stnk'));
            $('#archiveKIR').val(b.data('kir'));
            $('#archivePajakTahunan').val(b.data('pajak-tahunan'));
            $('#archivePajak5Tahunan').val(b.data('pajak-5tahunan'));
            $('#archiveMasaBerlakuKir').val(b.data('masa-berlaku-kir'));
            $('#archiveService').val(b.data('service'));
            $('#archiveDokumentasi').val(b.data('dokumentasi'));
            $('#archiveDetailModal').modal('show');
        });
    });
</script>
@endpush