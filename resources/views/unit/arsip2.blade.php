@extends('unit.layout.main')

@section('title', 'Arsip Digital')

@section('content')

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="../../css/arsipUnit.css">

<div class="archive-content">

    <header class="main-header">
        <h2>ARSIP SMIF</h2>
    </header>

    <!-- Search and Filter Section -->
    <section class="search-filter">
        <input type="text" id="search-archive" placeholder="Cari Arsip..." class="search-input">

        <select id="year-filter" class="filter-dropdown">
            <option value="">Semua Tahun</option>
            <!-- Year options will be populated by JavaScript -->
        </select>

        <select id="category-filter" class="filter-dropdown">
            <option value="">Semua Kategori</option>
            <option value="sga">SGA</option>
            <option value="scft">SCFT</option>
            <option value="ss">SS</option>
        </select>
    </section>

    <!-- Arsip per Tahun -->
    <section class="archive-year-section" id="archive-section">
        <!-- Year sections will be populated by JavaScript -->
    </section>
    
    <!-- Empty state message (initially hidden) -->
    <div class="empty-state" id="empty-state">
        <i class="fas fa-search"></i>
        <p>Tidak ada arsip yang sesuai dengan kriteria pencarian</p>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-archive');
        const yearFilter = document.getElementById('year-filter');
        const categoryFilter = document.getElementById('category-filter');
        const archiveSection = document.getElementById('archive-section');
        const emptyState = document.getElementById('empty-state');

        const currentYear = new Date().getFullYear();
        const yearsToDisplay = [currentYear, currentYear - 1, currentYear - 2]; // Display current year and two previous years

        // Populate year filter dropdown and archive sections dynamically
        yearsToDisplay.forEach((year, index) => {
            // Add year to filter
            const yearOption = document.createElement('option');
            yearOption.value = year;
            yearOption.textContent = year;
            yearFilter.appendChild(yearOption);

            // Add year section
            const yearSection = document.createElement('div');
            yearSection.classList.add('year-archive');
            yearSection.setAttribute('data-year', year);
            
            // Add staggered animation delay
            yearSection.style.animationDelay = `${index * 0.1}s`;

            const yearHeader = document.createElement('h2');
            yearHeader.textContent = year;
            yearSection.appendChild(yearHeader);

            const archiveList = document.createElement('ul');
            archiveList.classList.add('archive-list');
            yearSection.appendChild(archiveList);
            
            // Sample items - in real app these would come from database
            const categoryTypes = ['SGA', 'SCFT', 'SS'];
            const departments = ['IT', 'HR', 'Finance', 'Marketing'];
            
            // Create 3-5 list items per year with different categories
            const itemCount = Math.floor(Math.random() * 3) + 3; // 3-5 items
            
            for (let i = 0; i < itemCount; i++) {
                const listItem = document.createElement('li');
                const link = document.createElement('a');
                link.href = '#';
                
                const dept = departments[Math.floor(Math.random() * departments.length)];
                const category = categoryTypes[Math.floor(Math.random() * categoryTypes.length)];
                
                link.textContent = `Risalah ${dept} ${category}`;
                link.setAttribute('data-category', category.toLowerCase());
                
                listItem.appendChild(link);
                archiveList.appendChild(listItem);
            }

            archiveSection.appendChild(yearSection);
        });

        // Function to filter and search archives
        function filterAndSearchArchives() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedYear = yearFilter.value;
            const selectedCategory = categoryFilter.value;
            
            let hasVisibleSection = false;
            const archiveSections = document.querySelectorAll('.year-archive');

            archiveSections.forEach(section => {
                const archiveItems = section.querySelectorAll('.archive-list li');
                const sectionYear = section.getAttribute('data-year');
                let hasVisibleItem = false;

                archiveItems.forEach(item => {
                    const itemText = item.textContent.toLowerCase();
                    const link = item.querySelector('a');
                    const itemCategory = link.getAttribute('data-category') || '';

                    // Logic for matching search, year, and category
                    const matchesSearch = searchTerm === '' || itemText.includes(searchTerm);
                    const matchesYear = selectedYear === '' || sectionYear === selectedYear;
                    const matchesCategory = selectedCategory === '' || itemCategory.includes(selectedCategory);

                    // Show/hide item based on matches
                    if (matchesSearch && matchesYear && matchesCategory) {
                        item.style.display = 'block';
                        hasVisibleItem = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide section based on visibility of items
                if (hasVisibleItem) {
                    section.style.display = 'block';
                    hasVisibleSection = true;
                } else {
                    section.style.display = 'none';
                }
            });
            
            // Show empty state if no results found
            if (!hasVisibleSection) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }

        // Event listeners for search and filter
        searchInput.addEventListener('input', filterAndSearchArchives);
        yearFilter.addEventListener('change', filterAndSearchArchives);
        categoryFilter.addEventListener('change', filterAndSearchArchives);
        
        // Run initial filter
        filterAndSearchArchives();
    });
</script>

@endsection
