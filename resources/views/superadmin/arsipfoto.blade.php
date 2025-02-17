@extends('superadmin.layout.main')

@section('title', 'Arsip Digital')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../css/arsipfotoUnit.css">
<link rel="stylesheet" href="../../css/arsipfotoTable.css">

<div class="container">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-folder-open"></i> Dokumentasi SMIF
        </div>
        <div class="card-body">
            <form id="form-tambah" action="/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="photo">Upload Foto</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan"  required>
                </div>
                <div class="form-group">
                    <button type="submit">+ Tambah</button>
                </div>
            </form>
            <div class="table-scroll">
                <table id="strukturOrganisasiTable">
                    <thead>
                        <tr>
                            <th>Delete</th>
                            <th>No.</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody id="data-tabel">
                        <!-- Data akan ditambahkan di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const formTambah = document.getElementById('form-tambah');
    const dataTabel = document.getElementById('data-tabel');

    formTambah.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(formTambah);
        const keterangan = formData.get('keterangan');
        const photo = formData.get('photo');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><button class="delete-btn">Delete</button></td>
            <td>${dataTabel.rows.length + 1}</td>
            <td>${keterangan}</td>
            <td><a href="${URL.createObjectURL(photo)}" target="_blank">Lihat Foto</a></td>
        `;
        dataTabel.appendChild(newRow);

        // Tambahkan event listener pada tombol delete
        const btnDelete = newRow.querySelector('.delete-btn');
        btnDelete.addEventListener('click', () => {
            newRow.remove();
        });

        // Reset input field
        formTambah.reset();
    });
</script>
@endsection
