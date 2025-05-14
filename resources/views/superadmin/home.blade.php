@extends('superadmin.layout.main')

@section('title', 'Dashboard')

@section('content')

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../css/report.css">

<div class="container-fluid py-4">

    <!-- Filter Tahun -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="form-group">
                <select id="tahun" name="tahun" class="form-control" onchange="updateLaporan()">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <!-- Loading Indicator -->
    <div id="loading-indicator" class="text-center mb-4" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Memuat data...</p>
    </div>

    <!-- Statistik Proposal -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-file-alt"></i> Jumlah Total Arsip</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="jumlah-proposal" class="text-primary">{{ $totalArsip }}</h2>
                    <p>Total Proposal Diajukan</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-users"></i> Tingkat Partisipasi</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="tingkat-partisipasi" class="text-success">{{ $jumlahGrup }}</h2> <!-- Update dengan data yang relevan -->
                    <p>Jumlah Grup Yang Berpartisipasi</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white">
                    <h5><i class="fas fa-tags"></i> Kriteria Improvement</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-warning">2</h2> <!-- Update dengan jumlah kategori -->
                    <p>SGA & SCFT</p> <!-- Kategori Inovasi -->
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Proposal -->
    <div class="row">
        <div class="col-md-12">
            <div class="card-grafik">
                <div class="card-header bg-dark text-white">
                    <h5><i class="fas fa-chart-line"></i> Grafik Jumlah Peserta Improvement</h5>
                </div>
                <div class="card-body">
                    <!-- Debug info -->
                    <div style="margin-bottom: 10px">
                        <small>SGA Count: {{ $sgaCount }}     SCFT Count: {{ $scftCount }}</small>
                    </div>
                    <!-- Chart container with fixed height -->
                    <div style="height: 400px;">
                        <canvas id="proposalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js library for displaying charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js setup for proposal per category
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('proposalChart').getContext('2d');
        var proposalChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['SGA', 'SCFT'],
                datasets: [{
                    label: 'Jumlah Proposal',
                    data: [{{ $sgaCount }}, {{ $scftCount }}],
                    backgroundColor: [
                        'rgba(30, 72, 48, 0.8)',  // SGA - dark green color
                        'rgba(30, 72, 48, 0.8)'   // SCFT - dark green color
                    ],
                    borderColor: [
                        'rgba(30, 72, 48, 1)',    // SGA - dark green color
                        'rgba(30, 72, 48, 1)'     // SCFT - dark green color
                    ],
                    borderWidth: 2,
                    borderRadius: 12,
                    barThickness: 50,
                    hoverBackgroundColor: [
                        'rgba(30, 72, 48, 1)',    // SGA - dark green color
                        'rgba(30, 72, 48, 1)'     // SCFT - dark green color
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 72, 48, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(30, 72, 48, 1)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Total: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(30, 72, 48, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#1e4830',
                            font: {
                                size: 12,
                                family: "'Poppins', sans-serif",
                                weight: '500'
                            },
                            padding: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#1e4830',
                            font: {
                                size: 12,
                                family: "'Poppins', sans-serif",
                                weight: '500'
                            },
                            padding: 10
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Store chart in window object for later access
        window.proposalChart = proposalChart;
    });

    function updateLaporan() {
        var tahun = document.getElementById('tahun').value;
        var loadingIndicator = document.getElementById('loading-indicator');
        
        // Show loading indicator
        loadingIndicator.style.display = 'block';
        
        // Make AJAX request to get filtered data
        fetch(`/superadmin/get-filtered-dashboard-data?tahun=${tahun}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update statistics
                document.getElementById('jumlah-proposal').textContent = data.totalArsip;
                document.getElementById('tingkat-partisipasi').textContent = data.jumlahGrup;
                
                // Update chart data
                if (window.proposalChart) {
                    window.proposalChart.data.datasets[0].data = [data.sgaCount, data.scftCount];
                    window.proposalChart.update();
                }
                
                // Hide loading indicator
                loadingIndicator.style.display = 'none';
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                // Hide loading indicator even if there's an error
                loadingIndicator.style.display = 'none';
                // Show error message to user
                alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
            });
    }
</script>

@endsection
