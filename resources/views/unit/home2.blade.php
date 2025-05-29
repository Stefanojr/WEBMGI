@extends('unit.layout.main')
@section('title', 'Dashboard')

@section('content')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="../../css/dashboard.css">
<link rel="stylesheet" href="../../css/responsive.css">

<div class="dashboard-content">
        <header class="main-header">
            <div class="filter-container">
                <label for="filterYear">
                    Tahun:
                </label>
                <select id="filterYear">
                    <option value="all">Semua Tahun</option>
                    @php
                        $currentYear = date('Y');
                        for($year = $currentYear; $year >= $currentYear - 5; $year--) {
                            echo "<option value='$year'>$year</option>";
                        }
                    @endphp
                </select>

                <label for="filterGroup">
                    Grup:
                </label>
                <select id="filterGroup">
                    <option value="">Pilih Grup</option>
                    @foreach($pendaftarans as $pendaftaran)
                        <option value="{{ $pendaftaran->id_pendaftaran }}">{{ $pendaftaran->nama_grup }}</option>
                    @endforeach
                </select>

                <button id="applyFilter">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </header>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stat-card" data-parameter="Quality">
            <i class="fas fa-award stat-icon"></i>
            <div class="stat-info">
                <p>Quality</p>
            </div>
        </div>
        <div class="stat-card" data-parameter="Cost">
            <i class="fas fa-money-bill-wave stat-icon"></i>
            <div class="stat-info">
                <p>Cost</p>
            </div>
        </div>
        <div class="stat-card" data-parameter="Delivery">
            <i class="fas fa-box stat-icon"></i>
            <div class="stat-info">
                <p>Delivery</p>
            </div>
        </div>
        <div class="stat-card" data-parameter="Safety">
            <i class="fas fa-shield-alt stat-icon"></i>
            <div class="stat-info">
                <p>Safety</p>
            </div>
        </div>
        <div class="stat-card" data-parameter="Moral">
            <i class="fas fa-heart stat-icon"></i>
            <div class="stat-info">
                <p>Moral</p>
            </div>
        </div>
        <div class="stat-card" data-parameter="Productivity">
            <i class="fas fa-chart-line stat-icon"></i>
            <div class="stat-info">
                <p>Productivity</p>
            </div>
        </div>
        <div class="stat-card" data-parameter="Environment">
            <i class="fas fa-globe stat-icon"></i>
            <div class="stat-info">
                <p>Environment</p>
            </div>
        </div>
    </section>

     <!-- Popup Container -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h2 id="popup-title">Detail</h2>
        <table id="popup-table" class="popup-table">
            <thead>
                <tr>
                    <th>Nama Grup</th>
                    <th>Before</th>
                    <th>After</th>
                    <th>Tahun</th>
                </tr>
            </thead>
            <tbody id="popup-table-body">
            </tbody>
        </table>
        <div id="no-data-message" style="display: none; text-align: center; padding: 20px; color: #6c757d;">
            Tidak ada data untuk parameter ini
        </div>
    </div>
</div>

    <!-- Progress Tracker Section -->
    <section class="progress-section">
        <h2>Progres Tahapan</h2>
        <div class="progress-section-content">
            <div class="progress-tracker">
                @foreach($pendaftarans as $index => $pendaftaran)
                    <div class="progress-card" data-id="{{ $pendaftaran->id_pendaftaran }}" style="{{ $index === 0 ? '' : 'display: none;' }}" data-index="{{ $index }}">
                        <div class="progress-header">
                            <div class="progress-header-left">
                                <h3>{{ $pendaftaran->nama_grup }}</h3>
                                <span class="id-badge">ID: {{ $pendaftaran->id_pendaftaran }}</span>
                            </div>
                            <span class="year-badge">{{ $pendaftaran->created_at->format('Y') }}</span>
                        </div>
                        <div class="progress-steps">
                            @php
                                $files = $pendaftaran->files->sortBy('id_step');
                                $latestApprovedStep = 0;
                                $lastUpdate = null;
                                $allStepsApproved = true;

                                foreach($files as $file) {
                                    if($file->status === 'approved') {
                                        $latestApprovedStep = $file->id_step;
                                    }
                                    // Track the most recent update from any file
                                    if($file->proses && $file->proses->tanggal_upload) {
                                        $currentUpdate = \Carbon\Carbon::parse($file->proses->tanggal_upload);
                                        if(!$lastUpdate || $currentUpdate > $lastUpdate) {
                                            $lastUpdate = $currentUpdate;
                                        }
                                    }
                                    if($file->status !== 'approved') {
                                        $allStepsApproved = false;
                                    }
                                }
                            @endphp

                            @for($i = 1; $i <= 8; $i++)
                                @php
                                    $currentFile = $files->firstWhere('id_step', $i);
                                    $status = $currentFile ? $currentFile->status : 'pending';
                                    $stepClass = '';

                                    switch($status) {
                                        case 'approved':
                                            $stepClass = 'active completed';
                                            break;
                                        case 'waiting':
                                            $stepClass = 'waiting';
                                            break;
                                        case 'rejected':
                                            $stepClass = 'rejected';
                                            break;
                                        default:
                                            $stepClass = '';
                                    }
                                @endphp

                                <div class="step-container">
                                    <div class="step-indicator {{ $stepClass }}" title="Step {{ $i }}: {{ ucfirst($status) }}">
                                        <span class="step-number">{{ $i }}</span>
                                        @if($status === 'approved')
                                            <i class="fas fa-check"></i>
                                        @elseif($status === 'waiting')
                                            <i class="fas fa-clock"></i>
                                        @elseif($status === 'rejected')
                                            <i class="fas fa-times"></i>
                                        @endif
                                    </div>
                                    @if($i < 8)
                                        <div class="step-line {{ $i < $latestApprovedStep ? 'active' : '' }}"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                        <div class="progress-summary">
                            <div class="progress-percentage">
                                <span class="percentage">{{ round(($latestApprovedStep / 8) * 100) }}%</span>
                                <span class="label">Complete</span>
                            </div>
                            <div class="last-update">
                                <i class="fas fa-clock"></i>
                                <span>Last update: {{ $lastUpdate ? $lastUpdate->format('d M Y H:i') : 'N/A' }}</span>
                            </div>
                        </div>

                        @if($allStepsApproved)
                            <div class="generate-section" style="display: none;">
                                <div class="alert alert-success">
                                    Berhasil dikumpulkan
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterYear = document.getElementById('filterYear');
        const filterGroup = document.getElementById('filterGroup');
        const applyFilter = document.getElementById('applyFilter');
        const progressCards = document.querySelectorAll('.progress-card');
        const statCards = document.querySelectorAll('.stat-card');
        const popup = document.getElementById('popup');
        const popupClose = document.querySelector('.popup-close');
        const popupTitle = document.getElementById('popup-title');
        const popupTableBody = document.getElementById('popup-table-body');
        const noDataMessage = document.getElementById('no-data-message');

        // Set current year as default
        const currentYear = new Date().getFullYear();
        filterYear.value = currentYear;

        // Function to update group options based on selected year
        function updateGroupOptions() {
            const selectedYear = filterYear.value;
            const allGroups = document.querySelectorAll('.progress-card');
            const groupSelect = document.getElementById('filterGroup');

            // Store current selection
            const currentSelection = groupSelect.value;

            // Clear existing options except first one
            while (groupSelect.options.length > 1) {
                groupSelect.remove(1);
            }

            // Add filtered options
            allGroups.forEach(card => {
                const cardYear = new Date(card.querySelector('.year-badge').textContent).getFullYear().toString();
                const groupName = card.querySelector('h3').textContent;
                const cardId = card.getAttribute('data-id');

                if (selectedYear === 'all' || cardYear === selectedYear) {
                    const option = document.createElement('option');
                    option.value = cardId;
                    option.textContent = groupName;
                    groupSelect.appendChild(option);
                }
            });

            // Restore selection if still available
            if ([...groupSelect.options].some(opt => opt.value === currentSelection)) {
                groupSelect.value = currentSelection;
            }
        }

        // Update group options when year changes
        filterYear.addEventListener('change', updateGroupOptions);

        // Filter functionality
        applyFilter.addEventListener('click', function() {
            const selectedYear = filterYear.value;
            const selectedId = filterGroup.value;

            progressCards.forEach(card => {
                const cardId = card.getAttribute('data-id');
                const cardYear = new Date(card.querySelector('.year-badge').textContent).getFullYear().toString();

                if ((!selectedId || cardId === selectedId) &&
                    (selectedYear === 'all' || cardYear === selectedYear)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Initial update of group options
        updateGroupOptions();

        // Sort cards by ID and show all by default
        const sortedCards = Array.from(progressCards).sort((a, b) => {
            const idA = parseInt(a.getAttribute('data-id').split('-')[1]) || 0;
            const idB = parseInt(b.getAttribute('data-id').split('-')[1]) || 0;
            return idA - idB; // Sort in ascending order by ID
        });

        // Show all cards by default
        sortedCards.forEach(card => {
            card.style.display = 'block';
        });

        // Don't pre-select any specific group in the filter
        filterGroup.value = "";

        // Event listener untuk setiap stat card
        statCards.forEach(card => {
            card.addEventListener('click', function() {
                const parameter = this.getAttribute('data-parameter');
                const year = filterYear.value;
                const groupId = filterGroup.value;

                // Fetch data from server
                fetch(`/unit/get-qcdsmpe-data?parameter=${parameter}&year=${year}&group_id=${groupId}`)
                    .then(response => response.json())
                    .then(data => {
                        popupTitle.textContent = `Detail ${parameter}`;
                        popupTableBody.innerHTML = '';

                        if (data.length === 0) {
                            document.getElementById('popup-table').style.display = 'none';
                            noDataMessage.style.display = 'block';
                        } else {
                            document.getElementById('popup-table').style.display = 'table';
                            noDataMessage.style.display = 'none';

                            data.forEach(item => {
                                const row = document.createElement('tr');
                                const date = new Date(item.tahun);
                                row.innerHTML = `
                                    <td>${item.nama_grup}</td>
                                    <td>${item.before || '-'}</td>
                                    <td>${item.after || '-'}</td>
                                    <td>${date.getFullYear()}</td>
                                `;
                                popupTableBody.appendChild(row);
                            });
                        }
                        popup.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data');
                    });
            });
        });

        // Close popup
        popupClose.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        window.addEventListener('click', event => {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });

        // Function to check QCDSMPE status and update button visibility
        function checkQcdsmpeStatus(idPendaftaran) {
            fetch(`/unit/qcdsmpe/${idPendaftaran}`)
                .then(response => response.json())
                .then(data => {
                    const qcdsmpeBtn = document.querySelector(`[data-id="${idPendaftaran}"] .btn_qcdsmpe`);

                    if (data.success && data.data && data.data.length > 0) {
                        // If QCDSMPE data exists
                        if (qcdsmpeBtn) {
                            qcdsmpeBtn.remove(); // Remove the QCDSMPE button
                        }
                        // Store status in localStorage
                        localStorage.setItem(`qcdsmpe_submitted_${idPendaftaran}`, 'true');
                    }
                })
                .catch(error => console.error('Error checking QCDSMPE status:', error));
        }

        // Check QCDSMPE status when opening status popup
        document.querySelectorAll('.popup-btn-status').forEach(button => {
            button.addEventListener('click', function() {
                const idPendaftaran = this.getAttribute('data-id');

                // Check if QCDSMPE has been submitted
                if (localStorage.getItem(`qcdsmpe_submitted_${idPendaftaran}`) === 'true') {
                    const qcdsmpeBtn = document.querySelector(`[data-id="${idPendaftaran}"] .btn_qcdsmpe`);
                    if (qcdsmpeBtn) {
                        qcdsmpeBtn.remove();
                    }
                } else {
                    // If not in localStorage, check with server
                    checkQcdsmpeStatus(idPendaftaran);
                }
            });
        });

        // Check all QCDSMPE statuses on page load
        progressCards.forEach(card => {
            const idPendaftaran = card.getAttribute('data-id');
            if (idPendaftaran) {
                checkQcdsmpeStatus(idPendaftaran);
            }
        });
    });
</script>

@endsection
