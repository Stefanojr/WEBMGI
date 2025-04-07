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
                                        data-id="{{ $pendaftaran->id_pendaftaran }}">Detail</button>
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
                        <label for="file">Select File (DOC, DOCX)</label>
                        <div class="custom-file-upload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Drop your file here or click to browse</span>
                            <span class="file-selected" id="file-name"></span>
                            <input type="file" id="file" name="file" accept=".doc,.docx" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Submit</button>
                        <button type="button" class="popup-close modal-close">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

        <!-- Popup Struktur Anggota -->
        <div class="popup" id="popup">
            <h3>Struktur Anggota</h3>
            <form id="struktur-form">
                <div class="team-info">
                    <div class="team-id">
                        <div class="input-container">
                            <label for="id-pendaftaran">ID Pendaftaran</label>
                            <input type="text" id="id-pendaftaran" name="id-pendaftaran" readonly required>
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
                <button class="popup-close" id="popup-close-status">
                    <i class="fas fa-times"></i> Tutup
                </button>
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
                    const modalCloseBtn = document.querySelector('.modal-close');
                    
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            document.getElementById('upload-modal').style.display = 'none';
                            document.getElementById('overlay').style.display = 'none';
                        });
                    }
                    
                    if (modalCloseBtn) {
                        modalCloseBtn.addEventListener('click', function(e) {
                            e.preventDefault();
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
                                                    document.getElementById('sponsor').value = grup.nama || '-';
                                                    document.getElementById('sponsor-perner').value = grup.perner || '-';
                                                    break;
                                                case 'fasilitator':
                                                    document.getElementById('fasilitator').value = grup.nama || '-';
                                                    document.getElementById('fasilitator-perner').value = grup.perner || '-';
                                                    break;
                                                case 'ketua':
                                                    document.getElementById('ketua').value = grup.nama || '-';
                                                    document.getElementById('ketua-perner').value = grup.perner || '-';
                                                    break;
                                                case 'sekretaris':
                                                    document.getElementById('sekretaris').value = grup.nama || '-';
                                                    document.getElementById('sekretaris-perner').value = grup.perner || '-';
                                                    break;
                                                case 'anggota':
                                                    // Create anggota card with improved styling
                                                    const divAnggota = document.createElement('div');
                                                    divAnggota.classList.add('input-container');
                                                    divAnggota.innerHTML = `
                                        <label>Anggota</label>
                                        <input type="text" value="${grup.nama || '-'}" readonly placeholder="Nama">
                                        <input type="text" value="${grup.perner || '-'}" readonly placeholder="Perner">
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

                                    // Check if we received an empty array or a 404 message wrapped in JSON
                                    if (!data.length || (data.message && data.message.includes('No files found'))) {
                                        console.log('No files found, showing default Step 1');
                                        // If no files yet, show the first step for upload
                                        addEmptyStepRow(1, idPendaftaran, statusBody);
                                        return;
                                    }

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
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    // If there's an error (e.g., no files found), show the first step
                                    statusBody.innerHTML = '';
                                    addEmptyStepRow(1, idPendaftaran, statusBody);
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
                    // Only disable if waiting or approved, enable if rejected
                    const isDisabled = isWaiting || isApproved;

                    // Determine the tooltip message
                    let tooltipMessage = '';
                    if (isWaiting) {
                        tooltipMessage = 'File is waiting for approval';
                    } else if (isApproved) {
                        tooltipMessage = 'File has been approved';
                    } else if (isRejected) {
                        tooltipMessage = 'Upload a new file after rejection';
                    }
                    
                    // Define status badge styles
                    let badgeStyle, badgeClass;
                    
                    if (isWaiting) {
                        badgeClass = 'status-badge waiting';
                    } else if (isApproved) {
                        badgeClass = 'status-badge approved';
                    } else if (isRejected) {
                        badgeClass = 'status-badge rejected';
                    } else {
                        badgeClass = 'status-badge';
                    }

                    row.innerHTML = `
                        <td>${item.tanggal_upload || '-'}</td>
                        <td>${item.tahapan || '-'}</td>
                        <td><a href="${item.file}" target="_blank" class="download-link"><i class="fas fa-download"></i> Download</a></td>
                        <td><span class="${badgeClass}">${item.status}</span></td>
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
                        <td><span class="status-badge pending">Not uploaded</span></td>
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

                    // Reset the file input and file name display
                    document.getElementById('file').value = '';
                    document.getElementById('file-name').textContent = '';
                    document.getElementById('file-name').style.display = 'none';

                    // Show the upload modal and overlay with animation
                    const modal = document.getElementById('upload-modal');
                    const overlay = document.getElementById('overlay');
                    overlay.style.display = 'block';

                    // Trigger reflow for animation
                    void modal.offsetWidth;

                    // Show modal with animation
                    modal.style.display = 'block';
                    setTimeout(() => {
                        modal.classList.add('show');
                    }, 10);
                }

                document.addEventListener("DOMContentLoaded", function() {
                    // File input change listener to show selected filename
                    const fileInput = document.getElementById('file');
                    const fileNameDisplay = document.getElementById('file-name');
                    const dropArea = document.querySelector('.custom-file-upload');

                    if (fileInput && dropArea) {
                        // File input change handler
                        fileInput.addEventListener('change', function() {
                            if (this.files && this.files[0]) {
                                fileNameDisplay.textContent = 'Selected: ' + this.files[0].name;
                                fileNameDisplay.style.display = 'block';
                                dropArea.classList.add('has-file');
                            } else {
                                fileNameDisplay.textContent = '';
                                fileNameDisplay.style.display = 'none';
                                dropArea.classList.remove('has-file');
                            }
                        });

                        // Drag and drop handlers
                        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                            dropArea.addEventListener(eventName, preventDefaults, false);
                        });

                        function preventDefaults(e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }

                        ['dragenter', 'dragover'].forEach(eventName => {
                            dropArea.addEventListener(eventName, highlight, false);
                        });

                        ['dragleave', 'drop'].forEach(eventName => {
                            dropArea.addEventListener(eventName, unhighlight, false);
                        });

                        function highlight() {
                            dropArea.classList.add('highlight');
                        }

                        function unhighlight() {
                            dropArea.classList.remove('highlight');
                        }

                        dropArea.addEventListener('drop', handleDrop, false);

                        function handleDrop(e) {
                            const dt = e.dataTransfer;
                            const files = dt.files;

                            if (files.length) {
                                fileInput.files = files;
                                fileNameDisplay.textContent = 'Selected: ' + files[0].name;
                                fileNameDisplay.style.display = 'block';
                                dropArea.classList.add('has-file');
                            }
                        }
                    }

                    // Close button for upload modal
                    const closeBtn = document.querySelector('.close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            const modal = document.getElementById('upload-modal');
                            modal.classList.remove('show');

                            // Wait for animation to complete before hiding
                            setTimeout(() => {
                                modal.style.display = 'none';
                                document.getElementById('overlay').style.display = 'none';
                            }, 300);
                        });
                    }
                });

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
                                        // Close the modal with animation
                                        const modal = document.getElementById('upload-modal');
                                        modal.classList.remove('show');

                                        // Wait for animation to complete before hiding
                                        setTimeout(() => {
                                            modal.style.display = 'none';
                                            document.getElementById('overlay').style.display = 'none';
                                            // Refresh the page to show the updated data
                                            window.location.href = window.location.pathname; // Refresh without query params
                                        }, 300);
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

        <style>
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

            .modal-close {
                background: linear-gradient(135deg, #7f8c8d 0%, #576574 100%);
                box-shadow: 0 4px 10px rgba(87, 101, 116, 0.2);
            }

            .modal-close:hover {
                box-shadow: 0 6px 15px rgba(87, 101, 116, 0.3);
            }

            /* Update close button for modals */
            .close {
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 28px;
                font-weight: bold;
                color: #aaa;
                cursor: pointer;
                transition: all 0.3s ease;
                display: none;
            }

            .close:hover {
                color: #e74c3c;
            }
        </style>
    </body>

    </html>
