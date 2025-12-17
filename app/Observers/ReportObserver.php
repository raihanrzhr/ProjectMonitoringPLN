<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\UnitLog;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     * Log saat laporan anomali baru dibuat.
     */
    public function created(Report $report): void
    {
        $userId = Auth::id();
        $unit = $report->unit;
        $lokasiPenggunaan = $report->lokasi_penggunaan ?? 'lokasi tidak diketahui';

        UnitLog::create([
            'unit_id' => $report->unit_id,
            'user_id' => $userId,
            'kategori_histori' => 'Anomali',
            'keterangan' => "Laporan anomali dilaporkan di {$lokasiPenggunaan}",
            'date_time' => $report->tgl_kejadian ?? now(),
        ]);
    }
}
