<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['user_id', 'total', 'status', 'city', 'address', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function weeklyOrderCounts()
    {
        return Order::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as week'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy('week')
            ->orderBy('week')
            ->get();
    }
}
