<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProductsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $quantities, array $labels)
    {
        return $this->chart->pieChart()
            ->setTitle('Top Selling Products by Quantity Sold')
            ->setDataset($quantities)
            ->setLabels($labels);
    }
}
