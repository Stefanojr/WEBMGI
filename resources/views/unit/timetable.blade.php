@extends('unit.layout.main')
@section('title', 'Risalah')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/background.css">
    <link rel="stylesheet" href="../../css/formTime.css">
    <link rel="stylesheet" href="../../css/tableTime.css">
    <title>FORM TIME TABLE</title>
</head>
<body>

    <div class="container">
        <h2>FORM TIME TABLE</h2>
        <form>
            <div class="form-group">
                <label for="idDaftar">ID Pendaftaran</label>
                <input type="text" id="idDaftar" disabled>
            </div>
            <div class="form-group">
                <label for="noInput">Langkah ke</label>
                <input type="text" id="noInput" disabled>
            </div>
            <div class="form-group">
                <label for="faseInput">Fase</label>
                <input type="text" id="faseInput" disabled> <!-- Fase yang akan terisi otomatis -->
            </div>
            <div class="form-group">
                <label for="fase">Kegiatan</label>
                <select id="kegiatan" onchange="updateInput()">
                    <option value="" disabled selected>Pilih Kegiatan</option>
                    <option value="Menentukan Masalah Utama">(1) Menentukan Masalah Utama</option>
                    <option value="Mencari Sebab Masalah (Analisa Data)">(2) Mencari Sebab Masalah (Analisa Data)</option>
                    <option value="Mencari Sebab Dominan">(3) Mencari Sebab Dominan</option>
                    <option value="Menyusun Rencana Perbaikan">(4) Menyusun Rencana Perbaikan</option>
                    <option value="Melakukan Perbaikan">(5) Melakukan Perbaikan</option>
                    <option value="Memeriksa Hasil Perbaikan">(6) Memeriksa Hasil Perbaikan</option>
                    <option value="Standarisasi">(7) Standarisasi</option>
                    <option value="Menentukan Rencana Berikutnya">(8) Menentukan Rencana Berikutnya</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rencanaAwal">Rencana Awal</label>
                <div class="input-container">
                    <input type="date" id="rencanaAwal" name="rencanaAwal" required onchange="calculateWeeks()">
                    <label for="rencanaAkhir">Akhir</label>
                    <input type="date" id="rencanaAkhir" name="rencanaAkhir" class="short-input" required onchange="calculateWeeks()">
                </div>
            </div>

            <div class="section-title">INDIKATOR TIME TABLE</div>
            <div class="form-group">
                <label for="plan">Planning</label>
                <input type="text" id="plan" name="plan" disabled>
            </div>

            <button type="button" class="insert-btn" onclick="addToTable()">+ Tambah</button>

            <div class="table-scroll">
            <table id="strukturOrganisasiTable">
                <thead>
                    <tr>
                        <th>Delete</th>
                        <th>Langkah ke</th>
                        <th>Fase</th>
                        <th>Kegiatan</th>
                        <th>Rencana Awal</th>
                        <th>Akhir</th>
                        <th>Planning</th>
                        <th>Realisasi</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Data akan ditambahkan di sini -->
                </tbody>
            </table>
            <div class="form-group">

            </div>
        </form>
    </div>
    <button type="submit" class="submit-btn">SUBMIT</button>
</div>


    <script>
        function updateInput() {
            var selectedValue = document.getElementById("kegiatan").value;

            if (selectedValue === "Menentukan Masalah Utama") {
                document.getElementById("noInput").value = "1";
                document.getElementById("faseInput").value = "Plan";
            } else if (selectedValue === "Mencari Sebab Masalah (Analisa Data)") {
                document.getElementById("noInput").value = "2";
                document.getElementById("faseInput").value = "Plan";
            } else if (selectedValue === "Mencari Sebab Dominan") {
                document.getElementById("noInput").value = "3";
                document.getElementById("faseInput").value = "Plan";
            } else if (selectedValue === "Menyusun Rencana Perbaikan") {
                document.getElementById("noInput").value = "4";
                document.getElementById("faseInput").value = "Plan";
            } else if (selectedValue === "Melakukan Perbaikan") {
                document.getElementById("noInput").value = "5";
                document.getElementById("faseInput").value = "Do";
            } else if (selectedValue === "Memeriksa Hasil Perbaikan") {
                document.getElementById("noInput").value = "6";
                document.getElementById("faseInput").value = "Check";
            } else if (selectedValue === "Standarisasi") {
                document.getElementById("noInput").value = "7";
                document.getElementById("faseInput").value = "Check";
            } else if (selectedValue === "Menentukan Rencana Berikutnya") {
                document.getElementById("noInput").value = "8";
                document.getElementById("faseInput").value = "Act";
            } else {
                document.getElementById("noInput").value = "";
                document.getElementById("faseInput").value = "";
            }
        }

        function calculateWeeks() {
            var startDate = document.getElementById("rencanaAwal").value;
            var endDate = document.getElementById("rencanaAkhir").value;

            if (startDate && endDate) {
                var start = new Date(startDate);
                var end = new Date(endDate);

                // Calculate the difference in milliseconds
                var diffTime = end - start;

                // Convert to weeks
                var diffWeeks = Math.floor(diffTime / (1000 * 60 * 60 * 24 * 7));

                // Update the Planning field
                document.getElementById("plan").value = diffWeeks + " Minggu";
            } else {
                document.getElementById("plan").value = "";
            }
        }

        function addToTable() {
    // Ambil nilai dari input field
    const langkah = document.getElementById("noInput").value;
    const fase = document.getElementById("faseInput").value;
    const kegiatan = document.getElementById("kegiatan").value;
    const rencanaAwal = document.getElementById("rencanaAwal").value;
    const rencanaAkhir = document.getElementById("rencanaAkhir").value;
    const planning = document.getElementById("plan").value;

    // Pastikan semua data yang diperlukan terisi
    if (!langkah || !fase || !kegiatan || !rencanaAwal || !rencanaAkhir || !planning) {
        alert("Harap lengkapi semua field sebelum menambahkan ke tabel.");
        return;
    }

    // Ambil tabel dan buat baris baru
    const table = document.getElementById("strukturOrganisasiTable").getElementsByTagName("tbody")[0];
    const newRow = table.insertRow();

    // Tambahkan sel untuk tombol Delete
    const deleteCell = newRow.insertCell(0);
    const langkahCell = newRow.insertCell(1);
    const faseCell = newRow.insertCell(2);
    const kegiatanCell = newRow.insertCell(3);
    const rencanaAwalCell = newRow.insertCell(4);
    const rencanaAkhirCell = newRow.insertCell(5);
    const planningCell = newRow.insertCell(6);
    const realisasiCell = newRow.insertCell(7); // Realisasi dibiarkan kosong

    // Isi data ke dalam sel
    deleteCell.innerHTML = `<button type="button" class="delete-btn" onclick="deleteRow(this)">Delete</button>`;
    langkahCell.textContent = langkah;
    faseCell.textContent = fase;
    kegiatanCell.textContent = kegiatan;
    rencanaAwalCell.textContent = rencanaAwal;
    rencanaAkhirCell.textContent = rencanaAkhir;
    planningCell.textContent = planning;
    realisasiCell.textContent = ""; // Kosong karena realisasi disabled

   // Reset input fields
   document.getElementById("noInput").value = "";
    document.getElementById("faseInput").value = "";
    document.getElementById("kegiatan").value = "";
    document.getElementById("rencanaAwal").value = "";
    document.getElementById("rencanaAkhir").value = "";
    document.getElementById("plan").value = "";
}


function deleteRow(button) {
    // Menghapus baris tempat tombol berada
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}


    </script>

</body>
</html>

@endsection

