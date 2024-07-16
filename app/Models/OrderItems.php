<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderItems extends Model
{
    use HasFactory;
    protected $table = 'orderItems';
    protected $fillable = ['order_id', 'product_id', 'quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function topSellingProductsQuantity()
    {
        return $this->select('product_id', DB::raw('COUNT(*) as quantity'))
            ->with('product:id,name,price')
            ->groupBy('product_id')
            ->orderBy('quantity', 'desc')
            ->take(5)
            ->get();
    }

    public function topSellingProductsQuantityLast7Days()
    {
        return $this->select('product_id', DB::raw('COUNT(*) as quantity'))
            ->with('product:id,name,price')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('product_id')
            ->orderBy('quantity', 'desc')
            ->take(5)
            ->get();
    }

    public function topSellingProductsQuantityLast7Weeks()
    {
        return $this->select('product_id', DB::raw('COUNT(*) as quantity'))
            ->with('product:id,name,price')
            ->where('created_at', '>=', now()->subWeeks(7))
            ->groupBy('product_id')
            ->orderBy('quantity', 'desc')
            ->take(5)
            ->get();
    }

    public function topSellingProductsQuantityLast12Months()
    {
        return $this->select('product_id', DB::raw('COUNT(*) as quantity'))
            ->with('product:id,name,price')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('product_id')
            ->orderBy('quantity', 'desc')
            ->take(5)
            ->get();
    }



    public function topSellingProductPrice()
    {
        return $this->select('product_id', DB::raw('SUM(products.price) as total_price'))
            ->join('products', 'orderItems.product_id', '=', 'products.id')
            ->with('product:id,name,price')
            ->groupBy('product_id')
            ->orderBy('total_price', 'desc')
            ->take(5)
            ->get();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
