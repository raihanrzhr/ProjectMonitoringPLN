@extends('admin.layout')

@section('title', 'Users - UP2D Pasundan')

@section('content')
    <div class="page-header-sticky d-flex justify-content-between align-items-center mb-4">
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

    {{-- Success Notification --}}
    <div id="successNotification" class="notification-toast" style="display: none;">
        <div class="notification-content notification-success">
            <i class="fa-solid fa-check-circle me-2"></i>
            <span id="notificationMessage"></span>
            <button type="button" class="notification-close" onclick="hideNotification()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </div>

    {{-- Error Notification --}}
    <div id="errorNotification" class="notification-toast" style="display: none;">
        <div class="notification-content notification-error">
            <i class="fa-solid fa-circle-xmark me-2"></i>
            <span id="errorNotificationMessage"></span>
            <button type="button" class="notification-close" onclick="hideErrorNotification()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </div>

    {{-- Show notification from session flash --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification("{{ session('success') }}");
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showErrorNotification("{{ session('error') }}");
            });
        </script>
    @endif

    <div class="scrollable-content-wrapper">
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

                                    {{-- Tombol Delete dengan Custom Modal --}}
                                    <button type="button" class="btn-action delete ms-2 btn-delete-user"
                                        data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                        data-id="{{ $user->id }}" data-nama="{{ $user->name }}"
                                        style="border:none; background:none;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
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
                            <input type="text" class="form-control" name="name" id="createName" placeholder="Nama Lengkap" required>
                            <div class="invalid-feedback-custom" id="error-name"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">NIP</label>
                            <input type="text" class="form-control" name="NIP" id="createNIP" placeholder="Nomor Induk Pegawai" required>
                            <div class="invalid-feedback-custom" id="error-NIP"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email" id="createEmail" placeholder="email@example.com" required>
                            <div class="invalid-feedback-custom" id="error-email"></div>
                        </div>

                        <!-- Keamanan -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-lock me-2"></i>Keamanan</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Password</label>
                            <input type="password" class="form-control" name="password" id="createPassword" placeholder="Password" required>
                            <div class="invalid-feedback-custom" id="error-password"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="createPasswordConfirmation" placeholder="Ulangi Password" required>
                            <div class="invalid-feedback-custom" id="error-password_confirmation"></div>
                        </div>

                        <!-- Akses -->
                        <div class="col-12">
                            <div class="form-section-title"><i class="fa-solid fa-shield-halved me-2"></i>Hak Akses</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Role</label>
                            <select class="form-select" name="role_id" id="createRoleId" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback-custom" id="error-role_id"></div>
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
                                <div class="invalid-feedback-custom" id="edit-error-name"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">NIP</label>
                                <input type="text" class="form-control" id="editUserNip" name="NIP" required>
                                <div class="invalid-feedback-custom" id="edit-error-NIP"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email" required>
                                <div class="invalid-feedback-custom" id="edit-error-email"></div>
                            </div>

                            <!-- Keamanan -->
                            <div class="col-12">
                                <div class="form-section-title"><i class="fa-solid fa-lock me-2"></i>Keamanan</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="editUserPassword" name="password" placeholder="Kosongkan jika tidak ubah">
                                <div class="invalid-feedback-custom" id="edit-error-password"></div>
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
                                <div class="invalid-feedback-custom" id="edit-error-role_id"></div>
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

    {{-- Delete User Confirmation Modal --}}
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content delete-modal-content">
                <div class="modal-body text-center py-4">
                    <div class="delete-icon-wrapper mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h5 class="mb-2">Hapus User?</h5>
                    <p class="text-muted mb-0">Anda akan menghapus user:</p>
                    <p class="fw-semibold mb-3" id="deleteUserName"></p>
                    <p class="text-muted small mb-4">Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <form id="deleteUserForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fa-solid fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Notification functions (global scope for inline onclick)
        function showNotification(message) {
            $('#notificationMessage').text(message);
            $('#successNotification').fadeIn(300);
            
            // Auto hide after 5 seconds
            setTimeout(function() {
                hideNotification();
            }, 5000);
        }
        
        function hideNotification() {
            $('#successNotification').fadeOut(300);
        }

        // Error notification functions
        function showErrorNotification(message) {
            $('#errorNotificationMessage').text(message);
            $('#errorNotification').fadeIn(300);
            
            // Auto hide after 8 seconds (longer for error)
            setTimeout(function() {
                hideErrorNotification();
            }, 8000);
        }
        
        function hideErrorNotification() {
            $('#errorNotification').fadeOut(300);
        }

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

            // Check for success message from AJAX redirect
            const successMessage = sessionStorage.getItem('successMessage');
            if (successMessage) {
                showNotification(successMessage);
                sessionStorage.removeItem('successMessage');
            }

            // Handle delete button click
            $('.btn-delete-user').on('click', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                
                // Set user name in modal
                $('#deleteUserName').text(nama);
                
                // Set form action URL
                let url = "{{ route('admin.users.destroy', ':id') }}";
                url = url.replace(':id', id);
                $('#deleteUserForm').attr('action', url);
            });

            // Clear all validation errors
            function clearValidationErrors() {
                $('.invalid-feedback-custom').text('').hide();
                $('#createUserForm .form-control, #createUserForm .form-select').removeClass('is-invalid');
            }

            // Show validation errors
            function showValidationErrors(errors) {
                clearValidationErrors();
                $.each(errors, function(field, messages) {
                    const $input = $('#createUserForm [name="' + field + '"]');
                    const $error = $('#error-' + field);
                    
                    $input.addClass('is-invalid');
                    $error.text(messages[0]).show();
                });
            }

            // Handle create user form submission via AJAX
            $('#createUserForm').on('submit', function(e) {
                e.preventDefault();
                
                clearValidationErrors();
                
                const $form = $(this);
                const $submitBtn = $('button[form="createUserForm"]');
                const originalText = $submitBtn.html();
                
                // Disable button and show loading
                $submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Adding...');
                
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        // Store message for display after redirect
                        sessionStorage.setItem('successMessage', response.message);
                        window.location.href = "{{ route('admin.users') }}";
                    },
                    error: function(xhr) {
                        // Re-enable button
                        $submitBtn.prop('disabled', false).html(originalText);
                        
                        if (xhr.status === 422) {
                            // Validation error - show errors
                            const errors = xhr.responseJSON.errors;
                            showValidationErrors(errors);
                        } else {
                            // Other error
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            });

            // Clear errors when modal is closed
            $('#createUserModal').on('hidden.bs.modal', function() {
                clearValidationErrors();
                $('#createUserForm')[0].reset();
            });

            // Clear edit form validation errors
            function clearEditValidationErrors() {
                $('#editUserForm .invalid-feedback-custom').text('').hide();
                $('#editUserForm .form-control, #editUserForm .form-select').removeClass('is-invalid');
            }

            // Show edit form validation errors
            function showEditValidationErrors(errors) {
                clearEditValidationErrors();
                $.each(errors, function(field, messages) {
                    const $input = $('#editUserForm [name="' + field + '"]');
                    const $error = $('#edit-error-' + field);
                    
                    $input.addClass('is-invalid');
                    $error.text(messages[0]).show();
                });
            }

            $('.btn-edit-user').on('click', function () {
                const button = $(this);

                // Clear previous errors
                clearEditValidationErrors();

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

            // Handle edit user form submission via AJAX
            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();
                
                clearEditValidationErrors();
                
                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const originalText = $submitBtn.html();
                
                // Disable button and show loading
                $submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...');
                
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        // Store message for display after redirect
                        sessionStorage.setItem('successMessage', response.message);
                        window.location.href = "{{ route('admin.users') }}";
                    },
                    error: function(xhr) {
                        // Re-enable button
                        $submitBtn.prop('disabled', false).html(originalText);
                        
                        if (xhr.status === 422) {
                            // Validation error - show errors
                            const errors = xhr.responseJSON.errors;
                            showEditValidationErrors(errors);
                        } else {
                            // Other error
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            });

            // Clear errors when edit modal is closed
            $('#editUserModal').on('hidden.bs.modal', function() {
                clearEditValidationErrors();
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        :root {
            --primary-dark: #0f172a;
        }

        /* Success Notification Toast */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .notification-content {
            display: flex;
            align-items: center;
            color: white;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
        }

        .notification-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .notification-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        .notification-content i.fa-check-circle,
        .notification-content i.fa-circle-xmark {
            font-size: 18px;
        }

        .notification-close {
            background: none;
            border: none;
            color: white;
            margin-left: 12px;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
            padding: 4px;
        }

        .notification-close:hover {
            opacity: 1;
        }

        /* Delete Confirmation Modal Styles */
        .delete-modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .delete-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .delete-icon-wrapper i {
            font-size: 28px;
            color: #d97706;
        }

        .delete-modal-content h5 {
            font-weight: 600;
            color: #1f2937;
        }

        .delete-modal-content .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .delete-modal-content .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .delete-modal-content .btn-outline-secondary {
            font-weight: 500;
            border-radius: 8px;
        }

        .delete-modal-content .btn-danger {
            border-radius: 8px;
        }

        /* Validation Error Styles */
        .invalid-feedback-custom {
            display: none;
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 4px;
            font-weight: 500;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
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

        /* Page Header Sticky */
        .page-header-sticky {
            position: sticky;
            top: 0;
            background: var(--bg-soft, #f5f8ff);
            z-index: 100;
            padding-bottom: 16px;
        }

        /* Scrollable Content Wrapper - X and Y */
        .scrollable-content-wrapper {
            max-height: calc(100vh - 180px);
            max-width: calc(100vw - 305px);
            overflow-y: auto;
            overflow-x: auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
        }

        /* Mobile responsive - when sidebar is hidden */
        @media (max-width: 991.98px) {
            .scrollable-content-wrapper {
                max-width: 100%;
                max-height: calc(100vh - 200px);
                overflow-x: auto;
                overflow-y: auto;
            }

            .scrollable-content-wrapper > .card {
                min-width: 800px;
            }
        }
    </style>
@endpush