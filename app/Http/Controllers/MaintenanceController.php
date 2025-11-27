<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = Maintenance::all();
        // return view('maintenances.index', compact('maintenances'));
        return view('admin.maintenance', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.maintenance');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'laporan_id' => 'required|integer|exists:report,laporan_id',
            'unit_id' => 'required|integer|exists:unit,unit_id',
            'item_pekerjaan' => 'required|string|max:255',
            'no_notdin' => 'nullable|string|max:100',
            'tgl_notdin' => 'nullable|date',
            'status_acc_ku' => 'nullable|in:PENDING,OK,REJECTED',
            'tgl_eksekusi' => 'nullable|date',
            'nilai_pekerjaan' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        Maintenance::create($validatedData);

        // return redirect()->route('maintenances.index');
        return redirect()->route('maintenance');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        // $maintenance = Maintenance::findOrFail($maintenance->perbaikan_id);
        // return view('maintenances.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        // $maintenance = Maintenance::findOrFail($maintenance->perbaikan_id);
        // return view('maintenances.edit', compact('maintenance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $validatedData = $request->validate([
            'laporan_id' => 'required|integer|exists:report,laporan_id',
            'unit_id' => 'required|integer|exists:unit,unit_id',
            'item_pekerjaan' => 'required|string|max:255',
            'no_notdin' => 'nullable|string|max:100',
            'tgl_notdin' => 'nullable|date',
            'status_acc_ku' => 'nullable|in:PENDING,OK,REJECTED',
            'tgl_eksekusi' => 'nullable|date',
            'nilai_pekerjaan' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $maintenance->update($validatedData);

        return redirect()->route('maintenances');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance = Maintenance::findOrFail($maintenance->perbaikan_id);
        return redirect()->route('maintenances');
    }
}
