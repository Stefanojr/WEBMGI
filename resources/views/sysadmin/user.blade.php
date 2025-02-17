@extends('sysadmin.layout.main')

@section('title', 'Manajemen Pengguna')

@section('content')

<link rel="stylesheet" href="../../css/tableUserSysadmin.css">

<div class="table-container">
    <h2>Manajemen Pengguna</h2>

    <!-- Tombol Tambah Pengguna -->
    <div style="text-align: center; margin-bottom: 20px;">
        <button class="input-data-btn" onclick="openInputPopup()">+ Tambah Pengguna</button>
    </div>

    <!-- Tabel Pengguna -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Status</th>
                <th>Perner</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Role</th>
                <th>Unit</th>
                <th>Perusahaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td>
                        <button class="action-btn">
                            <i class="fas fa-toggle-{{ $user->aktif == 1 ? 'on' : 'off' }}"></i>
                        </button>
                    </td>
                    <td>{{ $user->perner }}</td>
                    <td>{{ $user->nama_user }}</td>
                    <td>{{ $user->email_user }}</td>
                    <td>{{ ucfirst($user->role_user) }}</td>
                    <td>{{ optional($user->unit)->nama_unit }}</td>
                    <td>{{ optional(optional($user->unit)->perusahaan)->nama_perusahaan }}</td>
                    <td>
                        <button class="edit-btn" onclick="openEditPopup({{ $user->id_user }})">Edit</button>
                        <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Popup untuk Menambah Pengguna -->
<div class="popup-overlay" id="input-popup" onclick="closeInputPopup()">
    <div class="popup-content" onclick="event.stopPropagation()">
        <h3>Tambah Pengguna Baru</h3>
        <form id="data-form" method="POST" action="{{ route('users.insert') }}">
            @csrf
            <!-- Input Data Pengguna -->
            <div>
                <label for="perner">Perner:</label><br>
                <input type="text" id="perner" name="perner" value="{{ old('perner') }}" required>
                @error('perner') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="nama_user">Nama Pengguna:</label><br>
                <input type="text" id="nama_user" name="nama_user" value="{{ old('nama_user') }}" required>
                @error('nama_user') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="email_user">Email:</label><br>
                <input type="email" id="email_user" name="email_user" value="{{ old('email_user') }}" required>
                @error('email_user') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
                @error('password') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="role_user">Role:</label><br>
                <select id="role_user" name="role_user" required>
                    <option value="admin" {{ old('role_user') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ old('role_user') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="user" {{ old('role_user') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div>
                <label for="id_unit">Unit:</label><br>
                <select id="id_unit" name="id_unit" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id_unit }}" {{ old('id_unit') == $unit->id_unit ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" style="background-color: #27ae60; color: white;">Simpan</button>
            <button type="button" class="close-btn" onclick="closeInputPopup()">Tutup</button>
        </form>
    </div>
</div>

<!-- Popup untuk Edit Pengguna -->
<div class="popup-overlay" id="edit-popup" onclick="closeEditPopup()">
    <div class="popup-content" onclick="event.stopPropagation()">
        <h3>Edit Pengguna</h3>
        <form id="edit-form" method="POST" action="{{ route('users.update', ':id_user') }}">
            @csrf
            @method('PUT') <!-- Pastikan metode PUT untuk update -->
            <input type="hidden" id="edit-id_user" name="id_user">
            <div>
                <label for="edit-perner">Perner:</label><br>
                <input type="text" id="edit-perner" name="perner" required>
            </div>
            <div>
                <label for="edit-nama_user">Nama Pengguna:</label><br>
                <input type="text" id="edit-nama_user" name="nama_user" required>
            </div>
            <div>
                <label for="edit-email_user">Email:</label><br>
                <input type="email" id="edit-email_user" name="email_user" required>
            </div>
            <div>
                <label for="edit-role_user">Role:</label><br>
                <select id="edit-role_user" name="role_user" required>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div>
                <label for="edit-id_unit">Unit:</label><br>
                <select id="edit-id_unit" name="id_unit" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" style="background-color: #27ae60; color: white;">Simpan</button>
            <button type="button" class="close-btn" onclick="closeEditPopup()">Tutup</button>
        </form>
    </div>
</div>

<script>
    function openInputPopup() {
        document.getElementById('edit-popup').style.display = 'none';
        document.getElementById('input-popup').style.display = 'block';
    }

    function closeInputPopup() {
        document.getElementById('input-popup').style.display = 'none';
    }

    function openEditPopup(userId) {
        fetch(`/users/${userId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-id_user').value = data.id_user;
                document.getElementById('edit-perner').value = data.perner;
                document.getElementById('edit-nama_user').value = data.nama_user;
                document.getElementById('edit-email_user').value = data.email_user;
                document.getElementById('edit-role_user').value = data.role_user;
                document.getElementById('edit-id_unit').value = data.id_unit;
                document.getElementById('edit-popup').style.display = 'block';
            })
            .catch(error => console.error('Error:', error));
    }

    function closeEditPopup() {
        document.getElementById('edit-popup').style.display = 'none';
    }
</script>
@endsection
