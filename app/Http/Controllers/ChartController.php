<?php

namespace App\Http\Controllers;

use App\Charts\ProductsChart;
use App\Charts\PriceChart;
use App\Charts\SalesChart;
use Illuminate\Http\Request;
use App\Models\OrderItems;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ChartController extends Controller
{

    public function index(ProductsChart $chart, PriceChart $priceChart, SalesChart $salesChart, Request $request)
    {
        $filter = $request->input('filter', 'all'); // Default to 'all' if filter is not provided

        $topSellingProducts = $this->getTopSellingProducts($filter);
        $quantities = $topSellingProducts->pluck('quantity')->toArray();
        $labels = $topSellingProducts->pluck('product.name')->toArray();
        $productchart = $chart->build($quantities, $labels);

        $pricefilter = 'all';
        $topSellingProductsPrice = $this->getTopSellingProductPrice($pricefilter);
        $quantitiesPrice = $topSellingProductsPrice->pluck('total_price')->toArray();
        $labelsPrice = $topSellingProductsPrice->pluck('product.name')->toArray();
        $priceChart = $priceChart->build($quantitiesPrice, $labelsPrice);

        $salesChart = $salesChart->build();
        if ($request->has('is_ajax') && $request->is_ajax) {
            Log::debug("message called from ajax");

            $html = View::make('admin.charts.productchart', compact('productchart'))->render();
            return response()->json([
                'html' => $html
            ]);
        }

        return view('admin.charts.index', compact('productchart', 'priceChart', 'salesChart'));
    }

    // Method to fetch top selling products based on filter
    private function getTopSellingProducts($filter)
    {
        $orderItems = new OrderItems(); // Instantiate OrderItems model
        switch ($filter) {
            case 'last7':
                return $orderItems->topSellingProductsQuantityLast7Days();
            case 'last7weeks':
                return $orderItems->topSellingProductsQuantityLast7Weeks();
            case '12months':
                return $orderItems->topSellingProductsQuantityLast12Months();
            case 'all':
            default:
                return $orderItems->topSellingProductsQuantity();
        }
    }

    private function getTopSellingProductPrice($filter)
    {
        $orderItems = new OrderItems(); // Instantiate OrderItems model
        switch ($filter) {
                // case 'last7':
                //     return $orderItems->topSellingProductPriceLast7Days();
                // case 'last7weeks':
                //     return $orderItems->topSellingProductPriceLast7Weeks();
                // case '12months':
                //     return $orderItems->topSellingProductPriceLast12Months();
                // case 'all':
            default:
                return $orderItems->topSellingProductPrice();
        }
    }
}
