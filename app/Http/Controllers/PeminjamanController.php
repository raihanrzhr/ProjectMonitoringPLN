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
        $peminjamans = Peminjaman::with(['unit', 'userPemohon'])->get();
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
            'posko_pelaksana' => 'required|string|max:255',
            'up3' => 'required|string|max:255',
            'tamu_vip' => 'nullable|string|max:255',
        ]);

        // Ambil user_id dari user yang sedang login
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
            'keterangan' => $request->posko_pelaksana,
        ]);

        // Update status unit menjadi 'Digunakan'
        Unit::where('unit_id', $request->unit_id)->update(['status' => 'Digunakan']);

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
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $peminjaman::findOrFail($peminjaman->peminjaman_id);

        $validatedData = $request->validate([
            'unit_id' => 'required|integer|exists:unit,unit_id',
            'user_id_pemohon' => 'required|integer|exists:users,id',

            'tgl_mobilisasi' => 'required|date',
            'tgl_event_mulai' => 'nullable|date',
            'tgl_event_selesai' => 'nullable|date',
            'tgl_demobilisasi' => 'nullable|date',
            'kegiatan' => 'required|string',
            'Tamu_VIP' => 'nullable|string|max:255',
            'lokasi_tujuan' => 'required|string|max:255',
            'up3_id' => 'required|integer|exists:up3,up3_id',
            'status_peminjaman' => 'required|in:Pending,Selesai,Cancel,Sedang Digunakan',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman->update($validatedData);
        return redirect()->route('peminjaman');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman::findOrFail($peminjaman->peminjaman_id);

        $peminjaman->delete();
        return redirect()->route('peminjaman');
    }
}
