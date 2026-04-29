<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Location;
use Carbon\Carbon;
use App\Models\Department;
use App\Mail\BookingTicketMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingApprovalMail;
use App\Mail\BookingStatusMail;


class BookingController extends Controller
{
    // Papar form
    public function create()
    {
        return view('booking');
    }

    // Simpan tempahan
    public function store(Request $request)
    {
        $request->validate([
            'no_ic' => 'required',
            'nama_penuh' => 'required',
            'jabatan_id' => 'required',
            'jawatan' => 'required',
            'no_tel_bimbit' => 'required',
            'no_tel_pejabat' => 'required',
            'email' => 'required',
            'kegunaan' => 'required',
            'catatan' => 'required',
            'tarikh_mula' => 'required',
            'tarikh_tamat' => 'required',
            'masa_mula' => 'required',
            'masa_tamat' => 'required',
            'location_id' => 'required',
        ], [
            'no_ic.required' => 'No Kad Pengenalan diperlukan',
            'nama_penuh.required' => 'Nama penuh diperlukan',
            'jabatan_id.required' => 'Sila pilih jabatan',
            'jawatan.required' => 'Jawatan diperlukan',
            'no_tel_bimbit.required' => 'No telefon bimbit diperlukan',
            'no_tel_pejabat.required' => 'No telefon pejabat diperlukan',
            'email.required' => 'Email diperlukan',
            'kegunaan.required' => 'Tujuan kegunaan diperlukan',
            'catatan.required' => 'Catatan diperlukan',
            'tarikh_mula.required' => 'Tarikh mula diperlukan',
            'tarikh_tamat.required' => 'Tarikh tamat diperlukan',
            'masa_mula.required' => 'Masa mula diperlukan',
            'masa_tamat.required' => 'Masa tamat diperlukan',
            'location_id.required' => 'Lokasi diperlukan',
        ]);

        if (!$request->tarikh_mula || !$request->tarikh_tamat) {
            return back()->withErrors(['tarikh_mula' => 'Tarikh wajib diisi']);
        }

        $mula = Carbon::createFromFormat('d-m-Y', $request->tarikh_mula);
        $tamat = Carbon::createFromFormat('d-m-Y', $request->tarikh_tamat);
        $ticket_no = 'S' . date('dmyHis');

        $booking = Booking::create([
            'no_ic' => $request->no_ic,
            'nama_penuh' => $request->nama_penuh,
            'jabatan_id' => $request->jabatan_id,
            'jawatan' => $request->jawatan,
            'no_tel_bimbit' => $request->no_tel_bimbit,
            'no_tel_pejabat' => $request->no_tel_pejabat,
            'email' => $request->email,
            'kegunaan' => $request->kegunaan,
            'catatan' => $request->catatan,

            'tarikh_mula' => $mula->format('Y-m-d'),
            'tarikh_tamat' => $tamat->format('Y-m-d'),

            'masa_mula' => $request->masa_mula,
            'masa_tamat' => $request->masa_tamat,
            'location_id' => $request->location_id,

            'ticket_no' => $ticket_no,
            'status' => 'pending',
        ]);

        $request->validate([
            'location_id' => 'required|exists:locations,id',
        ]);

        // EMAIL USER
        Mail::to($booking->email)->send(new BookingTicketMail($booking));

        // EMAIL ADMIN (template lain)
        Mail::to('papanreput17@gmail.com')->send(new BookingApprovalMail($booking));

        // baru return
        return back()
            ->with('success', true)
            ->with('ticket_no', $ticket_no);
    }

    // Autofill berdasarkan no_ic
    public function autofill(Request $request)
    {
        $booking = Booking::where('no_ic', $request->no_ic)->latest()->first();
        if ($booking) {
            return response()->json([
                'nama_penuh' => $booking->nama_penuh,
                'email' => $booking->email,
                'jabatan_id' => $booking->jabatan_id,
                'jawatan' => $booking->jawatan,
                'no_tel_bimbit' => $booking->no_tel_bimbit,
                'no_tel_pejabat' => $booking->no_tel_pejabat,
            ]);
        }
        return response()->json([]);
    }

    public function events()
    {
        $bookings = \App\Models\Booking::all();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->kegunaan ?: 'Tempahan Bilik',
                'start' => $booking->tarikh_mula . 'T' . $booking->masa_mula,
                'end' => $booking->tarikh_tamat . 'T' . $booking->masa_tamat,
                'extendedProps' => [
                    'nama_pemohon' => $booking->nama_penuh,
                    'location' => optional($booking->location)->location_name,
                    'notes' => $booking->catatan ?: 'Tiada catatan'
                ]
            ];
        });

        return response()->json($events);
    }

    public function checkTicket(Request $request)
    {
        $ticket = $request->ticket_no;

        $booking = Booking::with('location')->where('ticket_no', $ticket)->first();

        if (!$booking) {
            return response()->json([
                'found' => false,
                'message' => 'No tiket ini tidak wujud dalam sistem kami'
            ]);
        }

        $formatTime = function ($time) {
            if (!$time)
                return '-';
            return Carbon::parse($time)->format('g.i A'); // 2.00 PM
        };

        return response()->json([
            'found' => true,
            'ticket_no' => $booking->ticket_no ?: '-',
            'title' => $booking->kegunaan ?: '-',
            'date' => $booking->tarikh_mula ? Carbon::parse($booking->tarikh_mula)->format('d/m/Y') : '-',
            'time' => $formatTime($booking->masa_mula) . ' - ' . $formatTime($booking->masa_tamat),
            'location' => $booking->location ? $booking->location->location_name : '-',
            'status' => $booking->status ?: '-'
        ]);
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'approved';
        $booking->save();

        // email user
        Mail::to($booking->email)->send(new BookingStatusMail($booking));

        return back()->with('success', 'Booking approved');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';
        $booking->save();

        // email user
        Mail::to($booking->email)->send(new BookingStatusMail($booking));

        return back()->with('success', 'Booking rejected');
    }
}