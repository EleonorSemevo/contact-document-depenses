<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class BandeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('San Francisco vs Boston.')
            ->setSubtitle('Wins during season 2021.')
            ->addData('San Francisco', [6, 9, 3, 4, 10, 8])
            ->addData('Boston', [7, 3, 8, 2, 6, 4])
            ->setXAxis(['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Ju','Juil','Août','Sept','Oct','Nov','Dec']);
    }
}
