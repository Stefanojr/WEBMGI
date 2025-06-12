<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-SMIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="register-wrapper">
        <div class="container">
            <div class="register-container">
                <div class="row g-0">
                    <!-- Left Column - Image Slideshow -->
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="slideshow-container">
                            <div class="slide-overlay"></div>
                            <div class="mySlides fade-in">
                                <img src="../images/gambar1.jpg" alt="Slide 1">
                            </div>
                            <div class="mySlides fade-in">
                                <img src="../images/gambar2.jpg" alt="Slide 2">
                            </div>
                            <div class="mySlides fade-in">
                                <img src="../images/gambar3.png" alt="Slide 3">
                            </div>
                            <div class="mySlides fade-in">
                                <img src="../images/gambar4.jpg" alt="Slide 4">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Register Form -->
                    <div class="col-lg-7">
                        <div class="register-form-container">
                            <div class="logo-wrapper">
                                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRZ2eBIK7J28Q2tzynxNN46eOCuHedxyjmm8MleF0TMQT_7cftWzZVdMEbRRnLFfC4BPtCCJIC3YHMQ2riJ-dYuHSpPFLadgOLqoe082QjKRNAsNKDi6BNt9GNncXb-VQhjszu061LFv6D6mFg6h9bhLlgzyK7I338dD5a9C0tTpYvqodxfSxR0oyYTeBF/w1200-h630-p-k-no-nu/Sidomuncul%20Logo.png" alt="Logo Perusahaan" class="logo-image">
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                                </div>
                                <script>
                                    setTimeout(function() {
                                        window.location.href = '/';
                                    }, 2000);
                                </script>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('register.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Nama Lengkap" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" id="perner" name="perner" placeholder="Perner / NIK" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email_user" name="email_user" placeholder="Email" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <span class="toggle-password" onclick="togglePassword()">
                                            <i class="fas fa-eye" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-building"></i></span>
                                        <select class="form-select" id="id_perusahaan" name="id_perusahaan" required>
                                            <option value="">Pilih Perusahaan</option>
                                            @foreach ($perusahaan as $item)
                                                <option value="{{ $item->id_perusahaan }}">{{ $item->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-sitemap"></i></span>
                                        <select class="form-select" id="id_unit" name="id_unit" required>
                                            <option value="">Pilih Unit</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-register">
                                        <span>Daftar</span>
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>

                                <div class="login-link">
                                    <span>Sudah punya akun?</span>
                                    <a href="/">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Slideshow functionality
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("mySlides");

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }

            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 4000); // Change slide every 4 seconds
        }

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }

        // Handle unit selection based on company choice
        document.getElementById('id_perusahaan').addEventListener('change', function() {
            let perusahaanId = this.value;
            let unitDropdown = document.getElementById('id_unit');
            unitDropdown.innerHTML = '<option value="">Pilih Unit</option>';

            if (perusahaanId) {
                fetch(`/unitByPerusahaan/${perusahaanId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(unit => {
                            let option = document.createElement('option');
                            option.value = unit.id_unit;
                            option.text = unit.nama_unit;
                            unitDropdown.add(option);
                        });
                    })
                    .catch(error => console.error(error));
            }
        });
    </script>
</body>
</html>
