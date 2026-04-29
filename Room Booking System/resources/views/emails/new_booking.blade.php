@component('mail::message')
# Tempahan Baru

Terdapat tempahan baru oleh {{ $booking->nama_penuh }} ({{ $booking->no_ic }}).

**Tarikh & Masa:** {{ $booking->tarikh_mula }} {{ $booking->masa_mula }} - {{ $booking->tarikh_tamat }} {{ $booking->masa_tamat }}  
**Lokasi:** {{ $booking->location->name }}  

@component('mail::button', ['url' => url('/admin/bookings')])
Lihat Tempahan
@endcomponent

@endcomponent