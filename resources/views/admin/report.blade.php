@extends('admin.layout')

@section('title', 'Pelaporan Unit - UP2D Pasundan')

@push('styles')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        table th,
        table td {
            white-space: nowrap;
            vertical-align: middle !important;
        }

        table .text-center .d-flex {
            gap: .5rem;
        }

        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_length label,
        .dataTables_filter label {
            font-weight: 600;
        }

        .badge-ups {
            background-color: #3b82f6;
            color: #fff;
        }

        .badge-ukb {
            background-color: #10b981;
            color: #fff;
        }

        .badge-deteksi {
            background-color: #f59e0b;
            color: #fff;
        }

        .report-photo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 4px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .report-photo:hover {
            transform: scale(1.1);
        }

        .photo-container {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        @media (max-width: 1000px) {
            .table-responsive {
                font-size: 13px;
            }

            .dataTables_length,
            .dataTables_filter {
                font-size: 13px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-outline-dark btn-sm d-lg-none" id="toggleSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="mb-1">Pelaporan Unit</h1>
            <span class="text-muted">Laporan kondisi dan anomali unit</span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="reportTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama Pelapor</th>
                            <th>Unit</th>
                            <th>Kapasitas / Panjang / Fitur</th>
                            <th>Nopol</th>
                            <th>Kondisi Kendaraan</th>
                            <th>Tanggal Kejadian</th>
                            <th>Lokasi Penggunaan</th>
                            <th>No. BA</th>
                            <th>Posko Pelaksana</th>
                            <th>UP3</th>
                            <th>Keterangan</th>
                            <th>Keperluan Anggaran</th>
                            <th>Bukti Foto</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $item)
                            @php
                                $tipePeralatan = $item->unit->tipe_peralatan ?? '-';

                                // Determine kapasitas/panjang/fitur based on equipment type
                                if ($tipePeralatan === 'UPS') {
                                    $kapasitasPanjangFitur = $item->unit->detailUps->kapasitas_kva ?? '-';
                                    if ($kapasitasPanjangFitur !== '-')
                                        $kapasitasPanjangFitur .= ' KVA';
                                } elseif ($tipePeralatan === 'UKB') {
                                    $kapasitasPanjangFitur = $item->unit->detailUkb->panjang_kabel_m ?? '-';
                                    if ($kapasitasPanjangFitur !== '-')
                                        $kapasitasPanjangFitur .= ' m';
                                } elseif ($tipePeralatan === 'Deteksi' || $tipePeralatan === 'DETEKSI') {
                                    $kapasitasPanjangFitur = $item->unit->detailDeteksi->fitur ?? '-';
                                } else {
                                    $kapasitasPanjangFitur = '-';
                                }

                                // Format tanggal kejadian
                                $tglKejadian = $item->tgl_kejadian
                                    ? \Carbon\Carbon::parse($item->tgl_kejadian)->format('d M Y')
                                    : '-';

                                // Posko Pelaksana (gabung lokasi dari unit)
                                $posko = $item->unit->lokasi ?? '-';

                                // Format anggaran
                                $anggaran = $item->keperluan_anggaran
                                    ? 'Rp ' . number_format($item->keperluan_anggaran, 0, ',', '.')
                                    : '-';

                                // Badge class based on type
                                $badgeClass = match ($tipePeralatan) {
                                    'UPS' => 'badge-ups',
                                    'UKB' => 'badge-ukb',
                                    'Deteksi', 'DETEKSI' => 'badge-deteksi',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <tr>
                                <td>{{ $item->userPelapor->name ?? '-' }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ $tipePeralatan }}</span></td>
                                <td>{{ $kapasitasPanjangFitur }}</td>
                                <td>{{ $item->unit->nopol ?? '-' }}</td>
                                <td>
                                    @php
                                        $kondisiClass = match ($item->unit->kondisi_kendaraan ?? '') {
                                            'BAIK' => 'green',
                                            'DIGUNAKAN' => 'yellow',
                                            'RUSAK', 'PERBAIKAN' => 'red',
                                            default => 'yellow'
                                        };
                                    @endphp
                                    <span class="badge-status {{ $kondisiClass }}">{{ $item->unit->kondisi_kendaraan ?? '-' }}</span>
                                </td>
                                <td>{{ $tglKejadian }}</td>
                                <td>{{ $item->lokasi_penggunaan ?? '-' }}</td>
                                <td>{{ $item->no_ba ?? '-' }}</td>
                                <td>{{ $posko }}</td>
                                <td>{{ $item->up3 ?? '-' }}</td>
                                <td>{{ $item->deskripsi_kerusakan ?? '-' }}</td>
                                <td>{{ $anggaran }}</td>
                                <td>
                                    <div class="photo-container">
                                        @forelse($item->images as $image)
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Bukti Foto" class="report-photo"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImage('{{ asset('storage/' . $image->path) }}')">
                                        @empty
                                            <span class="text-muted">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn-action edit btn-edit-report" data-bs-toggle="modal"
                                        data-bs-target="#editReportModal" data-id="{{ $item->laporan_id }}"
                                        data-nama="{{ $item->userPelapor->name ?? '' }}" data-peralatan="{{ $tipePeralatan }}"
                                        data-nopol="{{ $item->unit->nopol ?? '' }}"
                                        data-kondisi="{{ $item->unit->kondisi_kendaraan ?? '' }}"
                                        data-tgl-kejadian="{{ $item->tgl_kejadian ? \Carbon\Carbon::parse($item->tgl_kejadian)->format('Y-m-d') : '' }}"
                                        data-lokasi="{{ $item->lokasi_penggunaan ?? '' }}" data-no-ba="{{ $item->no_ba ?? '' }}"
                                        data-up3="{{ $item->up3 ?? '' }}"
                                        data-keterangan="{{ $item->deskripsi_kerusakan ?? '' }}"
                                        data-anggaran="{{ $item->keperluan_anggaran ?? '' }}"
                                        data-images='@json($item->images->map(fn($img) => ["id" => $img->id, "path" => $img->path]))'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-action delete ms-2" data-id="{{ $item->laporan_id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="Preview" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Report Modal -->
    <div class="modal fade" id="editReportModal" tabindex="-1" aria-labelledby="editReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReportModalLabel">Edit Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editReportForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Informasi Pelapor -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-user me-2"></i>Informasi Pelapor</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Pelapor</label>
                                <input type="text" class="form-control" id="reportNama" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" id="reportPeralatan" readonly>
                            </div>

                            <!-- Informasi Unit -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-bolt me-2"></i>Informasi Unit</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nopol</label>
                                <input type="text" class="form-control" id="reportNopol" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Kejadian</label>
                                <input type="date" class="form-control" name="tgl_kejadian" id="reportTglKejadian">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lokasi Penggunaan</label>
                                <input type="text" class="form-control" name="lokasi_penggunaan" id="reportLokasi">
                            </div>

                            <!-- Detail Kejadian -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-calendar-days me-2"></i>Detail Kejadian</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. BA</label>
                                <input type="text" class="form-control" name="no_ba" id="reportNoBA">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">UP3</label>
                                <input type="text" class="form-control" name="up3" id="reportUp3">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" rows="3" name="deskripsi_kerusakan" id="reportKeterangan"></textarea>
                            </div>

                            <!-- Anggaran & Dokumentasi -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-money-bill me-2"></i>Anggaran & Dokumentasi</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keperluan Anggaran</label>
                                <input type="number" class="form-control" name="keperluan_anggaran" id="reportAnggaran" placeholder="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kondisi Kendaraan</label>
                                <select class="form-select" name="kondisi_kendaraan" id="reportKondisi">
                                    <option value="BAIK">Baik</option>
                                    <option value="DIGUNAKAN">Digunakan</option>
                                    <option value="RUSAK">Rusak</option>
                                    <option value="PERBAIKAN">Perbaikan</option>
                                </select>
                            </div>

                            <!-- Existing Images Section -->
                            <div class="col-12">
                                <label class="form-label">Foto yang Ada</label>
                                <div id="existingImagesContainer" class="d-flex flex-wrap gap-2 mb-2">
                                    <!-- Images will be loaded dynamically -->
                                    <p class="text-muted small" id="noImagesText">Tidak ada foto</p>
                                </div>
                            </div>

                            <!-- Upload New Images -->
                            <div class="col-12">
                                <label class="form-label">Tambah Foto Baru</label>
                                <input type="file" name="new_images[]" id="newImages" multiple
                                    accept="image/jpeg,image/jpg,image/png" class="form-control">
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 5MB per file.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus laporan ini?</p>
                    <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Show image in modal
        function showImage(src) {
            document.getElementById('previewImage').src = src;
        }

        // Delete image function
        function deleteImage(imageId, element) {
            if (!confirm('Hapus foto ini?')) return;

            $.ajax({
                url: '/admin/report/image/' + imageId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Remove image element from DOM
                    $(element).closest('.image-item').remove();
                    // Check if no images left
                    if ($('#existingImagesContainer .image-item').length === 0) {
                        $('#noImagesText').show();
                    }
                },
                error: function (xhr) {
                    alert('Gagal menghapus foto: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }

        $(function () {
            // Initialize DataTable
            $('#reportTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                scrollX: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            // Edit button handler
            $(document).on('click', '.btn-edit-report', function () {
                const button = $(this);
                const id = button.data('id');

                // Set form action URL
                $('#editReportForm').attr('action', '/admin/report/' + id);

                // Populate form fields
                $('#reportNama').val(button.data('nama'));
                $('#reportPeralatan').val(button.data('peralatan'));
                $('#reportNopol').val(button.data('nopol'));
                $('#reportKondisi').val(button.data('kondisi'));
                $('#reportTglKejadian').val(button.data('tgl-kejadian'));
                $('#reportLokasi').val(button.data('lokasi'));
                $('#reportNoBA').val(button.data('no-ba'));
                $('#reportUp3').val(button.data('up3'));
                $('#reportKeterangan').val(button.data('keterangan'));
                $('#reportAnggaran').val(button.data('anggaran'));

                // Clear file input
                $('#newImages').val('');

                // Load existing images
                const container = $('#existingImagesContainer');
                container.empty();

                const images = button.data('images') || [];
                if (images.length === 0) {
                    container.html('<p class="text-muted small" id="noImagesText">Tidak ada foto</p>');
                } else {
                    images.forEach(function(img) {
                        container.append(`
                            <div class="image-item position-relative" style="display: inline-block;">
                                <img src="/storage/${img.path}"
                                     alt="Foto"
                                     class="rounded"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                <button type="button"
                                        class="btn btn-danger btn-sm position-absolute"
                                        style="top: -5px; right: -5px; padding: 2px 6px; font-size: 10px;"
                                        onclick="deleteImage(${img.id}, this)">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        `);
                    });
                }
            });

            // Delete button handler
            $(document).on('click', '.btn-action.delete', function () {
                const id = $(this).data('id');
                // Set form action URL for delete
                $('#deleteForm').attr('action', '/admin/report/' + id);
                // Show confirmation modal
                $('#deleteConfirmModal').modal('show');
            });
        });
    </script>
@endpush