<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no',
        'nama_penuh',
        'no_ic',
        'jabatan_id',
        'jawatan',
        'no_tel_bimbit',
        'no_tel_pejabat',
        'email',
        'kegunaan',
        'catatan',
        'tarikh_mula',
        'masa_mula',
        'tarikh_tamat',
        'masa_tamat',
        'location_id',
        'status', // pending, approved, rejected
    ];

    // Relation ke department
    public function department()
    {
        return $this->belongsTo(Department::class, 'jabatan_id');
    }

    // Relation ke location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}