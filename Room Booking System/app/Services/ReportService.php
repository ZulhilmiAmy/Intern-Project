<?php

namespace App\Services;

use App\Models\Booking;
use DB;

class ReportService
{
    public function getMonthlyData($year)
    {
        return Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->month_name = date('F', mktime(0, 0, 0, $item->month, 1));
                return $item;
            });
    }

    public function getBookings($month, $year)
    {
        return Booking::with('location')
            ->whereMonth('tarikh_mula', $month)
            ->whereYear('tarikh_mula', $year)
            ->orderBy('tarikh_mula', 'asc')
            ->get();
    }

    public function getSummary($bookings)
    {
        return [
            'total' => $bookings->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
        ];
    }
}