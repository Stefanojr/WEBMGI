<!DOCTYPE html>
<html lang="id">

<head>
    <title>E-SMIF</title>
    <link rel="stylesheet" href="../../css/main.css">
    <script>
        function confirmLogout() {
            const isConfirmed = confirm("Apakah anda yakin akan logout?");
            if (isConfirmed) {
                window.location.href = '/';
            }
        }

        function logout() {
            window.location.href = '/';
        }

        function setActiveMenu() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu a');

            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }

        function toggleProfile() {
            const profileDropdown = document.getElementById('profile-dropdown');
            if (profileDropdown.classList.contains('show')) {
                profileDropdown.classList.remove('show');
            } else {
                profileDropdown.classList.add('show');
            }
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.profile-icon')) {
                const dropdowns = document.getElementsByClassName('dropdown-content');
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        window.onload = function() {
            setActiveMenu();
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img alt="Company Logo" height="50"
                src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRZ2eBIK7J28Q2tzynxNN46eOCuHedxyjmm8MleF0TMQT_7cftWzZVdMEbRRnLFfC4BPtCCJIC3YHMQ2riJ-dYuHSpPFLadgOLqoe082QjKRNAsNKDi6BNt9GNncXb-VQhjszu061LFv6D6mFg6h9bhLlgzyK7I338dD5a9C0tTpYvqodxfSxR0oyYTeBF/w1200-h630-p-k-no-nu/Sidomuncul%20Logo.png"
                width="150" />
        </div>
        <div class="menu">
            <a href="/superadmin/home">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            <a href="/superadmin/daftarApproval">
                <i class="fas fa-check"></i>
                Daftar Approval
            </a>
            <a href="/superadmin/daftarImprovementSA">
                <i class="fas fa-list"></i>
                Daftar Improvement
            </a>
            {{-- <a href="/superadmin/report">
                <i class="fas fa-chart-bar"></i>
                Report SMIF
            </a> --}}
            <a href="/superadmin/arsip">
                <i class="fas fa-folder"></i>
                Arsip SMIF
            </a>
            <a href="/users">
                <i class="fas fa-users"></i>
                Data User
            </a>


            <a href="/superadmin/masterData">
                <i class="fas fa-database"></i>
                Master Data

            </a>


        </div>
        <div class="logout">
            <img src="../images/gambarscft.png" class="logout-icon">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
            <button type="submit">
                <i class="fas fa-power-off"></i>
                Logout
            </button>
        </div>
    </div>
    <div class="content">
        <div class="topbar">
            <h3>E-SMIF</h3>

            <div class="dropdown">
                <div class="profile-icon" onclick="toggleProfile()">
                    {{ Auth::user()->nama_user[0] ?? 'K' }}
                </div>
                <div id="profile-dropdown" class="dropdown-content">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ Auth::user()->nama_user[0] ?? 'K' }}
                        </div>
                        <div class="user-details">
                            <h4>{{ Auth::user()->nama_user ?? 'Unknown User' }}</h4>
                            <span class="user-role">Komite</span>
                        </div>
                    </div>
                    <div class="user-metadata">
                        <div class="metadata-item">
                            <span class="label">ID User:</span>
                            <span class="value">{{ Auth::user()->id_user ?? '-' }}</span>
                        </div>
                        <div class="metadata-item">
                            <span class="label">Perner:</span>
                            <span class="value">{{ Auth::user()->perner ?? '-' }}</span>
                        </div>
                        <div class="metadata-item">
                            <span class="label">Email:</span>
                            <span class="value">{{ Auth::user()->email_user ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    <!-- Bootstrap JS (dengan Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')

<style>
    /* Profile Dropdown Styling */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        position: absolute;
        right: 0;
        top: 55px;
        background-color: white;
        min-width: 280px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .dropdown-content.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px 15px;
        background: linear-gradient(90deg, #4a6b4f 0%, #3d5a41 100%);
        color: white;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 500;
    }

    .user-details h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: 600;
    }

    .user-role {
        font-size: 12px;
        opacity: 0.8;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 3px 8px;
        border-radius: 10px;
    }

    .user-metadata {
        padding: 15px;
        background-color: #f8f9fa;
    }

    .metadata-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 13px;
    }

    .metadata-item .label {
        font-weight: 500;
        color: #6c757d;
    }

    .metadata-item .value {
        color: #495057;
        font-weight: 500;
    }

    .dropdown-divider {
        height: 1px;
        background-color: #e9ecef;
        margin: 0;
    }

    .dropdown-content a {
        color: #495057;
        padding: 14px 16px;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .dropdown-content a i {
        margin-right: 10px;
        font-size: 16px;
        color: #4a6b4f;
    }

    .dropdown-content a:hover {
        background-color: #f8f9fa;
        color: #4a6b4f;
    }
</style>

</html>
