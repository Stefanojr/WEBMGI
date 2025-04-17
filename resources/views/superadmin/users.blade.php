@extends('superadmin.layout.main')
@section('title', 'Risalah')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>DAFTAR USERS</h2>
            <!-- Tombol Tambah -->
           <button type="button" class="btn text-white" style="background-color: #446349;" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
    <i class="fas fa-user-plus"></i> Tambah User
</button>
        </div>

        <div class="table-responsive">
            <table id="userTable" class="table table-bordered table-striped">
                <thead class="table">
                    <tr>
                        <th>No</th>
                        <th>Perner</th>
                        <th>Nama User</th>
                        <th>Email User</th>
                        <th>Role User</th>
                        <th>Aktif</th>
                        <th>Nama Unit</th>
                        <th>Nama Perusahaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
               <tbody>
    @php $no = 1; @endphp
    @foreach ($users as $user)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $user->perner }}</td>
            <td>{{ $user->nama_user }}</td>
            <td>{{ $user->email_user }}</td>
            <td>{{ $user->role_user }}</td>
            <td>{{ $user->aktif ? 'Aktif' : 'Non-Aktif' }}</td>
            <td>{{ $user->unit ? $user->unit->nama_unit : 'N/A' }}</td>
            <td>{{ $user->perusahaan ? $user->perusahaan->nama_perusahaan : 'N/A' }}</td>
            <td class="d-flex gap-2">
                <!-- Edit Button -->
                <button type="button" class="btn btn-warning btn-sm btn-edit-user" data-id="{{ $user->id_user }}">
                    <i class="fas fa-edit"></i> Edit
                </button>

                <!-- Delete Button -->
            <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $user->id_user }}">
    <i class="fas fa-trash"></i> Delete
</button>


            </td>
        </tr>
    @endforeach
</tbody>

<!-- Delete Form (hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

            </table>
        </div>
    </div>

     <!-- Modal Tambah User -->
    <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
       <form id="formTambahUser" method="POST" action="{{ url('/users/store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahUserModalLabel">Tambah User Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                          <input type="hidden" name="_method" value="POST" id="form_method">
                        <input type="hidden" name="id_user" id="id_user">
                        <div class="mb-3">
                            <label for="perner" class="form-label">Perner</label>
                            <input type="text" class="form-control" name="perner" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_user" class="form-label">Nama User</label>
                            <input type="text" class="form-control" name="nama_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_user" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_user" class="form-label">Role</label>
                            <select name="role_user" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="superadmin">Superadmin</option>
                                <option value="komite">Komite</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="aktif" class="form-label">Status</label>
                            <select name="aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>
                         <div class="mb-3">
    <label for="id_perusahaan" class="form-label">Perusahaan</label>
    <select name="id_perusahaan" id="id_perusahaan" class="form-select" required>
        <option value="">-- Pilih Perusahaan --</option>
        @foreach($perusahaans as $perusahaan)
            <option value="{{ $perusahaan->id_perusahaan }}">{{ $perusahaan->nama_perusahaan }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="id_unit" class="form-label">Unit</label>
    <select name="id_unit" id="id_unit" class="form-select" required>
        <option value="">-- Pilih Unit --</option>
    </select>
</div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSimpanUser">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
    @push('scripts')
<script>
    $(document).ready(function () {
  $(document).on('click', '.deleteButton', function () {
    let userId = $(this).data('id');

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/users/delete/${userId}`,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}' // ← Gunakan token langsung di data
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Data berhasil dihapus!',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Hapus baris dari tabel (opsional, jika pakai table biasa)
                    $(`button[data-id="${userId}"]`).closest('tr').remove();

                    // Atau reload datatable / halaman jika perlu
                    location.reload();
                },
                error: function () {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    );
                }
            });
        }
    });
});

$('#btnSimpanUser').click(function () {
    let form = $('#formTambahUser');
    let formData = form.serialize(); // Mengambil data dari form
    let formAction = form.attr('action'); // URL action form
    let formMethod = $('#form_method').val(); // Method form, ini untuk menghandle method spoofing PUT jika perlu

    // Lakukan AJAX POST request
    $.ajax({
        url: formAction, // URL untuk menambahkan data
        type: 'POST', // Menggunakan POST untuk menambah data baru
        data: formData, // Mengirimkan data form
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token
        },
        success: function (response) {
           Swal.fire({
                title: 'Sukses!',
                text: 'Data berhasil disimpan.',
                icon: 'success',
                confirmButtonText: 'Tutup'
            });
            $('#tambahUserModal').modal('hide'); // Menutup modal
            location.reload(); // Reload halaman atau bisa diganti dengan refresh tabel menggunakan AJAX
        },
        error: function (xhr) {
            if (xhr.status === 422) { // Validasi gagal
                let errors = xhr.responseJSON.errors;
                let msg = '';
                $.each(errors, function (key, value) {
                    msg += `${value}<br>`; // Menampilkan pesan kesalahan
                });
                alert("Validasi Gagal:\n" + msg);
            } else {
                alert('Terjadi kesalahan saat menyimpan data.'); // Pesan kesalahan umum
            }
        }
    });
});



$('#btnTambahUser').click(function () {
    $('#formTambahUser')[0].reset();
    $('#form_method').val('POST');
    $('#formTambahUser').attr('action', "{{ url('/users/store') }}");
    $('#tambahUserModal').modal('show');
});


            $('#id_perusahaan').on('change', function () {
            var perusahaanId = $(this).val();

            $('#id_unit').html('<option value="">Memuat data unit...</option>');

            if (perusahaanId) {
                $.ajax({
                    url: '/unitByPerusahaan/' + perusahaanId,
                    type: 'GET',
                    success: function (data) {
                        var html = '<option value="">-- Pilih Unit --</option>';
                        data.forEach(function (unit) {
                            html += '<option value="' + unit.id_unit + '">' + unit.nama_unit + '</option>';
                        });
                        $('#id_unit').html(html);
                    },
                    error: function () {
                        alert('Gagal memuat data unit');
                        $('#id_unit').html('<option value="">-- Pilih Unit --</option>');
                    }
                });
            } else {
                $('#id_unit').html('<option value="">-- Pilih Unit --</option>');
            }
        });
    // Trigger ketika tombol edit diklik
    
    $('.btn-edit-user').click(function () {
        var id = $(this).data('id');

        $.ajax({
            url: '/users/edit/' + id,
            method: 'GET',
            success: function (data) {
                $('#tambahUserModal').modal('show');

                // Set form action
                $('#formTambahUser').attr('action', '/users/update/' + id);

                // Tambah method PUT kalau belum ada
                if ($('#form_method').length === 0) {
                    $('#formTambahUser').append('<input type="hidden" id="form_method" name="_method" value="PUT">');
                } else {
                    $('#form_method').val('PUT');
                }

                // Isi form
                $('[name="perner"]').val(data.perner);
                $('[name="nama_user"]').val(data.nama_user);
                $('[name="password"]').val('');
                $('[name="email_user"]').val(data.email_user);
                $('[name="role_user"]').val(data.role_user);
                $('[name="aktif"]').val(data.aktif);
                 $.ajax({
                    url: '/get-perusahaan-by-unit/' + data.id_unit,
                    method: 'GET',
                    success: function (res) {
                        $('[name="id_perusahaan"]').val(res.id_perusahaan).trigger('change');

                          $.ajax({
                    url: '/unitByPerusahaan/' + res.id_perusahaan,
                    type: 'GET',
                    success: function (dataUnit) {
                        var html = '<option value="">-- Pilih Unit --</option>';
                        dataUnit.forEach(function (dataUnit) {
                            html += '<option value="' + dataUnit.id_unit + '">' + dataUnit.nama_unit + '</option>';
                        });
 
                      
                        $('#id_unit').html(html);
                         $('[name="id_unit"]').val(data.id_unit).trigger('change');
                    },
                    error: function () {
                        alert('Gagal memuat data unit');
                        $('#id_unit').html('<option value="">-- Pilih Unit --</option>');
                    }
                });
                    },
                    error: function () {
                        alert('Gagal mengambil data perusahaan dari unit.');
                    }
                });
               
            },
            error: function () {
                alert('Gagal mengambil data user.');
            }
        });
    });
    });
</script>
@endpush

@endsection
