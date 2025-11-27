<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

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

        Report::create($validatedData);
        return redirect()->route('report');
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
