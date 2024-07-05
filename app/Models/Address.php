<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'type'
    ];
    const SHIPPING_ADDR = '120';
    const BILLING_ADDR = '110';
}
