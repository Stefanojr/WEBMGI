@extends('unit.layout.main')
@section('title', 'Dashboard')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Daftar Pengajuan</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="../../css/tableUnitDash.css">
        <style>
        </style>
    </head>

    <body>
        <div class="table-container">
            @if (session('success'))
                <div class="success-message" id="successMessage">
                    {{ session('success') }}
                    <button class="close-btn" onclick="closeMessage()">&times;</button>
                </div>
            @endif
            <h2>DAFTAR IMPROVEMENT</h2>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Daftar</th>
                            <th>Unit</th>
                            <th>Perusahaan</th>
                            <th>Kriteria</th>
                            <th>Tema</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Tahapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftarans as $key => $pendaftaran)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <button class="popup-btn-id" data-id="{{ $pendaftaran->id_pendaftaran }}">
                                        {{ $pendaftaran->id_pendaftaran }}
                                    </button>
                                </td>
                                <td>{{ $pendaftaran->unit }}</td>
                                <td>{{ $pendaftaran->pabrik }}</td>
                                <td>{{ $pendaftaran->kreteria_grup }}</td>
                                <td>{{ $pendaftaran->tema }}</td>
                                <td>{{ $pendaftaran->judul }}</td>
                                {{-- <td>
                                <a href="timetable" class="popup-link">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                            </td> --}}
                                <td>{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <button class="popup-btn-status"
                                        data-id="{{ $pendaftaran->id_pendaftaran }}">Pendaftaran</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <!-- Modal untuk Upload -->
                </table>
            </div>
        </div>

        <div class="modal" id="upload-modal"
            style="display: none; height: 50%; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; z-index: 1000; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
            <div class="modal-content-upload">
                <h2 style="font-size: 16px;">Upload File</h2>
                <form id="upload-form" action="{{ route('pendaftaran.uploadfile') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="inputId" name="id_pendaftaran" required>
                    <div class="form-group">
                        <input type="file" id="upload_file" name="upload_file" required />
                    </div>
                    <div class="form-actions">
                        <button id="close-modal" type="button">Close</button>
                        <button id="submit-modal" type="submit">Upload</button>
                    </div>
                </form>
                <div id="upload-success" style="display: none; color: green; margin-top: 10px;">
                    File sudah terkirim!
                </div>
            </div>
        </div>

        <!-- Modal untuk Upload -->
        {{-- <div class="modal" id="upload-modal" style="display: none;">
    <div class="modal-content-upload">
        <h2 style="font-size: 16px;">Upload File</h2>
        <form id="upload-form" action="{{ route('pendaftaran.uploadfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input data-id="{{ $pendaftaran->id_pendaftaran }}" type="text" id="id_pendaftaran" name="id_pendaftaran" value="{{ $pendaftaran->id_pendaftaran }}" />
            <div class="form-group">
                <input type="file" id="upload_file" name="upload_file" accept=".docx" required />
            </div>
            <div class="form-actions">
                <button type="submit">Upload</button>
                <button id="close-modal" type="button">Close</button>
            </div>
        </form>

        <!-- Pesan sukses setelah upload -->
        <div id="upload-success" style="display: none; color: green; margin-top: 10px;">
            File sudah terkirim!
        </div>

    </div>
</div> --}}


        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

        <!-- Popup Struktur Anggota -->
        <div class="popup" id="popup">
            <h3>Struktur Anggota</h3>
            <form id="struktur-form">
                <div class="input-container">
                    <label for="id-pendaftaran">ID Pendaftaran</label>
                    <input type="text" id="id-pendaftaran" name="id-pendaftaran" readonly required>
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


        <div class="popup" id="popup-status">
            <h3>Status</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tahapan</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th>Upload</th>
                    </tr>
                </thead>
                <tbody id="status-body">
                    <!-- Data akan diisi secara dinamis -->
                </tbody>
            </table>
            <div class="form-actions">
                <button class="popup-close" id="popup-close-status">Close</button>
            </div>
        </div>

        @push('scripts')
            <script>
                function closeOverlay() {
                    document.getElementById('overlay').style.display = 'none';
                    document.getElementById('popup').style.display = 'none';
                    document.getElementById('popup-status').style.display = 'none';
                    document.getElementById('upload-modal').style.display = 'none';
                }

                const inputId = document.querySelectorAll('#inputId')
                // Tampilkan popup struktur anggota
                document.querySelectorAll('.popup-btn-id').forEach(button => {
                    button.addEventListener('click', function() {
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('popup').style.display = 'block';

                        const idPendaftaran = button.getAttribute('data-id');

                        inputId.getAttribute('data-id')

                        // Bersihkan container anggota sebelum memuat data baru
                        const anggotaContainer = document.getElementById('anggota-container');
                        anggotaContainer.innerHTML = '';

                        // Ambil data dari server berdasarkan id_pendaftaran
                        fetch(`/unit/daftarImprovement/${idPendaftaran}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data && data.length > 0) {
                                    document.getElementById('id-pendaftaran').value = data[0].id_pendaftaran;

                                    data.forEach((grup, index) => {
                                        if (grup.jabatan_grup === 'sponsor') {
                                            document.getElementById('sponsor').value = grup.nama;
                                            document.getElementById('sponsor-perner').value = grup
                                                .perner;
                                        } else if (grup.jabatan_grup === 'fasilitator') {
                                            document.getElementById('fasilitator').value = grup.nama;
                                            document.getElementById('fasilitator-perner').value = grup
                                                .perner;
                                        } else if (grup.jabatan_grup === 'ketua') {
                                            document.getElementById('ketua').value = grup.nama;
                                            document.getElementById('ketua-perner').value = grup.perner;
                                        } else if (grup.jabatan_grup === 'sekretaris') {
                                            document.getElementById('sekretaris').value = grup.nama;
                                            document.getElementById('sekretaris-perner').value = grup
                                                .perner;
                                        } else if (grup.jabatan_grup === 'anggota') {
                                            const divAnggota = document.createElement('div');
                                            divAnggota.classList.add('input-container');

                                            const label = document.createElement('label');
                                            label.textContent = `Anggota ${index + 1}`;
                                            divAnggota.appendChild(label);

                                            const inputNama = document.createElement('input');
                                            inputNama.type = 'text';
                                            inputNama.value = grup.nama;
                                            inputNama.readOnly = true;
                                            divAnggota.appendChild(inputNama);

                                            const inputPerner = document.createElement('input');
                                            inputPerner.type = 'text';
                                            inputPerner.value = grup.perner;
                                            inputPerner.readOnly = true;
                                            divAnggota.appendChild(inputPerner);

                                            anggotaContainer.appendChild(divAnggota);
                                        }
                                    });
                                } else {
                                    console.error('Data tidak ditemukan.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                // Tampilkan popup status
                document.querySelectorAll('.popup-btn-status').forEach(button => {
                    button.addEventListener('click', function() {
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('popup-status').style.display = 'block';

                        const idPendaftaran = button.getAttribute('data-id');

                        // Bersihkan tabel status sebelum memuat data baru
                        const statusBody = document.getElementById('status-body');
                        statusBody.innerHTML = '';

                        // Data dummy untuk testing
                        const dummyData = [{
                                tanggal: '',
                                tahapan: 'Langkah 1',
                                dokumen: '',
                                status_approval: 'Waiting'
                            }

                        ];

                        dummyData.forEach(status => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                <td>${status.tanggal}</td>
                <td>${status.tahapan}</td>
                <td>${status.dokumen || '-'}</td>
                <td>${status.status_approval}</td>
                <td>
                    <button class="upload-btn" data-id="${idPendaftaran}">
                        <i class="fas fa-upload"></i>
                    </button>
                </td>
            `;
                            statusBody.appendChild(row);
                        });

                        // Tambahkan event listener pada ikon upload
                        document.querySelectorAll('.upload-btn').forEach(uploadButton => {
                            uploadButton.addEventListener('click', function() {
                                document.getElementById('overlay').style.display = 'block';
                                document.getElementById('upload-modal').style.display = 'block';

                                const selectedIdPendaftaran = uploadButton.getAttribute('data-id');
                                document.getElementById('inputId').value =
                                    selectedIdPendaftaran;
                            });
                        });
                    });

                    // document.getElementById('upload-form').addEventListener('submit', function(event) {
                    //     event.preventDefault(); // Mencegah reload halaman saat submit

                    //     let formData = new FormData(this);
                    //     let idPendaftaran = document.getElementById('id_pendaftaran').value;

                    //     fetch('/upload-file', { // Pastikan route sesuai dengan backend Laravel Anda
                    //             method: 'POST',
                    //             body: formData,
                    //             headers: {
                    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    //             }
                    //         })
                    //         .then(response => response.json())
                    //         .then(data => {
                    //             if (data.success) {
                    //                 // Perbarui tanggal berdasarkan waktu saat ini
                    //                 let today = new Date();
                    //                 let formattedDate = today.getDate().toString().padStart(2, '0') + '/' +
                    //                     (today.getMonth() + 1).toString().padStart(2, '0') + '/' +
                    //                     today.getFullYear();

                    //                 // Cari baris tabel berdasarkan ID Pendaftaran
                    //                 let rows = document.querySelectorAll('#status-body tr');
                    //                 rows.forEach(row => {
                    //                     let button = row.querySelector('.upload-btn');
                    //                     if (button && button.getAttribute('data-id') ===
                    //                         idPendaftaran) {
                    //                         row.cells[0].textContent = formattedDate; // Update tanggal
                    //                         row.cells[2].innerHTML =
                    //                             `<a href="${data.file_url}" target="_blank">Download</a>`; // Update file
                    //                         button.disabled = true; // Disable upload button
                    //                     }
                    //                 });

                    //                 // Tampilkan pesan sukses
                    //                 document.getElementById('upload-success').style.display = 'block';

                    //                 // Tutup modal setelah 2 detik
                    //                 setTimeout(() => {
                    //                     document.getElementById('upload-modal').style.display = 'none';
                    //                     document.getElementById('overlay').style.display = 'none';
                    //                     document.getElementById('upload-success').style.display =
                    //                         'none';
                    //                 }, 2000);
                    //             }
                    //         })
                    //         .catch(error => console.error('Upload error:', error));
                    // });

                });

                // Tutup popup status
                document.getElementById('popup-close-status').addEventListener('click', function() {
                    document.getElementById('overlay').style.display = 'none';
                    document.getElementById('popup-status').style.display = 'none';

                });

                document.getElementById('submit-modal').addEventListener('click', function() {
                    console.log("Upload button clicked");
                });

                document.getElementById('close-modal').addEventListener('click', function() {
                    document.getElementById('upload-modal').style.display = 'none';
                });
            </script>



            <script>
                // Fungsi untuk menutup pesan sukses
                function closeMessage() {
                    let messageBox = document.getElementById('successMessage');
                    messageBox.style.animation = 'fadeOut 0.4s ease-in-out';
                    setTimeout(() => {
                        messageBox.style.display = 'none';
                    }, 500);
                }

                // Auto-close setelah 5 detik
                setTimeout(closeMessage, 5000);
            </script>
        @endpush
    </body>

    </html>
