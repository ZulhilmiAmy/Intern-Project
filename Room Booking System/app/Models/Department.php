<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'jabatan_id');
    }
}
