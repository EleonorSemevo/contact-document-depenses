<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ForPieChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($data_get, $names): \ArielMejiaDev\LarapexCharts\PieChart
    {
       $data = $names;
        return $this->chart->pieChart()
            ->setTitle('Les dépenses')
            ->addData($data_get)
            ->setLabels($names);
    }
}
