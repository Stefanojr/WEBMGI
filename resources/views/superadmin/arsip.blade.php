@extends('superadmin.layout.main')

@section('title', 'Arsip Digital')

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
            <option value="">Semua Tahun</option>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <select id="pendaftaran-filter" class="filter-dropdown">
            <option value="">Semua Pendaftaran</option>
            @foreach($pendaftaranWithArchives as $pendaftaran)
                <option value="{{ $pendaftaran->id_pendaftaran }}">{{ $pendaftaran->nama_grup }} - {{ $pendaftaran->judul }}</option>
            @endforeach
        </select>


    </section>

    <!-- Arsip per Tahun -->
    <section class="archive-year-section" id="archive-section">
        @php
            $groupedArchives = $pendaftaranWithArchives->sortByDesc(function($pendaftaran) {
                return $pendaftaran->arsip->max('created_at') ?? $pendaftaran->created_at;
            })->groupBy(function($pendaftaran) {
                $latestArchive = $pendaftaran->arsip->sortByDesc('created_at')->first();
                return $latestArchive ? date('Y', strtotime($latestArchive->created_at)) : date('Y', strtotime($pendaftaran->created_at));
            });
        @endphp

        @foreach($groupedArchives as $year => $pendaftaranGroup)
            <div class="year-archive" data-year="{{ $year }}">
                <h2>{{ $year }}</h2>
                <ul class="archive-list">
                    @foreach($pendaftaranGroup as $pendaftaran)
                        @if(count($pendaftaran->arsip) > 0)
                            @foreach($pendaftaran->arsip as $archive)
                                <li data-pendaftaran="{{ $pendaftaran->id_pendaftaran }}">
                                    <a href="{{ url('/unit/download-archive/' . $archive->id_arsip) }}" title="{{ $archive->nama_file }}">
                                        {{ $archive->nama_file }}
                                    </a>
                                    <span class="file-details">
                                        ({{ $pendaftaran->nama_grup }} - {{ $pendaftaran->unit }})
                                    </span>
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach
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
        const pendaftaranFilter = document.getElementById('pendaftaran-filter');

        const archiveSections = document.querySelectorAll('.year-archive');
        const emptyState = document.getElementById('empty-state');

        // Fungsi utama untuk pencarian dan filter
        function filterAndSearchArchives() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedYear = yearFilter.value;
            const selectedPendaftaran = pendaftaranFilter.value;
    

            let hasVisibleSection = false;

            archiveSections.forEach(section => {
                const archiveItems = section.querySelectorAll('.archive-list li');
                const sectionYear = section.getAttribute('data-year');
                let hasVisibleItem = false;

                archiveItems.forEach(item => {
                    const itemText = item.textContent.toLowerCase();
                    const pendaftaranId = item.getAttribute('data-pendaftaran');


                    // Logika Pencocokan
                    const matchesSearch = searchTerm === '' || itemText.includes(searchTerm);
                    const matchesYear = selectedYear === '' || sectionYear === selectedYear;
                    const matchesPendaftaran = selectedPendaftaran === '' || pendaftaranId === selectedPendaftaran;


                    // Tentukan apakah item ditampilkan
                    if (matchesSearch && matchesYear && matchesPendaftaran) {
                        item.style.display = 'block';
                        hasVisibleItem = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Tampilkan/sembunyikan section berdasarkan hasil filter
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

        // Add transition delay to cards for staggered animation
        archiveSections.forEach((section, index) => {
            section.style.animationDelay = `${index * 0.1}s`;
        });

        // Event listeners untuk semua filter dan input
        searchInput.addEventListener('input', filterAndSearchArchives);
        yearFilter.addEventListener('change', filterAndSearchArchives);
        pendaftaranFilter.addEventListener('change', filterAndSearchArchives);


        // Initialize search on page load
        filterAndSearchArchives();
    });
</script>
@endsection
