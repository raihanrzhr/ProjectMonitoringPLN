<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with([
            'unit.detailUps',
            'unit.detailUkb',
            'unit.detailDeteksi',
            'userPemohon'
        ])->get();
        return view('admin.peminjaman', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipe_unit' => 'required|string|in:UPS,UKB,Deteksi',
            'unit_id' => 'required|integer|exists:units,unit_id',
            'lokasi_penggunaan' => 'required|string|max:255',
            'tanggal_mobilisasi' => 'required|date',
            'tanggal_demobilisasi' => 'required|date',
            'tanggal_event_mulai' => 'required|date',
            'tanggal_event_selesai' => 'required|date',
            'tujuan_penggunaan' => 'required|string',
            'up3' => 'required|string|max:255',
            'tamu_vip' => 'nullable|string|max:255',
        ]);

        // Ambil user_id dari user yang sedang login
        // Posko pelaksana diambil dari unit->lokasi, tidak perlu di-input dari form
        $peminjaman = Peminjaman::create([
            'unit_id' => $request->unit_id,
            'user_id_pemohon' => Auth::id(),
            'tgl_mobilisasi' => $request->tanggal_mobilisasi,
            'tgl_demobilisasi' => $request->tanggal_demobilisasi,
            'tgl_event_mulai' => $request->tanggal_event_mulai,
            'tgl_event_selesai' => $request->tanggal_event_selesai,
            'kegiatan' => $request->tujuan_penggunaan,
            'Tamu_VIP' => $request->tamu_vip,
            'lokasi_tujuan' => $request->lokasi_penggunaan,
            'up3_id' => $request->up3,
            'status_peminjaman' => 'Sedang Digunakan',
            'keterangan' => null, // Keterangan diisi melalui edit modal di admin
        ]);

        // Update status dan kondisi_kendaraan unit menjadi 'Digunakan'
        Unit::where('unit_id', $request->unit_id)->update([
            'status' => 'Digunakan',
            'kondisi_kendaraan' => 'DIGUNAKAN'
        ]);

        return redirect()->route('landing')->with('success', 'Form peminjaman berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman = Peminjaman::with(['unit', 'userPemohon'])->findOrFail($peminjaman->peminjaman_id);

        // return view('admin.peminjaman_detail', compact('peminjaman')); MASIH RAGU
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::where('peminjaman_id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'tgl_mobilisasi' => 'nullable|date',
            'tgl_event_mulai' => 'nullable|date',
            'tgl_event_selesai' => 'nullable|date',
            'tgl_demobilisasi' => 'nullable|date',
            'kegiatan' => 'nullable|string',
            'Tamu_VIP' => 'nullable|string|max:255',
            'lokasi_tujuan' => 'nullable|string|max:255',
            'up3_id' => 'nullable|string|max:255',
            'status_peminjaman' => 'required|in:Selesai,Cancel,Sedang Digunakan',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman->update($validatedData);

        // Jika status berubah menjadi Selesai atau Cancel, update status dan kondisi unit
        if (in_array($request->status_peminjaman, ['Selesai', 'Cancel'])) {
            Unit::where('unit_id', $peminjaman->unit_id)->update([
                'status' => 'Standby',
                'kondisi_kendaraan' => 'BAIK'
            ]);
        }

        return redirect()->route('admin.peminjaman')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::where('peminjaman_id', $id)->firstOrFail();
        
        // Update status dan kondisi unit kembali ke Standby/BAIK
        Unit::where('unit_id', $peminjaman->unit_id)->update([
            'status' => 'Standby',
            'kondisi_kendaraan' => 'BAIK'
        ]);

        $peminjaman->delete();
        return redirect()->route('admin.peminjaman')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
