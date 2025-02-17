<!DOCTYPE html>
<html lang="id">
<head>
    <title>Komite Page</title>
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
            const profilePopup = document.getElementById('profile-popup');
            profilePopup.style.display = (profilePopup.style.display === 'block') ? 'none' : 'block';
        }

        window.onload = setActiveMenu;
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img alt="Company Logo" height="50" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRZ2eBIK7J28Q2tzynxNN46eOCuHedxyjmm8MleF0TMQT_7cftWzZVdMEbRRnLFfC4BPtCCJIC3YHMQ2riJ-dYuHSpPFLadgOLqoe082QjKRNAsNKDi6BNt9GNncXb-VQhjszu061LFv6D6mFg6h9bhLlgzyK7I338dD5a9C0tTpYvqodxfSxR0oyYTeBF/w1200-h630-p-k-no-nu/Sidomuncul%20Logo.png" width="150"/>
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
            <a href="/superadmin/report">
                <i class="fas fa-chart-bar"></i>
                Report SMIF
            </a>
            <a href="/superadmin/arsip">
                <i class="fas fa-folder"></i>
                Arsip SMIF
            </a>
        </div>
        <div class="logout">
            <img src="../images/gambarscft.png" class="logout-icon">
            <button onclick="confirmLogout()">
                <i class="fas fa-power-off"></i>
                Logout
            </button>
        </div>
    </div>
    <div class="content" style="flex-grow: 1;">
        <div class="topbar">
            <h3>E-SMIF</h3>

            <div class="profile-icon" onclick="toggleProfile()">K</div>
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
</body>
@stack('scripts')

</html>


