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
                    <tbody>
                        @foreach ($pendaftarans as $key => $pendaftaran)
                            <tr>
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
                        const idPendaftaran = this.closest('tr').querySelector('.popup-btn-id').getAttribute('data-id');
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

<style>
    /* Modern popup styling */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 800px;
        width: 90%;
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        z-index: 1000;
        max-height: 85vh;
        overflow-y: auto;
        animation: fadeIn 0.3s ease-out;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translate(-50%, -45%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }

    .popup h3 {
        text-align: center;
        margin-bottom: 25px;
        color: #2c3e50;
        font-size: 20px;
        font-weight: 600;
        position: relative;
        padding-bottom: 15px;
    }

    .popup h3::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, #4a6b4f, #6ca175);
        border-radius: 3px;
    }

    .team-info {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .team-id {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .team-id .input-container {
        display: flex;
        align-items: center;
    }

    .team-id .input-container label {
        font-weight: 600;
        color: #2c3e50;
        width: 150px;
    }

    .team-id .input-container input {
        flex-grow: 1;
        padding: 10px 12px;
        background-color: white;
        border: 1px solid #e1e5e9;
        border-radius: 8px;
        color: #4a6b4f;
        font-weight: 600;
    }

    .leadership-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
    }

    .member-card {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
    }

    .member-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .sponsor-card { border-left: 4px solid #4a6b4f; }
    .fasilitator-card { border-left: 4px solid #4d7dc4; }
    .ketua-card { border-left: 4px solid #d35400; }
    .sekretaris-card { border-left: 4px solid #8e44ad; }

    .member-role {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #2c3e50;
        font-weight: 600;
    }

    .member-role i {
        background-color: rgba(74, 107, 79, 0.1);
        color: #4a6b4f;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .sponsor-card .member-role i { color: #4a6b4f; background-color: rgba(74, 107, 79, 0.1); }
    .fasilitator-card .member-role i { color: #4d7dc4; background-color: rgba(77, 125, 196, 0.1); }
    .ketua-card .member-role i { color: #d35400; background-color: rgba(211, 84, 0, 0.1); }
    .sekretaris-card .member-role i { color: #8e44ad; background-color: rgba(142, 68, 173, 0.1); }

    .member-data {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .member-name input, .member-perner input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e1e5e9;
        border-radius: 6px;
        background-color: white;
        color: #495057;
    }

    .member-name input::placeholder, .member-perner input::placeholder {
        color: #adb5bd;
    }

    .team-members {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-top: 10px;
    }

    .team-members-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .team-members-header i {
        color: #4a6b4f;
        font-size: 18px;
    }

    .team-members-header h4 {
        color: #2c3e50;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }

    .anggota-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
    }

    .anggota-container .input-container {
        background-color: white;
        border-radius: 8px;
        padding: 12px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .anggota-container .input-container label {
        color: #4a6b4f;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .anggota-container .input-container label::before {
        content: "\f007";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
    }

    .anggota-container .input-container input {
        padding: 8px 12px;
        border: 1px solid #e1e5e9;
        border-radius: 6px;
        background-color: #f8f9fa;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .popup-close {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
    }

    .popup-close:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
    }

    .popup-close:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .popup {
            width: 95%;
            padding: 20px;
        }
        
        .leadership-grid {
            grid-template-columns: 1fr;
        }
        
        .anggota-container {
            grid-template-columns: 1fr;
        }
    }
</style>
