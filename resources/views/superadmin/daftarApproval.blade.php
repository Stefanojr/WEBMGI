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
                                    <button class="popup-btn-status">Detail</button>
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
                <div class="team-info">
                    <div class="team-id">
                        <div class="input-container">
                            <label for="id-pendaftaran">ID Pendaftaran</label>
                            <input type="text" id="id-pendaftaran" name="id-pendaftaran" readonly>
                        </div>
                    </div>
                    
                    <div class="leadership-grid">
                        <div class="member-card sponsor-card">
                            <div class="member-role">
                                <i class="fas fa-star"></i>
                                <span>Sponsor</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="sponsor" name="sponsor" readonly placeholder="Nama Sponsor">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="sponsor-perner" name="sponsor-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>
                        
                        <div class="member-card fasilitator-card">
                            <div class="member-role">
                                <i class="fas fa-user-tie"></i>
                                <span>Fasilitator</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="fasilitator" name="fasilitator" readonly placeholder="Nama Fasilitator">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="fasilitator-perner" name="fasilitator-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>
                        
                        <div class="member-card ketua-card">
                            <div class="member-role">
                                <i class="fas fa-chess-king"></i>
                                <span>Ketua</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="ketua" name="ketua" readonly placeholder="Nama Ketua">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="ketua-perner" name="ketua-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>
                        
                        <div class="member-card sekretaris-card">
                            <div class="member-role">
                                <i class="fas fa-pen-fancy"></i>
                                <span>Sekretaris</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="sekretaris" name="sekretaris" readonly placeholder="Nama Sekretaris">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="sekretaris-perner" name="sekretaris-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota Grup -->
                    <div class="team-members">
                        <div class="team-members-header">
                            <i class="fas fa-users"></i>
                            <h4>Anggota Tim</h4>
                        </div>
                        <div id="anggota-container" class="anggota-container"></div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button class="popup-close" id="popup-close-id">
                        <i class="fas fa-times"></i> Tutup
                    </button>
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
            <div class="form-actions">
                <button class="popup-close" id="close-tahapan">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
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
                                    approveBtn.innerHTML = '<i class="fas fa-check-circle"></i> Setujui';
                                    approveBtn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        handleApproval(item.id, idPendaftaran);
                                    });
                                    approveBtn.addEventListener('mouseenter', function() {
                                        this.classList.add('pulse');
                                        setTimeout(() => {
                                            this.classList.remove('pulse');
                                        }, 1500);
                                    });

                                    // Create reject button
                                    const rejectBtn = document.createElement('button');
                                    rejectBtn.className = 'btn-reject';
                                    rejectBtn.innerHTML = '<i class="fas fa-times-circle"></i> Tolak';
                                    rejectBtn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        showRejectCommentPopup(item.id, idPendaftaran);
                                    });
                                    rejectBtn.addEventListener('mouseenter', function() {
                                        this.classList.add('pulse');
                                        setTimeout(() => {
                                            this.classList.remove('pulse');
                                        }, 1500);
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
                    Swal.fire({
                        title: 'Konfirmasi Persetujuan',
                        text: 'Apakah Anda yakin ingin menyetujui dokumen ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-check-circle"></i> Setujui',
                        cancelButtonText: '<i class="fas fa-arrow-left"></i> Kembali',
                        confirmButtonColor: '#27ae60',
                        cancelButtonColor: '#7f8c8d',
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
                            confirmButton: 'btn-confirm-green',
                            cancelButton: 'btn-cancel',
                            popup: 'custom-popup',
                            title: 'custom-title'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            Swal.fire({
                                title: 'Processing',
                                text: 'Sedang memproses persetujuan...',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

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
                    });
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
                        confirmButtonText: '<i class="fas fa-times-circle"></i> Tolak',
                        cancelButtonText: '<i class="fas fa-arrow-left"></i> Kembali',
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#7f8c8d',
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
                            document.getElementById('sponsor').value = grup.nama || '-';
                            document.getElementById('sponsor-perner').value = grup.perner || '-';
                        } else if (grup.jabatan_grup === 'fasilitator') {
                            document.getElementById('fasilitator').value = grup.nama || '-';
                            document.getElementById('fasilitator-perner').value = grup.perner || '-';
                        } else if (grup.jabatan_grup === 'ketua') {
                            document.getElementById('ketua').value = grup.nama || '-';
                            document.getElementById('ketua-perner').value = grup.perner || '-';
                        } else if (grup.jabatan_grup === 'sekretaris') {
                            document.getElementById('sekretaris').value = grup.nama || '-';
                            document.getElementById('sekretaris-perner').value = grup.perner || '-';
                        } else if (grup.jabatan_grup === 'anggota') {
                            // Create anggota card with improved styling
                            const divAnggota = document.createElement('div');
                            divAnggota.classList.add('input-container');
                            
                            // Label Anggota 
                            const label = document.createElement('label');
                            label.textContent = `Anggota ${index + 1}`;
                            divAnggota.appendChild(label);

                            // Input untuk nama anggota
                            const inputNama = document.createElement('input');
                            inputNama.type = 'text';
                            inputNama.value = grup.nama || '-';
                            inputNama.readOnly = true;
                            inputNama.placeholder = 'Nama';
                            divAnggota.appendChild(inputNama);

                            // Input untuk perner anggota
                            const inputPerner = document.createElement('input');
                            inputPerner.type = 'text';
                            inputPerner.value = grup.perner || '-';
                            inputPerner.readOnly = true;
                            inputPerner.placeholder = 'Perner';
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
    document.getElementById('popup-close-id').addEventListener('click', function() {
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
                                        document.getElementById('sponsor').value = grup.nama || '-';
                                        document.getElementById('sponsor-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'fasilitator') {
                                        document.getElementById('fasilitator').value = grup.nama || '-';
                                        document.getElementById('fasilitator-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'ketua') {
                                        document.getElementById('ketua').value = grup.nama || '-';
                                        document.getElementById('ketua-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'sekretaris') {
                                        document.getElementById('sekretaris').value = grup.nama || '-';
                                        document.getElementById('sekretaris-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'anggota') {
                                        // Create anggota card with improved styling
                                        const divAnggota = document.createElement('div');
                                        divAnggota.classList.add('input-container');
                                        
                                        // Label Anggota 
                                        const label = document.createElement('label');
                                        label.textContent = `Anggota ${index + 1}`;
                                        divAnggota.appendChild(label);

                                        // Input untuk nama anggota
                                        const inputNama = document.createElement('input');
                                        inputNama.type = 'text';
                                        inputNama.value = grup.nama || '-';
                                        inputNama.readOnly = true;
                                        inputNama.placeholder = 'Nama';
                                        divAnggota.appendChild(inputNama);

                                        // Input untuk perner anggota
                                        const inputPerner = document.createElement('input');
                                        inputPerner.type = 'text';
                                        inputPerner.value = grup.perner || '-';
                                        inputPerner.readOnly = true;
                                        inputPerner.placeholder = 'Perner';
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
                document.getElementById('popup-close-id').addEventListener('click', function() {
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
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
            }

            .btn-confirm:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 8px rgba(220,53,69,0.3) !important;
            }

            .btn-confirm-green {
                font-weight: 500 !important;
                padding: 10px 20px !important;
                border-radius: 8px !important;
                box-shadow: 0 3px 5px rgba(39,174,96,0.2) !important;
                transition: all 0.2s ease !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
            }

            .btn-confirm-green:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 8px rgba(39,174,96,0.3) !important;
            }

            .btn-cancel {
                font-weight: 500 !important;
                padding: 10px 20px !important;
                border-radius: 8px !important;
                box-shadow: 0 3px 5px rgba(108,117,125,0.2) !important;
                transition: all 0.2s ease !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
            }

            .btn-cancel:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 8px rgba(108,117,125,0.3) !important;
            }
            
            /* Modern popup styling */
            .popup {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                max-width: 800px;
                width: 90%;
                background-color: #fff;
                border-radius: 16px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.1);
                padding: 30px;
                z-index: 1000;
                max-height: 85vh;
                overflow-y: auto;
                animation: fadeIn 0.3s ease-out;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translate(-50%, -45%); }
                to { opacity: 1; transform: translate(-50%, -50%); }
            }

            .popup h3 {
                text-align: center;
                margin-bottom: 25px;
                color: #2c3e50;
                font-size: 20px;
                font-weight: 600;
                position: relative;
                padding-bottom: 15px;
            }

            .popup h3::after {
                content: '';
                position: absolute;
                left: 50%;
                bottom: 0;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background: linear-gradient(to right, #4a6b4f, #6ca175);
                border-radius: 3px;
            }

            .team-info {
                display: flex;
                flex-direction: column;
                gap: 25px;
            }

            .team-id {
                background-color: #f8f9fa;
                border-radius: 10px;
                padding: 15px;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .team-id .input-container {
                display: flex;
                align-items: center;
            }

            .team-id .input-container label {
                font-weight: 600;
                color: #2c3e50;
                width: 150px;
            }

            .team-id .input-container input {
                flex-grow: 1;
                padding: 10px 12px;
                background-color: white;
                border: 1px solid #e1e5e9;
                border-radius: 8px;
                color: #4a6b4f;
                font-weight: 600;
            }

            .leadership-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 15px;
            }

            .member-card {
                background-color: #f8f9fa;
                border-radius: 12px;
                padding: 15px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
                transition: all 0.2s ease;
            }

            .member-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            }

            .sponsor-card { border-left: 4px solid #4a6b4f; }
            .fasilitator-card { border-left: 4px solid #4d7dc4; }
            .ketua-card { border-left: 4px solid #d35400; }
            .sekretaris-card { border-left: 4px solid #8e44ad; }

            .member-role {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 10px;
                color: #2c3e50;
                font-weight: 600;
            }

            .member-role i {
                background-color: rgba(74, 107, 79, 0.1);
                color: #4a6b4f;
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
            }

            .sponsor-card .member-role i { color: #4a6b4f; background-color: rgba(74, 107, 79, 0.1); }
            .fasilitator-card .member-role i { color: #4d7dc4; background-color: rgba(77, 125, 196, 0.1); }
            .ketua-card .member-role i { color: #d35400; background-color: rgba(211, 84, 0, 0.1); }
            .sekretaris-card .member-role i { color: #8e44ad; background-color: rgba(142, 68, 173, 0.1); }

            .member-data {
                display: grid;
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .member-name input, .member-perner input {
                width: 100%;
                padding: 8px 12px;
                border: 1px solid #e1e5e9;
                border-radius: 6px;
                background-color: white;
                color: #495057;
            }

            .member-name input::placeholder, .member-perner input::placeholder {
                color: #adb5bd;
            }

            .team-members {
                background-color: #f8f9fa;
                border-radius: 12px;
                padding: 20px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                margin-top: 10px;
            }

            .team-members-header {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .team-members-header i {
                color: #4a6b4f;
                font-size: 18px;
            }

            .team-members-header h4 {
                color: #2c3e50;
                font-size: 16px;
                font-weight: 600;
                margin: 0;
            }

            .anggota-container {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 15px;
            }

            .anggota-container .input-container {
                background-color: white;
                border-radius: 8px;
                padding: 12px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
                display: grid;
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .anggota-container .input-container label {
                color: #4a6b4f;
                font-weight: 600;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 5px;
            }
            
            .anggota-container .input-container label::before {
                content: "\f007";
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
            }

            .anggota-container .input-container input {
                padding: 8px 12px;
                border: 1px solid #e1e5e9;
                border-radius: 6px;
                background-color: #f8f9fa;
            }

            .form-actions {
                display: flex;
                justify-content: center;
                margin-top: 30px;
            }

            .popup-close {
                background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
            }

            .popup-close:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
            }

            .popup-close:active {
                transform: translateY(0);
            }

            @media (max-width: 768px) {
                .popup {
                    width: 95%;
                    padding: 20px;
                }
                
                .leadership-grid {
                    grid-template-columns: 1fr;
                }
                
                .anggota-container {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </body>

    </html>

@endsection
