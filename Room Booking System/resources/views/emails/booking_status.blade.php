<h2>Status Tempahan Anda</h2>

<p>No Tiket: <b>{{ $booking->ticket_no }}</b></p>

<p>Nama: {{ $booking->nama_penuh }}</p>

<p>Status terkini:
    <b>
        {{ strtoupper($booking->status) }}
    </b>
</p>

<p>Terima kasih.</p>