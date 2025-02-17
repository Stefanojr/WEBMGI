@extends('sysadmin.layout.main')
@section('title', 'Dashboard')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Perusahaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../css/background.css">
    <link rel="stylesheet" href="../../css/tableManagUser.css">

    <script>
        // Function to toggle the popup
        function togglePopup(id) {
            const popup = document.getElementById(`popup-${id}`);
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
            } else {
                popup.style.display = 'block';
            }
        }
    </script>


</head>

<body>
    <div class="table-container">
        <h2>LIST PERUSAHAAN</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Perusahaan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr>
                    <td>{{ $company->id_perusahaan }}</td>
                    <td>
                        <button class="button-link" onclick="togglePopup({{ $company->id_perusahaan }})">{{ $company->nama_perusahaan }}</button>
                    </td>
                    <td class="icon">
                        <a href="{{ route('edit-company', $company->id_perusahaan) }}" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('delete-company', $company->id_perusahaan) }}" class="delete-btn"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Popups for each company -->
@foreach($companies as $company)
    <div class="popup-overlay" id="popup-{{ $company->id_perusahaan }}">
        <div class="popup-content">
            <h2>Detail Informasi Perusahaan: {{ $company->nama_perusahaan }}</h2>

            <!-- Scrollable table inside popup -->
            <div class="scrollable-table">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->units as $unit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $company->nama_perusahaan }}</td>
                                <td>{{ $unit->nama_unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button class="close-btn" onclick="togglePopup({{ $company->id_perusahaan }})">Tutup</button>
        </div>
    </div>
@endforeach

</body>
@endsection
