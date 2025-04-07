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
                    <option value="2021" disabled selected>Pilih Tahun</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <!-- Tambahkan tahun lain sesuai kebutuhan -->
                </select>
            </div>
        </div>
    </div>

    <!-- Statistik Proposal -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-file-alt"></i> Jumlah Total Risalah</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="jumlah-proposal" class="text-primary">150</h2> <!-- Update dengan data yang relevan -->
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
                    <!-- Grafik bisa ditambahkan di sini menggunakan chart.js atau library lainnya -->
                    <canvas id="proposalChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js library for displaying charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js setup for proposal per category
    var ctx = document.getElementById('proposalChart').getContext('2d');
    var proposalChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['SGA', 'SCFT'],
            datasets: [{
                label: 'Jumlah Proposal',
                data: [50, 40],
                backgroundColor: [
                    'rgba(30, 72, 48, 0.8)',  // SGA - new dark green color
                    'rgba(30, 72, 48, 0.8)'   // SCFT - new dark green color
                ],
                borderColor: [
                    'rgba(30, 72, 48, 1)',    // SGA - new dark green color
                    'rgba(30, 72, 48, 1)'     // SCFT - new dark green color
                ],
                borderWidth: 2,
                borderRadius: 12,
                barThickness: 50,
                hoverBackgroundColor: [
                    'rgba(30, 72, 48, 1)',    // SGA - new dark green color
                    'rgba(30, 72, 48, 1)'     // SCFT - new dark green color
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
                            return `Jumlah: ${context.raw}`;
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

    function updateLaporan() {
        var tahun = document.getElementById('tahun').value;
        var newData = [];

        if (tahun === "2021") {
            document.getElementById('jumlah-proposal').innerText = "120";
            document.getElementById('tingkat-partisipasi').innerText = "60%";
            newData = [40, 30];
        } else if (tahun === "2022") {
            document.getElementById('jumlah-proposal').innerText = "150";
            document.getElementById('tingkat-partisipasi').innerText = "75%";
            newData = [50, 40];
        } else if (tahun === "2023") {
            document.getElementById('jumlah-proposal').innerText = "200";
            document.getElementById('tingkat-partisipasi').innerText = "85%";
            newData = [70, 60];
        } else if (tahun === "2024") {
            document.getElementById('jumlah-proposal').innerText = "180";
            document.getElementById('tingkat-partisipasi').innerText = "80%";
            newData = [60, 50];
        }

        // Animate the chart update
        proposalChart.data.datasets[0].data = newData;
        proposalChart.update('none');
    }
</script>

@endsection
