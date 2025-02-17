@extends('superadmin.layout.main')
@section('title', 'Dashboard')

@section('content')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="../../css/dashboardSA.css">


<div class="dashboard-content">
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stat-card">
            <i class="fas fa-users stat-icon"></i>
            <div class="stat-info">
                <h3>{{ $jumlahGrup }}</h3>
                <p>Grup</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>10</h3>
                <p>Langkah 1</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 2</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 3</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 4</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 5</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 6</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 7</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-file-alt stat-icon"></i>
            <div class="stat-info">
                <h3>5</h3>
                <p>Langkah 8</p>
            </div>
        </div>
    </section>

    <div class="notification-container">
        <h2>Notifikasi</h2>
        <div class="notification-card">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
            </div>
            <div class="notification-content">
                <p class="notification-message">Pemberitahuan penting: Langkah 1 telah diperbarui. (Sido IT)</p>
                <span class="notification-time">2 menit lalu</span>
            </div>
        </div>
        <div class="notification-card">
            <div class="notification-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="notification-content">
                <p class="notification-message">Proses Langkah 2 selesai! (Sido IT)</p>
                <span class="notification-time">5 menit lalu</span>
            </div>
        </div>
        <div class="notification-card">
            <div class="notification-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="notification-content">
                <p class="notification-message">Tindakan yang diperlukan pada Langkah 3!</p>
                <span class="notification-time">10 menit lalu</span>
            </div>
        </div>
    </div>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let steps = document.querySelectorAll('.step');
        let currentStep = 0;

        function activateStep(step) {
            steps[step].classList.add('active');
        }

        // Simulate progress over time (e.g., every 2 seconds)
        setInterval(function() {
            if (currentStep < steps.length) {
                activateStep(currentStep);
                currentStep++;
            }
        }, 2000); // Every 2 seconds
    });

</script>

@endsection
