<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Unit;
use App\Models\Peminjaman;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with([
            'unit.detailUps',
            'unit.detailUkb',
            'unit.detailDeteksi',
            'userPelapor',
            'images'
        ])->get();
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
        try {
            $validatedData = $request->validate([
                'tipe_unit' => 'required|string|in:UPS,UKB,Deteksi',
                'unit_id' => 'required|integer|exists:units,unit_id',
                'tanggal_kejadian' => 'required|date',
                'lokasi_penggunaan' => 'required|string|max:255',
                'noba' => 'required|string|max:100',
                'up3' => 'nullable|string|max:255',
                'keterangan' => 'required|string',
                'anggaran' => 'nullable|string',
                'bukti_foto' => 'required|array|min:1',
                'bukti_foto.*' => 'image|mimes:jpg,jpeg,png|max:5120', // 5MB = 5120KB
            ], [
                'bukti_foto.required' => 'Bukti foto wajib diupload.',
                'bukti_foto.*.image' => 'File harus berupa gambar.',
                'bukti_foto.*.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'bukti_foto.*.max' => 'Ukuran file maksimal 5MB per file.',
            ]);

            // Ambil peminjaman terakhir untuk unit ini
            $peminjaman = Peminjaman::where('unit_id', $request->unit_id)->latest()->first();

            // Ambil user_id dari user yang sedang login
            $report = Report::create([
                'unit_id' => $request->unit_id,
                'peminjaman_id' => $peminjaman ? $peminjaman->peminjaman_id : 1,
                'user_id_pelapor' => Auth::id(),
                'tgl_kejadian' => $request->tanggal_kejadian,
                'lokasi_penggunaan' => $request->lokasi_penggunaan,
                'deskripsi_kerusakan' => $request->keterangan,
                'no_ba' => $request->noba,
                'keperluan_anggaran' => $this->parseAnggaran($request->anggaran ?? '0'),
                'up3' => $request->up3,
            ]);

            // Upload dan simpan gambar
            if ($request->hasFile('bukti_foto')) {
                foreach ($request->file('bukti_foto') as $file) {
                    // Simpan file ke storage/app/public/anomali/
                    $path = $file->store('anomali', 'public');
                    
                    // Simpan path ke database menggunakan polymorphic relation
                    $report->images()->create([
                        'path' => $path,
                    ]);
                }
            }

            // Update kondisi_kendaraan dan status unit menjadi RUSAK / Tidak Siap Oprasi
            Unit::where('unit_id', $request->unit_id)->update([
                'kondisi_kendaraan' => 'RUSAK',
                'status' => 'Tidak Siap Oprasi'
            ]);

            return redirect()->route('landing')->with('success', 'Form pelaporan anomali berhasil dikirim!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions untuk ditangani Laravel
            throw $e;
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error saat menyimpan report: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi. Error: ' . $e->getMessage());
        }
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
    public function update(Request $request, $id)
    {
        $report = Report::where('laporan_id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'tgl_kejadian' => 'nullable|date',
            'lokasi_penggunaan' => 'nullable|string|max:255',
            'deskripsi_kerusakan' => 'nullable|string',
            'no_ba' => 'nullable|string|max:100',
            'keperluan_anggaran' => 'nullable|numeric',
            'up3' => 'nullable|string|max:255',
            'kondisi_kendaraan' => 'nullable|in:BAIK,DIGUNAKAN,RUSAK,PERBAIKAN',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $report->update([
            'tgl_kejadian' => $validatedData['tgl_kejadian'] ?? $report->tgl_kejadian,
            'lokasi_penggunaan' => $validatedData['lokasi_penggunaan'] ?? $report->lokasi_penggunaan,
            'deskripsi_kerusakan' => $validatedData['deskripsi_kerusakan'] ?? $report->deskripsi_kerusakan,
            'no_ba' => $validatedData['no_ba'] ?? $report->no_ba,
            'keperluan_anggaran' => $validatedData['keperluan_anggaran'] ?? $report->keperluan_anggaran,
            'up3' => $validatedData['up3'] ?? $report->up3,
        ]);

        // Update kondisi_kendaraan di tabel units jika ada perubahan
        if ($request->filled('kondisi_kendaraan')) {
            Unit::where('unit_id', $report->unit_id)->update([
                'kondisi_kendaraan' => $request->kondisi_kendaraan
            ]);
        }

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path = $file->store('anomali', 'public');
                $report->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.report')->with('success', 'Data laporan berhasil diperbarui!');
    }

    /**
     * Delete a specific image from a report.
     */
    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        
        // Delete file from storage
        \Storage::disk('public')->delete($image->path);
        
        // Delete record from database
        $image->delete();
        
        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $report = Report::where('laporan_id', $id)->firstOrFail();
        
        // Delete associated images
        foreach ($report->images as $image) {
            // Delete file from storage
            \Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        
        $report->delete();
        return redirect()->route('admin.report')->with('success', 'Data laporan berhasil dihapus!');
    }
}
