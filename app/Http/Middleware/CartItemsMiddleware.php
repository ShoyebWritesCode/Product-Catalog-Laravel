<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\OrderItems;

class CartItemsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($user = auth()->user()) {
            $order = Order::where('user_id', $user->id)->where('status', 0)->first();
            $numberOfItems = $order ? OrderItems::where('order_id', $order->id)->count() : 0;
            View::share('numberOfItems', $numberOfItems);
        }

        return $next($request);
    }
}
