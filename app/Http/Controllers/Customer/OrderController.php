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
    // public function index()
    // {
    //     $user = auth()->user();
    //     $order = Order::where('user_id', $user->id)->where('status', 0)->first();
    //     $orderItems = collect();


    //     if ($order) {
    //         $orderItems = OrderItems::where('order_id', $order->id)->get();
    //     }

    //     return view('customer.order.home', compact('order', 'orderItems'));
    // }


    protected function getOrderData()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $orderItems = collect();

        if ($order) {
            $orderItems = OrderItems::where('order_id', $order->id)->get();
        }

        return compact('order', 'orderItems');
    }

    public function index()
    {
        $data = $this->getOrderData();

        return view('customer.order.home', $data);
    }

    public function popup()
    {
        $data = $this->getOrderData();

        return view('customer.order.popup', $data);
    }

    public function shipping()
    {
        $data = $this->getOrderData();
        return view('customer.order.shipping', $data);
    }

    public function checkoutpage()
    {
        $data = $this->getOrderData();
        return view('customer.order.checkout', $data);
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
            $order->city = '';
            $order->address = '';
            $order->phone = '';
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

    public function itemCount()
    {
        $user = auth()->user();
        $numberOfItems = 0;

        if ($user) {
            $order = Order::where('user_id', $user->id)->where('status', 0)->first();
            $numberOfItems = $order ? OrderItems::where('order_id', $order->id)->count() : 0;
        }

        return response()->json(['numberOfItems' => $numberOfItems]);
    }

    public function shippingSave(Order $order, Request $request)
    {
        $order->city = $request->city;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->save();
        session()->flash('success', 'Shipping details saved successfully');
        return redirect()->route('customer.order.checkoutpage')->with('success', 'Shipping details saved successfully');
    }

    public function history()
    {
        $user = auth()->user();
        $pendingorders = Order::where('user_id', $user->id)->where('status', 1)->get();
        $completedorders = Order::where('user_id', $user->id)->where('status', 2)->get();
        return view('customer.order.history', compact('pendingorders', 'completedorders'));
    }

    public function orderdetail(Order $order)
    {
        $orderItems = OrderItems::where('order_id', $order->id)->get();
        $data = compact('order', 'orderItems');
        return view('customer.order.orderdetail', $data);
    }
}
