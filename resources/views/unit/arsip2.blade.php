@extends('unit.layout.main')

@section('title', 'Arsip Digital')

@section('content')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../css/responsive.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/arsipUnit.css') }}">


<div class="archive-content">
    <header class="main-header">
        <h2>ARSIP SMIF</h2>
    </header>

    <!-- Search and Filter Section -->
    <section class="search-filter">
        <input type="text" id="search-archive" placeholder="Cari Arsip..." class="search-input">

        <select id="year-filter" class="filter-dropdown">
            <option value="">Semua Tahun</option>
        </select>

        <select id="pendaftaran-filter" class="filter-dropdown">
            <option value="">Semua Pendaftaran</option>
        </select>

        <select id="user-filter" class="filter-dropdown">
            <option value="">Semua User</option>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-archive');
    const yearFilter = document.getElementById('year-filter');
    const pendaftaranFilter = document.getElementById('pendaftaran-filter');
    const userFilter = document.getElementById('user-filter');
    const archiveSection = document.getElementById('archive-section');
    const emptyState = document.getElementById('empty-state');
    let allArchives = [];

    function processData(data) {
        // Flatten the nested archives structure
        return data.reduce((acc, pendaftaran) => {
            if (pendaftaran.arsip && pendaftaran.arsip.length > 0) {
                pendaftaran.arsip.forEach(arsip => {
                    acc.push({
                        ...arsip,
                        id_pendaftaran: pendaftaran.id_pendaftaran,
                        id_user: pendaftaran.id_user,
                        created_at: arsip.created_at,
                        tahun: new Date(arsip.created_at).getFullYear()
                    });
                });
            }
            return acc;
        }, []);
    }

    function populateArchives(data) {
        allArchives = processData(data);
        renderArchives(allArchives);
        populateFilters(allArchives);
    }

    function renderArchives(archives) {
        archiveSection.innerHTML = '';

        if (archives.length === 0) {
            emptyState.style.display = 'flex';
            return;
        }

        // Group by year
        const archivesByYear = archives.reduce((acc, archive) => {
            const year = archive.tahun;
            if (!acc[year]) acc[year] = [];
            acc[year].push(archive);
            return acc;
        }, {});

        Object.entries(archivesByYear)
            .sort(([a], [b]) => b - a)
            .forEach(([year, archives], index) => {
                const yearSection = document.createElement('div');
                yearSection.className = 'year-archive';
                yearSection.dataset.year = year;

                const yearHeader = document.createElement('h2');
                yearHeader.textContent = year;
                yearSection.appendChild(yearHeader);

                const archiveList = document.createElement('ul');
                archiveList.className = 'archive-list';

                archives.forEach(archive => {
                    const li = document.createElement('li');
                    li.dataset.pendaftaran = archive.id_pendaftaran;
                    li.dataset.user = archive.id_user;

                    const link = document.createElement('a');
                    link.href = `/unit/download-archive/${archive.id_arsip}`;
                    link.textContent = archive.nama_file || 'Unnamed File';
                    link.title = `Pendaftaran: ${archive.id_pendaftaran} | User: ${archive.id_user}`;

                    archiveList.appendChild(li);
                    li.appendChild(link);
                });

                yearSection.appendChild(archiveList);
                archiveSection.appendChild(yearSection);
            });

        emptyState.style.display = archives.length === 0 ? 'flex' : 'none';
    }

    function populateFilters(archives) {
        // Populate year filter
        const years = [...new Set(archives.map(a => a.tahun))].sort((a, b) => b - a);
        years.forEach(year => {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearFilter.appendChild(option);
        });

        // Populate pendaftaran filter
        const pendaftaranIds = [...new Set(archives.map(a => a.id_pendaftaran))];
        pendaftaranIds.forEach(id => {
            const option = document.createElement('option');
            option.value = id;
            option.textContent = `Pendaftaran ${id}`;
            pendaftaranFilter.appendChild(option);
        });

        // Populate user filter
        const userIds = [...new Set(archives.map(a => a.id_user))];
        userIds.forEach(id => {
            const option = document.createElement('option');
            option.value = id;
            option.textContent = `User ${id}`;
            userFilter.appendChild(option);
        });
    }

    function filterArchives() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedYear = yearFilter.value;
        const selectedPendaftaran = pendaftaranFilter.value;
        const selectedUser = userFilter.value;

        const filtered = allArchives.filter(archive => {
            const matchesSearch = archive.nama_file.toLowerCase().includes(searchTerm);
            const matchesYear = !selectedYear || archive.tahun == selectedYear;
            const matchesPendaftaran = !selectedPendaftaran || archive.id_pendaftaran == selectedPendaftaran;
            const matchesUser = !selectedUser || archive.id_user == selectedUser;

            return matchesSearch && matchesYear && matchesPendaftaran && matchesUser;
        });

        renderArchives(filtered);
    }

    // Event Listeners
    [searchInput, yearFilter, pendaftaranFilter, userFilter].forEach(element => {
        element.addEventListener('input', filterArchives);
        element.addEventListener('change', filterArchives);
    });

    // Initial fetch
    @if(isset($archives) && count($archives) > 0)
        populateArchives(@json($archives));
    @else
        fetch('/unit/get-archives')
            .then(response => response.json())
            .then(populateArchives)
            .catch(error => {
                console.error('Error:', error);
                emptyState.style.display = 'flex';
            });
    @endif
});
</script>
@endpush

@endsection
