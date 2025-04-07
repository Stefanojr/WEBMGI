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
                <div class="dropdown">
                    <div class="profile-icon" onclick="toggleProfile()">
                        {{ Auth::user()->nama_user[0] ?? 'V' }}
                    </div>
                    <div id="profile-dropdown" class="dropdown-content">
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ Auth::user()->nama_user[0] ?? 'V' }}
                            </div>
                            <div class="user-details">
                                <h4>{{ Auth::user()->nama_user ?? 'Unknown User' }}</h4>
                                <span class="user-role">Viewer</span>
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
                        <a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
   <div class="main-content">
    @yield('content')

 </body>
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
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
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
