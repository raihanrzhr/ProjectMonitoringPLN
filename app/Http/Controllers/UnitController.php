<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\DetailUps;
use App\Models\DetailUkb;
use App\Models\DetailDeteksi;
use Illuminate\Support\Facades\Redirect;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::with(['detailUps', 'detailUkb', 'detailDeteksi'])->get();
        return view('admin.units', compact('units'));
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
            'nama_unit' => 'required|string|max:100',
            'tipe_peralatan' => 'required|in:UPS,UKB,DETEKSI',

            'nopol' => 'required|string|max:15|unique:unit',
            'merk_kendaraan' => 'nullable|string|max:50',
            'tipe_kendaraan' => 'nullable|string|max:50',
            'kondisi_kendaraan' => 'required|in:BAIK,DIGUNAKAN,RUSAK,PERBAIKAN',
            'status' => 'required|in:Standby,Digunakan,Tidak Siap Oprasi',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',

            'tgl_service_terakhir' => 'nullable|date',
            'status_bpkb' => 'boolean',
            'status_stnk' => 'boolean',
            'pajak_tahunan' => 'nullable|date',
            'pajak_5tahunan' => 'nullable|date',
            'status_kir' => 'boolean',
            'masa_berlaku_kir' => 'nullable|date',
            'dokumentasi' => 'nullable|string|max:255',
        ]);

        $unit = Unit::create($validatedData);

        if($request->tipe_peralatan === 'UPS') {
            DetailUps::create([
                'unit_id' => $unit->unit_id,
                'kapasitas_kva' => $request->kapasitas_kva,
                'jenis_ups' => $request->jenis_ups,
                'batt_merk' => $request->batt_merk,
                'batt_jumlah' => $request->batt_jumlah,
                'batt_kapasitas' => $request->batt_kapasitas,
                'model_no_seri' => $request->model_no_seri,
            ]);
        } 
        
        elseif($request->tipe_peralatan === 'UKB') {
            DetailUkb::create([
                'unit_id' => $unit->unit_id,
                'jenis_ukb' => $request->jenis_ukb,
                'type' => $request->type,
                'panjang_kabel_m' => $request->panjang_kabel_m,
                'kabel' => $request->kabel,
                'volume' => $request->volume,
            ]);
        }
        
        elseif($request->tipe_peralatan === 'DETEKSI') {
            DetailDeteksi::create([
                'unit_id' => $unit->unit_id,
                'fitur' => $request->fitur,
                'type' => $request->type,
            ]);
        }

        return Redirect()->route('units');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        // $unit = Unit::with(['ups','ukb','deteksi'])->findOrFail($unit->unit_id);
        // return view('admin.units', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $unit = Unit::findOrFail($unit->unit_id);

        $validatedData = $request->validate([
            'nama_unit' => 'required|string|max:100',
            'tipe_peralatan' => 'required|in:UPS,UKB,DETEKSI',

            'nopol' => 'required|string|max:15|unique:unit,nopol,' . $unit->unit_id . ',unit_id',
            'merk_kendaraan' => 'nullable|string|max:50',
            'tipe_kendaraan' => 'nullable|string|max:50',
            'kondisi_kendaraan' => 'required|in:BAIK,DIGUNAKAN,RUSAK,PERBAIKAN',
            'status' => 'required|in:Standby,Digunakan,Tidak Siap Oprasi',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',

            'tgl_service_terakhir' => 'nullable|date',
            'status_bpkb' => 'boolean',
            'status_stnk' => 'boolean',
            'pajak_tahunan' => 'nullable|date',
            'pajak_5tahunan' => 'nullable|date',
            'status_kir' => 'boolean',
            'masa_berlaku_kir' => 'nullable|date',
            'dokumentasi' => 'nullable|string|max:255',
        ]);

        $unit->update($validatedData);

        DetailUps::where('unit_id', $unit->unit_id)->delete();
        DetailUkb::where('unit_id', $unit->unit_id)->delete();
        DetailDeteksi::where('unit_id', $unit->unit_id)->delete();

         if($request->tipe_peralatan === 'UPS') {
            DetailUps::create([
                'unit_id' => $unit->unit_id,
                'kapasitas_kva' => $request->kapasitas_kva,
                'jenis_ups' => $request->jenis_ups,
                'batt_merk' => $request->batt_merk,
                'batt_jumlah' => $request->batt_jumlah,
                'batt_kapasitas' => $request->batt_kapasitas,
                'model_no_seri' => $request->model_no_seri,
            ]);
        } 
        
        elseif($request->tipe_peralatan === 'UKB') {
            DetailUkb::create([
                'unit_id' => $unit->unit_id,
                'jenis_ukb' => $request->jenis_ukb,
                'type' => $request->type,
                'panjang_kabel_m' => $request->panjang_kabel_m,
                'kabel' => $request->kabel,
                'volume' => $request->volume,
            ]);
        }
        
        elseif($request->tipe_peralatan === 'DETEKSI') {
            DetailDeteksi::create([
                'unit_id' => $unit->unit_id,
                'fitur' => $request->fitur,
                'type' => $request->type,
            ]);
        }
        return Redirect()->route('units');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit = Unit::findOrFail($unit->unit_id);
        $unit->delete();
        return Redirect()->route('units');
    }
}
