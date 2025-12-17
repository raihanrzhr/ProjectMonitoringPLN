<?php

namespace App\Observers;

use App\Models\Peminjaman;
use App\Models\UnitLog;
use Illuminate\Support\Facades\Auth;

class PeminjamanObserver
{
    /**
     * Handle the Peminjaman "created" event.
     * Log saat peminjaman baru dibuat.
     */
    public function created(Peminjaman $peminjaman): void
    {
        $userId = Auth::id();
        $lokasiTujuan = $peminjaman->lokasi_tujuan ?? 'lokasi tidak diketahui';

        UnitLog::create([
            'unit_id' => $peminjaman->unit_id,
            'user_id' => $userId,
            'kategori_histori' => 'Peminjaman',
            'keterangan' => "Unit dipinjam ke {$lokasiTujuan}",
            'date_time' => $peminjaman->tgl_mobilisasi ?? now(),
        ]);
    }

    /**
     * Handle the Peminjaman "updating" event.
     * Log saat status peminjaman berubah menjadi Selesai.
     */
    public function updating(Peminjaman $peminjaman): void
    {
        // Cek jika status_peminjaman berubah menjadi 'Selesai'
        if ($peminjaman->isDirty('status_peminjaman') && $peminjaman->status_peminjaman === 'Selesai') {
            $userId = Auth::id();
            $lokasiTujuan = $peminjaman->lokasi_tujuan ?? 'lokasi tidak diketahui';

            UnitLog::create([
                'unit_id' => $peminjaman->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Peminjaman',
                'keterangan' => "Peminjaman selesai dari {$lokasiTujuan}",
                'date_time' => $peminjaman->tgl_demobilisasi ?? now(),
            ]);
        }

        // Log jika peminjaman dibatalkan (Cancel)
        if ($peminjaman->isDirty('status_peminjaman') && $peminjaman->status_peminjaman === 'Cancel') {
            $userId = Auth::id();
            $lokasiTujuan = $peminjaman->lokasi_tujuan ?? 'lokasi tidak diketahui';

            UnitLog::create([
                'unit_id' => $peminjaman->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Peminjaman',
                'keterangan' => "Peminjaman ke {$lokasiTujuan} dibatalkan",
                'date_time' => now(),
            ]);
        }
    }
}
