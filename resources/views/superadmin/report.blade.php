@extends('superadmin.layout.main')

@section('title', 'Dashboard')

@section('content')

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../css/report.css">

<div class="container-fluid py-4">

    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="text-center text-primary">Laporan Analisis Risalah Improvement</h1>
        </div>
    </div>

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
                    <h2 id="tingkat-partisipasi" class="text-success">75%</h2> <!-- Update dengan data yang relevan -->
                    <p>Partisipasi Karyawan dalam Proposal</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white">
                    <h5><i class="fas fa-tags"></i> Kriteria Improvement</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-warning">3</h2> <!-- Update dengan jumlah kategori -->
                    <p>SGA, SCFT, SS</p> <!-- Kategori Inovasi -->
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
            labels: ['SGA', 'SCFT', 'SS'], // Mengganti kategori menjadi SGA, SCFT, SS
            datasets: [{
                label: 'Jumlah Proposal',
                data: [50, 40, 60], // Data default, akan diubah saat memilih tahun
                backgroundColor: '#4a6b4f',
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function updateLaporan() {
        // Ambil nilai tahun yang dipilih
        var tahun = document.getElementById('tahun').value;

        // Simulasi pembaruan data berdasarkan tahun yang dipilih
        if (tahun === "2021") {
            document.getElementById('jumlah-proposal').innerText = "120";
            document.getElementById('tingkat-partisipasi').innerText = "60%";
            proposalChart.data.datasets[0].data = [40, 30, 50];
        } else if (tahun === "2022") {
            document.getElementById('jumlah-proposal').innerText = "150";
            document.getElementById('tingkat-partisipasi').innerText = "75%";
            proposalChart.data.datasets[0].data = [50, 40, 60];
        } else if (tahun === "2023") {
            document.getElementById('jumlah-proposal').innerText = "200";
            document.getElementById('tingkat-partisipasi').innerText = "85%";
            proposalChart.data.datasets[0].data = [70, 60, 70];
        } else if (tahun === "2024") {
            document.getElementById('jumlah-proposal').innerText = "180";
            document.getElementById('tingkat-partisipasi').innerText = "80%";
            proposalChart.data.datasets[0].data = [60, 50, 70];
        }

        // Update grafik dengan data baru
        proposalChart.update();
    }
</script>

@endsection
