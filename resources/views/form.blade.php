@extends('layout')

@section('title', 'Pengisian Form - UP2D Pasundan')
@section('bodyClass', 'bg-gray-50')

@section('content')
<section class="relative min-h-[480px] md:min-h-[540px] flex items-center justify-center bg-cover bg-center"
    style="background-image: url('{{ asset('assets/image/Foto Hero .png') }}');">
    <div class="absolute inset-0 bg-blue-900 bg-opacity-50"></div>
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
            <div class="flex justify-center gap-4 mb-6">
                <button class="px-10 py-3 bg-blue-900 text-white font-semibold rounded-full shadow-md transition-all duration-200 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-200" id="peminjamanTab" onclick="showForm('peminjaman')">
                    Form Peminjaman
                </button>
                <button class="px-10 py-3 bg-gray-300 text-gray-700 font-semibold rounded-full shadow-md transition-all duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-200" id="pelaporanTab" onclick="showForm('pelaporan')">
                    Form Pelaporan Anomali
                </button>
            </div>

            <!-- Peminjaman Form - UPS (Default) -->
            <div id="peminjamanForm" class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Form Peminjaman</h2>
                <form class="space-y-6" id="peminjamanFormContent">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama <span class="text-red-600">*</span></label>
                            <input type="text" name="nama" placeholder="Isi Nama" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email or No. Telepon <span class="text-red-600">*</span></label>
                            <input type="text" name="kontak" placeholder="xxx@gmail.com/08xxxx" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Unit <span class="text-red-600">*</span></label>
                            <select id="peminjamanUnit" name="unit" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent" onchange="updatePeminjamanMerkNopol()">
                                <option value="">Pilih Unit</option>
                                <option value="UPS">UPS</option>
                                <option value="UKB">UKB</option>
                                <option value="Deteksi">Deteksi</option>
                            </select>
                        </div>
                        <div id="peminjamanJenisKapasitasContainer"></div>
                    </div>
                    <div id="peminjamanMerkNopolContainer"></div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Lokasi Penggunaan <span class="text-red-600">*</span></label>
                            <input type="text" name="lokasi_penggunaan" placeholder="Isi Lokasi Penggunaan" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Mobilisasi <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_mobilisasi" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tujuan Penggunaan / Kegiatan <span class="text-red-600">*</span></label>
                        <textarea rows="4" name="tujuan_penggunaan" placeholder="Tujuan Penggunaan / Kegiatan" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent"></textarea>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Demobilisasi <span class="text-red-600">*</span></label>
                            <input type="date" name="tanggal_demobilisasi" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Posko Pelaksana <span class="text-red-600">*</span></label>
                            <input type="text" name="posko_pelaksana" placeholder="Isi Posko Pelaksana" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">UP3 <span class="text-red-600">*</span></label>
                        <input type="text" name="up3" placeholder="Isi UP3" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-blue-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Submit Form
                    </button>
                </form>
            </div>

            <!-- Pelaporan Form - UPS (Default) -->
            <div id="pelaporanForm" class="hidden bg-white rounded-lg shadow-lg p-6 md:p-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Form Pelaporan Anomali</h2>
                <form class="space-y-6" id="pelaporanFormContent">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Pelapor <span class="text-red-600">*</span></label>
                            <input type="text" name="nama_pelapor" placeholder="Isi Nama" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Unit <span class="text-red-600">*</span></label>
                            <select id="pelaporanUnit" name="unit" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent" onchange="updatePelaporanMerkNopol()">
                                <option value="">Pilih Unit</option>
                                <option value="UPS">UPS</option>
                                <option value="UKB">UKB</option>
                                <option value="Deteksi">Deteksi</option>
                            </select>
                        </div>
                    </div>
                    <div id="pelaporanJenisKapasitasContainer"></div>
                    <div id="pelaporanMerkNopolContainer"></div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Kondisi <span class="text-red-600">*</span></label>
                            <select name="kondisi" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                                <option value="">Pilih Kondisi Kerusakan</option>
                                <option>UPS</option>
                                <option>Mobil</option>
                                <option>UKB</option>
                                <option>Deteksi</option>
                            </select>
                        </div>
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
                            <label class="block text-gray-700 font-medium mb-2">Posko Pelaksana <span class="text-red-600">*</span></label>
                            <input type="text" name="posko_pelaksana" placeholder="Isi Posko Pelaksana" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                        </div>
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
                        <label class="block text-gray-700 font-medium mb-2">Keperluan Anggaran <span class="text-red-600">*</span></label>
                        <input type="text" name="anggaran" placeholder="Rp 0,00" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Bukti Foto <span class="text-red-600">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <button type="button" class="bg-gray-200 px-4 py-2 rounded-lg mb-2">Upload File</button>
                            <p class="text-sm text-gray-500">File.jpg</p>
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-blue-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
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
            <button onclick="document.getElementById('formErrorModal').remove()" class="mt-2 px-6 py-2 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
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
    // TODO: Submit as normal/submit ajax/whatever is needed
    form.submit();
}

// PEMINJAMAN
const pemUnitData = {
    UPS: [
        { value: 'UPS1', label: 'UPS1 - DK 8001 AB' },
        { value: 'UPS2', label: 'UPS2 - DK 8002 AB' },
        { value: 'UPS3', label: 'UPS3 - DK 8003 AB' }
    ],
    UKB: [
        { value: 'UKB1', label: 'UKB1 - D 8011 ZZ' },
        { value: 'UKB2', label: 'UKB2 - D 8012 ZZ' },
        { value: 'UKB3', label: 'UKB3 - D 8013 ZZ' }
    ],
    Deteksi: [
        { value: 'DET1', label: 'Deteksi 1 - B 1234 XY' },
        { value: 'DET2', label: 'Deteksi 2 - B 5678 XY' },
        { value: 'DET3', label: 'Deteksi 3 - B 9087 XY' }
    ]
};
function updatePeminjamanMerkNopol() {
    const unit = document.getElementById('peminjamanUnit').value;
    const merkNopolContainer = document.getElementById('peminjamanMerkNopolContainer');
    let labelUnit = 'Merk dan Nopol ' + (unit || 'Unit');
    let options = (pemUnitData[unit]||[]).map(o => `<option value="${o.value}">${o.label}</option>`).join('');
    if (!unit) options = '<option value="">Pilih Unit Terlebih Dahulu</option>';
    merkNopolContainer.innerHTML = `<label class="block text-gray-700 font-medium mb-2">${labelUnit} <span class="text-red-600">*</span></label><select name="merk_nopol" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">${options}</select>`;
    updatePeminjamanJenisKapasitas(unit);
}
function updatePeminjamanJenisKapasitas(unit) {
    // tetap sesuai design lama atau modif bila ada permintaan lain
    const el = document.getElementById('peminjamanJenisKapasitasContainer');
    el.innerHTML = '<label class="block text-gray-700 font-medium mb-2">Jenis dan Kapasitas <span class="text-red-600">*</span></label><select name="jenis_kapasitas" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent"><option value="">Pilih Jenis - Kapasitas</option><option>Mobile - 250 KVA</option><option>Portable - 110 KVA</option><option>Portable - 30 KVA</option></select>';
}
// PE<b>LAPORAN</b>
const lapUnitData = pemUnitData; // sama dummy
document.getElementById('peminjamanUnit').addEventListener('change', updatePeminjamanMerkNopol);
function updatePelaporanMerkNopol() {
    const unit = document.getElementById('pelaporanUnit').value;
    const merkNopolContainer = document.getElementById('pelaporanMerkNopolContainer');
    let labelUnit = 'Merk dan Nopol ' + (unit || 'Unit');
    let options = (lapUnitData[unit]||[]).map(o => `<option value="${o.value}">${o.label}</option>`).join('');
    if (!unit) options = '<option value="">Pilih Unit Terlebih Dahulu</option>';
    merkNopolContainer.innerHTML = `<label class="block text-gray-700 font-medium mb-2">${labelUnit} <span class="text-red-600">*</span></label><select name="merk_nopol" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent">${options}</select>`;
    updatePelaporanJenisKapasitas(unit);
}
function updatePelaporanJenisKapasitas(unit) {
    // tetap dummy simple, sama
    const el = document.getElementById('pelaporanJenisKapasitasContainer');
    el.innerHTML = '<label class="block text-gray-700 font-medium mb-2">Jenis dan Kapasitas <span class="text-red-600">*</span></label><select name="jenis_kapasitas" class="required-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent"><option value="">Pilih Jenis - Kapasitas</option><option>Mobile - 250 KVA</option><option>Portable - 110 KVA</option><option>Portable - 30 KVA</option></select>';
}
document.getElementById('pelaporanUnit').addEventListener('change', updatePelaporanMerkNopol);
// Init dummy on load
updatePeminjamanMerkNopol();
updatePelaporanMerkNopol();
// Submit bind
['peminjamanFormContent','pelaporanFormContent'].forEach(id => {
    document.getElementById(id).onsubmit = validateForm;
});
</script>
@endpush

{{--  @if (!Auth::check())
<div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
  <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xs text-center">
    <div class="text-lg font-semibold text-blue-900 mb-4">Silakan login terlebih dahulu</div>
    <button onclick="window.location.href='/'" class="mt-2 px-6 py-2 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
  </div>
</div>
@endif  --}}
