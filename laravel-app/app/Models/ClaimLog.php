<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'nama',
        'password',
        'tingkat',
        'phone',
        'item',
        'ip_address',
        'user_agent',
        'status',
    ];
}
