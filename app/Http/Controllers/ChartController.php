<?php

namespace App\Http\Controllers;

use App\Charts\ProductsChart;
use App\Charts\PriceChart;
use App\Charts\SalesChart;
use Illuminate\Http\Request;
use App\Models\OrderItems;

class ChartController extends Controller
{
    // public function index(ProductsChart $productchart)
    // {
    //     return view('admin.charts.index', ['productchart' => $productchart->build()]);
    // }

    // public function topSellingProductsQuantity()
    // {
    //     $topSellingProducts = (new OrderItems)->topSellingProductsQuantity();

    //     foreach ($topSellingProducts as $item) {
    //         echo 'Product ID: ' . $item->product_id;
    //         echo ' Product Name: ' . $item->product->name;
    //         echo ' Quantity Sold: ' . $item->quantity;
    //         echo ' Product Price: ' . $item->product->price;
    //     }
    // }


    public function index(ProductsChart $chart, PriceChart $priceChart, SalesChart $salesChart)
    {
        $topSellingProducts = (new OrderItems)->topSellingProductsQuantity();

        $quantities = $topSellingProducts->pluck('quantity')->toArray();
        $labels = $topSellingProducts->pluck('product.name')->toArray();

        $productchart = $chart->build($quantities, $labels);

        $topSellingProductsPrice = (new OrderItems)->topSellingProductPrice();

        $quantities = $topSellingProductsPrice->pluck('total_price')->toArray();
        $labels = $topSellingProductsPrice->pluck('product.name')->toArray();

        $priceChart = $priceChart->build($quantities, $labels);
        $salesChart = $salesChart->build();


        return view('admin.charts.index', compact('productchart', 'priceChart', 'salesChart'));
    }
}
