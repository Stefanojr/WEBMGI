@extends('superadmin.layout.main')
@section('title', 'Risalah')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <link rel="stylesheet" href="../../css/tableSADash.css">

</head>
<body>
    <div class="table-container">
        <h2>DAFTAR APPROVAL</h2>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Grup</th>
                        <th>Nama Grup</th>
                        <th>Unit</th>
                        <th>Perusahaan</th>
                        <th>Kriteria</th>
                        <th>Tema</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Tahap Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftarans as $key => $pendaftaran)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <button class="popup-btn-id" data-id="{{ $pendaftaran->id_pendaftaran }}">
                                {{ $pendaftaran->id_pendaftaran }}
                            </button>
                        </td>
                        <td>{{ $pendaftaran->nama_grup }}</td>
                        <td>{{ $pendaftaran->unit }}</td>
                        <td>{{ $pendaftaran->pabrik }}</td>
                        <td>{{ $pendaftaran->kreteria_grup }}</td>
                        <td>{{ $pendaftaran->tema }}</td>
                        <td>{{ $pendaftaran->judul }}</td>
                        <td>{{ $pendaftaran->updated_at ? $pendaftaran->updated_at->format('d/m/Y') : '-' }}</td>
                        <td>
                            <button class="popup-btn-status">Langkah 1</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
 <!-- Overlay -->
 <div class="overlay" id="overlay"></div>

 <!-- Popup Struktur Anggota -->
 <div class="popup" id="popup">
     {{-- <span class="close-btn" id="close-btn">&times;</span> --}}
     <h3>Struktur Anggota</h3>
     <form id="struktur-form">
         <div class="input-container">
             <label for="id-pendaftaran">ID Pendaftaran</label>
             <input type="text" id="id-pendaftaran" name="id-pendaftaran" readonly>
         </div>
         <div class="input-container">
             <label for="sponsor">Nama Sponsor</label>
             <input type="text" id="sponsor" name="sponsor" readonly>
             <input type="text" id="sponsor-perner" name="sponsor-perner" readonly>
         </div>
         <div class="input-container">
             <label for="fasilitator">Nama Fasilitator</label>
             <input type="text" id="fasilitator" name="fasilitator" readonly>
             <input type="text" id="fasilitator-perner" name="fasilitator-perner" readonly>
         </div>
         <div class="input-container">
             <label for="ketua">Ketua Kelompok</label>
             <input type="text" id="ketua" name="ketua" readonly>
             <input type="text" id="ketua-perner" name="ketua-perner" readonly>
         </div>
         <div class="input-container">
             <label for="sekretaris">Sekretaris</label>
             <input type="text" id="sekretaris" name="sekretaris" readonly>
             <input type="text" id="sekretaris-perner" name="sekretaris-perner" readonly>
         </div>

         <!-- Anggota Grup -->

         <div id="anggota-container" class="anggota-container"></div>
         <div class="form-actions">
             <button class="popup-close" id="popup-close-id">Close</button>
         </div>
     </form>
 </div>

 @push('scripts')
 <script>
document.querySelectorAll('.popup-btn-id').forEach(button => {
button.addEventListener('click', function () {
 // Menampilkan popup
 document.getElementById('overlay').style.display = 'block';
 document.getElementById('popup').style.display = 'block';

 const idPendaftaran = button.getAttribute('data-id'); // Mengambil data-id dari button

 // Bersihkan container anggota sebelum memuat data baru
 const anggotaContainer = document.getElementById('anggota-container');
 anggotaContainer.innerHTML = ''; // Hapus semua elemen di dalam container

 // Ambil data dari server berdasarkan id_pendaftaran
 fetch(`/superadmin/daftarApproval/${idPendaftaran}`, {
     method: 'GET',
     headers: { 'Content-Type': 'application/json' }
 })
 .then(response => response.json())
 .then(data => {
     console.log(data); // Debug: Periksa apakah data diterima

     // Menampilkan id_pendaftaran di form
     document.getElementById('id-pendaftaran').value = data[0].id_pendaftaran; // Pastikan data.id_pendaftaran ada

     // Menampilkan data anggota ke input form berdasarkan jabatan_grup
     data.forEach((grup, index) => {
         if (grup.jabatan_grup === 'sponsor') {
             document.getElementById('sponsor').value = grup.nama;
             document.getElementById('sponsor-perner').value = grup.perner;
         } else if (grup.jabatan_grup === 'fasilitator') {
             document.getElementById('fasilitator').value = grup.nama;
             document.getElementById('fasilitator-perner').value = grup.perner;
         } else if (grup.jabatan_grup === 'ketua') {
             document.getElementById('ketua').value = grup.nama;
             document.getElementById('ketua-perner').value = grup.perner;
         } else if (grup.jabatan_grup === 'sekretaris') {
             document.getElementById('sekretaris').value = grup.nama;
             document.getElementById('sekretaris-perner').value = grup.perner;
         } else if (grup.jabatan_grup === 'anggota') {
             // Menampilkan setiap anggota dengan kolom nama dan perner terpisah
             const divAnggota = document.createElement('div');
             divAnggota.classList.add('input-container'); // Menambahkan class agar tampil seragam

             // Label Anggota (Anggota 1, Anggota 2, dst)
             const label = document.createElement('label');
             label.textContent = `Anggota ${index + 1}`; // Menambahkan label dinamis
             divAnggota.appendChild(label);

             // Input untuk nama anggota
             const inputNama = document.createElement('input');
             inputNama.type = 'text';
             inputNama.value = grup.nama;
             inputNama.readOnly = true;
             divAnggota.appendChild(inputNama);

             // Input untuk perner anggota
             const inputPerner = document.createElement('input');
             inputPerner.type = 'text';
             inputPerner.value = grup.perner;
             inputPerner.readOnly = true;
             divAnggota.appendChild(inputPerner);

             // Menambahkan div anggota ke container anggota
             anggotaContainer.appendChild(divAnggota);
         }
     });
 })
 .catch(error => console.error('Error:', error));
});
});

     // Fungsi untuk menutup popup
     document.getElementById('popup-close').addEventListener('click', function () {
         document.getElementById('overlay').style.display = 'none';
         document.getElementById('popup').style.display = 'none';
     });
 </script>
 @endpush
</body>
</html>

@endsection
