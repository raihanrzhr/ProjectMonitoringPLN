@extends('layout')

@section('title', 'Pengisian Form - UP2D Pasundan')
@section('bodyClass', 'bg-gray-50')

@section('content')
<section class="relative min-h-[480px] md:min-h-[540px] flex items-center justify-center bg-cover bg-center"
    style="background-image: url('{{ asset('assets/image/Foto Hero .png') }}');">
    <div class="absolute inset-0 bg-[#002837] bg-opacity-50"></div>
    <div class="relative z-10 w-full">
        <div class="container mx-auto flex flex-col items-center justify-center text-center h-full px-4 py-16">
            <nav class="mb-6 flex items-center justify-center space-x-2 text-white text-sm font-medium">
                <a href="{{ route('landing') }}" class="hover:underline hover:text-yellow-400 transition">
                    Home
                </a>
                <span class="mx-1 text-white/80 font-bold">/</span>
                <span class="text-yellow-400 cursor-default">Form</span>
            </nav>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg leading-tight">
                <span class="text-white">Pengisian</span>
                <span class="text-yellow-400"> Form</span>
            </h1>
        </div>
    </div>
</section>

    <section class="py-12 px-4 bg-gray-50">
        <div class="container mx-auto max-w-6xl">
            <div class="flex justify-center gap-4 mb-6 pb-4">
                <button class="px-10 py-3 bg-[#002837] text-white font-semibold rounded-full shadow-md transition-all duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-200" id="peminjamanTab" onclick="showForm('peminjaman')">
                    Form Peminjaman
                </button>
                <button class="px-10 py-3 bg-gray-300 text-gray-700 font-semibold rounded-full shadow-md transition-all duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-200" id="pelaporanTab" onclick="showForm('pelaporan')">
                    Form Pelaporan Anomali
                </button>
            </div>

            {{-- Error Messages --}}
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong>Validasi Gagal:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <strong>Sukses!</strong> {{ session('success') }}
                </div>
            @endif


            <!-- Peminjaman Form -->
            <div id="peminjamanForm" class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-[#002837] mb-6">Form Peminjaman</h2>
                <form class="space-y-6" method="POST" action="{{ route('peminjaman.form.store') }}" id="peminjamanFormContent">
                    @csrf
                    <!-- Unit Selection -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tipe Unit <span class="text-red-600">*</span></label>
                        <select id="peminjamanUnit" name="tipe_unit" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                            <option value="">Pilih Tipe Unit</option>
                            <option value="UPS">UPS</option>
                            <option value="UKB">UKB</option>
                            <option value="Deteksi">Deteksi</option>
                        </select>
                    </div>
                    
                    <!-- Dynamic Unit Container (akan diisi via JavaScript) -->
                    <div id="peminjamanNopolContainer"></div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Mobilisasi <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_mobilisasi" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Demobilisasi <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_demobilisasi" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Event Mulai <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_event_mulai" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Event Selesai <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_event_selesai" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tujuan Penggunaan / Kegiatan <span class="text-red-600">*</span></label>
                        <textarea rows="4" name="tujuan_penggunaan" placeholder="Tujuan Penggunaan / Kegiatan" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Lokasi Penggunaan <span class="text-red-600">*</span></label>
                        <input type="text" name="lokasi_penggunaan" placeholder="Isi Lokasi Penggunaan" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">UP3 <span class="text-red-600">*</span></label>
                        <input type="text" name="up3" placeholder="Isi UP3" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tamu VIP/VVIP</label>
                        <input type="text" name="tamu_vip" placeholder="Isi Tamu VIP/VVIP" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-[#002837] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Submit Form
                    </button>
                </form>
            </div>

            <!-- Pelaporan Form -->
            <div id="pelaporanForm" class="hidden bg-white rounded-lg shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-[#002837] mb-6">Form Pelaporan Anomali</h2>
                <form class="space-y-6" method="POST" action="{{ route('report.form.store') }}" id="pelaporanFormContent" enctype="multipart/form-data">
                @csrf
                    <!-- Unit Selection -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tipe Unit <span class="text-red-600">*</span></label>
                        <select id="pelaporanUnit" name="tipe_unit" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                            <option value="">Pilih Tipe Unit</option>
                            <option value="UPS">UPS</option>
                            <option value="UKB">UKB</option>
                            <option value="Deteksi">Deteksi</option>
                        </select>
                    </div>
                    
                    <!-- Dynamic Unit Container (akan diisi via JavaScript) -->
                    <div id="pelaporanNopolContainer"></div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- <div>
                            <label class="block text-gray-700 font-medium mb-2">Kondisi <span class="text-red-600">*</span></label>
                            <select name="kondisi" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                                <option value="">Pilih Kondisi Kerusakan</option>
                                <option value="Ringan">Ringan</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Berat">Berat</option>
                            </select>
                        </div> -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Kejadian <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_kejadian" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Lokasi Penggunaan <span class="text-red-600">*</span></label>
                        <input type="text" name="lokasi_penggunaan" placeholder="Isi Lokasi Penggunaan" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">No. BA <span class="text-red-600">*</span></label>
                        <input type="text" name="noba" placeholder="Isi No. BA" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">UP3 <span class="text-red-600">*</span></label>
                            <input type="text" name="up3" placeholder="Isi UP3" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Keterangan <span class="text-red-600">*</span></label>
                        <textarea rows="3" name="keterangan" placeholder="Isi Keterangan" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Keperluan Anggaran</label>
                        <input type="text" name="anggaran" placeholder="Rp 0,00" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Bukti Foto <span class="text-red-600">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                            <input type="file" name="bukti_foto[]" id="bukti_foto" multiple accept="image/jpeg,image/jpg,image/png" class="required-field w-full text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#002837] file:text-white hover:file:bg-blue-800 file:cursor-pointer">
                            <p class="text-sm text-gray-500 mt-2">Format: JPG, JPEG, PNG. Maksimal 5MB per file. Bisa upload lebih dari 1 file.</p>
                            <div id="preview-container" class="mt-3 grid grid-cols-3 gap-2"></div>
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-[#002837] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Submit Form
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
// Error handling & set "*" already in markup
function showErrorPopup(message) {
    const modalHtml = `<div id="formErrorModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
        <div class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full text-center">
            <p class="text-red-600 text-lg font-semibold mb-6">${message}</p>
            <button onclick="document.getElementById('formErrorModal').remove()" class="mt-2 px-6 py-2 bg-[#002837] text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
        </div></div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

function validateForm(e) {
    e.preventDefault();
    const form = e.target;
    let empty = false;
    form.querySelectorAll('.required-field').forEach(fld => { if (!fld.value.trim()) empty = true; });
    if (empty) {
        showErrorPopup('Semua kolom wajib diisi!');
        return false;
    }
    form.submit();
}

// Cache untuk data unit dari API
let unitDataCache = {};
let allUnitDataCache = {};

// Fetch data unit dari API berdasarkan tipe (hanya status Standby - untuk Peminjaman)
async function fetchUnitsByType(type) {
    if (unitDataCache[type]) {
        return unitDataCache[type];
    }
    
    try {
        const response = await fetch(`{{ route('api.units-by-type') }}?type=${type}`);
        const data = await response.json();
        unitDataCache[type] = data;
        return data;
    } catch (error) {
        console.error('Error fetching units:', error);
        return [];
    }
}

// Fetch SEMUA unit dari API berdasarkan tipe (untuk Pelaporan Anomali)
async function fetchAllUnitsByType(type) {
    if (allUnitDataCache[type]) {
        return allUnitDataCache[type];
    }
    
    try {
        const response = await fetch(`{{ route('api.all-units-by-type') }}?type=${type}`);
        const data = await response.json();
        allUnitDataCache[type] = data;
        return data;
    } catch (error) {
        console.error('Error fetching all units:', error);
        return [];
    }
}

// ========== PEMINJAMAN FORM ==========
async function updatePeminjamanFields() {
    const unit = document.getElementById('peminjamanUnit').value;
    const nopolContainer = document.getElementById('peminjamanNopolContainer');
    
    // Reset container
    nopolContainer.innerHTML = '';
    
    
    if (!unit) {
        nopolContainer.innerHTML = `
            <div>
                <label class="block text-gray-700 font-medium mb-2">Pilih Unit <span class="text-red-600">*</span></label>
                <select name="unit_id" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent" disabled>
                    <option value="">Pilih Tipe Unit Terlebih Dahulu</option>
                </select>
            </div>`;
        return;
    }
    
    // Fetch data dari API
    const units = await fetchUnitsByType(unit);
    
    if (units.length === 0) {
        nopolContainer.innerHTML = `
            <div>
                <label class="block text-gray-700 font-medium mb-2">Pilih Unit <span class="text-red-600">*</span></label>
                <select name="unit_id" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    <option value="">Tidak ada unit ${unit} yang tersedia (Standby)</option>
                </select>
            </div>`;
        return;
    }
    
    // Build dropdown dengan format gabungan berdasarkan tipe unit
    let options = '<option value="">Pilih Unit</option>';
    units.forEach(u => {
        let label = '';
        switch(unit) {
            case 'UPS':
                // Format: Nopol - KVA - Jenis (contoh: D 1750 MC - 1000 KVA - Mobile)
                label = `${u.nopol} - ${u.kapasitas_kva || '-'} KVA - ${u.jenis_ups || '-'}`;
                break;
            case 'UKB':
                // Format: Nopol - Panjang - Volume (contoh: D 1234 AB - 150m - 2 set)
                label = `${u.nopol} - ${u.panjang_kabel_m || '-'}m - ${u.volume || '-'}`;
                break;
            case 'Deteksi':
            case 'DETEKSI':
                // Format: Nopol - Fitur (contoh: D 5678 XY - Thermal Camera)
                label = `${u.nopol} - ${u.fitur || '-'}`;
                break;
            default:
                label = u.nopol;
        }
        options += `<option value="${u.unit_id}">${label}</option>`;
    });
    
    // Tentukan label berdasarkan tipe
    let fieldLabel = 'Pilih Unit';
    switch(unit) {
        case 'UPS':
            fieldLabel = 'Nopol - KVA - Jenis';
            break;
        case 'UKB':
            fieldLabel = 'Nopol - Panjang - Volume';
            break;
        case 'Deteksi':
        case 'DETEKSI':
            fieldLabel = 'Nopol - Fitur';
            break;
    }
    
    nopolContainer.innerHTML = `
        <div>
            <label class="block text-gray-700 font-medium mb-2">${fieldLabel} <span class="text-red-600">*</span></label>
            <select name="unit_id" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                ${options}
            </select>
        </div>`;
}

// ========== PELAPORAN FORM ==========
async function updatePelaporanFields() {
    const unit = document.getElementById('pelaporanUnit').value;
    const nopolContainer = document.getElementById('pelaporanNopolContainer');
    
    // Reset container
    nopolContainer.innerHTML = '';
    
    if (!unit) {
        nopolContainer.innerHTML = `
            <div>
                <label class="block text-gray-700 font-medium mb-2">Pilih Unit <span class="text-red-600">*</span></label>
                <select name="unit_id" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent" disabled>
                    <option value="">Pilih Tipe Unit Terlebih Dahulu</option>
                </select>
            </div>`;
        return;
    }
    
    // Fetch SEMUA data dari API (tanpa filter status)
    const units = await fetchAllUnitsByType(unit);
    
    if (units.length === 0) {
        nopolContainer.innerHTML = `
            <div>
                <label class="block text-gray-700 font-medium mb-2">Pilih Unit <span class="text-red-600">*</span></label>
                <select name="unit_id" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    <option value="">Tidak ada unit ${unit} yang tersedia</option>
                </select>
            </div>`;
        return;
    }
    
    // Build dropdown dengan format gabungan berdasarkan tipe unit
    let options = '<option value="">Pilih Unit</option>';
    units.forEach(u => {
        let label = '';
        switch(unit) {
            case 'UPS':
                // Format: Nopol - KVA - Jenis (contoh: D 1750 MC - 1000 KVA - Mobile)
                label = `${u.nopol} - ${u.kapasitas_kva || '-'} KVA - ${u.jenis_ups || '-'}`;
                break;
            case 'UKB':
                // Format: Nopol - Panjang - Volume (contoh: D 1234 AB - 150m - 2 set)
                label = `${u.nopol} - ${u.panjang_kabel_m || '-'}m - ${u.volume || '-'}`;
                break;
            case 'Deteksi':
            case 'DETEKSI':
                // Format: Nopol - Fitur (contoh: D 5678 XY - Thermal Camera)
                label = `${u.nopol} - ${u.fitur || '-'}`;
                break;
            default:
                label = u.nopol;
        }
        options += `<option value="${u.unit_id}">${label}</option>`;
    });
    
    // Tentukan label berdasarkan tipe
    let fieldLabel = 'Pilih Unit';
    switch(unit) {
        case 'UPS':
            fieldLabel = 'Nopol - KVA - Jenis';
            break;
        case 'UKB':
            fieldLabel = 'Nopol - Panjang - Volume';
            break;
        case 'Deteksi':
        case 'DETEKSI':
            fieldLabel = 'Nopol - Fitur';
            break;
    }
    
    nopolContainer.innerHTML = `
        <div>
            <label class="block text-gray-700 font-medium mb-2">${fieldLabel} <span class="text-red-600">*</span></label>
            <select name="unit_id" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                ${options}
            </select>
        </div>`;
}

// ========== TAB SWITCHING ==========
function showForm(type) {
    const pemForm = document.getElementById('peminjamanForm');
    const pelForm = document.getElementById('pelaporanForm');
    const pemTab = document.getElementById('peminjamanTab');
    const pelTab = document.getElementById('pelaporanTab');
    if (type === 'peminjaman') {
        pemForm.classList.remove('hidden');
        pelForm.classList.add('hidden');
        pemTab.classList.add('bg-[#002837]','text-white');
        pemTab.classList.remove('bg-gray-300','text-gray-700');
        pelTab.classList.add('bg-gray-300','text-gray-700');
        pelTab.classList.remove('bg-[#002837]','text-white');
    } else {
        pemForm.classList.add('hidden');
        pelForm.classList.remove('hidden');
        pelTab.classList.add('bg-[#002837]','text-white');
        pelTab.classList.remove('bg-gray-300','text-gray-700');
        pemTab.classList.add('bg-gray-300','text-gray-700');
        pemTab.classList.remove('bg-[#002837]','text-white');
    }
}

// ========== INITIALIZATION ==========
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners for unit dropdowns
    document.getElementById('peminjamanUnit').addEventListener('change', updatePeminjamanFields);
    document.getElementById('pelaporanUnit').addEventListener('change', updatePelaporanFields);
    
    // Initialize fields
    updatePeminjamanFields();
    updatePelaporanFields();
    
    // Submit bind
    ['peminjamanFormContent','pelaporanFormContent'].forEach(id => {
        document.getElementById(id).onsubmit = validateForm;
    });
});
</script>
@endpush

@if (!Auth::check())
<div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
  <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xs text-center">
    <div class="text-lg font-semibold text-blue-900 mb-4">Silakan login terlebih dahulu</div>
    <button onclick="window.location.href='{{ route('login') }}'" class="mt-2 px-6 py-2 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800">Login</button>
  </div>
</div>
@endif
