<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Unit;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();
        return view('admin.report', compact('reports'));
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
            'kondisi' => 'required|string|in:Ringan,Sedang,Berat',
            'tanggal_kejadian' => 'required|date',
            'lokasi_penggunaan' => 'required|string|max:255',
            'noba' => 'required|string|max:100',
            'posko_pelaksana' => 'required|string|max:255',
            'up3' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'anggaran' => 'required|string',
        ]);

        // Ambil peminjaman terakhir untuk unit ini
        $peminjaman = Peminjaman::where('unit_id', $request->unit_id)->latest()->first();

        // Ambil user_id dari user yang sedang login
        $report = Report::create([
            'unit_id' => $request->unit_id,
            'peminjaman_id' => $peminjaman ? $peminjaman->peminjaman_id : 1,
            'user_id_pelapor' => Auth::id(),
            'tgl_kejadian' => $request->tanggal_kejadian,
            'lokasi_kejadian' => $request->lokasi_penggunaan,
            'deskripsi_kerusakan' => $request->keterangan . ' - Kondisi: ' . $request->kondisi,
            'no_ba' => $request->noba,
            'keperluan_anggaran' => $this->parseAnggaran($request->anggaran),
        ]);

        return redirect()->route('landing')->with('success', 'Form pelaporan anomali berhasil dikirim!');
    }

    /**
     * Helper function to parse anggaran string to numeric
     */
    private function parseAnggaran($anggaran)
    {
        // Hapus "Rp", spasi, titik, dan koma
        $cleaned = preg_replace('/[^0-9]/', '', $anggaran);
        return (float) $cleaned;
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validatedData = $request->validate([
            'unit_id' => 'required|integer|exists:unit,unit_id',
            'user_id' => 'required|integer|exists:users,id',
            'peminjaman_id' => 'required|integer|exists:peminjaman,peminjaman_id',
            'user_id_pelapor' => 'required|integer|exists:users,id',
            'tgl_kejadian' => 'required|date',
            'lokasi_kejadian' => 'nullable|string|max:255',
            'deskripsi_kerusakan' => 'required|string',
            'no_ba' => 'nullable|string|max:100',
            'keperluan_anggaran' => 'nullable|numeric',
        ]);

        $report->update($validatedData);
        return redirect()->route('report');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report = Report::findOrFail($report->laporan_id);
        return redirect()->route('report');
    }
}
