@extends('superadmin.layout.main')
@section('title', 'Risalah')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daftar Pengajuan</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <link rel="stylesheet" href="../../css/tableSADash.css">
    </head>

    <body>
        <div class="table-container">
            <h2>DAFTAR IMPROVEMENT GRUP</h2>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Grup</th>
                            <th>Unit</th>
                            <th>Perusahaan</th>
                            <th>Kriteria</th>
                            <th>Tema</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Tahapan</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($pendaftarans as $key => $pendaftaran)
                            <tr data-id="{{ $pendaftaran->id_pendaftaran }}" class="data-row">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <button class="popup-btn-id" data-id="{{ $pendaftaran->id_pendaftaran }}">
                                        {{ $pendaftaran->id_pendaftaran }}
                                    </button>
                                </td>
                                <td>{{ $pendaftaran->nama_grup }}</td>
                                <td>{{ $pendaftaran->unit }}</td>
                                <td>{{ $pendaftaran->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td>{{ $pendaftaran->kreteria_grup }}</td>
                                <td>{{ $pendaftaran->tema }}</td>
                                <td>{{ $pendaftaran->judul }}</td>
                                <td>{{ $pendaftaran->updated_at ? $pendaftaran->updated_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <button class="popup-btn-status">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

        <!-- Popup Struktur Anggota -->
        <div class="popup" id="popup">
            {{-- <span class="close-btn" id="close-btn">&times;</span> --}}
            <h3>Struktur Anggota</h3>
            <form id="struktur-form">
                <div class="team-info">
                    <div class="team-id">
                        <div class="input-container">
                            <label for="id-pendaftaran">ID Pendaftaran</label>
                            <input type="text" id="id-pendaftaran" name="id-pendaftaran" readonly>
                        </div>
                    </div>

                    <div class="leadership-grid">
                        <div class="member-card sponsor-card">
                            <div class="member-role">
                                <i class="fas fa-star"></i>
                                <span>Sponsor</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="sponsor" name="sponsor" readonly placeholder="Nama Sponsor">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="sponsor-perner" name="sponsor-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>

                        <div class="member-card fasilitator-card">
                            <div class="member-role">
                                <i class="fas fa-user-tie"></i>
                                <span>Fasilitator</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="fasilitator" name="fasilitator" readonly placeholder="Nama Fasilitator">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="fasilitator-perner" name="fasilitator-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>

                        <div class="member-card ketua-card">
                            <div class="member-role">
                                <i class="fas fa-chess-king"></i>
                                <span>Ketua</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="ketua" name="ketua" readonly placeholder="Nama Ketua">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="ketua-perner" name="ketua-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>

                        <div class="member-card sekretaris-card">
                            <div class="member-role">
                                <i class="fas fa-pen-fancy"></i>
                                <span>Sekretaris</span>
                            </div>
                            <div class="member-data">
                                <div class="member-name">
                                    <input type="text" id="sekretaris" name="sekretaris" readonly placeholder="Nama Sekretaris">
                                </div>
                                <div class="member-perner">
                                    <input type="text" id="sekretaris-perner" name="sekretaris-perner" readonly placeholder="Perner">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota Grup -->
                    <div class="team-members">
                        <div class="team-members-header">
                            <i class="fas fa-users"></i>
                            <h4>Anggota Tim</h4>
                        </div>
                        <div id="anggota-container" class="anggota-container"></div>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="popup-close" id="popup-close-id">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </form>
        </div>


        <!-- Popup Table Status -->
        <div class="overlay" id="overlay-tahapan"></div>

        <div class="popup" id="popup-tahapan">
            <h2>Detail Status</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Approval</th>
                        <th>Tahapan</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Komentar</th>
                    </tr>
                </thead>
                <tbody id="tahapan-body">
                    <!-- Data akan dimasukkan melalui JavaScript -->
                </tbody>
            </table>
            <div class="form-actions">
                <button class="popup-close" id="close-tahapan">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>

        @push('scripts')
            <script>
                document.querySelectorAll('.popup-btn-status').forEach(button => {
                    button.addEventListener('click', function() {
                        const idPendaftaran = this.closest('tr').getAttribute('data-id');
                        const namaGrup = this.closest('tr').querySelector('td:nth-child(3)').textContent;

                        document.getElementById('overlay-tahapan').style.display = 'block';
                        document.getElementById('popup-tahapan').style.display = 'block';

                        fetch(`/superadmin/files/pendaftaran/${idPendaftaran}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Received data:', data);
                                const tbody = document.getElementById('tahapan-body');
                                tbody.innerHTML = '';

                                if (data.length > 0) {
                                    data.forEach(item => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                                            <td>${item.tanggal || '-'}</td>
                                            <td>${item.tahapan || '-'}</td>
                                            <td><a href="${item.file}" target="_blank">Download</a></td>
                                            <td><span class="status-badge ${item.status}">${item.status}</span></td>
                                            <td>${item.komentar || '-'}</td>
                                        `;
                                        tbody.appendChild(row);
                                    });
                                } else {
                                    tbody.innerHTML = '<tr><td colspan="5">No data available</td></tr>';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                const tbody = document.getElementById('tahapan-body');
                                tbody.innerHTML = '<tr><td colspan="5">Error loading data</td></tr>';
                            });
                    });
                });

                // Fungsi untuk menutup popup
                document.getElementById('close-tahapan').addEventListener('click', function() {
                    document.getElementById('overlay-tahapan').style.display = 'none';
                    document.getElementById('popup-tahapan').style.display = 'none';
                });
            </script>



            <script>
                document.querySelectorAll('.popup-btn-id').forEach(button => {
                    button.addEventListener('click', function() {
                        // Menampilkan popup
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('popup').style.display = 'block';

                        const idPendaftaran = button.getAttribute('data-id'); // Mengambil data-id dari button

                        // Bersihkan container anggota sebelum memuat data baru
                        const anggotaContainer = document.getElementById('anggota-container');
                        anggotaContainer.innerHTML = ''; // Hapus semua elemen di dalam container

                        // Ambil data dari server berdasarkan id_pendaftaran
                        fetch(`/superadmin/daftarImprovementSA/${idPendaftaran}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data); // Debug: Periksa apakah data diterima

                                // Menampilkan id_pendaftaran di form
                                document.getElementById('id-pendaftaran').value = data[0]
                                    .id_pendaftaran; // Pastikan data.id_pendaftaran ada

                                // Menampilkan data anggota ke input form berdasarkan jabatan_grup
                                data.forEach((grup, index) => {
                                    if (grup.jabatan_grup === 'sponsor') {
                                        document.getElementById('sponsor').value = grup.nama || '-';
                                        document.getElementById('sponsor-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'fasilitator') {
                                        document.getElementById('fasilitator').value = grup.nama || '-';
                                        document.getElementById('fasilitator-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'ketua') {
                                        document.getElementById('ketua').value = grup.nama || '-';
                                        document.getElementById('ketua-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'sekretaris') {
                                        document.getElementById('sekretaris').value = grup.nama || '-';
                                        document.getElementById('sekretaris-perner').value = grup.perner || '-';
                                    } else if (grup.jabatan_grup === 'anggota') {
                                        // Create anggota card with improved styling
                                        const divAnggota = document.createElement('div');
                                        divAnggota.classList.add('input-container');

                                        // Label Anggota
                                        const label = document.createElement('label');
                                        label.textContent = `Anggota ${index + 1}`;
                                        divAnggota.appendChild(label);

                                        // Input untuk nama anggota
                                        const inputNama = document.createElement('input');
                                        inputNama.type = 'text';
                                        inputNama.value = grup.nama || '-';
                                        inputNama.readOnly = true;
                                        inputNama.placeholder = 'Nama';
                                        divAnggota.appendChild(inputNama);

                                        // Input untuk perner anggota
                                        const inputPerner = document.createElement('input');
                                        inputPerner.type = 'text';
                                        inputPerner.value = grup.perner || '-';
                                        inputPerner.readOnly = true;
                                        inputPerner.placeholder = 'Perner';
                                        divAnggota.appendChild(inputPerner);

                                        // Menambahkan div anggota ke container anggota
                                        anggotaContainer.appendChild(divAnggota);
                                    }
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                // Fungsi untuk menutup popup
                document.getElementById('popup-close-id').addEventListener('click', function() {
                    document.getElementById('overlay').style.display = 'none';
                    document.getElementById('popup').style.display = 'none';
                });
            </script>
        @endpush
    </body>

    </html>

@endsection

