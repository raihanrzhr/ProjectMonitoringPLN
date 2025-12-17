<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Peminjaman;
use App\Models\Report;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with real data from database.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        // Build base query for units with optional filter
        $unitsQuery = Unit::query();
        if ($filter !== 'all') {
            $unitsQuery->where('tipe_peralatan', strtoupper($filter));
        }
        
        // Get unit IDs for filtered queries
        $unitIds = (clone $unitsQuery)->pluck('unit_id');
        
        // === SUMMARY CARDS ===
        $totalUnits = (clone $unitsQuery)->count();
        $totalStandby = (clone $unitsQuery)->where('status', 'Standby')->count();
        $totalDigunakan = (clone $unitsQuery)->where('status', 'Digunakan')->count();
        $totalTidakSiap = (clone $unitsQuery)->where('status', 'Tidak Siap Oprasi')->count();
        
        // Count by condition
        $kondisiBaik = (clone $unitsQuery)->where('kondisi_kendaraan', 'BAIK')->count();
        $kondisiRusak = (clone $unitsQuery)->where('kondisi_kendaraan', 'RUSAK')->count();
        $kondisiPerbaikan = (clone $unitsQuery)->where('kondisi_kendaraan', 'PERBAIKAN')->count();
        
        // Peminjaman counts (status: Selesai, Cancel, Sedang Digunakan)
        $peminjamanQuery = Peminjaman::query();
        if ($filter !== 'all') {
            $peminjamanQuery->whereIn('unit_id', $unitIds);
        }
        $totalPeminjaman = (clone $peminjamanQuery)->where('status_peminjaman', '!=', 'Selesai')->where('status_peminjaman', '!=', 'Cancel')->count();
        $peminjamanAktif = (clone $peminjamanQuery)->where('status_peminjaman', 'Sedang Digunakan')->count();
        $peminjamanSelesai = (clone $peminjamanQuery)->where('status_peminjaman', 'Selesai')->count();
        
        // Report (Anomali) counts - no status column, just count all
        $reportQuery = Report::query();
        if ($filter !== 'all') {
            $reportQuery->whereIn('unit_id', $unitIds);
        }
        $totalReports = (clone $reportQuery)->count();
        // Since there's no status_laporan column, we'll count based on no_ba presence as indicator
        $reportsPending = (clone $reportQuery)->whereNull('no_ba')->count();
        $reportsSelesai = (clone $reportQuery)->whereNotNull('no_ba')->count();
        
        // === UNITS BY TYPE ===
        $unitsByType = [
            'UPS' => Unit::where('tipe_peralatan', 'UPS')->count(),
            'UKB' => Unit::where('tipe_peralatan', 'UKB')->count(),
            'DETEKSI' => Unit::where('tipe_peralatan', 'DETEKSI')->count(),
        ];
        
        // === WEEKLY DATA (Last 7 days) ===
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        // Initialize arrays for weekly data
        $weeklyLabels = [];
        $weeklyPeminjaman = [];
        $weeklyReports = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays(6 - $i);
            $weeklyLabels[] = $date->format('D'); // Mon, Tue, etc.
            
            // Peminjaman created on this day
            $peminjamanDayQuery = Peminjaman::whereDate('created_at', $date);
            if ($filter !== 'all') {
                $peminjamanDayQuery->whereIn('unit_id', $unitIds);
            }
            $weeklyPeminjaman[] = $peminjamanDayQuery->count();
            
            // Reports created on this day
            $reportDayQuery = Report::whereDate('created_at', $date);
            if ($filter !== 'all') {
                $reportDayQuery->whereIn('unit_id', $unitIds);
            }
            $weeklyReports[] = $reportDayQuery->count();
        }
        
        // === RECENT PEMINJAMAN (Last 5) ===
        $recentPeminjamanQuery = Peminjaman::with(['unit', 'userPemohon'])
            ->orderBy('created_at', 'desc')
            ->limit(5);
        if ($filter !== 'all') {
            $recentPeminjamanQuery->whereIn('unit_id', $unitIds);
        }
        $recentPeminjaman = $recentPeminjamanQuery->get();
        
        // === RECENT REPORTS (Last 5) ===
        $recentReportsQuery = Report::with(['unit', 'userPelapor'])
            ->orderBy('created_at', 'desc')
            ->limit(5);
        if ($filter !== 'all') {
            $recentReportsQuery->whereIn('unit_id', $unitIds);
        }
        $recentReports = $recentReportsQuery->get();
        
        // === UNITS NEEDING ATTENTION (Tax expiring soon) ===
        $taxExpiringQuery = Unit::query()
            ->where(function($q) {
                $oneMonthFromNow = Carbon::now()->addMonth();
                $q->whereBetween('pajak_tahunan', [Carbon::now(), $oneMonthFromNow])
                  ->orWhereBetween('pajak_5tahunan', [Carbon::now(), $oneMonthFromNow])
                  ->orWhereBetween('masa_berlaku_kir', [Carbon::now(), $oneMonthFromNow]);
            });
        if ($filter !== 'all') {
            $taxExpiringQuery->where('tipe_peralatan', strtoupper($filter));
        }
        $unitsNeedingAttention = $taxExpiringQuery->get();
        
        return view('admin.dashboard', compact(
            'filter',
            'totalUnits',
            'totalStandby',
            'totalDigunakan',
            'totalTidakSiap',
            'kondisiBaik',
            'kondisiRusak',
            'kondisiPerbaikan',
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanSelesai',
            'totalReports',
            'reportsPending',
            'reportsSelesai',
            'unitsByType',
            'weeklyLabels',
            'weeklyPeminjaman',
            'weeklyReports',
            'recentPeminjaman',
            'recentReports',
            'unitsNeedingAttention'
        ));
    }
}


