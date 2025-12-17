@extends('admin.layout')

@section('title', 'Detail Unit - UP2D Pasundan')

@push('styles')
<style>
  .page-header h1 { font-weight: 700; }
  .detail-card { background:#fff; border-radius:20px; padding:24px; box-shadow:0 16px 40px rgba(15,23,42,.08); }
  .detail-row label { font-weight:600; color:#64748b; font-size: 0.9rem; margin-bottom: 0.25rem; display: block; }
  .detail-value { background:#f8fafc; padding:12px 16px; border-radius:12px; font-weight:600; color:#0f172a; border: 1px solid #e2e8f0; }
  .history-table thead th { font-weight:600; background-color: #f1f5f9; }
  .back-btn { border-radius:12px; }
  
  /* Helper untuk status badge di detail */
  .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
  .bg-green { background-color: #dcfce7; color: #166534; }
  .bg-red { background-color: #fee2e2; color: #991b1b; }
  .bg-yellow { background-color: #fef9c3; color: #854d0e; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center page-header mb-4">
  <div>
    <a href="{{ route('admin.units') }}" class="btn btn-outline-dark back-btn"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <h1 class="d-inline-block ms-3 align-middle">Detail Unit: {{ $unit->nama_unit }}</h1>
  </div>
  <div>
      @php
        $statusClass = match($unit->status) {
            'Digunakan' => 'bg-green',
            'Tidak Siap Oprasi' => 'bg-red',
            default => 'bg-yellow'
        };
      @endphp
      <span class="badge-status {{ $statusClass }}">{{ $unit->status }}</span>
  </div>
</div>

<div class="detail-card mb-4">
  <div class="row g-4">
    {{-- === DATA UMUM (Semua Tipe Punya) === --}}
    <div class="col-md-6 col-lg-3">
        <label>Tipe Peralatan</label>
        <div class="detail-value">{{ $unit->tipe_peralatan }}</div>
    </div>
    <div class="col-md-6 col-lg-3">
        <label>Kondisi Kendaraan</label>
        <div class="detail-value">{{ $unit->kondisi_kendaraan }}</div>
    </div>
    <div class="col-md-6 col-lg-3">
        <label>Merk Kendaraan</label>
        <div class="detail-value">{{ $unit->merk_kendaraan ?? '-' }}</div>
    </div>
    <div class="col-md-6 col-lg-3">
        <label>No. Polisi</label>
        <div class="detail-value">{{ $unit->nopol }}</div>
    </div>
    <div class="col-md-6 col-lg-6">
        <label>Lokasi Saat Ini</label>
        <div class="detail-value">{{ $unit->lokasi }}</div>
    </div>
    <div class="col-md-6 col-lg-6">
        <label>Keterangan / Catatan</label>
        <div class="detail-value">{{ $unit->catatan ?? '-' }}</div>
    </div>

    <div class="col-12"><hr></div>

    {{-- === DATA SPESIFIK BERDASARKAN TIPE === --}}
    
    {{-- 1. JIKA UPS --}}
    @if($unit->tipe_peralatan === 'UPS' && $unit->detailUps)
        <div class="col-12"><h5 class="fw-bold text-primary">Spesifikasi UPS</h5></div>
        <div class="col-md-4">
            <label>Jenis UPS</label>
            <div class="detail-value">{{ $unit->detailUps->jenis_ups }}</div>
        </div>
        <div class="col-md-4">
            <label>Kapasitas (KVA)</label>
            <div class="detail-value">{{ $unit->detailUps->kapasitas_kva }} KVA</div>
        </div>
        <div class="col-md-4">
            <label>Model / No Seri</label>
            <div class="detail-value">{{ $unit->detailUps->model_no_seri }}</div>
        </div>
        <div class="col-md-4">
            <label>Merk Baterai</label>
            <div class="detail-value">{{ $unit->detailUps->batt_merk }}</div>
        </div>
        <div class="col-md-4">
            <label>Jumlah Baterai</label>
            <div class="detail-value">{{ $unit->detailUps->batt_jumlah }}</div>
        </div>
        <div class="col-md-4">
            <label>Kapasitas Baterai</label>
            <div class="detail-value">{{ $unit->detailUps->batt_kapasitas }} AH</div>
        </div>
    
    {{-- 2. JIKA UKB --}}
    @elseif($unit->tipe_peralatan === 'UKB' && $unit->detailUkb)
        <div class="col-12"><h5 class="fw-bold text-primary">Spesifikasi UKB</h5></div>
        <div class="col-md-4">
            <label>Jenis UKB</label>
            <div class="detail-value">{{ $unit->detailUkb->jenis_ukb }}</div>
        </div>
        <div class="col-md-4">
            <label>Tipe / Model</label>
            <div class="detail-value">{{ $unit->detailUkb->type }}</div>
        </div>
        <div class="col-md-4">
            <label>Panjang Kabel</label>
            <div class="detail-value">{{ $unit->detailUkb->panjang_kabel_m }} Meter</div>
        </div>
        <div class="col-md-4">
            <label>Volume</label>
            <div class="detail-value">{{ $unit->detailUkb->volume }}</div>
        </div>

    {{-- 3. JIKA DETEKSI --}}
    @elseif($unit->tipe_peralatan === 'DETEKSI' && $unit->detailDeteksi)
        <div class="col-12"><h5 class="fw-bold text-primary">Spesifikasi Deteksi</h5></div>
        <div class="col-md-6">
            <label>Tipe / Model</label>
            <div class="detail-value">{{ $unit->detailDeteksi->type }}</div>
        </div>
        <div class="col-md-6">
            <label>Fitur</label>
            <div class="detail-value">{{ $unit->detailDeteksi->fitur }}</div>
        </div>
    @endif

    <div class="col-12"><hr></div>

    {{-- === DATA ADMINISTRASI (STNK, KIR, DLL) === --}}
    <div class="col-12"><h5 class="fw-bold text-secondary">Data Administrasi</h5></div>
    
    <div class="col-md-3">
        <label>BPKB</label>
        <div class="detail-value">{{ $unit->status_bpkb ? 'Ada' : 'Tidak Ada' }}</div>
    </div>
    <div class="col-md-3">
        <label>STNK</label>
        <div class="detail-value">{{ $unit->status_stnk ? 'Ada' : 'Tidak Ada' }}</div>
    </div>
    <div class="col-md-3">
        <label>Pajak Tahunan</label>
        <div class="detail-value">{{ $unit->pajak_tahunan ? \Carbon\Carbon::parse($unit->pajak_tahunan)->format('d M Y') : '-' }}</div>
    </div>
    <div class="col-md-3">
        <label>Pajak 5 Tahunan</label>
        <div class="detail-value">{{ $unit->pajak_5tahunan ? \Carbon\Carbon::parse($unit->pajak_5tahunan)->format('d M Y') : '-' }}</div>
    </div>
    <div class="col-md-3">
        <label>Status KIR</label>
        <div class="detail-value">{{ $unit->status_kir ? 'Ada' : 'Tidak Ada' }}</div>
    </div>
    <div class="col-md-3">
        <label>Masa Berlaku KIR</label>
        <div class="detail-value">{{ $unit->masa_berlaku_kir ? \Carbon\Carbon::parse($unit->masa_berlaku_kir)->format('d M Y') : '-' }}</div>
    </div>
    <div class="col-md-3">
        <label>Service Terakhir</label>
        <div class="detail-value">{{ $unit->tgl_service_terakhir ? \Carbon\Carbon::parse($unit->tgl_service_terakhir)->format('d M Y') : '-' }}</div>
    </div>
    <div class="col-md-12">
        <label>Dokumentasi (Link)</label>
        <div class="detail-value">
            @if($unit->dokumentasi)
                <a href="{{ $unit->dokumentasi }}" target="_blank" class="text-decoration-none">
                    <i class="fa-solid fa-link"></i> Buka Link Dokumentasi
                </a>
            @else
                -
            @endif
        </div>
    </div>
  </div>
</div>

<!-- <div class="detail-card">
  <h5 class="mb-3 fw-bold">History Peminjaman</h5>
  <div class="table-responsive">
    <table class="table table-borderless align-middle history-table">
      <thead>
        <tr>
          <th>Peminjam</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Selesai</th>
          <th>Posko</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
          @forelse($unit->peminjaman as $history)
            <tr>
                {{-- Sesuaikan nama kolom ini dengan tabel 'peminjaman' database Anda --}}
                <td>{{ $history->nama_peminjam ?? 'User' }}</td>
                <td>{{ \Carbon\Carbon::parse($history->tgl_pinjam)->format('d M Y') }}</td>
                <td>
                    {{ $history->tgl_selesai ? \Carbon\Carbon::parse($history->tgl_selesai)->format('d M Y') : 'Masih Dipinjam' }}
                </td>
                <td>{{ $history->posko ?? '-' }}</td>
                <td>{{ $history->keterangan ?? '-' }}</td>
            </tr>
          @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    Belum ada riwayat peminjaman untuk unit ini.
                </td>
            </tr>
          @endforelse
      </tbody>
    </table>
  </div>
</div> -->

{{-- Section Riwayat Aktivitas Unit --}}
<div class="detail-card mt-4">
  <h5 class="mb-3 fw-bold">Riwayat Aktivitas Unit</h5>
  <div class="table-responsive">
    <table class="table table-borderless align-middle history-table">
      <thead>
        <tr>
          <th style="width: 160px;">Tanggal & Waktu</th>
          <th style="width: 120px;">Kategori</th>
          <th>Keterangan</th>
          <th style="width: 150px;">User</th>
        </tr>
      </thead>
      <tbody>
          @forelse($unit->unitLogs as $log)
            <tr>
                <td>{{ \Carbon\Carbon::parse($log->date_time)->format('d M Y, H:i') }}</td>
                <td>
                    @php
                        $badgeClass = match($log->kategori_histori) {
                            'Status' => 'bg-primary',
                            'Servis' => 'bg-info text-dark',
                            'Peminjaman' => 'bg-success',
                            'Pajak' => 'bg-warning text-dark',
                            'Mutasi' => 'bg-secondary',
                            'Anomali' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $log->kategori_histori }}</span>
                </td>
                <td>{{ $log->keterangan }}</td>
                <td>{{ $log->user->name ?? '-' }}</td>
            </tr>
          @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-3">
                    Belum ada riwayat aktivitas untuk unit ini.
                </td>
            </tr>
          @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection