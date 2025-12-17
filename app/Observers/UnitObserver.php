<?php

namespace App\Observers;

use App\Models\Unit;
use App\Models\UnitLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UnitObserver
{
    /**
     * Handle the Unit "created" event.
     * Log saat unit baru ditambahkan.
     */
    public function created(Unit $unit): void
    {
        $userId = Auth::id();

        UnitLog::create([
            'unit_id' => $unit->unit_id,
            'user_id' => $userId,
            'kategori_histori' => 'Status',
            'keterangan' => "Unit {$unit->nama_unit} ditambahkan",
            'date_time' => now(),
        ]);
    }

    /**
     * Handle the Unit "updating" event.
     * Log perubahan data sebelum disimpan ke database.
     */
    public function updating(Unit $unit): void
    {
        $userId = Auth::id();

        // Log perubahan tanggal servis terakhir
        if ($unit->isDirty('tgl_service_terakhir')) {
            $oldValue = $unit->getOriginal('tgl_service_terakhir');
            $newValue = $unit->tgl_service_terakhir;
            
            $keterangan = 'Servis terakhir diperbarui';
            if ($newValue) {
                $formattedDate = Carbon::parse($newValue)->format('d M Y');
                $keterangan = "Servis terakhir diperbarui menjadi {$formattedDate}";
            }

            UnitLog::create([
                'unit_id' => $unit->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Servis',
                'keterangan' => $keterangan,
                'date_time' => now(),
            ]);
        }

        // Log perubahan status unit
        if ($unit->isDirty('status')) {
            $oldStatus = $unit->getOriginal('status');
            $newStatus = $unit->status;

            UnitLog::create([
                'unit_id' => $unit->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Status',
                'keterangan' => "Status unit diubah dari {$oldStatus} menjadi {$newStatus}",
                'date_time' => now(),
            ]);
        }

        // Log perubahan kondisi kendaraan
        if ($unit->isDirty('kondisi_kendaraan')) {
            $oldKondisi = $unit->getOriginal('kondisi_kendaraan');
            $newKondisi = $unit->kondisi_kendaraan;

            UnitLog::create([
                'unit_id' => $unit->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Status',
                'keterangan' => "Kondisi kendaraan diubah dari {$oldKondisi} menjadi {$newKondisi}",
                'date_time' => now(),
            ]);
        }

        // Log perubahan pajak tahunan
        if ($unit->isDirty('pajak_tahunan')) {
            $newValue = $unit->pajak_tahunan;
            $keterangan = 'Pajak tahunan diperbarui';
            if ($newValue) {
                $formattedDate = Carbon::parse($newValue)->format('d M Y');
                $keterangan = "Pajak tahunan diperbarui menjadi {$formattedDate}";
            }

            UnitLog::create([
                'unit_id' => $unit->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Pajak',
                'keterangan' => $keterangan,
                'date_time' => now(),
            ]);
        }

        // Log perubahan pajak 5 tahunan
        if ($unit->isDirty('pajak_5tahunan')) {
            $newValue = $unit->pajak_5tahunan;
            $keterangan = 'Pajak 5 tahunan diperbarui';
            if ($newValue) {
                $formattedDate = Carbon::parse($newValue)->format('d M Y');
                $keterangan = "Pajak 5 tahunan diperbarui menjadi {$formattedDate}";
            }

            UnitLog::create([
                'unit_id' => $unit->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Pajak',
                'keterangan' => $keterangan,
                'date_time' => now(),
            ]);
        }

        // Log perubahan lokasi (Mutasi)
        if ($unit->isDirty('lokasi')) {
            $oldLokasi = $unit->getOriginal('lokasi') ?? '-';
            $newLokasi = $unit->lokasi ?? '-';

            UnitLog::create([
                'unit_id' => $unit->unit_id,
                'user_id' => $userId,
                'kategori_histori' => 'Mutasi',
                'keterangan' => "Lokasi unit dimutasi dari {$oldLokasi} ke {$newLokasi}",
                'date_time' => now(),
            ]);
        }
    }
}
