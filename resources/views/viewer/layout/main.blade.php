<html>
 <head>
  <title>
   Viewer Page
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../css/main.css">
  <script>
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
</script>

    </head>

    <body>
    <div class="sidebar">
    <div class="logo">
    <img alt="Company Logo" height="50" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRZ2eBIK7J28Q2tzynxNN46eOCuHedxyjmm8MleF0TMQT_7cftWzZVdMEbRRnLFfC4BPtCCJIC3YHMQ2riJ-dYuHSpPFLadgOLqoe082QjKRNAsNKDi6BNt9GNncXb-VQhjszu061LFv6D6mFg6h9bhLlgzyK7I338dD5a9C0tTpYvqodxfSxR0oyYTeBF/w1200-h630-p-k-no-nu/Sidomuncul%20Logo.png" width="150"/>
    </div>
    <div class="menu">
    <a class="active" href="/viewer/home3">
     <i class="fas fa-home">
     </i>
     Dashboard
    </a>
    <a href="/viewer/pendaftaran3">
    <i class="fas fa-file-alt">
    </i>
     Pendaftaran Improvement
    </a>
    <a href="/viewer/risalah3">
    <i class="fas fa-file"></i>
     Risalah Improvement
    </a>
    <a href="/viewer/approval3">
    <i class="fas fa-comment">
     </i>
     Approval
    </a>
   </div>
   <div class="logout">
    <button onclick="logout()">
        <i class="fas fa-power-off"></i>
        Logout
    </button>
</div>
  </div>
  <div class="content" style="flex-grow: 1;">
    <div class="topbar">
    <h3>Welcome, Officer!</h3>
                <div class="profile-icon"></div>
            </div>
   <div class="main-content">
    @yield('content')

 </body>
</html>
