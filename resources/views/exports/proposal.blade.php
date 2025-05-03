<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 30px; }
        h1, h2, h3 { text-align: center; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <h2>{{ $judul }}</h2>

    @foreach($contents as $content)
        <div>{!! $content !!}</div>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>
