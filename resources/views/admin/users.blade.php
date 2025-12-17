@extends('admin.layout')

@section('title', 'Users - UP2D Pasundan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-outline-dark btn-sm d-lg-none" id="toggleSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="mb-1">Users</h1>
            <span class="text-muted">Manajemen pengguna sistem</span>
        </div>
        <button class="btn-add d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fa-solid fa-plus"></i> Add User
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->NIP ?? '-' }}</td> {{-- Menampilkan '-' jika NIP null --}}
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{-- Ambil role_name dari relasi, jika null anggap 'User' --}}
                                    @php
                                        // Perhatikan: Kita pakai 'role_name' sesuai file Role.php Anda
                                        $roleName = $user->role->role_name ?? 'User';

                                        $badgeClass = match ($roleName) {
                                            'Admin' => 'bg-success',
                                            'Assistant Manager' => 'bg-warning',
                                            'Pending' => 'bg-secondary',
                                            'User' => 'bg-primary', // Pastikan case 'User' tertangani
                                            default => 'bg-primary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">{{ $roleName }}</span>
                                </td>
                                <td class="text-center">
                                    {{-- Tombol Edit dengan Data Dinamis --}}
                                    <button class="btn-action edit btn-edit-user" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal" data-id="{{ $user->id }}" data-nama="{{ $user->name }}"
                                        data-nip="{{ $user->NIP }}" {{-- Pastikan case NIP sesuai model --}}
                                        data-email="{{ $user->email }}" data-role-id="{{ $user->role_id }}"> {{-- Kirim ID,
                                        bukan Object/Nama --}}
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    {{-- Tombol Delete (Disarankan menggunakan Form untuk keamanan) --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete ms-2"
                                            style="border:none; background:none;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Tambahkan Action ke route store dan Method POST --}}
                    <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" class="row g-3">
                        @csrf

                        <!-- Informasi Personal -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-user me-2"></i>Informasi Personal</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">NIP</label>
                            <input type="text" class="form-control" name="NIP" placeholder="Nomor Induk Pegawai" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                        </div>

                        <!-- Keamanan -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-lock me-2"></i>Keamanan</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                placeholder="Ulangi Password" required>
                        </div>

                        <!-- Akses -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-shield-halved me-2"></i>Hak Akses</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Role</label>
                            <select class="form-select" name="role_id" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    {{-- Tombol submit menunjuk ke ID form di atas --}}
                    <button type="submit" form="createUserForm" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Form Action akan di-set lewat Javascript --}}
                <form id="editUserForm" method="POST" class="row g-3">
                    @csrf
                    @method('PUT') {{-- Method Spoofing untuk Update --}}

                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Informasi Personal -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-user me-2"></i>Informasi Personal</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Nama</label>
                                <input type="text" class="form-control" id="editUserNama" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">NIP</label>
                                <input type="text" class="form-control" id="editUserNip" name="NIP" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email" required>
                            </div>

                            <!-- Keamanan -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-lock me-2"></i>Keamanan</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="editUserPassword" name="password" placeholder="Kosongkan jika tidak ubah">
                                <small class="text-muted" style="font-size: 0.75rem;">*Isi hanya jika ingin mengganti password</small>
                            </div>

                            <!-- Akses -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-shield-halved me-2"></i>Hak Akses</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Role</label>
                                <select class="form-select" id="editUserRole" name="role_id" required>
                                    <option value="" disabled>Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#usersTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                }
            });

            $('.btn-edit-user').on('click', function () {
                const button = $(this);

                // 1. Ambil data
                const id = button.data('id');
                const nama = button.data('nama');
                const nip = button.data('nip');
                const email = button.data('email');
                const roleId = button.data('role-id');

                // 2. Isi value ke input text biasa
                $('#editUserNama').val(nama);
                $('#editUserNip').val(nip);
                $('#editUserEmail').val(email);
                $('#editUserRole').val(roleId).change();

                // 3. [PENTING] Reset/Kosongkan kolom password
                // Kita tidak menampilkan password lama demi keamanan
                $('#editUserPassword').val('');

                // 4. Update Action URL
                let url = "{{ route('admin.users.update', ':id') }}";
                url = url.replace(':id', id);

                $('#editUserForm').attr('action', url);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        :root {
            --primary-dark: #002d3c;
        }

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

        .dataTables_wrapper {
            padding: 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.5rem;
        }

        .dataTables_length label,
        .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            color: #475569;
            font-size: 14px;
            margin: 0;
        }

        .dataTables_length select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 32px 8px 12px;
            font-size: 14px;
            color: #334155;
            background-color: #fff;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23475569' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .dataTables_length select:hover {
            border-color: #94a3b8;
        }

        .dataTables_length select:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(0, 45, 60, 0.1);
        }

        .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 14px;
            min-width: 200px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .dataTables_filter input:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(0, 45, 60, 0.1);
        }

        .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            margin: 0 2px;
        }

        .dataTables_paginate .paginate_button.current {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
            color: #fff !important;
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