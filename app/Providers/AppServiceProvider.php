<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\OrderItems;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Using view composer to share $numberOfItems with all views
        View::composer('*', function ($view) {
            $user = auth()->user();
            $numberOfItems = 0;
            $order = Order::where('user_id', $user->id)->where('status', 0)->first();
            if ($order) {
                $orderItems = OrderItems::where('order_id', $order->id)->get();
                $numberOfItems = $orderItems->count();
            }
            $view->with('numberOfItems', $numberOfItems);
        });
    }

}
