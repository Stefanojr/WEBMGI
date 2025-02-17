@extends('viewer.layout.main')

@section('title', 'Form Approval')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengumpulan Risalah</title>
    <link rel="stylesheet" href="../../css/background.css">
    <link rel="stylesheet" href="../../css/formApprovalV.css">

</head>
<body>
    <div class="container">
        <h1>FORM APPROVAL MANAGEMENT IMPROVEMENT</h1>

        <form action="{{ route('form.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="group-name">Nama Group</label>
                <input type="text" id="group-name" name="group-name" required>
            </div>

            <div class="form-group">
                <label for="unit-name">Nama Unit</label>
                <input type="text" id="unit-name" name="unit-name" required>
            </div>

            <div class="form-group">
                <label for="langkah">Langkah</label>
                <select id="langkah" name="langkah" required>
                    <option value="langkah1">Langkah 1</option>
                    <option value="langkah2">Langkah 2</option>
                    <option value="langkah3">Langkah 3</option>
                    <option value="langkah4">Langkah 4</option>
                    <option value="langkah5">Langkah 5</option>
                    <option value="langkah6">Langkah 6</option>
                    <option value="langkah7">Langkah 7</option>
                    <option value="langkah8">Langkah 8</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Tanggal</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="setuju">DISETUJUI</option>
                    <option value="revisi">REVISI</option>
                </select>
            </div>

            <div class="form-group">
                <label for="komentar">Komentar</label>
                <input type="text" id="komentar" name="komentar">
            </div>

            <div>
                <button type="submit" class="submit-btn">SUBMIT</button>
            </div>


        </form>
    </div>
</body>
</html>
@endsection
