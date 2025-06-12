@extends('superadmin.layout.main')
@section('title', 'Perusahaan')

@section('content')

<link rel="stylesheet" href="../../css/masterData.css">

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
            <button class="btn-delete" data-id="{{ $perusahaan->id_perusahaan }}">Delete</button>
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



@endsection
