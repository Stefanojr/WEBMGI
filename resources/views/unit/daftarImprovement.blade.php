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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <td>{{ $pendaftaran->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td>{{ $pendaftaran->kreteria_grup }}</td>
                                <td>{{ $pendaftaran->tema }}</td>
                                <td>{{ $pendaftaran->judul }}</td>
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

        <div id="upload-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Upload File</h2>
                <form id="upload-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="inputId" name="id_pendaftaran">
                    <input type="hidden" id="step_number" name="step_number">
                    <div class="form-group">
                        <label for="file">Select File:</label>
                        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

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


        <!-- Popup Status -->
        <div class="popup" id="popup-status">
            <h3>Status</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Upload</th>
                        <th>Tahapan</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th>Komentar</th>
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

                document.addEventListener("DOMContentLoaded", function() {
                    // Close button for upload modal
                    const closeBtn = document.querySelector('.close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            document.getElementById('upload-modal').style.display = 'none';
                            document.getElementById('overlay').style.display = 'none';
                        });
                    }

                    // Close buttons for popup
                    const popupCloseId = document.getElementById('popup-close-id');
                    if (popupCloseId) {
                        popupCloseId.addEventListener('click', function() {
                            document.getElementById('overlay').style.display = 'none';
                            document.getElementById('popup').style.display = 'none';
                        });
                    }

                    // Close button for status popup
                    const popupCloseStatus = document.getElementById('popup-close-status');
                    if (popupCloseStatus) {
                        popupCloseStatus.addEventListener('click', function() {
                            document.getElementById('overlay').style.display = 'none';
                            document.getElementById('popup-status').style.display = 'none';
                        });
                    }

                    // Setup popup triggers
                    document.querySelectorAll('.popup-btn-id').forEach(button => {
                        button.addEventListener('click', function() {
                            document.getElementById('overlay').style.display = 'block';
                            document.getElementById('popup').style.display = 'block';

                            const idPendaftaran = button.getAttribute('data-id');

                            // Initialize all fields to '-'
                            document.getElementById('sponsor').value = '';
                            document.getElementById('sponsor-perner').value = '';
                            document.getElementById('fasilitator').value = '';
                            document.getElementById('fasilitator-perner').value = '';
                            document.getElementById('ketua').value = '';
                            document.getElementById('ketua-perner').value = '';
                            document.getElementById('sekretaris').value = '';
                            document.getElementById('sekretaris-perner').value = '';
                            const anggotaContainer = document.getElementById('anggota-container');
                            anggotaContainer.innerHTML = ''; // Clear previous anggota

                            fetch(`/unit/daftarImprovement/${idPendaftaran}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data && data.length > 0) {
                                        document.getElementById('id-pendaftaran').value = data[0].id_pendaftaran;

                                        data.forEach((grup) => {
                                            switch (grup.jabatan_grup) {
                                                case 'sponsor':
                                                    document.getElementById('sponsor').value = grup.nama;
                                                    document.getElementById('sponsor-perner').value = grup
                                                        .perner;
                                                    break;
                                                case 'fasilitator':
                                                    document.getElementById('fasilitator').value = grup
                                                        .nama;
                                                    document.getElementById('fasilitator-perner').value =
                                                        grup.perner;
                                                    break;
                                                case 'ketua':
                                                    document.getElementById('ketua').value = grup.nama;
                                                    document.getElementById('ketua-perner').value = grup
                                                        .perner;
                                                    break;
                                                case 'sekretaris':
                                                    document.getElementById('sekretaris').value = grup.nama;
                                                    document.getElementById('sekretaris-perner').value =
                                                        grup.perner;
                                                    break;
                                                case 'anggota':
                                                    const divAnggota = document.createElement('div');
                                                    divAnggota.classList.add('input-container');
                                                    divAnggota.innerHTML = `
                                    <label>Anggota</label>
                                    <input type="text" value="${grup.nama}" readonly>
                                    <input type="text" value="${grup.perner}" readonly>
                                `;
                                                    anggotaContainer.appendChild(divAnggota);
                                                    break;
                                            }
                                        });
                                    } else {
                                        console.error('Data tidak ditemukan.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    });

                    document.querySelectorAll('.popup-btn-status').forEach(button => {
                        button.addEventListener('click', function() {
                            document.getElementById('overlay').style.display = 'block';
                            document.getElementById('popup-status').style.display = 'block';

                            const idPendaftaran = button.getAttribute('data-id');
                            const statusBody = document.getElementById('status-body');
                            statusBody.innerHTML = '';

                            fetch(`/files/pendaftaran/${idPendaftaran}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Received data:', data);
                                    if (data.length > 0) {
                                        // Sort data by step number
                                        data.sort((a, b) => parseInt(a.tahapan) - parseInt(b.tahapan));

                                        // Find the highest step number
                                        let highestStep = 0;
                                        let latestApprovedStep = 0;

                                        // Process existing data
                                        data.forEach(item => {
                                            const stepNumber = parseInt(item.tahapan) || 0;
                                            if (stepNumber > highestStep) {
                                                highestStep = stepNumber;
                                            }

                                            // Track the latest approved step
                                            if (item.status === 'approved' && stepNumber > latestApprovedStep) {
                                                latestApprovedStep = stepNumber;
                                            }
                                        });

                                        // Next step is the latest approved step + 1 (but not higher than 8)
                                        const nextStep = Math.min(latestApprovedStep + 1, 8);

                                        // Display all existing steps
                                        data.forEach(item => {
                                            addStepRow(item, statusBody);
                                        });

                                        // Add rows for missing steps up to the next available step
                                        if (latestApprovedStep > 0 && nextStep <= 8 && !data.some(item => parseInt(item.tahapan) === nextStep)) {
                                            // Add next step row for upload
                                            addEmptyStepRow(nextStep, idPendaftaran, statusBody);
                                        }

                                        // If it's the first upload and no data exists
                                        if (data.length === 0) {
                                            // Add first step row
                                            addEmptyStepRow(1, idPendaftaran, statusBody);
                                        }
                                    } else {
                                        // No data yet, show first step for upload
                                        addEmptyStepRow(1, idPendaftaran, statusBody);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    statusBody.innerHTML = '<tr><td colspan="6">Error loading data</td></tr>';
                                });
                        });
                    });
                });

                // Helper function to add a step row
                function addStepRow(item, container) {
                    const row = document.createElement('tr');
                    const stepNumber = parseInt(item.tahapan) || 0;
                    const isWaiting = item.status?.toLowerCase() === 'waiting';
                    const isApproved = item.status?.toLowerCase() === 'approved';
                    const isRejected = item.status?.toLowerCase() === 'rejected';

                    // Determine if this step's upload button should be disabled
                    const isDisabled = isWaiting || isApproved;

                    // Determine the tooltip message
                    let tooltipMessage = '';
                    if (isWaiting) {
                        tooltipMessage = 'File is waiting for approval';
                    } else if (isApproved) {
                        tooltipMessage = 'File has been approved';
                    }

                    row.innerHTML = `
                        <td>${item.tanggal_upload || '-'}</td>
                        <td>${item.tahapan || '-'}</td>
                        <td><a href="${item.file}" target="_blank">Download</a></td>
                        <td><span class="status-badge ${item.status}">${item.status}</span></td>
                        <td>${item.komentar || '-'}</td>
                        <td>
                            <button class="upload-btn ${isDisabled ? 'disabled-btn' : ''}"
                                onclick="openUploadModal('${item.id_pendaftaran}', ${item.tahapan})"
                                ${isDisabled ? 'disabled' : ''}
                                title="${tooltipMessage}">
                                <i class="fas fa-upload"></i>
                            </button>
                        </td>
                    `;
                    container.appendChild(row);
                }

                // Helper function to add an empty step row
                function addEmptyStepRow(stepNumber, idPendaftaran, container) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>-</td>
                        <td>${stepNumber}</td>
                        <td>-</td>
                        <td><span class="status-badge">-</span></td>
                        <td>-</td>
                        <td>
                            <button class="upload-btn"
                                onclick="openUploadModal('${idPendaftaran}', ${stepNumber})"
                                title="Upload file for step ${stepNumber}">
                                <i class="fas fa-upload"></i>
                            </button>
                        </td>
                    `;
                    container.appendChild(row);
                }

                // Function to open the upload modal
                function openUploadModal(idPendaftaran, stepNumber) {
                    // Set the values in the upload form
                    document.getElementById('inputId').value = idPendaftaran;
                    document.getElementById('step_number').value = stepNumber;

                    // Show the upload modal and overlay
                    const modal = document.getElementById('upload-modal');
                    const overlay = document.getElementById('overlay');
                    modal.style.display = 'block';
                    overlay.style.display = 'block';
                }

                // Handle form submission
                document.addEventListener("DOMContentLoaded", function() {
                    // Make sure form exists before attaching event listener
                    const uploadForm = document.getElementById('upload-form');
                    if (uploadForm) {
                        uploadForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            console.log('Form submit event triggered');

                            const formData = new FormData(this);

                            // Add CSRF token to formData instead of headers
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            formData.append('_token', csrfToken);

                            // Debug FormData contents
                            console.log('FormData contents:');
                            for (let pair of formData.entries()) {
                                console.log(pair[0] + ': ' + (pair[0] === 'file' ? pair[1].name : pair[1]));
                            }

                            console.log('Sending fetch request to /upload-file');
                            fetch('/upload-file', {
                                method: 'POST',
                                body: formData
                                // Removing headers when using FormData with files
                            })
                            .then(response => {
                                console.log('Received response with status:', response.status);
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response data:', data);
                                if (data.success) {
                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: data.message,
                                        timer: 3000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // Close the modal and overlay
                                        document.getElementById('upload-modal').style.display = 'none';
                                        document.getElementById('overlay').style.display = 'none';
                                        // Refresh the page to show the updated data
                                        window.location.href = window.location.pathname; // Refresh without query params
                                    });
                                } else {
                                    // Show error message
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: data.message
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'An error occurred while uploading the file.'
                                });
                            });
                        });
                    } else {
                        console.error('Upload form element not found');
                    }
                });
            </script>

            <script>
                // Fungsi untuk menutup pesan sukses
                function closeMessage() {
                    let messageBox = document.getElementById('successMessage');
                    if (messageBox) {
                        messageBox.style.animation = 'fadeOut 0.4s ease-in-out';
                        setTimeout(() => {
                            messageBox.style.display = 'none';
                        }, 500);
                    }
                }

                // Auto-close setelah 5 detik
                setTimeout(closeMessage, 5000);
            </script>
        @endpush
    </body>

    </html>
