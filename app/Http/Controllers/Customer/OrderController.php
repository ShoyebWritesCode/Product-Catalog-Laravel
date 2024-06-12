<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItems;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $orderItems = collect();

    
        if ($order) {
            $orderItems = OrderItems::where('order_id', $order->id)->get();
        }
    
        return view('customer.order.home', compact('order', 'orderItems'));
    }
    

    public function add(Product $product)
    {
        // $num = 0;
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        
        if (!$order) {
            $order = new Order();
            $order->user_id = $user->id;
            $order->total = 0;
            $order->status = 0;
            $order->save();
        }
    
        $orderItem = new OrderItems();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $product->id;
        $orderItem->save();
    
        $order->total += $product->price;
        $order->save();

        // session()->flash('success', 'Added to cart successfully');
        // return redirect()->back()->with('success', 'Added to Cart successfully');
        // return response()->json(['success' => session('success')]);
        $message = 'Added to cart successfully!';
        // dd($average);
        // Log::debug($num);
        // die('came here');
        return response()->json(['success' => true, 'message' => $message]);
        // return view('customer.product.show', ['num' => $num]);
    }

    public function checkout()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $order->status = 1;
        $order->save();
        session()->flash('success', 'Order placed successfully');
        return redirect()->route('customer.order.home')->with('success', 'Order placed successfully');
    }
    
}