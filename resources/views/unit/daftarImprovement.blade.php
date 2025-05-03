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
        <link rel="stylesheet" href="../../css/qcdsmpe-popup.css">
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
                                    <button class="popup-btn-status" data-id="{{ $pendaftaran->id_pendaftaran }}">
                                        Detail
                                        <span class="notification-badge" style="display: none;"></span>
                                    </button>

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
                                    <input type="text" id="sponsor-perner" name="sponsor-perner" readonly
                                        placeholder="Perner">
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
                                    <input type="text" id="fasilitator" name="fasilitator" readonly
                                        placeholder="Nama Fasilitator">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="fasilitator-perner" name="fasilitator-perner" readonly
                                        placeholder="Perner">
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
                                    <input type="text" id="ketua-perner" name="ketua-perner" readonly
                                        placeholder="Perner">
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
                                    <input type="text" id="sekretaris" name="sekretaris" readonly
                                        placeholder="Nama Sekretaris">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="sekretaris-perner" name="sekretaris-perner" readonly
                                        placeholder="Perner">
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
        <div class="popup" id="popup-status" data-id="">
            <h3>Status</h3>
            <!-- Add new button for popup when status = 1 -->
            <div class="status-header-actions">
                <button class="status-comment-btn" id="status-comment-btn" style="display: none;">
                    <i class="fas fa-file-pdf"></i> Generate & Finish
                </button>
            </div>
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
                <button class="btn_qcdsmpe" id="qcdsmpe-btn">
                    <i class="fas fa-file-alt"></i> QCDSMPE
                </button>
            </div>
        </div>

        <!-- New popup for status comment -->
        <div class="popup" id="generate-popup">
            <h3>Generate & Finish</h3>
            <div class="form-group">
                <input type="text" id="id_daftar" name="id_daftar" readonly>
                <label for="status-comment">Nama File</label>
                <input type="text" id="status-comment" name="status-comment" placeholder="Contoh: SidoIT_SGA_2025">
            </div>
            <div class="form-actions">
                <button class="popup-close" id="generate-popup-close">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="submit-btn" id="submit-comment">
                    <i class="fas fa-paper-plane"></i> Submit
                </button>
            </div>
        </div>

        <!-- Popup for QCDSMPE form -->
        <div class="popup qcdsmpe-popup" id="qcdsmpe-popup">
            <div class="popup-header">
                <h3> QCDSMPE</h3>
                <button class="close-btn" id="close-qcdsmpe">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="popup-content">
                <div class="form-group id-group">
                    <input type="text" id="id_daftar" name="id_daftar" hidden>
                </div>
                <input type="text" name="status" id="status" value="1" hidden>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="alat-kontrol">
                            <i class="fas fa-chart-line"></i>
                            Parameter
                        </label>
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
                        <label for="before">
                            <i class="fas fa-arrow-left"></i>
                            Before
                        </label>
                        <input type="text" id="before" name="before" placeholder="Masukkan nilai before">
                    </div>

                    <div class="form-group">
                        <label for="after">
                            <i class="fas fa-arrow-right"></i>
                            After
                        </label>
                        <input type="text" id="after" name="after" placeholder="Masukkan nilai after">
                    </div>
                </div>

                <button class="insert-btn" id="addRowBtn">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>

                <div class="table-container">
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
                </div>

                <div class="form-actions">
                    <button type="button" class="submit-btn" id="submit-qcdsmpe">
                        <i class="fas fa-paper-plane"></i> Save
                    </button>
                </div>
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
                            console.log("idPendaftaran", idPendaftaran);
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
                                        document.getElementById('id-pendaftaran').value = data[0]
                                            .id_pendaftaran;

                                        data.forEach((grup) => {
                                            switch (grup.jabatan_grup) {
                                                case 'sponsor':
                                                    document.getElementById('sponsor').value =
                                                        grup.nama || '-';
                                                    document.getElementById('sponsor-perner')
                                                        .value = grup.perner || '-';
                                                    break;
                                                case 'fasilitator':
                                                    document.getElementById('fasilitator')
                                                        .value = grup.nama || '-';
                                                    document.getElementById(
                                                            'fasilitator-perner').value = grup
                                                        .perner || '-';
                                                    break;
                                                case 'ketua':
                                                    document.getElementById('ketua').value =
                                                        grup.nama || '-';
                                                    document.getElementById('ketua-perner')
                                                        .value = grup.perner || '-';
                                                    break;
                                                case 'sekretaris':
                                                    document.getElementById('sekretaris')
                                                        .value = grup.nama || '-';
                                                    document.getElementById('sekretaris-perner')
                                                        .value = grup.perner || '-';
                                                    break;
                                                case 'anggota':
                                                    // Create anggota card with improved styling
                                                    const divAnggota = document.createElement(
                                                        'div');
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
                            resetStepStatuses(); // Reset step statuses when opening popup

                            const idPendaftaran = this.getAttribute('data-id');
                            const statusBody = document.getElementById('status-body');
                            statusBody.innerHTML = '';

                            // First check QCDSMPE status
                            fetch(`/unit/qcdsmpe/${idPendaftaran}`)
                                .then(response => response.json())
                                .then(data => {
                                    const qcdsmpeBtn = document.getElementById('qcdsmpe-btn');

                                    if (data.success && data.data && data.data.length > 0) {
                                        // If QCDSMPE data exists, hide QCDSMPE button
                                        if (qcdsmpeBtn) {
                                            qcdsmpeBtn.style.display = 'none';
                                            qcdsmpeBtn.disabled = true;
                                        }
                                    } else {
                                        // If no QCDSMPE data, show QCDSMPE button
                                        if (qcdsmpeBtn) {
                                            qcdsmpeBtn.style.display = 'flex';
                                            qcdsmpeBtn.disabled = false;
                                        }
                                    }
                                })
                                .catch(error => {
                                    console.error('Error checking QCDSMPE status:', error);
                                });

                            // Then fetch and display status data
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
                                    if (!data.length || (data.message && data.message.includes(
                                            'No files found'))) {
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
                                        if (item.status === 'approved' && stepNumber >
                                            latestApprovedStep) {
                                            latestApprovedStep = stepNumber;
                                        }
                                    });

                                    // Next step is the latest approved step + 1 (but not higher than 8)
                                    const nextStep = Math.min(latestApprovedStep + 1, 8);

                                    // Display all existing steps
                                    data.forEach(item => {
                                        addStepRow(item, statusBody, idPendaftaran);
                                    });

                                    // Add rows for missing steps up to the next available step
                                    if (latestApprovedStep > 0 && nextStep <= 8 && !data.some(item =>
                                            parseInt(item.tahapan) === nextStep)) {
                                        // Add next step row for upload
                                        addEmptyStepRow(nextStep, idPendaftaran, statusBody);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    statusBody.innerHTML = '';
                                    addEmptyStepRow(1, idPendaftaran, statusBody);
                                });
                        });
                    });
                });

                // Helper function to add a step row
                function addStepRow(item, container, idPendaftaran) {
                    const row = document.createElement('tr');
                    const stepNumber = parseInt(item.tahapan) || 0;
                    const isWaiting = item.status?.toLowerCase() === 'waiting';
                    const isApproved = item.status?.toLowerCase() === 'approved';
                    const isRejected = item.status?.toLowerCase() === 'rejected';

                    // Determine if this step's upload button should be disabled
                    const isDisabled = isWaiting || isApproved;

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
                                onclick="openUploadModal('${idPendaftaran}', ${item.tahapan})"
                                ${isDisabled ? 'disabled' : ''}
                                title="${isWaiting ? 'File is waiting for approval' : isApproved ? 'File has been approved' : isRejected ? 'Upload a new file after rejection' : ''}">
                                <i class="fas fa-upload"></i>
                            </button>
                        </td>
                    `;
                    container.appendChild(row);

                    // Store step data for later checking
                    if (!window.stepStatuses) {
                        window.stepStatuses = {};
                    }
                    window.stepStatuses[stepNumber] = {
                        status: item.status?.toLowerCase(),
                        isApproved: isApproved
                    };

                    // Check all steps up to step 8
                    const generatePdfBtn = document.getElementById('qcdsmpe-btn');
                    let allStepsApproved = true;

                    for (let i = 1; i <= 8; i++) {
                        if (!window.stepStatuses[i] || window.stepStatuses[i].status !== 'approved') {
                            allStepsApproved = false;
                            break;
                        }
                    }

                    if (allStepsApproved) {

                        generatePdfBtn.style.display = 'block';
                        generatePdfBtn.className = 'qcdsmpe-btn ready';
                        generatePdfBtn.innerHTML = `
                            <i class="fas fa-file"></i>
                            <span>QCDSMPE</span>
                        `;
                        generatePdfBtn.onclick = function() {
                            generateQCDSMPE(idPendaftaran);
                        };

                        showStatusQcdsmpe(idPendaftaran);

                    } else {
                        generatePdfBtn.style.display = 'none';
                    }
                }

                // Replace the showStatusQcdsmpe function with:
                function showStatusQcdsmpe(idPendaftaran) {
                    fetch(`/unit/qcdsmpe/status/${idPendaftaran}`)
                        .then(response => response.json())
                        .then(data => {
                            const qcdsmpeBtn = document.getElementById('qcdsmpe-btn');
                            const rowQcdsmpeBtn = document.querySelector(`button.btn_qcdsmpe[data-id="${idPendaftaran}"]`);
                            const statusCommentBtn = document.getElementById('status-comment-btn');

                            console.log(data);
                            if (data.success === 1) {
                                // Hide QCDSMPE button when status is 1
                                if (qcdsmpeBtn) {
                                    qcdsmpeBtn.style.display = 'none';
                                }
                                if (rowQcdsmpeBtn) {
                                    rowQcdsmpeBtn.style.display = 'none';
                                }
                                // Show comment button when status is 1
                                if (statusCommentBtn) {
                                    statusCommentBtn.style.display = 'block';
                                }
                            } else {
                                // Show normal button when status is not 1
                                if (qcdsmpeBtn) {
                                    qcdsmpeBtn.innerHTML = `
                        <i class="fas fa-file"></i>
                        <span>QCDSMPE</span>
                    `;
                                    qcdsmpeBtn.style.display = 'flex';
                                }
                                if (rowQcdsmpeBtn) {
                                    rowQcdsmpeBtn.innerHTML = `QCDSMPE`;
                                    rowQcdsmpeBtn.style.display = 'inline-block';
                                }
                                // Hide comment button when status is not 1
                                if (statusCommentBtn) {
                                    statusCommentBtn.style.display = 'none';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error checking QCDSMPE status:', error);
                        });
                }



                // Add a function to reset step statuses when opening a new status popup
                function resetStepStatuses() {
                    window.stepStatuses = {};
                    document.getElementById('qcdsmpe-btn').style.display = 'none';
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
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content');
                            formData.append('_token', csrfToken);

                            // Debug FormData contents
                            console.log('FormData contents:');
                            for (let pair of formData.entries()) {
                                console.log(pair[0] + ': ' + (pair[0] === 'file' ? pair[1].name : pair[1]));
                            }

                            console.log('Sending fetch request to /upload-file');
                            fetch('/unit/daftarImprovement/upload', {
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
                                                document.getElementById('overlay').style
                                                    .display = 'none';
                                                // Refresh the page to show the updated data
                                                window.location.href = window.location
                                                    .pathname; // Refresh without query params
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

                // Function to generate PDF
                function generateQCDSMPE(idPendaftaran) {
                    // Show the QCDSMPE popup first
                    document.getElementById('overlay').style.display = 'block';
                    document.getElementById('qcdsmpe-popup').style.display = 'block';
                    document.getElementById('id_daftar').value = idPendaftaran;
                    document.getElementById('status').value = '1';
                    // Setup QCDSMPE form functionality
                    setupQcdsmpeForm(idPendaftaran);
                }

                // Function to setup QCDSMPE form
                function setupQcdsmpeForm(idPendaftaran) {
                    const alatKontrolElement = document.getElementById('alat-kontrol');
                    const beforeElement = document.getElementById('before');
                    const afterElement = document.getElementById('after');
                    const analysisTableBody = document.getElementById('analysisTableBody');
                    const addRowBtn = document.getElementById('addRowBtn');
                    let count = 0;

                    // Add row button click handler
                    addRowBtn.addEventListener('click', function() {
                        const parameter = alatKontrolElement.value;
                        const before = beforeElement.value;
                        const after = afterElement.value;

                        // Validate inputs
                        if (!parameter || !before || !after) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Harap lengkapi semua input!',
                                confirmButtonColor: '#4a6b4f'
                            });
                            return;
                        }

                        // Create new row
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${count + 1}</td>
                            <td>${parameter}</td>
                            <td>${before}</td>
                            <td>${after}</td>

                            <td>
                                <button class="delete-btn" onclick="this.closest('tr').remove(); updateRowNumbers();">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        `;

                        analysisTableBody.appendChild(row);
                        count++;

                        // Reset inputs
                        alatKontrolElement.value = '';
                        beforeElement.value = '';
                        afterElement.value = '';
                    });

                    // Submit QCDSMPE form
                    document.getElementById('submit-qcdsmpe').addEventListener('click', function() {
                        const rows = analysisTableBody.getElementsByTagName('tr');
                        if (rows.length === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Harap tambahkan minimal satu data QCDSMPE!'
                            });
                            return;
                        }

                        // Collect data from table
                        const qcdsmpeData = Array.from(rows).map(row => ({
                            parameter: row.cells[1].textContent,
                            before: row.cells[2].textContent,
                            after: row.cells[3].textContent,
                            status: '1'
                        }));

                        const data = {
                            id_pendaftaran: idPendaftaran,
                            qcdsmpe_data: qcdsmpeData,
                            status: '1'
                        };

                        console.log('Sending data:', data);

                        // Send data to server
                        fetch('/unit/submit-qcdsmpe', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(data)
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
                                        title: 'Success!',
                                        text: data.message,
                                        timer: 3000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // Close popups and clear form
                                        document.getElementById('qcdsmpe-popup').style.display = 'none';
                                        document.getElementById('overlay').style.display = 'none';
                                        analysisTableBody.innerHTML = '';

                                        // Hide QCDSMPE button and show Generate & Save in status popup
                                        const qcdsmpeBtn = document.getElementById('qcdsmpe-btn');
                                        const generateSaveBtn = document.getElementById('generate-save-btn');
                                        if (qcdsmpeBtn) {
                                            qcdsmpeBtn.style.display = 'none';
                                            qcdsmpeBtn.disabled = true;
                                            qcdsmpeBtn.remove();
                                        }
                                        if (generateSaveBtn) {
                                            generateSaveBtn.style.display = 'flex';
                                        }

                                        // Store in localStorage that QCDSMPE has been submitted for this ID
                                        localStorage.setItem(`qcdsmpe_submitted_${idPendaftaran}`, 'true');

                                        // Refresh page to ensure all states are updated
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: data.message || 'Failed to save QCDSMPE data'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'An error occurred while submitting QCDSMPE data: ' + error.message
                                });
                            });
                    });

                    // Close QCDSMPE popup
                    document.getElementById('close-qcdsmpe').addEventListener('click', function() {
                        document.getElementById('qcdsmpe-popup').style.display = 'none';
                        document.getElementById('overlay').style.display = 'none';
                    });
                }

                // Function to update row numbers
                function updateRowNumbers() {
                    const rows = document.getElementById('analysisTableBody').getElementsByTagName('tr');
                    for (let i = 0; i < rows.length; i++) {
                        rows[i].cells[0].textContent = i + 1;
                    }
                }
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



            <script>
                // Add this function to check for status changes
                function checkStatusChanges() {
                    document.querySelectorAll('.popup-btn-status').forEach(button => {
                        const idPendaftaran = button.getAttribute('data-id');
                        fetch(`/files/pendaftaran/${idPendaftaran}`)
                            .then(response => response.json())
                            .then(data => {
                                const waitingItems = data.filter(item => item.status?.toLowerCase() === 'waiting');
                                const badge = button.querySelector('.notification-badge');

                                if (waitingItems.length > 0) {
                                    badge.textContent = waitingItems.length;
                                    badge.style.display = 'flex';
                                    button.classList.add('has-notification');
                                } else {
                                    badge.style.display = 'none';
                                    button.classList.remove('has-notification');
                                }
                            })
                            .catch(error => console.error('Error checking status:', error));
                    });
                }

                // Call the function when the page loads
                document.addEventListener('DOMContentLoaded', function() {
                    checkStatusChanges();
                    // Check for changes every 30 seconds
                    setInterval(checkStatusChanges, 30000);
                });

                // Modify the existing status popup click handler
                document.querySelectorAll('.popup-btn-status').forEach(button => {
                    button.addEventListener('click', function() {
                        const idPendaftaran = this.getAttribute('data-id');
                        // ... existing code to show popup ...

                        // After showing the popup, update the notification badge
                        const badge = this.querySelector('.notification-badge');
                        if (badge) {
                            badge.style.display = 'none';
                            this.classList.remove('has-notification');
                        }
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Check QCDSMPE status when status popup opens
                    document.querySelectorAll('.popup-btn-status').forEach(button => {
                        button.addEventListener('click', function() {
                            const idPendaftaran = this.getAttribute('data-id');
                            checkQcdsmpeStatus(idPendaftaran);
                        });
                    });
                });

                function checkQcdsmpeStatus(idPendaftaran) {
                    fetch(`/unit/qcdsmpe/${idPendaftaran}`)
                        .then(response => response.json())
                        .then(data => {
                            const qcdsmpeBtn = document.getElementById('qcdsmpe-btn');
                            const rowQcdsmpeBtn = document.querySelector(`button.btn_qcdsmpe[data-id="${idPendaftaran}"]`);

                            if (data.success && data.data && data.data.length > 0) {
                                // If QCDSMPE data exists
                                if (qcdsmpeBtn) {
                                    qcdsmpeBtn.style.display = 'none';
                                    qcdsmpeBtn.disabled = true;
                                }
                                if (rowQcdsmpeBtn) {
                                    rowQcdsmpeBtn.style.display = 'none';
                                    rowQcdsmpeBtn.disabled = true;
                                }
                            } else {
                                // If no QCDSMPE data
                                if (qcdsmpeBtn) {
                                    qcdsmpeBtn.style.display = 'flex';
                                    qcdsmpeBtn.disabled = false;
                                }
                                if (rowQcdsmpeBtn) {
                                    rowQcdsmpeBtn.style.display = 'inline-block';
                                    rowQcdsmpeBtn.disabled = false;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

                // Check QCDSMPE status for all buttons when page loads
                document.addEventListener('DOMContentLoaded', function() {
                    // Check all QCDSMPE buttons on page load
                    document.querySelectorAll('.btn_qcdsmpe').forEach(button => {
                        const idPendaftaran = button.getAttribute('data-id');
                        if (idPendaftaran) {
                            checkQcdsmpeStatus(idPendaftaran);
                        }
                    });

                    // Check when status popup opens
                    document.querySelectorAll('.popup-btn-status').forEach(button => {
                        button.addEventListener('click', function() {
                            const idPendaftaran = this.getAttribute('data-id');
                            if (idPendaftaran) {
                                setTimeout(() => {
                                    checkQcdsmpeStatus(idPendaftaran);
                                }, 100);
                            }
                        });
                    });
                });
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Setup for generate popup
                    const statusCommentBtn = document.getElementById('status-comment-btn');
                    const generatePopup = document.getElementById('generate-popup');
                    const generatePopupClose = document.getElementById('generate-popup-close');
                    const submitComment = document.getElementById('submit-comment');
                    
                    if (statusCommentBtn) {
                        statusCommentBtn.addEventListener('click', function() {
                            document.getElementById('overlay').style.display = 'block';
                            generatePopup.style.display = 'block';
                            document.getElementById('popup-status').style.display = 'none';
                        });
                    }
                    
                    if (generatePopupClose) {
                        generatePopupClose.addEventListener('click', function() {
                            generatePopup.style.display = 'none';
                            document.getElementById('popup-status').style.display = 'block';
                        });
                    }
                    
                    if (submitComment) {
                        submitComment.addEventListener('click', function() {
                            const fileName = document.getElementById('status-comment').value;
                            const idDaftar = document.getElementById('id_daftar').value;
                            
                            if (fileName.trim() !== '' && idDaftar) {
                                // Show loading indicator
                                Swal.fire({
                                    title: 'Generating PDF...',
                                    text: 'Please wait while we generate your file',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                
                                // Submit the data to the backend
                                fetch('/unit/submit-comment', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        id_pendaftaran: idDaftar,
                                        file_name: fileName
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'File generated successfully!',
                                            confirmButtonText: 'Download PDF',
                                            showCancelButton: true,
                                            cancelButtonText: 'Close'
                                        }).then((result) => {
                                            if (result.isConfirmed && data.download_url) {
                                                // Open the download URL in a new tab
                                                window.open(data.download_url, '_blank');
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.message || 'Failed to generate file'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while generating the file'
                                    });
                                })
                                .finally(() => {
                                    // Close the generate popup and return to status popup
                                    const generatePopup = document.getElementById('generate-popup');
                                    generatePopup.style.display = 'none';
                                    document.getElementById('popup-status').style.display = 'block';
                                    document.getElementById('status-comment').value = '';
                                });
                            } else {
                                // Show validation error
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Validation Error',
                                    text: 'Please enter a file name and make sure ID Pendaftaran is selected'
                                });
                            }
                        });
                    }
                });
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const statusCommentBtn = document.getElementById('status-comment-btn');
                    let currentIdPendaftaran = null;

                    if (statusCommentBtn) {
                        statusCommentBtn.addEventListener('click', function() {
                            // Get the current id_pendaftaran from the status popup
                            const popupStatus = document.getElementById('popup-status');
                            currentIdPendaftaran = popupStatus.getAttribute('data-id');
                            
                            if (currentIdPendaftaran) {
                                // Set the id_daftar value in the generate popup
                                const idDaftarInput = document.getElementById('id_daftar');
                                if (idDaftarInput) {
                                    idDaftarInput.value = currentIdPendaftaran;
                                    idDaftarInput.classList.add('visible-readonly');
                                }
                                
                                // Show the generate popup
                                document.getElementById('overlay').style.display = 'block';
                                const generatePopup = document.getElementById('generate-popup');
                                generatePopup.style.display = 'block';
                                
                                // Hide the status popup
                                popupStatus.style.display = 'none';
                                
                                // Focus on the status-comment input field
                                setTimeout(() => {
                                    document.getElementById('status-comment').focus();
                                }, 100);
                            }
                        });
                    }
                    
                    // Close button for generate popup
                    const generatePopupClose = document.getElementById('generate-popup-close');
                    if (generatePopupClose) {
                        generatePopupClose.addEventListener('click', function() {
                            const generatePopup = document.getElementById('generate-popup');
                            generatePopup.style.display = 'none';
                            document.getElementById('popup-status').style.display = 'block';
                        });
                    }
                    
                    // Submit button for generate popup
                    const submitCommentBtn = document.getElementById('submit-comment');
                    if (submitCommentBtn) {
                        submitCommentBtn.addEventListener('click', function() {
                            const fileName = document.getElementById('status-comment').value;
                            const idDaftar = document.getElementById('id_daftar').value;
                            
                            if (fileName.trim() !== '' && idDaftar) {
                                // Submit the data to the backend
                                fetch('/unit/submit-comment', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        id_pendaftaran: idDaftar,
                                        file_name: fileName
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'File generated successfully!',
                                            confirmButtonText: 'Download PDF',
                                            showCancelButton: true,
                                            cancelButtonText: 'Close'
                                        }).then((result) => {
                                            if (result.isConfirmed && data.download_url) {
                                                // Open the download URL in a new tab
                                                window.open(data.download_url, '_blank');
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.message || 'Failed to generate file'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while generating the file'
                                    });
                                })
                                .finally(() => {
                                    // Close the generate popup and return to status popup
                                    const generatePopup = document.getElementById('generate-popup');
                                    generatePopup.style.display = 'none';
                                    document.getElementById('popup-status').style.display = 'block';
                                    document.getElementById('status-comment').value = '';
                                });
                            }
                        });
                    }
                });
            </script>

        @push('styles')
            <link rel="stylesheet" href="{{ asset('css/qcdsmpe-popup.css') }}">
        @endpush

    </body>

    </html>
