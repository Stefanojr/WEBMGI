@extends('superadmin.layout.main')
@section('title', 'Risalah')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Daftar Pengajuan</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


        <link rel="stylesheet" href="../../css/tableSADash.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body>
        <div class="table-container">
            <h2>DAFTAR APPROVAL</h2>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Grup</th>
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
                                <td>{{ $pendaftaran->nama_grup }}</td>
                                <td>{{ $pendaftaran->unit }}</td>
                                <td>{{ $pendaftaran->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td>{{ $pendaftaran->kreteria_grup }}</td>
                                <td>{{ $pendaftaran->tema }}</td>
                                <td>{{ $pendaftaran->judul }}</td>
                                <td>{{ $pendaftaran->updated_at ? $pendaftaran->updated_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <button class="popup-btn-status">Detail..</button>
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


        <!-- Popup Table Status -->
        <div class="overlay" id="overlay-tahapan"></div>

        <div class="popup" id="popup-tahapan">
            <h2>Approval Request</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tahapan</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody id="tahapan-body">
                    <!-- Data akan dimasukkan melalui JavaScript -->
                </tbody>
            </table>
            <button class="popup-close" id="close-tahapan">Close</button>
        </div>

        @push('scripts')
            <script>
                document.querySelectorAll('.popup-btn-status').forEach(button => {
                    button.addEventListener('click', function() {
                        const idPendaftaran = this.closest('tr').querySelector('.popup-btn-id').getAttribute('data-id');
                        const namaGrup = this.closest('tr').querySelector('td:nth-child(3)').textContent;

                        // Tampilkan popup
                        document.getElementById('overlay-tahapan').style.display = 'block';
                        document.getElementById('popup-tahapan').style.display = 'block';

                        fetch(`/files/pendaftaran/${idPendaftaran}`)
                            .then(response => response.json())
                            .then(data => {
                                const tbody = document.getElementById('tahapan-body');
                                tbody.innerHTML = '';

                                data.forEach(item => {
                                    const row = document.createElement('tr');
                                    // Add data-file-id attribute to the row
                                    row.setAttribute('data-file-id', item.id);

                                    // Buat tombol action
                                    const actionButtons = document.createElement('div');
                                    actionButtons.className = 'action-buttons';

                                    // Create approve button
                                    const approveBtn = document.createElement('button');
                                    approveBtn.className = 'btn-approve';
                                    approveBtn.innerHTML = '<i class="fas fa-check-circle"></i> Approve';
                                    approveBtn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        handleApproval(item.id, idPendaftaran);
                                    });

                                    // Create reject button
                                    const rejectBtn = document.createElement('button');
                                    rejectBtn.className = 'btn-reject';
                                    rejectBtn.innerHTML = '<i class="fas fa-times-circle"></i> Reject';
                                    rejectBtn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        showRejectCommentPopup(item.id, idPendaftaran);
                                    });

                                    actionButtons.appendChild(approveBtn);
                                    actionButtons.appendChild(rejectBtn);

                                    row.innerHTML = `
                                        <td>${item.tanggal}</td>
                                        <td>${item.tahapan}</td>
                                        <td><a href="${item.file}" target="_blank">Download</a></td>
                                        <td><span class="status-badge ${item.status}">${item.status}</span></td>
                                        <td></td>
                                    `;

                                    // Masukkan tombol action ke kolom terakhir
                                    row.querySelector('td:last-child').appendChild(actionButtons);
                                    tbody.appendChild(row);
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                // Fungsi untuk menangani approval
                function handleApproval(id_file, id_pendaftaran) {
                    if (confirm('Apakah Anda yakin ingin menyetujui dokumen ini?')) {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch('/approve-file', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                id_file: id_file,
                                id_pendaftaran: id_pendaftaran
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(text);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    // Remove the row from the table
                                    const row = document.querySelector(`tr[data-file-id="${id_file}"]`);
                                    if (row) {
                                        row.remove();
                                    }

                                    // Check if there are any remaining rows
                                    const tbody = document.getElementById('tahapan-body');
                                    if (tbody.children.length === 0) {
                                        // If no rows left, close the popup and refresh the main page
                                        document.getElementById('overlay-tahapan').style.display = 'none';
                                        document.getElementById('popup-tahapan').style.display = 'none';
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat menyetujui dokumen'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            let errorMessage = 'Terjadi kesalahan saat menyetujui dokumen';

                            try {
                                const errorData = JSON.parse(error.message);
                                errorMessage = errorData.message || errorMessage;
                            } catch (e) {
                                // If error message is not JSON, use it as is
                                errorMessage = error.message || errorMessage;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        });
                    }
                }

                // Fungsi untuk menampilkan popup komentar reject
                function showRejectCommentPopup(id_file, id_pendaftaran) {
                    Swal.fire({
                        title: 'Alasan Penolakan',
                        input: 'textarea',
                        inputPlaceholder: 'Tulis alasan penolakan...',
                        inputAttributes: {
                            'aria-label': 'Tulis alasan penolakan'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Tolak',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        width: '450px',
                        padding: '20px',
                        backdrop: `rgba(0,0,0,0.4)`,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        customClass: {
                            confirmButton: 'btn-confirm',
                            cancelButton: 'btn-cancel',
                            input: 'custom-textarea',
                            popup: 'custom-popup',
                            title: 'custom-title'
                        },
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Harap masukkan alasan penolakan'
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            fetch('/reject-file', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    id_file: id_file,
                                    id_pendaftaran: id_pendaftaran,
                                    komentar: result.value
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.text().then(text => {
                                        throw new Error(text);
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Remove the row from the popup table
                                    const fileRow = document.querySelector(`tr[data-file-id="${id_file}"]`);
                                    if (fileRow) {
                                        fileRow.remove();
                                    }

                                    // Check if there are any remaining rows in the table
                                    const tbody = document.getElementById('tahapan-body');
                                    if (tbody.children.length === 0) {
                                        // If no rows left, close the popup
                                        document.getElementById('overlay-tahapan').style.display = 'none';
                                        document.getElementById('popup-tahapan').style.display = 'none';

                                        // Remove the main row from the table
                                        const mainTableRow = document.querySelector(`button.popup-btn-id[data-id="${id_pendaftaran}"]`).closest('tr');
                                        if (mainTableRow) {
                                            mainTableRow.remove();
                                        }
                                    }

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: data.message
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                let errorMessage = 'Terjadi kesalahan saat menolak dokumen';

                                try {
                                    const errorData = JSON.parse(error.message);
                                    errorMessage = errorData.message || errorMessage;
                                } catch (e) {
                                    errorMessage = error.message || errorMessage;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage
                                });
                            });
                        }
                    });
                }

                // Fungsi untuk menutup popup
                document.getElementById('close-tahapan').addEventListener('click', function() {
                    document.getElementById('overlay-tahapan').style.display = 'none';
                    document.getElementById('popup-tahapan').style.display = 'none';
                });
            </script>




<script>
    document.querySelectorAll('.popup-btn-id').forEach(button => {
        button.addEventListener('click', function() {
            // Menampilkan popup
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';

            const idPendaftaran = button.getAttribute('data-id'); // Mengambil data-id dari button

            // Bersihkan container anggota sebelum memuat data baru
            const anggotaContainer = document.getElementById('anggota-container');
            anggotaContainer.innerHTML = ''; // Hapus semua elemen di dalam container

            // Ambil data dari server berdasarkan id_pendaftaran
            fetch(`/superadmin/daftarImprovementSA/${idPendaftaran}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Debug: Periksa apakah data diterima

                    // Menampilkan id_pendaftaran di form
                    document.getElementById('id-pendaftaran').value = data[0]
                        .id_pendaftaran; // Pastikan data.id_pendaftaran ada

                    // Menampilkan data anggota ke input form berdasarkan jabatan_grup
                    data.forEach((grup, index) => {
                        if (grup.jabatan_grup === 'sponsor') {
                            document.getElementById('sponsor').value = grup.nama;
                            document.getElementById('sponsor-perner').value = grup.perner;
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
                            // Menampilkan setiap anggota dengan kolom nama dan perner terpisah
                            const divAnggota = document.createElement('div');
                            divAnggota.classList.add(
                                'input-container'); // Menambahkan class agar tampil seragam

                            // Label Anggota (Anggota 1, Anggota 2, dst)
                            const label = document.createElement('label');
                            label.textContent =
                                `Anggota ${index + 1}`; // Menambahkan label dinamis
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
    document.getElementById('popup-close').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('popup').style.display = 'none';
    });
</script>



            <script>
                document.querySelectorAll('.popup-btn-id').forEach(button => {
                    button.addEventListener('click', function() {
                        // Menampilkan popup
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('popup').style.display = 'block';

                        const idPendaftaran = button.getAttribute('data-id'); // Mengambil data-id dari button

                        // Bersihkan container anggota sebelum memuat data baru
                        const anggotaContainer = document.getElementById('anggota-container');
                        anggotaContainer.innerHTML = ''; // Hapus semua elemen di dalam container

                        // Ambil data dari server berdasarkan id_pendaftaran
                        fetch(`/superadmin/daftarImprovementSA/${idPendaftaran}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data); // Debug: Periksa apakah data diterima

                                // Menampilkan id_pendaftaran di form
                                document.getElementById('id-pendaftaran').value = data[0]
                                    .id_pendaftaran; // Pastikan data.id_pendaftaran ada

                                // Menampilkan data anggota ke input form berdasarkan jabatan_grup
                                data.forEach((grup, index) => {
                                    if (grup.jabatan_grup === 'sponsor') {
                                        document.getElementById('sponsor').value = grup.nama;
                                        document.getElementById('sponsor-perner').value = grup.perner;
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
                                        // Menampilkan setiap anggota dengan kolom nama dan perner terpisah
                                        const divAnggota = document.createElement('div');
                                        divAnggota.classList.add(
                                            'input-container'); // Menambahkan class agar tampil seragam

                                        // Label Anggota (Anggota 1, Anggota 2, dst)
                                        const label = document.createElement('label');
                                        label.textContent =
                                            `Anggota ${index + 1}`; // Menambahkan label dinamis
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
                document.getElementById('popup-close').addEventListener('click', function() {
                    document.getElementById('overlay').style.display = 'none';
                    document.getElementById('popup').style.display = 'none';
                });
            </script>
        @endpush

        <style>
            /* SweetAlert2 Custom Styling */
            .custom-popup {
                border-radius: 15px !important;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
                padding: 1.5rem !important;
            }

            .custom-title {
                font-size: 22px !important;
                font-weight: 600 !important;
                color: #333 !important;
                padding-top: 0.5rem !important;
                padding-bottom: 1rem !important;
                position: relative !important;
            }

            .custom-title:after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 50px;
                height: 3px;
                background-color: #6c757d;
                border-radius: 2px;
            }

            .custom-textarea {
                border: 1px solid #d9d9d9 !important;
                border-radius: 8px !important;
                padding: 12px !important;
                margin-top: 15px !important;
                font-size: 14px !important;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
                transition: all 0.3s ease !important;
                min-height: 120px !important;
            }

            .custom-textarea:focus {
                border-color: #80bdff !important;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
                outline: none !important;
            }

            .swal2-actions {
                margin-top: 20px !important;
                gap: 12px !important;
            }

            .btn-confirm {
                font-weight: 500 !important;
                padding: 10px 20px !important;
                border-radius: 8px !important;
                box-shadow: 0 3px 5px rgba(220,53,69,0.2) !important;
                transition: all 0.2s ease !important;
            }

            .btn-confirm:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 8px rgba(220,53,69,0.3) !important;
            }

            .btn-cancel {
                font-weight: 500 !important;
                padding: 10px 20px !important;
                border-radius: 8px !important;
                box-shadow: 0 3px 5px rgba(108,117,125,0.2) !important;
                transition: all 0.2s ease !important;
            }

            .btn-cancel:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 8px rgba(108,117,125,0.3) !important;
            }
        </style>
    </body>

    </html>

@endsection
