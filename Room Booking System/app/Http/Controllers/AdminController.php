<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusMail;

class AdminController extends Controller
{
    // Show login page
    public function showLoginForm()
    {
        return view('admin_login'); // buat blade untuk admin login
    }

    // Process login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            // redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.home');
            } elseif ($user->role === 'itd') {
                return redirect()->route('itd.home'); // nanti awak buat page ITD
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Admin dashboard
    public function dashboard(Request $request)
    {
        // TABLE (NO FILTER)
        $yearNow = date('Y');

        $bookings = Booking::with('location')
            ->whereYear('tarikh_mula', $yearNow)
            ->get();

        // CHART QUERY (FILTER ONLY HERE)
        $chartQuery = Booking::query();

        if ($request->month) {
            $chartQuery->whereMonth('tarikh_mula', $request->month);
        }

        $yearNow = date('Y');

        $data = Booking::select(
            DB::raw('MONTH(tarikh_mula) as month_number'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tarikh_mula', $yearNow)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get()
            ->map(function ($item) {
                $item->month = date('F', mktime(0, 0, 0, $item->month_number, 1));
                return $item;
            });

        return view('admin', compact('bookings', 'data'));
    }

    // Approve booking
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'approved';
        $booking->save();

        // email user
        Mail::to($booking->email)->send(new BookingStatusMail($booking));

        return response()->json(['success' => true]);
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';
        $booking->save();

        // email user
        Mail::to($booking->email)->send(new BookingStatusMail($booking));

        return response()->json(['success' => true]);
    }

    public function report(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $bookings = Booking::with('location')
            ->whereMonth('tarikh_mula', $month)
            ->whereYear('tarikh_mula', $year)
            ->get();

        $summary = [
            'total' => $bookings->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
        ];

        $chart = Booking::select(
            DB::raw('MONTH(tarikh_mula) as month_number'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tarikh_mula', $year)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get()
            ->map(function ($item) {
                $item->month = date('F', mktime(0, 0, 0, $item->month_number, 1));
                return $item;
            });

        return view('adminreport', compact(
            'bookings',
            'summary',
            'chart',
            'month',
            'year'
        ));
    }

    public function monthlyReport()
    {
        $data = Booking::select(
            DB::raw('MONTH(tarikh_mula) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->month = date('F', mktime(0, 0, 0, $item->month, 1));
                return $item;
            });

        $bookings = Booking::with('location')->orderBy('tarikh_mula', 'desc')->get();

        return view('admin', compact('data', 'bookings'));
    }

    public function reportPdf(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $bookings = Booking::with('location')
            ->whereMonth('tarikh_mula', $month)
            ->whereYear('tarikh_mula', $year)
            ->get();

        $summary = [
            'total' => $bookings->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
        ];

        $chart = Booking::select(
            DB::raw('MONTH(tarikh_mula) as month_number'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tarikh_mula', $year)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get()
            ->map(function ($item) {
                $item->month = date('F', mktime(0, 0, 0, $item->month_number, 1));
                return $item;
            });

        $pdf = Pdf::loadView('adminreport_pdf', compact(
            'bookings',
            'month',
            'year'
        ));

        return $pdf->download('report-bulanan.pdf');
    }
}