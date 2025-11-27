@extends('admin.layout')

@section('title', 'Dashboard Admin - UP2D Pasundan')

@push('styles')
<style>
    .content-header h1 {
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 4px;
    }

    .content-header span {
        color: #64748b;
    }

    .card-analytics {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        display: flex;
        flex-direction: column;
        gap: 10px;
        border: none;
    }

    .card-analytics small {
        color: #64748b;
        font-weight: 500;
    }

    .card-analytics h2 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
    }

    .trend-up {
        color: #028f61;
        font-weight: 600;
    }

    .trend-down {
        color: #dc2626;
        font-weight: 600;
    }

    .card-analytics .icon-badge {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: rgba(11, 38, 77, 0.08);
        color: var(--accent-color);
    }

    .section-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.05);
        border: none;
        height: 100%;
    }

    .section-card h5 {
        font-weight: 600;
        margin-bottom: 20px;
    }

    .filter-group .form-label {
        font-weight: 600;
        color: #0f172a;
    }

    .filter-group .form-control,
    .filter-group .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
    }

    .btn-check-status {
        background: var(--primary-color);
        border: none;
        padding: 11px 24px;
        font-weight: 600;
        border-radius: 12px;
        color: #fff;
    }

    .datatable-card .dataTables_wrapper .dataTables_length,
    .datatable-card .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .datatable-card table.dataTable tbody tr {
        background-color: rgba(11, 133, 215, 0.06);
    }

    .datatable-card table.dataTable tbody tr:nth-of-type(even) {
        background-color: rgba(11, 133, 215, 0.12);
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .status-completed {
        background: #22c55e;
    }

    .status-pending {
        background: #f97316;
    }

    .status-route {
        background: #ef4444;
    }

    .status-unit-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .status-bar {
        height: 8px;
        border-radius: 4px;
        flex: 1;
        margin: 0 12px;
    }

    .status-bar.green {
        background: #22c55e;
    }

    .status-bar.red {
        background: #ef4444;
    }

    .status-bar.yellow {
        background: #f59e0b;
    }

    .admin-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 12px;
        background: #f8fafc;
        margin-bottom: 12px;
    }

    .admin-profile img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
    /* Graphs */
    .graph-card { background:#fff; border-radius:20px; padding:20px; box-shadow:0 16px 35px rgba(15,23,42,.06); border:none; }
    .graph-card { overflow:hidden; }
    .graph-title { font-weight:600; margin-bottom:12px; }
    .bar-chart { display:flex; align-items:flex-end; gap:12px; height:120px; padding:4px 8px 8px; overflow:hidden; }
    .bar-col { display:flex; flex-direction:column; align-items:center; gap:6px; }
    .bar { width:28px; border-radius:8px; background:linear-gradient(180deg, #0c58d0 0%, #78a5ff 100%); will-change: height; }
    .bar.maintenance { background:linear-gradient(180deg, #ef4444 0%, #f9a8a8 100%); }
    .bar.report { background:linear-gradient(180deg, #f59e0b 0%, #fcd34d 100%); }
    .bar-label { font-size:12px; color:#64748b; }
    .bar-value { font-size:12px; font-weight:700; color:#0f172a; }
    /* Tables */
    .loan-table thead th { font-weight:600; border-bottom:1px solid #e2e8f0; }
    .loan-table tbody tr { background:#f8fbff; }
    .loan-table tbody tr:nth-of-type(even) { background:#eef6ff; }
    .badge-soft { font-size:12px; padding:6px 10px; border-radius:999px; font-weight:600; }
    .badge-soft.green { background:#dcfce7; color:#14532d; }
    .badge-soft.yellow { background:#fef9c3; color:#854d0e; }
    .badge-soft.red { background:#fee2e2; color:#7f1d1d; }
    /* Notif toast */
    #notifContainer { position:fixed; top:16px; right:16px; z-index:1050; display:flex; flex-direction:column; gap:10px; }
    .notif-item { background:#fff; border-radius:12px; box-shadow:0 12px 30px rgba(15,23,42,.12); padding:12px 14px; min-width:280px; max-width:340px; display:flex; align-items:flex-start; gap:10px; border:1px solid #e2e8f0; }
    .notif-icon { width:28px; height:28px; border-radius:8px; background:#fee2e2; color:#ef4444; display:flex; align-items:center; justify-content:center; }
    .notif-content { flex:1; }
    .notif-actions { display:flex; align-items:center; gap:8px; }
    .notif-header { background:#fff; border:1px solid #e2e8f0; border-radius:12px; box-shadow:0 12px 30px rgba(15,23,42,.12); padding:8px 10px; display:flex; align-items:center; justify-content:space-between; }
</style>
@endpush

@section('content')
<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <button class="btn btn-outline-dark btn-sm d-lg-none mb-3" id="toggleSidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h1>Dashboard</h1>
        <span>Minggu, 01 Nov 2025 · 12:30 AM</span>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="dropdown me-2">
            <button id="notifBtn" onclick="showNotifPopup()" class="btn btn-light position-relative shadow-none">
                <i class="fa-solid fa-bell fa-lg"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
            </button>
        </div>
        <select class="form-select form-select-sm shadow-none" id="dashboardFilter" onchange="renderDashboardContent()" style="min-width: 125px;">
            <option value="all">Semua</option>
            <option value="UPS">UPS</option>
            <option value="UKB">UKB</option>
            <option value="Deteksi">Deteksi</option>
        </select>
    </div>
</div>
<div id="dashboardContent"></div>

@endsection

@push('scripts')
<script>
function getDummyContent(filter) {
    let cardData = {
        all: [
            { icon:'fa-car', label:'Total Unit', value:126 },
            { icon:'fa-key', label:'Total Lending', value:14 },
            { icon:'fa-wrench', label:'Total Maintenance', value:18 },
        ],
        UPS: [
            { icon:'fa-car', label:'Total Unit UPS', value:40 },
            { icon:'fa-key', label:'Total Lending UPS', value:7 },
            { icon:'fa-wrench', label:'Total Maintenance UPS', value:6 },
            { icon:'fa-box', label:'Total Stand By UPS', value:27 },
        ],
        UKB: [
            { icon:'fa-plug', label:'Total Unit UKB', value:53 },
            { icon:'fa-key', label:'Total Lending UKB', value:4 },
            { icon:'fa-wrench', label:'Total Maintenance UKB', value:5 },
            { icon:'fa-box', label:'Total Stand By UKB', value:44 },
        ],
        Deteksi: [
            { icon:'fa-magnifying-glass', label:'Total Unit Deteksi', value:12 },
            { icon:'fa-key', label:'Total Lending Deteksi', value:3 },
            { icon:'fa-wrench', label:'Total Maintenance Deteksi', value:4 },
            { icon:'fa-box', label:'Total Stand By Deteksi', value:8 },
        ],
    };
    const lendWeekly = {
        all:[2,3,1,4,2,1,1], UPS:[1,2,0,2,1,0,1], UKB:[0,1,0,1,0,1,1], Deteksi:[1,0,1,1,1,0,0]
    };
    const maintWeekly = {
        all:[1,0,2,1,1,3,0], UPS:[1,0,1,0,1,2,0], UKB:[0,0,1,1,0,1,0], Deteksi:[0,0,0,0,0,1,0]
    };
    const reportWeekly = {
        all:[0,1,1,0,2,0,1], UPS:[0,1,0,0,1,0,0], UKB:[0,0,1,0,0,0,1], Deteksi:[0,0,0,0,1,0,0]
    };
    let tabelDummy = {
        UPS:[
            {nama:'Darby Day', nopol:'DK 8113 DE', tgl:'2025-11-20', status:'SEDANG DIPINJAM'},
            {nama:'Helt Diven', nopol:'DK 8005 DE', tgl:'2025-11-22', status:'SELESAI'},
            {nama:'Demo A', nopol:'DK 8009 DE', tgl:'2025-11-25', status:'SEDANG DIPINJAM'},
        ],
        UKB:[
            {nama:'Surya Oki', nopol:'D 8934 FH', tgl:'2025-11-19', status:'SELESAI'},
            {nama:'Rini I', nopol:'D 8935 FH', tgl:'2025-11-23', status:'SEDANG DIPINJAM'},
            {nama:'Permana', nopol:'D 8936 FH', tgl:'2025-11-24', status:'SELESAI'},
        ],
        Deteksi:[
            {nama:'Arif Y', nopol:'B 9193 KCG', tgl:'2025-11-18', status:'SEDANG DIPINJAM'},
            {nama:'Bagus', nopol:'B 9192 KCG', tgl:'2025-11-20', status:'SELESAI'},
        ],
    };
    const statusUnitAll = [
        {label:'Sedang Digunakan', color:'green', value:2},
        {label:'Tidak Siap Operasi', color:'red', value:4},
        {label:'Stand By', color:'yellow', value:12}
    ];
    return {cardData,tabelDummy,lendWeekly,maintWeekly,reportWeekly,statusUnitAll};
}
function renderDashboardContent() {
    let selected = document.getElementById('dashboardFilter').value;
    let {cardData,tabelDummy,lendWeekly,maintWeekly,reportWeekly,statusUnitAll} = getDummyContent(selected);
    let innerHTML = '<div class="row g-3">';
    cardData[selected || 'all'].forEach(card => {
      innerHTML += `<div class="col-xl-3 col-md-6"><div class="card-analytics"><div class="d-flex justify-content-between align-items-start"><small>${card.label}</small><span class="icon-badge"><i class="fa-solid ${card.icon}"></i></span></div><h2>${card.value}</h2></div></div>`;
    });
    innerHTML += '</div>';
    const days = ['M','S','S','R','K','J','S'];
    function buildBars(arr, cls) {
        const max = Math.max(1, ...arr);
        const scale = 100; // max bar height to avoid overflow
        return `<div class='bar-chart'>` + arr.map((v,i)=>`<div class='bar-col'><div class='bar ${cls}' style='height:${(v/max)*scale}px'></div><div class='bar-value'>${v}</div><div class='bar-label'>${days[i]}</div></div>`).join('') + `</div>`;
    }
    const capKey = selected || 'all';
    innerHTML += `<div class='row g-3 mt-1'>
        <div class='col-xl-4 col-md-6'><div class='graph-card'><div class='graph-title'>Lending (7 hari)</div>${buildBars(lendWeekly[capKey],'')}</div></div>
        <div class='col-xl-4 col-md-6'><div class='graph-card'><div class='graph-title'>Maintenance (7 hari)</div>${buildBars(maintWeekly[capKey],'maintenance')}</div></div>
        <div class='col-xl-4 col-md-6'><div class='graph-card'><div class='graph-title'>Pelaporan Anomali (7 hari)</div>${buildBars(reportWeekly[capKey],'report')}</div></div>
    </div>`;

    if(selected !== 'all') {
        let cap = selected;
        let tabRows = (tabelDummy[cap]||[]).map(row=>{
            const badge = row.status === 'SELESAI' ? 'green' : row.status === 'SEDANG DIPINJAM' ? 'yellow' : 'red';
            return `<tr><td>${row.nama}</td><td><span class='badge-soft'>${row.nopol}</span></td><td>${row.tgl}</td><td><span class='badge-soft ${badge}'>${row.status}</span></td></tr>`;
        }).join('');
        innerHTML += `<div class='card mt-4'><div class='card-body'><h6 class='fw-bold mb-3'>Peminjaman ${cap} 7 Hari Terakhir</h6><div class='table-responsive'><table class='table table-borderless align-middle loan-table'><thead><tr><th>Nama</th><th>Nopol</th><th>Tanggal Pinjam</th><th>Status</th></tr></thead><tbody>${tabRows}</tbody></table></div></div></div>`;
    } else {
        // no status unit for non-default filters
    }
    document.getElementById('dashboardContent').innerHTML = innerHTML;
}
// Render immediately and hide static content row
renderDashboardContent();
const staticRow = document.querySelector('.row.g-3.mt-1');
if (staticRow) staticRow.classList.add('d-none');

document.getElementById('dashboardFilter').addEventListener('change', renderDashboardContent);
function showNotifPopup() {
    const notifs = [
        {id:'n1',unit:'UPS1 - DK 8001 AB', due:'27/12/2025', label:'Pajak habis 1 bulan lagi'},
        {id:'n2',unit:'UKB2 - D 8012 ZZ', due:'15/12/2025', label:'Pajak habis dalam 3 minggu'},
        {id:'n3',unit:'Deteksi 1 - B 1234 XY', due:'09/12/2025', label:'Pajak habis > 10 hari'},
    ];
    let container = document.getElementById('notifContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notifContainer';
        document.body.appendChild(container);
    }
    container.innerHTML = `<div class='notif-header'><div class='fw-bold small'>Notifikasi Pajak Jatuh Tempo</div><button class='btn btn-sm btn-outline-secondary' onclick="document.getElementById('notifContainer').remove()"><i class='fa-solid fa-xmark'></i></button></div>`;
    notifs.forEach(n=>{
        const item = document.createElement('div');
        item.className = 'notif-item';
        item.id = 'notif_'+n.id;
        item.innerHTML = `<div class='notif-icon'><i class='fa-solid fa-bell'></i></div>
            <div class='notif-content'><div class='fw-bold small'>${n.unit}</div>
            <div class='text-danger small mb-1'><i class='fa-solid fa-circle-exclamation me-1'></i>${n.label}</div>
            <div class='text-muted small'>Jatuh Tempo: ${n.due}</div></div>
            <div class='notif-actions'><button class='btn btn-sm btn-outline-danger' onclick="document.getElementById('notif_'+n.id).remove()"><i class='fa-solid fa-trash'></i></button></div>`;
        container.appendChild(item);
    });
}
</script>
@endpush
