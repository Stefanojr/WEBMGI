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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($pendaftarans as $key => $pendaftaran)
                            <tr data-id="{{ $pendaftaran->id_pendaftaran }}" class="data-row">
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
                                    <div style="position: relative;">
                                    <button class="popup-btn-status">Detail</button>
                                        <span class="notification-badge" style="display: none;"></span>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn-delete" data-id="{{ $pendaftaran->id_pendaftaran }}" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
                // Function to check for status changes and add notifications
                function checkNotifications() {
                    document.querySelectorAll('.data-row').forEach(row => {
                        const idPendaftaran = row.getAttribute('data-id');
                        const notificationBadge = row.querySelector('.notification-badge');

                        fetch(`/files/pendaftaran/${idPendaftaran}`)
                            .then(response => response.json())
                            .then(data => {
                                // Check if there are any items with status 'waiting'
                                const waitingItems = data.filter(item => item.status?.toLowerCase() === 'waiting');

                                if (waitingItems.length > 0) {
                                    // Show notification badge with count
                                    notificationBadge.textContent = waitingItems.length;
                                    notificationBadge.style.display = 'flex';

                                    // Add has-notification class to the button for additional styling
                                    const detailButton = row.querySelector('.popup-btn-status');
                                    detailButton.classList.add('has-notification');

                                    // Add a data attribute to mark this row as having notifications
                                    row.setAttribute('data-has-notification', 'true');
                                } else {
                                    // Hide notification badge
                                    notificationBadge.style.display = 'none';

                                    // Remove has-notification class
                                    const detailButton = row.querySelector('.popup-btn-status');
                                    detailButton.classList.remove('has-notification');

                                    // Remove the data attribute
                                    row.removeAttribute('data-has-notification');
                                }

                                // Sort the table to move notified rows to the top
                                sortTableByNotifications();
                            })
                            .catch(error => console.error('Error checking for notifications:', error));
                    });
                }

                // Function to sort table rows, moving rows with notifications to the top
                function sortTableByNotifications() {
                    const tbody = document.getElementById('table-body');
                    const rows = Array.from(tbody.querySelectorAll('.data-row'));

                    // Sort rows: notifications first, then by ID
                    rows.sort((a, b) => {
                        const aHasNotification = a.getAttribute('data-has-notification') === 'true';
                        const bHasNotification = b.getAttribute('data-has-notification') === 'true';

                        // Primary sort: notification status (true comes first)
                        if (aHasNotification && !bHasNotification) return -1;
                        if (!aHasNotification && bHasNotification) return 1;

                        // Secondary sort: by ID (if notification status is the same)
                        const aId = parseInt(a.getAttribute('data-id').split('-')[1]) || 0;
                        const bId = parseInt(b.getAttribute('data-id').split('-')[1]) || 0;
                        return aId - bId;
                    });

                    // Reorder the rows in the table
                    rows.forEach((row, index) => {
                        tbody.appendChild(row);

                        // Update the row numbers
                        row.querySelector('td:first-child').textContent = index + 1;
                    });
                }

                document.querySelectorAll('.popup-btn-status').forEach(button => {
                    button.addEventListener('click', function() {
                        const idPendaftaran = this.closest('tr').getAttribute('data-id');
                        const namaGrup = this.closest('tr').querySelector('td:nth-child(3)').textContent;

                        // Tampilkan popup
                        document.getElementById('overlay-tahapan').style.display = 'block';
                        document.getElementById('popup-tahapan').style.display = 'block';

                        fetch(`/files/pendaftaran/${idPendaftaran}`)
                            .then(response => response.json())
                            .then(data => {
                                const tbody = document.getElementById('tahapan-body');
                                tbody.innerHTML = '';

                                // Filter data to only include rows with "waiting" status
                                const waitingData = data.filter(item => item.status?.toLowerCase() === 'waiting');

                                if (waitingData.length === 0) {
                                    // If no waiting items, show a message
                                    tbody.innerHTML = `
                                        <tr>
                                            <td colspan="5" class="text-center">No pending approval requests</td>
                                        </tr>
                                    `;
                                    return;
                                }

                                waitingData.forEach(item => {
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

                                // After viewing details, refresh notifications
                                checkNotifications();
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
                                    // Update the row's status attribute and appearance
                                    const row = document.querySelector(`tr[data-file-id="${id_file}"]`);
                                    if (row) {
                                        // Remove the row from the table
                                        row.remove();
                                    }

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        // Check if there are any remaining rows
                                        const tbody = document.getElementById('tahapan-body');
                                        if (tbody.children.length === 0 ||
                                            (tbody.children.length === 1 && tbody.children[0].querySelector('td[colspan="5"]'))) {
                                            // If no rows left or only the "No pending approval requests" message, close the popup and refresh the main page
                                            document.getElementById('overlay-tahapan').style.display = 'none';
                                            document.getElementById('popup-tahapan').style.display = 'none';

                                            // Refresh notifications after approval
                                            checkNotifications();
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
                                    if (errorData && errorData.message) {
                                        errorMessage = errorData.message;
                                    }
                                } catch (e) {
                                    errorMessage = error.message || errorMessage;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: errorMessage
                                });
                            });
                        }
                    });
                }

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
                        fetch(`/superadmin/daftarApproval/${idPendaftaran}`, {
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

                // Fungsi untuk menutup popup
                document.getElementById('close-tahapan').addEventListener('click', function() {
                    document.getElementById('overlay-tahapan').style.display = 'none';
                    document.getElementById('popup-tahapan').style.display = 'none';
                });

                // Check for notifications when the page loads
                document.addEventListener('DOMContentLoaded', function() {
                    checkNotifications();

                    // Setup periodic checks for new notifications (every 30 seconds)
                    setInterval(checkNotifications, 30000);
                });

                // Function to show reject comment popup
                function showRejectCommentPopup(id_file, id_pendaftaran) {
                    Swal.fire({
                        title: 'Berikan Alasan Penolakan',
                        input: 'textarea',
                        inputPlaceholder: 'Tuliskan alasan penolakan disini...',
                        inputAttributes: {
                            'aria-label': 'Tuliskan alasan penolakan disini',
                            'class': 'custom-textarea'
                        },
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-times-circle"></i> Tolak',
                        cancelButtonText: '<i class="fas fa-arrow-left"></i> Kembali',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#7f8c8d',
                        width: '500px',
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
                            popup: 'custom-popup',
                            title: 'custom-title',
                            input: 'custom-textarea'
                        },
                        inputValidator: (value) => {
                            if (!value || value.trim() === '') {
                                return 'Alasan penolakan tidak boleh kosong!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const komentar = result.value;
                            handleRejection(id_file, id_pendaftaran, komentar);
                        }
                    });
                }

                // Handle delete button click
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', function() {
                        const idPendaftaran = this.getAttribute('data-id');

                        Swal.fire({
                            title: 'Konfirmasi Penghapusan',
                            text: 'Anda yakin ingin menghapus data ini? Semua data terkait termasuk file akan dihapus secara permanen.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-trash-alt"></i> Hapus',
                            cancelButtonText: '<i class="fas fa-arrow-left"></i> Batal',
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            reverseButtons: true,
                            focusCancel: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show loading indicator
                                Swal.fire({
                                    title: 'Menghapus Data...',
                                    text: 'Mohon tunggu sebentar',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                // Get CSRF token
                                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                // Send delete request
                                fetch(`/pendaftaran/delete/${idPendaftaran}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Data telah dihapus.',
                                            icon: 'success',
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            // Remove the row from the table
                                            const row = document.querySelector(`tr[data-id="${idPendaftaran}"]`);
                                            if (row) {
                                                row.remove();
                                                // Reorder row numbers
                                                const rows = document.querySelectorAll('#table-body tr');
                                                rows.forEach((row, index) => {
                                                    row.querySelector('td:first-child').textContent = index + 1;
                                                });
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: data.message || 'Terjadi kesalahan saat menghapus data.',
                                            icon: 'error'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan saat menghapus data.',
                                        icon: 'error'
                                    });
                                });
                            }
                        });
                    });
                });
            </script>
        @endpush
    </body>

    </html>

@endsection
