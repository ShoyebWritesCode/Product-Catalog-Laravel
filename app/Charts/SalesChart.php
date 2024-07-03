<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Order;

class SalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $orders = Order::weeklyOrderCounts();

        $labels = $orders->pluck('week')->toArray();
        $data = $orders->pluck('total_orders')->toArray();

        return $this->chart->lineChart()
            ->setTitle('Sales Per Week')
            ->setDataset([
                [
                    'name' => 'Physical sales',
                    'data' => $data,
                    'color' => '#ff0000'
                ]
            ])
            ->setXAxis($labels)
            ->setGrid();
    }
}
