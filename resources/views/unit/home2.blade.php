@extends('unit.layout.main')
@section('title', 'Dashboard')

@section('content')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="../../css/dashboard.css">

<div class="dashboard-content">

    <div class="dashboard-content">

        <header class="main-header">
            <div class="filter-container">

                <label for="filterYear">Tahun:</label>
                <select id="filterYear">
                    <option value="" disabled>Pilih Tahun</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>

                <label for="filterGroup">Grup:</label>
                <select id="filterGroup">
                    <option value="" disabled selected>Pilih Grup</option>
                    <option value="Group A">Group A</option>
                    <option value="Group B">Group B</option>
                    <option value="Group C">Group C</option>
                </select>

                <button id="applyFilter">Search</button>

            </div>

        </header>
    </div>


    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stat-card">
            <i class="fas fa-award stat-icon"></i>
            <div class="stat-info">
                <p>Quality</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-money-bill-wave stat-icon"></i>
            <div class="stat-info">
                <p>Cost</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-box stat-icon"></i>
            <div class="stat-info">
                <p>Delivery</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-shield-alt stat-icon"></i>
            <div class="stat-info">
                <p>Safety</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-heart stat-icon"></i>
            <div class="stat-info">
                <p>Moral</p>
                <p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-chart-line stat-icon"></i>
            <div class="stat-info">
                <p>Productivity</p>
            </div>
        </div>
        <div class="stat-card">
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
        <h2>Detail</h2>
        <table id="popup-table" class="popup-table">
            <thead>
                <tr>
                    <th>Before</th>
                    <th>After</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>


    <!-- Progress Tracker Section -->
    <section class="progress-tracker">
        <h2>Progress Langkah</h2>
        <div class="progress-indicator-wrapper">
            <div class="progress-indicator">
                <div class="step step-1 active" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-2" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-3" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-4" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-5" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-6" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-7" data-id="ID001" data-group="Group A" data-year="2024"></div>
                <div class="step step-8" data-id="ID001" data-group="Group A" data-year="2024"></div>
            </div>
            <div class="step-numbers">
                <span>Langkah 1</span>
                <span>Langkah 2</span>
                <span>Langkah 3</span>
                <span>Langkah 4</span>
                <span>Langkah 5</span>
                <span>Langkah 6</span>
                <span>Langkah 7</span>
                <span>Langkah 8</span>
            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Filter Tahun dan Grup
        const filterYear = document.getElementById('filterYear');
        const currentYear = new Date().getFullYear();
        filterYear.value = currentYear;

        document.getElementById('applyFilter').addEventListener('click', function () {
            const selectedYear = filterYear.value;
            const filterGroup = document.getElementById('filterGroup').value;

            const steps = document.querySelectorAll('.step');
            steps.forEach(step => {
                const stepYear = step.getAttribute('data-year');
                const stepGroup = step.getAttribute('data-group');
                step.style.display = (selectedYear === stepYear || selectedYear === '') &&
                    (filterGroup === stepGroup || filterGroup === '') ? 'inline-block' : 'none';
            });
        });

        document.getElementById('applyFilter').click();

        // Simulasi Progress Bar
        let steps = document.querySelectorAll('.step');
        let currentStep = 0;

        function activateStep(step) {
            steps[step].classList.add('active');
        }

        setInterval(function () {
            if (currentStep < steps.length) {
                activateStep(currentStep);
                currentStep++;
            }
        }, 2000);

        // Popup untuk stat card
        const statCards = document.querySelectorAll('.stat-card');
        const popup = document.getElementById('popup');
        const popupClose = document.querySelector('.popup-close');

        // Event listener untuk setiap stat card
        statCards.forEach(card => {
            card.addEventListener('click', function () {
                popup.style.display = 'block';
            });
        });

        // Close popup
        popupClose.addEventListener('click', () => popup.style.display = 'none');
        window.addEventListener('click', event => {
            if (event.target === popup) popup.style.display = 'none';
        });
    });
</script>



@endsection
