<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

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

        Peminjaman::create($validatedData);
        return redirect()->route('landing');
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
