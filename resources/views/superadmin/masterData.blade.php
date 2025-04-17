@extends('superadmin.layout.main')
@section('title', 'Perusahaan')

@section('content')
<div class="table-container">
    <h2>DAFTAR PERUSAHAAN</h2>
    <button id="addBtn" class="popup-btn-id">+ Tambah Perusahaan</button>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama Perusahaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
<tbody id="perusahaanTable">
    @foreach ($perusahaans as $key => $perusahaan)
    <tr data-id="{{ $perusahaan->id_perusahaan }}">
        <td>{{ $key + 1 }}</td>
        <td>{{ $perusahaan->id_perusahaan }}</td>
        <!-- Nama Perusahaan yang dibungkus dalam button -->
        <td>
            <button class="btn-nama-perusahaan" onclick="showModal({{ $perusahaan->id_perusahaan }})">
                {{ $perusahaan->nama_perusahaan }}
            </button>
        </td>
        <td>
            <button class="btn-edit" data-id="{{ $perusahaan->id_perusahaan }}">Edit</button>
            <button class="btn-delete" data-id="{{ $perusahaan->id_perusahaan }}">Hapus</button>
        </td>
    </tr>
    @endforeach
</tbody>


    </table>
</div>


<!-- Modal -->
<div class="overlay" id="overlay" style="display:none;"></div>

<div class="popup-container fade-in" id="popup" style="display:none;">
    <h3 id="formTitle" class="popup-title">Tambah Perusahaan</h3>
    <form id="perusahaanForm">
        @csrf
        <input type="hidden" name="id_perusahaan" id="id_perusahaan">
        
        <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" id="nama_perusahaan" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="submit-btn">Simpan</button>
            <button type="button" id="btnBatal" class="insert-btn">Batal</button>
        </div>
    </form>
</div>


<!-- Modal (Popup) -->

<div id="modalPerusahaan" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Data Unit</h3>

        <!-- 🔹 Form Perusahaan (bukan untuk tambah unit) -->
        <form id="perusahaanForm">
            @csrf
            <input type="hidden" name="id_perusahaan" id="modalIdPerusahaan">
            <!-- Form data perusahaan lain bisa ditambahkan di sini jika perlu -->
        </form>

     <!-- Form Tambah / Edit Unit -->
<form id="formTambahUnit" onsubmit="submitUnit(event)">
    @csrf
    <input type="hidden" id="unit_id_perusahaan" name="id_perusahaan">
    <input type="hidden" id="unit_id_editing"> <!-- untuk menyimpan id_unit saat edit -->
    
    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <input type="text" id="nama_unit_baru" name="nama_unit" placeholder="Nama Unit" required class="form-control" />
        <button type="submit" class="submit-btn" id="btnSubmitUnit">Tambah</button>
    </div>
</form>



        <!-- 🔹 Tabel Unit -->
        <div class="unit-table-wrapper">
            <table id="unitDataTable" class="table">
                <thead>
                    <tr>
                        <th>ID Unit</th>
                        <th>Nama Unit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="unitDataList"></tbody>
            </table>
        </div>
    </div>
</div>





<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function showModal(id_perusahaan) {
    document.getElementById('modalPerusahaan').style.display = 'flex';
    document.getElementById('modalIdPerusahaan').value = id_perusahaan;
    document.getElementById('unit_id_perusahaan').value = id_perusahaan;

    fetch(`/unitByPerusahaan/${id_perusahaan}`)
        .then(res => res.json())
        .then(data => {
            const unitList = document.getElementById('unitDataList');
            unitList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(unit => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${unit.id_unit}</td>
                        <td>${unit.nama_unit}</td>
                        <td>
                            <button class="btn-edit" onclick="editUnit(${unit.id_unit})">Edit</button>
                            <button class="btn-delete" onclick="deleteUnit(${unit.id_unit})">Hapus</button>
                        </td>
                    `;
                    unitList.appendChild(tr);
                });
            } else {
                unitList.innerHTML = `<tr><td colspan="3">Tidak ada data unit</td></tr>`;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Gagal memuat data unit.');
        });
}


function closeModal() {
    // Menutup modal
    document.getElementById('modalPerusahaan').style.display = 'none';
}
function submitUnit(event) {
    event.preventDefault();

    const id_perusahaan = document.getElementById('unit_id_perusahaan').value;
    const id_unit = document.getElementById('unit_id_editing').value;
    const nama_unit = document.getElementById('nama_unit_baru').value;
    const token = document.querySelector('input[name="_token"]').value;

    let url = '/units';
    let method = 'POST';
    let body = {
        id_perusahaan,
        nama_unit
    };

if (id_unit) {
    // Jika sedang mengedit
    url = `/units/${id_unit}`;
    method = 'POST'; // HARUS POST karena spoofing
    body = {
        _method: 'PUT', // spoofing untuk Laravel (web.php)
        nama_unit
    };
}

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest' // penting untuk web.php route
        },
        body: JSON.stringify(body)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Reset form
            document.getElementById('nama_unit_baru').value = '';
            document.getElementById('unit_id_editing').value = '';
            document.getElementById('btnSubmitUnit').innerText = 'Tambah';

            refreshUnitList(id_perusahaan);
        } else {
            alert('Gagal menyimpan unit.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat menyimpan unit.');
    });
}



function refreshUnitList(id_perusahaan) {
    fetch(`/unitByPerusahaan/${id_perusahaan}`)
        .then(res => res.json())
        .then(data => {
            const unitList = document.getElementById('unitDataList');
            unitList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(unit => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${unit.id_unit}</td>
                        <td>${unit.nama_unit}</td>
                        <td>
                            <button class="btn-edit" onclick="editUnit(${unit.id_unit})">Edit</button>
                            <button class="btn-delete" onclick="deleteUnit(${unit.id_unit})">Hapus</button>
                        </td>
                    `;
                    unitList.appendChild(tr);
                });
            } else {
                unitList.innerHTML = `<tr><td colspan="3">Tidak ada data unit</td></tr>`;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Gagal memuat data unit.');
        });
}



function editUnit(id_unit) {
    fetch(`/units/detail/${id_unit}`)
        .then(res => res.json())
        .then(unit => {
            console.log(unit); // Tambahkan ini untuk debugging

            document.getElementById('unit_id_editing').value = unit.id_unit;
            document.getElementById('nama_unit_baru').value = unit.nama_unit;
            document.getElementById('btnSubmitUnit').innerText = 'Simpan';
        })
        .catch(err => {
            console.error(err);
            alert('Gagal memuat data unit.');
        });
}


function deleteUnit(id_unit) {
    if (confirm('Apakah Anda yakin ingin menghapus unit ini?')) {
        fetch(`/units/${id_unit}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const id_perusahaan = document.getElementById('unit_id_perusahaan').value;
                showModal(id_perusahaan); // Refresh data
            } else {
                alert('Gagal menghapus unit.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus unit.');
        });
    }
}


    function resetForm() {
        $('#formTitle').text('Tambah Perusahaan');
        $('#perusahaanForm')[0].reset();
        $('#id_perusahaan').val('');
    }

    // Show modal
    $('#addBtn').on('click', function() {
        resetForm();
        $('#popup, #overlay').show();
    });

    // Hide modal
    $('#btnBatal, #overlay').on('click', function() {
        $('#popup, #overlay').hide();
        resetForm();
    });

    // Submit form
    $('#perusahaanForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('perusahaan.store') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                location.reload(); // Reload page to show new data
            }
        });
    });

    // Edit button click
    $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        $.get("/perusahaan/" + id, function(data) {
            $('#formTitle').text('Edit Perusahaan');
            $('#id_perusahaan').val(data.id_perusahaan);
            $('#nama_perusahaan').val(data.nama_perusahaan);
            $('#popup, #overlay').show();
        });
    });

    // Delete button
    $('.btn-delete').on('click', function() {
        if (confirm('Yakin ingin hapus?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/perusahaan/' + id,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(result) {
                    location.reload();
                }
            });
        }
    });
</script>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        background-color: #ffffff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border-radius: 12px;
        overflow: hidden;
    }

    table thead {
        background: linear-gradient(to right, #4a6b4f, #6ca175);
        color: white;
    }

    table th, table td {
        text-align: left;
        padding: 12px 16px;
        font-size: 14px;
    }

    table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s ease;
    }

    table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .btn-edit,
    .btn-delete {
        padding: 6px 12px;
        font-size: 13px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-edit {
        background-color: #3498db;
        color: white;
        margin-right: 8px;
    }

    .btn-edit:hover {
        background-color: #2980b9;
    }

    .btn-delete {
        background-color: #e74c3c;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c0392b;
    }

    .overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
        z-index: 999;
    }

    .popup-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 40px 30px;
        width: 90%;
        max-width: 500px;
        z-index: 1000;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.3s ease-in-out;
    }

    .popup-title {
        font-size: 18px;
        font-weight: 600;
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }

    .popup-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #4a6b4f, #6ca175);
        transform: translateX(-50%);
        border-radius: 3px;
    }

    .popup-container .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .popup-container .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        margin-bottom: 6px;
    }

    .popup-container .form-group input {
        padding: 12px 15px;
        font-size: 14px;
        border: 1px solid #e1e5e9;
        border-radius: 8px;
        background-color: #f9fafb;
        transition: 0.3s;
    }

    .popup-container .form-group input:focus {
        border-color: #4a6b4f;
        background-color: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 107, 79, 0.1);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    .popup-btn-id {
        background: linear-gradient(135deg, #4a6b4f 0%, #3d5a41 100%);
        color: #fff;
        padding: 12px 30px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(74, 107, 79, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .popup-btn-id:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(74, 107, 79, 0.3);
    }

    .popup-btn-id:active {
        transform: translateY(0);
    }
    .submit-btn {
        background: linear-gradient(135deg, #4a6b4f 0%, #3d5a41 100%);
        color: #fff;
        padding: 12px 30px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(74, 107, 79, 0.2);
        display: inline-block;
    }

    .insert-btn {
        background: linear-gradient(135deg, #4d7dc4 0%, #3b6ab3 100%);
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(77, 125, 196, 0.2);
        display: inline-block;
        margin-left: 10px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(74, 107, 79, 0.3);
    }

    .insert-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(77, 125, 196, 0.3);
    }

    .submit-btn:active,
    .insert-btn:active {
        transform: translateY(0);
    }
    .modal {
        display: none; /* Awalnya modal disembunyikan */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Background semi-transparan */
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
        max-width: 600px;
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }


    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .submit-btn, .insert-btn {
        width: 100px;
        padding: 10px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
    }

    .submit-btn {
        background: linear-gradient(135deg, #4a6b4f 0%, #3d5a41 100%);
        color: white;
    }

    .insert-btn {
        background: linear-gradient(135deg, #4d7dc4 0%, #3b6ab3 100%);
        color: white;
    }
    .btn-nama-perusahaan {
        background: none;
        border: none;
        color: #4a6b4f;
        font-size: 14px;
        font-weight: 600;
        text-align: left;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: underline;
    }

    .btn-nama-perusahaan:hover {
        color: #6ca175;
    }

    /* Gaya Tabel di Modal unit*/
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
    }

    .table td {
        background-color: #fff;
    }

    .table button {
        padding: 5px 10px;
        margin: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .table .btn-edit {
        background-color: #4cae4c;
        color: white;
    }

    .table .btn-delete {
        background-color: #d9534f;
        color: white;
    }

    .table button:hover {
        opacity: 0.8;
    }


    .unit-table-wrapper {
        max-height: 300px; /* Ubah sesuai kebutuhan */
        overflow-y: auto;
        border: 1px solid #ccc;
        border-radius: 8px;
    }
    .unit-table-wrapper table {
        width: 100%;
        border-collapse: collapse;
    }
    .unit-table-wrapper th, .unit-table-wrapper td {
        padding: 8px 12px;
        border-bottom: 1px solid #ddd;
    }
</style>

@endsection
