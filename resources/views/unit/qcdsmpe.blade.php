@extends('unit.layout.main')
@section('title', 'Form Langkah 1')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../css/background.css">
<link rel="stylesheet" href="../../css/formQc.css">
<link rel="stylesheet" href="../../css/tableUnitDaftar.css">

<div class="container">
    <h1>TABEL ANALISA QCDSMPE</h1>

    <div class="form-group" style="margin-bottom: 30px;">
        <label for="id_daftar">ID Daftar</label>
        <input type="text" id="id_daftar" name="id_daftar" readonly>
    </div>

    <div class="form-grid">
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
    </div>

    <button class="insert-btn" id="addRowBtn">
        <i class="fas fa-plus"></i> Tambah
    </button>

    <div class="table-scroll">
        <table id="strukturOrganisasiTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Parameter</th>
                    <th>Before</th>
                    <th>After</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="analysisTableBody">
                <!-- Data tabel akan ditambahkan di sini -->
            </tbody>
        </table>
    </div>

    <button class="submit-btn">
        <i class="fas fa-check"></i> SUBMIT
    </button>
</div>

<script>
    // Mendapatkan elemen yang diperlukan
    const alatKontrolElement = document.getElementById('alat-kontrol');
    const beforeElement = document.getElementById('before');
    const afterElement = document.getElementById('after');
    const analysisTableBody = document.getElementById('analysisTableBody');
    const addRowBtn = document.getElementById('addRowBtn');

    // Mengatur nomor awal
    let count = 0;

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
            const noCell = document.createElement('td');
            noCell.textContent = count + 1;

            const parameterCell = document.createElement('td');
            parameterCell.textContent = parameter;

            const beforeCell = document.createElement('td');
            beforeCell.textContent = before;

            const afterCell = document.createElement('td');
            afterCell.textContent = after;

            const actionCell = document.createElement('td');
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'delete-btn';
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
            deleteBtn.onclick = function() {
                row.remove();
                // Update row numbers after deletion
                updateRowNumbers();
            };
            actionCell.appendChild(deleteBtn);

            // Menambahkan semua cell ke dalam baris
            row.appendChild(noCell);
            row.appendChild(parameterCell);
            row.appendChild(beforeCell);
            row.appendChild(afterCell);
            row.appendChild(actionCell);

            // Menambahkan baris baru ke dalam tubuh tabel
            analysisTableBody.appendChild(row);

            // Increment counter
            count++;

            // Reset input form
            alatKontrolElement.value = '';
            beforeElement.value = '';
            afterElement.value = '';
        } else {
            alert("Harap lengkapi semua input!");
        }
    });

    // Fungsi untuk memperbarui nomor baris setelah penghapusan
    function updateRowNumbers() {
        const rows = analysisTableBody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].textContent = i + 1;
        }
    }
</script>

@endsection
