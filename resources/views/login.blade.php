<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-SMIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="container">
            <div class="login-container">
                <div class="row g-0">
                    <!-- Left Column - Image Slideshow -->
                    <div class="col-md-6 d-none d-md-block">
                        <div class="slideshow-container">
                            <div class="slide-overlay"></div>
                            <div class="mySlides fade-in">
                                <img src="images/gambar1.jpg" alt="Slide 1">
                            </div>
                            <div class="mySlides fade-in">
                                <img src="images/gambar2.jpg" alt="Slide 2">
                            </div>
                            <div class="mySlides fade-in">
                                <img src="images/gambar3.png" alt="Slide 3">
                            </div>
                            <div class="mySlides fade-in">
                                <img src="images/gambar4.jpg" alt="Slide 4">
                            </div>

                        </div>
                    </div>
                    
                    <!-- Right Column - Login Form -->
                    <div class="col-md-6">
                        <div class="login-form-container">
                            <div class="logo-wrapper">
                                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRZ2eBIK7J28Q2tzynxNN46eOCuHedxyjmm8MleF0TMQT_7cftWzZVdMEbRRnLFfC4BPtCCJIC3YHMQ2riJ-dYuHSpPFLadgOLqoe082QjKRNAsNKDi6BNt9GNncXb-VQhjszu061LFv6D6mFg6h9bhLlgzyK7I338dD5a9C0tTpYvqodxfSxR0oyYTeBF/w1200-h630-p-k-no-nu/Sidomuncul%20Logo.png" alt="Logo Perusahaan" class="logo-image">
                            </div>

                            <form action="{{ url('/') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="perner" name="perner" placeholder="Perner / NIK" required>
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
                                    <button type="submit" class="btn btn-login">
                                        <span>Login</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                                
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                    </div>
                                @endif
                                
                                <div class="register-link">
                                    <span>Belum punya akun?</span>
                                    <a href="/pendaftaran/register">Daftar Akun Baru</a>
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
    </script>
</body>
</html>
