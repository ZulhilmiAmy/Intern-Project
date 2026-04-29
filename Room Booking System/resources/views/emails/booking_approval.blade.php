<!DOCTYPE html>
<html>
<head>
    <title>Kelulusan Tempahan</title>
</head>
<body>

<h2>📌 Permohonan Tempahan Baru</h2>

<p><b>No Tiket:</b> {{ $booking->ticket_no }}</p>
<p><b>Nama:</b> {{ $booking->nama_penuh }}</p>
<p><b>Email:</b> {{ $booking->email }}</p>
<p><b>Tujuan:</b> {{ $booking->kegunaan }}</p>
<p><b>Tarikh:</b> {{ $booking->tarikh_mula }} - {{ $booking->tarikh_tamat }}</p>

<br>

<p>
    Sila login ke admin panel untuk:
</p>

<ul>
    <li>✔ Luluskan tempahan</li>
    <li>✖ Tolak tempahan</li>
</ul>

</body>
</html>