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
                    <tr>
                        <td>Sofiatu Zahra</td>
                        <td>12345678</td>
                        <td>xxx@gmail.com</td>
                        <td><span class="badge bg-primary">User</span></td>
                        <td class="text-center">
                            <button class="btn-action edit btn-edit-user" data-bs-toggle="modal" data-bs-target="#editUserModal" data-nama="Sofiatu Zahra Khalifah" data-nip="12345678" data-email="xxx@gmail.com" data-role="Assistant Manager">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    @foreach(range(1,7) as $index)
                    <tr>
                        <td>Sofiatu Zahra</td>
                        <td>12345678</td>
                        <td>xxx@gmail.com</td>
                        <td><span class="badge bg-success">Admin</span></td>
                        <td class="text-center">
                            <button class="btn-action edit btn-edit-user" data-bs-toggle="modal" data-bs-target="#editUserModal" data-nama="Sofiatu Zahra" data-nip="12345678" data-email="xxx@gmail.com" data-role="Admin">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action delete ms-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
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
                <form id="createUserForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" placeholder="Isi Nama" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" placeholder="Isi NIP" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Isi Email" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Role</label>
                        <select class="form-select" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option>User</option>
                            <option>Admin</option>
                            <option>Assistant Manager</option>
                            <option>Pending</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
            <div class="modal-body">
                <form id="editUserForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editUserNama">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" id="editUserNip">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="editUserEmail">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="editUserRole">
                            <option>User</option>
                            <option>Admin</option>
                            <option>Assistant Manager</option>
                            <option>Pending</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editUserForm" class="btn btn-primary">Edit</button>
            </div>
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
            $('#editUserNama').val(button.data('nama'));
            $('#editUserNip').val(button.data('nip'));
            $('#editUserEmail').val(button.data('email'));
            $('#editUserRole').val(button.data('role'));
        });
    });
</script>
@endpush

@push('styles')
<style>
.table-responsive { overflow-x: auto; }
table th, table td { white-space: nowrap; vertical-align: middle !important; }
table .text-center .d-flex { gap: .5rem; }
.dataTables_length, .dataTables_filter { margin-bottom: 1rem; }
.dataTables_length label, .dataTables_filter label { font-weight: 600; }
@media (max-width: 1000px) {
    .table-responsive { font-size: 13px; }
    .dataTables_length, .dataTables_filter { font-size: 13px; }
}
</style>
@endpush
