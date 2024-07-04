<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class PriceChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $quantities, array $labels)
    {
        return $this->chart->barChart()
            ->setTitle('Top Selling Products by Total Price')
            ->setDataset([
                [
                    'name' => 'Total Sell (BDT)',
                    'data' => $quantities
                ],
            ])
            ->setXAxis($labels);
    }
}
