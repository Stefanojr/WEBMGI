<section class="vh-100">
    <link rel="stylesheet" href="welcome.css">
    <script src="script.js"></script>
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form id="login-form">
                    <!-- Nomor Perner and Password input -->
                    <html>
                    <head>
                        <link rel="stylesheet" href="../../css/login.css">
                        <title>Login Page</title>
                    </head>
                    <body>
                        <div class="login-container" style="text-align: center;">
                            <!-- Slideshow Container -->
                            <div class="slideshow-container">
                                <div class="mySlides">
                                    <img src="images/gambar1.jpg" alt="Image 1">
                                    <div class="text"></div>
                                </div>
                                <div class="mySlides">
                                    <img src="images/gambar2.jpg" alt="Image 2">
                                    <div class="text"></div>
                                </div>
                                <div class="mySlides">
                                    <img src="images/gambar3.png" alt="Image 3">
                                    <div class="text"></div>
                                </div>
                                <div class="mySlides">
                                    <img src="images/gambar4.jpg" alt="Image 4">
                                    <div class="text"></div>
                                </div>
                            </div>

                            <!-- Logo Image -->
                            <img src="https://ajaib.co.id/wp-content/uploads/2020/09/logo-sidomuncul.png" alt="Company Logo" class="logo-image"/>

                            <input type="text" id="perner" placeholder="Nomor Perner" style="display: inline-block; width: 100%; margin: 10px 0;"/>
                            <input type="password" id="password" placeholder="Password" style="display: inline-block; width: 100%; margin: 10px 0;"/>

                            <button id="login-btn" style="display: inline-block; width: 100%; margin: 10px 0;">Log In</button>
                            <div class="text-right">
                                <span>Belum punya akun?</span>
                                <a href="javascript:void(0);" onclick="window.location.href='/pendaftaran/register';">Daftar Akun Baru</a>
                            </div>

                        </div>

                        <script>
                            let slideIndex = 0;
                            showSlides();

                            function showSlides() {
                                let i;
                                let slides = document.getElementsByClassName("mySlides");
                                for (i = 0; i < slides.length; i++) {
                                    slides[i].style.display = "none";
                                }
                                slideIndex++;
                                if (slideIndex > slides.length) {slideIndex = 1}

                                slides[slideIndex - 1].style.display = "block";
                                slides[slideIndex - 1].style.animation = "slide 1s forwards"; // Menambahkan animasi slide

                                setTimeout(showSlides, 3000); // Ubah slide setiap 3 detik
                            }

                            const loginBtn = document.getElementById('login-btn');
                            const pernerInput = document.getElementById('perner');
                            const passwordInput = document.getElementById('password');

                            loginBtn.addEventListener('click', (e) => {
                                e.preventDefault();

                                const perner = pernerInput.value;
                                const password = passwordInput.value;

                                const userRole = authenticateUser(perner, password);

                                if (userRole) {
                                    alert('Successful login!');
                                    switch (userRole) {
                                        case 'superadmin':
                                            window.location.href = 'superadmin/home';
                                            break;
                                        case 'unit':
                                            window.location.href = 'unit/home2';
                                            break;
                                        case 'sysadmin':
                                            window.location.href = 'sysadmin/home4'; // Halaman untuk sysadmin
                                            break;
                                        default:
                                            alert('Invalid nomor perner or password');
                                    }
                                } else {
                                    alert('Invalid nomor perner or password');
                                }
                            });

                            function authenticateUser(perner, password) {
                                // Pengguna superadmin
                                const superadmins = [
                                    { perner: '12345', password: 'SA123' },
                                    { perner: '12346', password: 'SA456' },
                                    { perner: '12347', password: 'SA789' },
                                    { perner: '12348', password: 'SA111' },
                                ];

                                // Pengguna unit
                                const units = [
                                    { perner: '23456', password: 'U123' },
                                    { perner: '23457', password: 'U444' },
                                    { perner: '23458', password: 'U789' },
                                ];

                                // Pengguna sysadmin
                                const sysadmins = [
                                    { perner: '34567', password: 'SY1234' },
                                    { perner: '34568', password: 'SY5678' },
                                ];

                                // Cekrole superadmin
                                for (let admin of superadmins) {
                                    if (perner === admin.perner && password.startsWith('SA')) {
                                        return 'superadmin';
                                    }
                                }

                                // Cekrole unit
                                for (let unit of units) {
                                    if (perner === unit.perner && password.startsWith('U')) {
                                        return 'unit';
                                    }
                                }

                                // Cekrole sysadmin
                                for (let sysadmin of sysadmins) {
                                    if (perner === sysadmin.perner && password.startsWith('SY')) {
                                        return 'sysadmin'; // Mengembalikan role sysadmin
                                    }
                                }

                                // Jika tidak ada yang cocok
                                return null;
                            }
                        </script>
                    </body>
                    </html>
                </form>
            </div>
        </div>
    </div>
</section>
