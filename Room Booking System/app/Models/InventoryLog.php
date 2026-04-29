<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'item_name',
        'borrower',
        'department',
        'position',
        'purpose',
        'out_date',
        'return_date',
    ];
}
