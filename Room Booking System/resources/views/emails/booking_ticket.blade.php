<!DOCTYPE html>
<html>
<head>
    <title>Tempahan Bilik</title>
</head>
<body>
    <h2>Tempahan Berjaya</h2>

    <p>Hai {{ $booking->nama_penuh }},</p>

    <p>No Tiket anda:</p>
    <h3>{{ $booking->ticket_no }}</h3>

    <p>Sila simpan nombor ini untuk semakan status tempahan.</p>

</body>
</html>