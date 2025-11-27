@extends('admin.layout')

@section('title', 'Detail Unit - UP2D Pasundan')

@push('styles')
<style>
  .page-header h1 { font-weight: 700; }
  .detail-card { background:#fff; border-radius:20px; padding:24px; box-shadow:0 16px 40px rgba(15,23,42,.08); }
  .detail-row label { font-weight:600; color:#0f172a; }
  .detail-value { background:#eef6ff; padding:10px 14px; border-radius:12px; font-weight:600; color:#0f172a; }
  .history-table thead th { font-weight:600; }
  .back-btn { border-radius:12px; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center page-header mb-4">
  <div>
    <button class="btn btn-outline-dark back-btn" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button>
    <h1 class="d-inline-block ms-3">Detail Unit</h1>
  </div>
</div>

<div class="detail-card mb-4">
  <div id="unitDetailRender" class="row g-3 detail-row"></div>
</div>

<div class="detail-card">
  <h5 class="mb-3">History Peminjaman</h5>
  <div class="table-responsive">
    <table class="table table-borderless align-middle history-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Selesai</th>
          <th>Posko</th>
          <th>UP3</th>
        </tr>
      </thead>
      <tbody id="historyBody"></tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
function renderDetail() {
  let payload = {};
  try { payload = JSON.parse(localStorage.getItem('unitDetailPayload')||'{}'); } catch(e) {}
  const type = payload.unitType || payload.unit_type || payload['unit-type'] || '';
  let sections = [];
  if (type === 'UPS') {
    sections = [
      ['Unit', payload.unit], ['Jenis', payload.jenis], ['KVA', payload.kva], ['Kondisi', payload.kondisi],
      ['Merk', payload.merk], ['Model/No Seri', payload.model], ['NOPOL', payload.nopol], ['Lokasi', payload.lokasi],
      ['Status', payload.status], ['Keterangan', payload.keterangan], ['Merk Battery', payload['merk-battery']],
      ['Jumlah Battery', payload['jumlah-battery']], ['Kapasitas', payload['kapasitas-battery']],
      ['BPKB', payload.bpkb], ['STNK', payload.stnk], ['Pajak Tahunan STNK', payload['pajak-tahunan']],
      ['Pajak 5 Tahunan STNK', payload['pajak-5tahunan']], ['KIR', payload.kir], ['Masa Berlaku KIR', payload['masa-berlaku-kir']],
      ['Service Mobil Terakhir', payload.service], ['Dokumentasi', payload.dokumentasi]
    ];
  } else if (type === 'UKB') {
    sections = [
      ['Unit', payload.unit], ['Kondisi', payload.kondisi], ['Merk', payload.merk], ['Panjang', payload.panjang],
      ['Volume', payload.volume], ['Jenis', payload.jenis], ['Type/Model/No Seri', payload.model], ['NOPOL', payload.nopol],
      ['Lokasi', payload.lokasi], ['Status', payload.status], ['Keterangan', payload.keterangan], ['BPKB', payload.bpkb],
      ['STNK', payload.stnk], ['Pajak Tahunan STNK', payload['pajak-tahunan']], ['Pajak 5 Tahunan STNK', payload['pajak-5tahunan']],
      ['KIR', payload.kir], ['Masa Berlaku KIR', payload['masa-berlaku-kir']], ['Service Mobil Terakhir', payload.service],
      ['Dokumentasi', payload.dokumentasi]
    ];
  } else if (type === 'Deteksi') {
    sections = [
      ['Unit', payload.unit], ['Kondisi', payload.kondisi], ['Merk', payload.merk], ['Fitur', payload.fitur],
      ['Type/Model/No Seri', payload.model], ['NOPOL', payload.nopol], ['Lokasi', payload.lokasi], ['Status', payload.status],
      ['Keterangan', payload.keterangan], ['BPKB', payload.bpkb], ['STNK', payload.stnk], ['Pajak Tahunan STNK', payload['pajak-tahunan']],
      ['Pajak 5 Tahunan STNK', payload['pajak-5tahunan']], ['KIR', payload.kir], ['Masa Berlaku KIR', payload['masa-berlaku-kir']],
      ['Service Mobil Terakhir', payload.service], ['Dokumentasi', payload.dokumentasi]
    ];
  }
  const container = document.getElementById('unitDetailRender');
  container.innerHTML = sections.filter(s=>s[1]!==undefined && s[1]!==null && s[1]!=='').map(([label,value])=>
    `<div class='col-md-6'><label class='form-label'>${label}</label><div class='detail-value'>${value}</div></div>`
  ).join('');

  const hs = [
    {nama:'Darby Day', pinjam:'2025-11-20', selesai:'2025-11-22', posko:'Disjaya', up3:'BDG'},
    {nama:'Helt Diven', pinjam:'2025-11-18', selesai:'2025-11-19', posko:'Bandung Raya', up3:'BDG'},
    {nama:'Raihan', pinjam:'2025-11-15', selesai:'2025-11-16', posko:'Bogor Raya', up3:'BGR'}
  ];
  document.getElementById('historyBody').innerHTML = hs.map(h=>
    `<tr><td>${h.nama}</td><td>${h.pinjam}</td><td>${h.selesai}</td><td>${h.posko}</td><td>${h.up3}</td></tr>`
  ).join('');
}
document.addEventListener('DOMContentLoaded', renderDetail);
</script>
@endpush
