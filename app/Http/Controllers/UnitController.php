<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\DetailUps;
use App\Models\DetailUkb;
use App\Models\DetailDeteksi;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

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

            'nopol' => 'required|string|max:15|unique:units',
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

        return Redirect()->route('admin.units')->with('success', 'Unit added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Pastikan ID bersih
        $clean_id = trim($id); 

        // Query Manual (Paling Aman untuk situasi Anda sekarang)
        $unit = Unit::with(['detailUps', 'detailUkb', 'detailDeteksi', 'peminjaman'])
                    ->where('unit_id', $clean_id)
                    ->first();

        if (!$unit) {
            abort(404, 'Unit tidak ditemukan di Database');
        }

        return view('admin.unit-detail', compact('unit'));
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
    public function update(Request $request, $id)
    {
        // 1. Cari Unit Manual (Hindari 404 Binding)
        $unit = Unit::where('unit_id', $id)->first();

        if (!$unit) {
            return redirect()->back()->withErrors(['msg' => 'Unit tidak ditemukan']);
        }

        // 2. Validasi Input
        $validated = $request->validate([
            // Validasi Umum
            'nopol' => 'required|string|max:15|unique:units,nopol,' . $id . ',unit_id', // Ignore ID saat ini
            'merk_kendaraan' => 'nullable|string|max:50',
            'kondisi_kendaraan' => 'required',
            'status' => 'required',
            'lokasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status_bpkb' => 'nullable',
            'status_stnk' => 'nullable',
            'status_kir' => 'nullable',
            // ... tambahkan validasi date jika perlu ...
        ]);

        // 3. Update Data Utama (Tabel Units)
        $unit->update([
            'nopol' => $request->nopol,
            'merk_kendaraan' => $request->merk_kendaraan,
            'kondisi_kendaraan' => $request->kondisi_kendaraan,
            'status' => $request->status,
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
            // Convert "Ada"/"Tidak Ada" dropdown value ke Boolean (1/0)
            'status_bpkb' => $request->status_bpkb == 'Ada' ? 1 : 0,
            'status_stnk' => $request->status_stnk == 'Ada' ? 1 : 0,
            'status_kir' => $request->status_kir == 'Ada' ? 1 : 0,
            
            'pajak_tahunan' => $request->pajak_tahunan,
            'pajak_5tahunan' => $request->pajak_5tahunan,
            'masa_berlaku_kir' => $request->masa_berlaku_kir,
            'tgl_service_terakhir' => $request->tgl_service_terakhir,
            'dokumentasi' => $request->dokumentasi,
        ]);

        // 4. Update Data Detail Berdasarkan Tipe
        if ($unit->tipe_peralatan === 'UPS') {
            $unit->detailUps()->updateOrCreate(
                ['unit_id' => $unit->unit_id],
                [
                    'jenis_ups' => $request->jenis_ups,
                    'kapasitas_kva' => $request->kapasitas_kva,
                    'model_no_seri' => $request->model_no_seri,
                    'batt_merk' => $request->batt_merk,
                    'batt_jumlah' => $request->batt_jumlah,
                    'batt_kapasitas' => $request->batt_kapasitas,
                ]
            );
        } 
        elseif ($unit->tipe_peralatan === 'UKB') {
            $unit->detailUkb()->updateOrCreate(
                ['unit_id' => $unit->unit_id],
                [
                    'jenis_ukb' => $request->jenis_ukb,
                    'type' => $request->type, // Pastikan 'name' di form modal UKB adalah 'type' atau sesuaikan
                    'panjang_kabel_m' => $request->panjang_kabel_m,
                    'volume' => $request->volume,
                ]
            );
        } 
        elseif ($unit->tipe_peralatan === 'DETEKSI') {
            $unit->detailDeteksi()->updateOrCreate(
                ['unit_id' => $unit->unit_id],
                [
                    'fitur' => $request->fitur,
                    'type' => $request->type,
                ]
            );
        }

        return redirect()->route('admin.units')->with('success', 'Unit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit = Unit::findOrFail($unit->unit_id);
        $unit->delete();
        return Redirect()->route('admin.units');
    }
}
