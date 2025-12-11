<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\DetailUps;
use App\Models\DetailUkb;
use App\Models\DetailDeteksi;
use Illuminate\Http\Request;

class FormApiController extends Controller
{
    /**
     * Get units by type (UPS, UKB, DETEKSI) with status Standby
     */
    public function getUnitsByType(Request $request)
    {
        $type = strtoupper($request->type);
        
        // Ambil unit dengan status Standby saja
        $units = Unit::where('tipe_peralatan', $type)
            ->where('status', 'Standby')
            ->get();
        
        $result = [];
        
        foreach ($units as $unit) {
            $data = [
                'unit_id' => $unit->unit_id,
                'nama_unit' => $unit->nama_unit,
                'nopol' => $unit->nopol,
                'merk_kendaraan' => $unit->merk_kendaraan,
                'tipe_kendaraan' => $unit->tipe_kendaraan,
            ];
            
            // Tambahkan detail berdasarkan tipe
            switch ($type) {
                case 'UPS':
                    $detail = $unit->detailUps;
                    if ($detail) {
                        $data['kapasitas_kva'] = $detail->kapasitas_kva;
                        $data['jenis_ups'] = $detail->jenis_ups;
                    }
                    break;
                    
                case 'UKB':
                    $detail = $unit->detailUkb;
                    if ($detail) {
                        $data['jenis_ukb'] = $detail->jenis_ukb;
                        $data['panjang_kabel_m'] = $detail->panjang_kabel_m;
                        $data['volume'] = $detail->volume;
                    }
                    break;
                    
                case 'DETEKSI':
                    $detail = $unit->detailDeteksi;
                    if ($detail) {
                        $data['fitur'] = $detail->fitur;
                        $data['type'] = $detail->type;
                    }
                    break;
            }
            
            $result[] = $data;
        }
        
        return response()->json($result);
    }
}
