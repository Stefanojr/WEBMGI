@extends('viewer.layout.main')
@section('title', 'Form Langkah 1')
@section('content')

<link rel="stylesheet" href="../../css/background.css">
<link rel="stylesheet" href="../../css/calendarV.css">

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<body>
    <div class="container">
        <div class="month-year" id="month-year"></div>
        <div class="calendar" id="calendar"></div>
    </div>

    <script>
    // Script untuk Calendar
    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    function renderCalendar() {
        const calendarElement = document.getElementById('calendar');
        const monthYearElement = document.getElementById('month-year');
        const now = new Date();
        const month = now.getMonth();
        const year = now.getFullYear();

        monthYearElement.textContent = `${monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        calendarElement.innerHTML = '';
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dayNames.forEach(day => {
            const dayNameElement = document.createElement('div');
            dayNameElement.className = 'day-name';
            dayNameElement.textContent = day;
            calendarElement.appendChild(dayNameElement);
        });

        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement('div');
            calendarElement.appendChild(emptyDiv);
        }

        for (let date = 1; date <= lastDate; date++) {
            const dateElement = document.createElement('div');
            dateElement.className = 'day-number';
            dateElement.textContent = date;
            if (date === now.getDate()) {
                dateElement.classList.add('today');
            }
            calendarElement.appendChild(dateElement);
        }
    }

    function init() {
        renderCalendar();
    }

    init();

</script>

</html>
@endsection













