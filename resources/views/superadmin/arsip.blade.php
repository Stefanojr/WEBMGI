@extends('superadmin.layout.main')

@section('title', 'Pendaftaran')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="../../css/arsipUnit.css">

<div class="archive-content">

    <header class="main-header">
        <h2>ARSIP SMIF</h2>
    </header>

    <!-- Search and Filter Section -->
    <section class="search-filter">
        <input type="text" id="search-archive" placeholder="Cari Arsip..." class="search-input">

        <select id="year-filter" class="filter-dropdown">
            <option value="">Pilih Tahun</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <!-- Add more years as needed -->
        </select>

        <select id="category-filter" class="filter-dropdown">
            <option value="">Pilih Kategori</option>
            <option value="sga">SGA</option>
            <option value="scft">SCFT</option>
            <option value="ss">SS</option>
        </select>
    </section>

    <!-- Arsip per Tahun -->
    <section class="archive-year-section">

        <!-- Year 2024 -->
        <div class="year-archive" data-year="2024">
            <h2>2024</h2>
            <ul class="archive-list">
                <li><a href="#">Risalah IT SGA</a></li>
                <li><a href="#">Risalah HR SCFT</a></li>
                <li><a href="#">Risalah SS</a></li>
            </ul>
        </div>

        <!-- Year 2023 -->
        <div class="year-archive" data-year="2023">
            <h2>2023</h2>
            <ul class="archive-list">
                <li><a href="#">Risalah IT SGA</a></li>
                <li><a href="#">Risalah HR SCFT</a></li>
                <li><a href="#">Risalah SS</a></li>
            </ul>
        </div>

        <!-- Year 2022 -->
        <div class="year-archive" data-year="2022">
            <h2>2022</h2>
            <ul class="archive-list">
                <li><a href="#">Risalah IT SGA</a></li>
                <li><a href="#">Risalah HR SCFT</a></li>
                <li><a href="#">Risalah SS</a></li>
            </ul>
        </div>

        <!-- Add more years as needed -->
    </section>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-archive');
        const yearFilter = document.getElementById('year-filter');
        const categoryFilter = document.getElementById('category-filter');
        const archiveSections = document.querySelectorAll('.year-archive');

        // Fungsi utama untuk pencarian dan filter
        function filterAndSearchArchives() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedYear = yearFilter.value;
            const selectedCategory = categoryFilter.value;

            archiveSections.forEach(section => {
                const archiveItems = section.querySelectorAll('.archive-list li');
                const sectionYear = section.getAttribute('data-year');
                let hasVisibleItem = false;

                archiveItems.forEach(item => {
                    const itemText = item.textContent.toLowerCase();
                    const itemCategory = item.textContent.toLowerCase(); // Misal kategori ada dalam teks

                    // Logika Pencocokan
                    const matchesSearch = searchTerm === '' || itemText.includes(searchTerm);
                    const matchesYear = selectedYear === '' || sectionYear === selectedYear;
                    const matchesCategory = selectedCategory === '' || itemCategory.includes(selectedCategory);

                    // Tentukan apakah item ditampilkan
                    if (matchesSearch && matchesYear && matchesCategory) {
                        item.style.display = 'block';
                        hasVisibleItem = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Tampilkan/sembunyikan section berdasarkan hasil filter
                section.style.display = hasVisibleItem ? 'block' : 'none';
            });
        }

        // Event listeners untuk semua filter dan input
        searchInput.addEventListener('input', filterAndSearchArchives);
        yearFilter.addEventListener('change', filterAndSearchArchives);
        categoryFilter.addEventListener('change', filterAndSearchArchives);
    });
</script>
@endsection
