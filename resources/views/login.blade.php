<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/login.css">

</head>
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5">
                    <div class="login-container">
                        <!-- Slideshow Container -->
                        <div class="slideshow-container">
                            <div class="mySlides">
                                <img src="images/gambar1.jpg" style="width:100%">
                            </div>
                            <div class="mySlides">
                                <img src="images/gambar2.jpg" style="width:100%">
                            </div>
                            <div class="mySlides">
                                <img src="images/gambar3.png" style="width:100%" height="100%">
                            </div>
                            <div class="mySlides">
                                <img src="images/gambar4.jpg" style="width:100%">
                            </div>
                        </div>

                        <!-- Logo Perusahaan -->
                        <img src="https://ajaib.co.id/wp-content/uploads/2020/09/logo-sidomuncul.png" alt="Logo Perusahaan" class="logo-image"/>

                        <!-- Form Login -->
                        <form action="{{ url('/') }}" method="POST">
                            @csrf
                            <!-- Input Nomor Perner -->
                            <div class="mb-3">
                                <input type="text" class="form-control" id="perner" name="perner" placeholder="Perner / NIK" required>
                            </div>
                            <!-- Input Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <!-- Tombol Login -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Login</button>
                            </div>

                            <!-- Pesan Error -->
                            @if (session('error'))
                                <div class="alert alert-danger mt-3">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Link Pendaftaran -->
                            <div class="text-right">
                                <span>Belum punya akun?</span>
                                <a href="javascript:void(0);" onclick="window.location.href='/pendaftaran/register';">Daftar Akun Baru</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
            if (slideIndex > slides.length) { slideIndex = 1 }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 3000); // Ganti slide setiap 3 detik
        }
    </script>
</body>
</html>
