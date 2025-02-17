@extends('unit.layout.main')
@section('title', 'Form Langkah 1')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../css/background.css">
<link rel="stylesheet" href="../../css/formQc.css">
<link rel="stylesheet" href="../../css/tableUnitDaftar.css">

<div class="container">
    <h1>TABEL ANALISA QCDSMPE</h1>

    <div class="form-group">
        <label for="no-urut">No.</label>
        <input type="text" id="no-urut" name="no-urut" disabled>
    </div>

    <div class="form-group">
        <label for="unit">Departemen / Unit</label>
        <input type="text" id="unit" name="unit">
    </div>

    <div class="form-group">
        <label for="nama-kelompok">Nama Group</label>
        <input type="text" id="nama-kelompok" name="nama-kelompok">
    </div>

    <div class="form-group">
        <label for="tema">Tema / Judul</label>
        <input type="text" id="tema" name="tema">
    </div>

    <div class="form-group">
        <label for="jenis-improvement">Jenis Improvement</label>
        <input type="text" id="jenis-improvement" name="jenis-improvement">
    </div>

    <div class="section-title">TABEL ANALISA</div>

    <div class="form-group">
        <label for="alat-kontrol">Parameter</label>
        <select id="alat-kontrol" name="alat-kontrol">
            <option value="" disabled selected>Pilih Parameter</option>
            <option value="Quality">Quality</option>
            <option value="Cost">Cost</option>
            <option value="Delivery">Delivery</option>
            <option value="Safety">Safety</option>
            <option value="Moral">Moral</option>
            <option value="Productivity">Productivity</option>
            <option value="Environment">Environment</option>
        </select>
    </div>
    <div class="form-group">
        <label for="before">Before</label>
        <input type="text" id="before" name="before">
    </div>
    <div class="form-group">
        <label for="after">After</label>
        <input type="text" id="after" name="after">
    </div>
    <button class="insert-btn" id="addRowBtn">+ Tambah</button>

    <div class="table-scroll">
        <table id="strukturOrganisasiTable">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>No.</th>
                    <th>Parameter</th>
                    <th>Before</th>
                    <th>After</th>
                </tr>
            </thead>
            <tbody id="analysisTableBody">
                <!-- Data tabel akan ditambahkan di sini -->
            </tbody>
        </table>
    </div>


    <div class="form-group">
        <label for="cost-saving">Cost Saving</label>
        <input type="text" id="cost-saving" name="cost-saving" disabled>
    </div>

    <button class="submit-btn">SUBMIT</button>
</div>

<script>
    // Mendapatkan elemen yang diperlukan
    const noUrutElement = document.getElementById('no-urut');
    const alatKontrolElement = document.getElementById('alat-kontrol');
    const beforeElement = document.getElementById('before');
    const afterElement = document.getElementById('after');
    const analysisTableBody = document.getElementById('analysisTableBody');
    const addRowBtn = document.getElementById('addRowBtn');

    // Mengatur nomor awal
    let count = 0; // Pastikan dimulai dari 1

    // Fungsi untuk memperbarui nomor otomatis
    function updateCount() {
        noUrutElement.value = count; // Memperbarui nomor yang ditampilkan di input
        count++; // Menambah nomor untuk input berikutnya
    }

    // Memperbarui nomor saat halaman dimuat
    updateCount();

    // Fungsi untuk menambahkan baris baru ke tabel
    addRowBtn.addEventListener('click', function () {
        const parameter = alatKontrolElement.value;
        const before = beforeElement.value;
        const after = afterElement.value;

        // Validasi input
        if (parameter && before && after) {
            // Membuat elemen tr baru
            const row = document.createElement('tr');

            // Membuat elemen td untuk tiap kolom
            const actionCell = document.createElement('td');
            const editLink = document.createElement('a');
            editLink.href = '#';
            editLink.textContent = 'Edit';
            actionCell.appendChild(editLink);

            const noCell = document.createElement('td');
            noCell.textContent = count; // Nomor urut

            const parameterCell = document.createElement('td');
            parameterCell.textContent = parameter;

            const beforeCell = document.createElement('td');
            beforeCell.textContent = before;

            const afterCell = document.createElement('td');
            afterCell.textContent = after;

            // Menambahkan semua cell ke dalam baris
            row.appendChild(actionCell);
            row.appendChild(noCell);
            row.appendChild(parameterCell);
            row.appendChild(beforeCell);
            row.appendChild(afterCell);

            // Menambahkan baris baru ke dalam tubuh tabel
            analysisTableBody.appendChild(row);

            // Memperbarui nomor urut
            updateCount();

            // Reset input form
            alatKontrolElement.value = '';
            beforeElement.value = '';
            afterElement.value = '';
        } else {
            alert("Harap lengkapi semua input!");
        }
    });
</script>

@endsection
