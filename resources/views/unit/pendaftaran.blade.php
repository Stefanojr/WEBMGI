@extends('unit.layout.main')
@section('title', 'Form Pendaftaran')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/background.css">
    <link rel="stylesheet" href="../../css/formDaftar.css">
    <link rel="stylesheet" href="../../css/tableUnitDaftar.css">
    <link rel="stylesheet" href="../../css/responsive.css">

    <div class="container">
        @if(session('success'))
        <script>
            alert("{{ session('success') }}");
            window.location.href = "{{ route('/unit/daftarImprovement') }}";
        </script>
    @endif
        <h1>PERMOHONAN PENDAFTARAN SGA & SCFT</h1>

        <!-- Error Handling -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Form Identitas Grup -->
            <div class="form-group" style="display: none;">
                <input type="text" name="id_user" value="{{ $userId }}" hidden>
            </div>
            <div class="section-title">IDENTITAS GRUP</div>
            <div class="form-group">
                <label for="kreteria_grup">
                    <i class="fas fa-layer-group"></i> Kriteria Improvement
                </label>
                <select class="pilih" id="kreteria_grup" name="kreteria_grup" required>
                    <option value="" disabled selected>Pilih Kriteria</option>
                    <option value="scft">SIDO CROSS FUNCTIONAL TEAM (SCFT)</option>
                    <option value="sga">SIDO GROUP ACTIVITY (SGA)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pabrik">
                    <i class="fas fa-industry"></i> Pabrik / Departemen
                </label>
                <select id="pabrik" name="id_perusahaan" required>
                    <option value="" disabled selected>Pilih Pabrik</option>
                    @foreach ($perusahaans as $perusahaan)
                        <option value="{{ $perusahaan->id_perusahaan }}"
                            {{ old('pabrik') == $perusahaan->id_perusahaan ? 'selected' : '' }}>
                            {{ $perusahaan->nama_perusahaan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="unit">
                    <i class="fas fa-building"></i> Unit
                </label>
                <select id="unit" name="unit" required>
                    <option value="" disabled selected>Pilih Unit</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_grup">
                    <i class="fas fa-users"></i> Nama Grup
                </label>
                <input type="text" id="nama_grup" name="nama_grup" value="{{ old('nama_grup') }}" required placeholder="Masukkan Nama Grup">
            </div>

            <!-- Tema -->
            <div class="section-title">KETERANGAN TEMA</div>
            <div class="form-group">
                <label for="nomor-tema">
                    <i class="fas fa-hashtag"></i> Nomor Tema
                </label>
                <input type="text" id="nomor_tema" name="nomor_tema" value="{{ old('nomor_tema') }}" required placeholder="Contoh: 01">
            </div>

            <div class="form-group">
                <label for="judul">
                    <i class="fas fa-heading"></i> Judul
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required placeholder="Masukkan Judul ">
            </div>
            <div class="form-group">
                <label for="tema">
                    <i class="fas fa-lightbulb"></i> Tema
                </label>
                <input type="text" id="tema" name="tema" value="{{ old('tema') }}" required placeholder="Masukkan Tema ">
            </div>

            <!-- Struktur Organisasi Grup -->
            <div class="section-title">STRUKTUR ORGANISASI</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="jabatan_grup">
                        <i class="fas fa-id-badge"></i> Jabatan
                    </label>
                    <select name="grup_temp[jabatan_grup]" id="jabatan_grup">
                        <option value="" disabled selected>Pilih Jabatan</option>
                        <option value="sponsor">Sponsor</option>
                        <option value="fasilitator">Fasilitator</option>
                        <option value="ketua">Ketua</option>
                        <option value="sekretaris">Sekretaris</option>
                        <option value="anggota">Anggota</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-id-card"></i> Perner
                    </label>
                    <input type="text" name="grup_temp[perner]" placeholder="Masukkan Nomor Perner">
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-user"></i> Nama
                    </label>
                    <input type="text" name="grup_temp[nama]" placeholder="Masukkan Nama Anggota">
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-camera"></i> Foto
                    </label>
                    <input type="file" name="grup_temp[foto]" accept=".jpg, .jpeg, .png" class="file-input">
                </div>
            </div>
            <input type="hidden" name="grup_data" id="grup_data">
            <button type="button" class="insert-btn" onclick="addGrup()">
                <i class="fas fa-user-plus"></i> Anggota
            </button>

            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Jabatan</th>
                            <th>Perner</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="grup-table-body">
                    </tbody>
                </table>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i> SUBMIT
            </button>
        </form>

        @push('scripts')
            <!-- jQuery CDN -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#pabrik').on('change', function() {
                        var perusahaanId = $(this).val();

                        // Kosongkan dropdown unit sebelum mengisi data baru
                        $('#unit').empty().append('<option value="" disabled selected>Loading...</option>');

                        if (perusahaanId) {
                            $.ajax({
                                url: '/unitByPerusahaan/' + perusahaanId,
                                type: 'GET',
                                success: function(data) {
                                    $('#unit').empty().append(
                                        '<option value="" disabled selected>Pilih Unit</option>');
                                    $.each(data, function(key, unit) {
                                        $('#unit').append('<option value="' + unit.id_unit +
                                            '">' + unit.nama_unit + '</option>');
                                    });
                                },
                                error: function() {
                                    alert('Gagal memuat data unit');
                                    $('#unit').html('<option value="" disabled selected>Pilih Unit</option>');
                                }
                            });
                        } else {
                            $('#unit').empty().append('<option value="" disabled selected>Pilih Unit</option>');
                        }
                    });
                });

                var grupData = [];
                var grupIndex = 0;

                function addGrup() {
                    var jabatan = document.querySelector('[name="grup_temp[jabatan_grup]"]').value;
                    var perner = document.querySelector('[name="grup_temp[perner]"]').value;
                    var nama = document.querySelector('[name="grup_temp[nama]"]').value;
                    var fotoInput = document.querySelector('[name="grup_temp[foto]"]');
                    var foto = fotoInput.files[0];

                    if (!jabatan || !perner || !nama) {
                        alert("Semua kolom harus diisi!");
                        return;
                    }

                    var fotoUrl = foto ? URL.createObjectURL(foto) : null;

                    grupData.push({
                        jabatan,
                        perner,
                        nama,
                        foto: foto ? foto.name : "Tidak ada foto"
                    });

                    var tableBody = document.getElementById("grup-table-body");
                    var newRow = `
                        <tr id="grup-row-${grupIndex}" class="fade-in">
                            <td>${jabatan}</td>
                            <td>${perner}</td>
                            <td>${nama}</td>
                            <td>
                                ${foto ? `<a href="${fotoUrl}" target="_blank">${foto.name}</a>` : 'Tidak ada foto'}
                            </td>
                            <td>
                                <button type="button" class="delete-btn" onclick="removeGrup(${grupIndex})">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    `;

                    tableBody.insertAdjacentHTML('beforeend', newRow);

                    // Clear form fields after adding
                    document.querySelector('[name="grup_temp[jabatan_grup]"]').value = '';
                    document.querySelector('[name="grup_temp[perner]"]').value = '';
                    document.querySelector('[name="grup_temp[nama]"]').value = '';
                    fotoInput.value = '';

                    grupIndex++;
                    updateGrupDataInput();
                }

                function removeGrup(index) {
                    var row = document.getElementById(`grup-row-${index}`);

                    // Add fade-out animation
                    row.classList.add('fade-out');

                    // After animation completes, remove the row
                    setTimeout(function() {
                        grupData.splice(index, 1);
                        if (row) {
                            row.remove();
                        }
                        updateGrupDataInput();
                    }, 300);
                }

                function updateGrupDataInput() {
                    var grupDataInput = document.getElementById('grup_data');
                    grupDataInput.value = JSON.stringify(grupData);
                }
            </script>


        @endpush
    </div>

@endsection
