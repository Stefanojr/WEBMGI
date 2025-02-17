<section class="vh-100">
    <link rel="stylesheet" href="welcome.css">
    <script src="script.js"></script>
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6"></div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form id="login-form" onsubmit="return validateForm()">
                    <html>
                    <head>
                        <link rel="stylesheet" href="../../css/login.css">
                        <title>Register Page</title>
                    </head>
                    <body>
                        <div class="login-container" style="text-align: center;">
                            <!-- Logo Image -->
                            <img src="https://ajaib.co.id/wp-content/uploads/2020/09/logo-sidomuncul.png" alt="Company Logo" class="logo-image"/>
                            <div class="form-group">
                                <select id="pabrik" name="pabrik" required>
                                    <option value="" disabled selected>Pilih Pabrik</option>
                                    <option value="pabrik1">Sido Muncul (SM)</option>
                                    <option value="pabrik2">Semarang Herbal Indoplant (SHI)</option>
                                    <option value="pabrik3">Sido Muncul Pupuk Nusantara (SMPN)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="unit" name="unit" required>
                                    <option value="" disabled selected>Pilih Unit</option>
                                    <option value="unit1">Unit 1</option>
                                    <option value="unit2">Unit 2</option>
                                    <option value="unit3">Unit 3</option>
                                </select>
                            </div>

                            <!-- Email Input -->
                            <input type="text" id="email" placeholder="Email" style="display: inline-block; width: 100%; margin: 10px 0;" required/>

                            <!-- Nomor Perner Input -->
                            <input type="text" id="perner" placeholder="Perner / NIK" style="display: inline-block; width: 100%; margin: 10px 0;" required/>

                            <!-- Password Input -->
                            <input type="password" id="password" placeholder="Password" style="display: inline-block; width: 100%; margin: 10px 0;" required/>

                            <!-- Submit Button -->
                            <button type="submit" id="daftar-btn" style="display: inline-block; width: 100%; margin: 10px 0;">Daftar</button>

                            <!-- Link to Login Page -->
                            <div class="text-right">
                                <span>Sudah punya akun?</span>
                                <a href="javascript:void(0);" onclick="window.location.href='/';">Masuk</a>
                            </div>

                        </div>

                        <script>
                            // Function to validate form
                            function validateForm() {
                                var email = document.getElementById('email').value;
                                var perner = document.getElementById('perner').value;
                                var password = document.getElementById('password').value;
                                var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

                                // Check if email is valid
                                if (!email.match(emailPattern)) {
                                    alert("Please enter a valid Gmail address.");
                                    return false;  // Prevent form submission if email is not valid
                                }

                                // Check if all fields are filled
                                if (email === "" || perner === "" || password === "") {
                                    alert("Please fill in all fields.");
                                    return false;  // Prevent form submission if fields are empty
                                }

                                // Show success message and redirect to login page
                                alert("Pendaftaran berhasil!");
                                window.location.href = "/";  // Redirect to the login page
                                return false;  // Prevent default form submission
                            }
                        </script>
                    </body>
                    </html>
                </form>
            </div>
        </div>
    </div>
</section>
