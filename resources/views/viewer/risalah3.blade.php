@extends('viewer.layout.main')

@section('title', 'Risalah')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langkah 1</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../css/background.css">
    <link rel="stylesheet" href="../../css/tableRisalahV.css">
</head>

<body>

    <div class="table-container">
        <h2>LANGKAH 1</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 1</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 1</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 1</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 1</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 2</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 2</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 2</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 2</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 2</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 3</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 3</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 3</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 3</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 3</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 4</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 4</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 4</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 4</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 4</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 5</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 5</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 5</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 5</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 5</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 6</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 6</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 6</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 6</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 6</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 7</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 7</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 7</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 7</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 7</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <h2>LANGKAH 8</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Unit</th>
                    <th>Nama Group</th>
                    <th>Langkah</th> <!-- Kolom Langkah ditambahkan di sini -->
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Unit A</td>
                    <td>Group 1</td>
                    <td>Langkah 8</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>01-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Unit B</td>
                    <td>Group 2</td>
                    <td>Langkah 8</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Unit C</td>
                    <td>Group 3</td>
                    <td>Langkah 8</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Unit D</td>
                    <td>Group 4</td>
                    <td>Langkah 8</td> <!-- Isi kolom Langkah -->
                    <td class="icon"><a href="link-to-file.pdf" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                    <td>02-01-2023</td>
                    <td class="action-icons">
                        <a href="link-to-download-file.pdf" download><i class="fas fa-download"></i></a>
                        <a href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


@endsection
