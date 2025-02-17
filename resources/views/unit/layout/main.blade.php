<html>
 <head>
  <title>
   Unit Page
  </title>
  <link rel="stylesheet" href="../../css/main.css">

  <script>
      function confirmLogout() {
            // Tampilkan pesan konfirmasi sebelum logout
            const isConfirmed = confirm("Apakah anda yakin akan logout?");
            if (isConfirmed) {
                // Jika pengguna mengonfirmasi, redirect ke halaman login
                window.location.href = '/';
            }
        }
    function logout() {
        // Redirect ke halaman login
        window.location.href = '/';
    }
     // Fungsi untuk menandai menu yang aktif
     function setActiveMenu() {
            const currentPath = window.location.pathname; // Mendapatkan path saat ini
            const menuItems = document.querySelectorAll('.menu a'); // Mengambil semua item menu

            menuItems.forEach(item => {
                // Jika href dari item menu sama dengan currentPath, tambahkan kelas 'active'
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }

        // Panggil fungsi setActiveMenu saat halaman dimuat
        window.onload = setActiveMenu;
        function toggleSubmenu(event, submenuId) {
    event.preventDefault(); // Mencegah navigasi langsung
    const submenu = document.getElementById(submenuId);

    // Toggle kelas 'active' pada submenu
    if (submenu.classList.contains('active')) {
        submenu.classList.remove('active');
    } else {
        submenu.classList.add('active');
    }


}

</script>

    </head>

    <body>
    <div class="sidebar">
    <div class="logo">
    <img alt="Company Logo" height="50" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRZ2eBIK7J28Q2tzynxNN46eOCuHedxyjmm8MleF0TMQT_7cftWzZVdMEbRRnLFfC4BPtCCJIC3YHMQ2riJ-dYuHSpPFLadgOLqoe082QjKRNAsNKDi6BNt9GNncXb-VQhjszu061LFv6D6mFg6h9bhLlgzyK7I338dD5a9C0tTpYvqodxfSxR0oyYTeBF/w1200-h630-p-k-no-nu/Sidomuncul%20Logo.png" width="150"/>
    </div>
    <div class="menu">
    <a class="active" href="/unit/home2">
     <i class="fas fa-home">
     </i>
     Dashboard
    </a>
    <a href="/unit/pendaftaran2">
        <i class="fas fa-pen"></i>
    Pendaftaran
        </a>
    <a class="active" href="/unit/daftarImprovement">
        <i class="fas fa-list">
        </i>
    Daftar Improvement
       </a>
       <a class="active" href="/unit/arsip2" onclick="toggleSubmenu('submenu-arsip')">
        <i class="fas fa-folder"></i>
        Arsip SMIF
    </a>
    <div id="submenu-arsip" class="submenu">
        <a href="/unit/arsipfoto2" class="submenu-item">
            <i class="fas fa-camera"></i>
         Arsip Foto
        </a>
    </div>

   </div>
   <div class="logout">
    <img src="../images/gambarscft.png" class="logout-icon">
    <!-- Panggil fungsi confirmLogout ketika tombol Logout diklik -->
    <button onclick="confirmLogout()">
        <i class="fas fa-power-off"></i>
        Logout
    </button>
</div>
</div>

  </div>
  <div class="content" style="flex-grow: 1;">
    <div class="topbar">
    <h3>E-SMIF</h3>

                <div class="profile-icon">U</div>

    </i>
   </div>
   <div class="main-content">
    @yield('content')
   </div>
</div>

 </body>
 @stack('scripts')
</html>


