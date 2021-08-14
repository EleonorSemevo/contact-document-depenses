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
            ->setTitle('Dépenses')
            ->addData($data_get)
            ->setLabels($names);
    }

    public function band($band_data): \ArielMejiaDev\LarapexCharts\BarChart
    {
        /*
        return $this->chart->barChart()
            ->setTitle('San Francisco vs Boston.')
            ->setSubtitle('Wins during season 2021.')
            ->addData('San Francisco', [6, 9, 3, 4, 10, 8])
            ->addData('Boston', [7, 3, 8, 2, 6, 4])
            ->setXAxis(['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Ju','Juil','Août','Sept','Oct','Nov','Dec']);
            */
             $dt = $this->chart->barChart()
            ->setTitle('Dépenses et revenus')
            ->setSubtitle("Année ".date('Y'))
            ->setXAxis(['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Ju','Juil','Août','Sept','Oct','Nov','Dec']);

            foreach($band_data as $band_value)
            {
                 $dt->addData($band_value['titre'],$band_value['values']);
            }

           // $dt->addData('somo',[1,4,7,8,9,5]);

            return $dt;
    }

    public function line_diagramm($line_data): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $lc= $this->chart->lineChart()
            ->setTitle('Dépenses et revenus')
            ->setSubtitle("Année ".date('Y'))
            ->setXAxis(['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Ju','Juil','Août','Sept','Oct','Nov','Dec']);
         foreach($line_data as $line_value)
            {
                 $lc->addData($line_value['titre'],$line_value['values']);
            }
        return $lc;
    }
}
