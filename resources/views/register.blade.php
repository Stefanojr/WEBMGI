<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/register.css">
</head>
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5">
                    <div class="login-container">
                        <h2 class="mb-4">Registrasi Akun</h2>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    window.location.href = '/';
                                }, 2000);
                            </script>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_user" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                            </div>
                            <div class="form-group">
                                <label for="perner" class="form-label">Perner / NIK</label>
                                <input type="text" class="form-control" id="perner" name="perner" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="email_user" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email_user" name="email_user" required>
                            </div>
                            <div class="form-group">
                                <label for="id_perusahaan" class="form-label">Perusahaan</label>
                                <select class="form-select" id="id_perusahaan" name="id_perusahaan" required>
                                    <option value="">-- Pilih Perusahaan --</option>
                                    @foreach ($perusahaan as $item)
                                        <option value="{{ $item->id_perusahaan }}">{{ $item->nama_perusahaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_unit" class="form-label">Unit</label>
                                <select class="form-select" id="id_unit" name="id_unit" required>
                                    <option value="">-- Pilih Unit --</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>

                        <div class="text-right mt-3">
                            <span>Sudah punya akun?</span>
                            <a href="/">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('id_perusahaan').addEventListener('change', function() {
            let perusahaanId = this.value;
            let unitDropdown = document.getElementById('id_unit');
            unitDropdown.innerHTML = '<option value="">-- Pilih Unit --</option>';
            fetch(`/api/units/${perusahaanId}`)
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
        });
    </script>
</body>
</html>
