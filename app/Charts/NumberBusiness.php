<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class NumberBusiness extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function generateChart($data, $type)
    {

    	$fillColors = [
            "#00b0f0",
            "#33ccff",
            "#7aecf2",
            "#6a6f7e",
            "#55bcc9",
            "#1768AC",
            "#8ee4af",
            "#98a0a9",
            "#cafafe",
            "#557a95",
            "#1768AC",
            "#2541B2",
        ];

        $chart = new Percent;
        $chart->labels($data['keys']);

        $chart->dataset('Zarząd', $type, $data[0])
            ->backgroundcolor('#00b0f0');

        $chart->dataset('Kadra Zarządzająca raportująca do Zarządu', $type, $data[1])
            ->backgroundcolor('#2c31ef');

        $chart->dataset('Kadra Kierownicza', $type, $data[2])
            ->backgroundcolor('#98a0a9');

        $chart->displayAxes(true);
        $chart->options([
            'responsive' => true,
            'tooltips' => [
                'enabled' => false
            ],
            'legend' => [
            	'display' => true,
                'position' => 'top',
                'align' => 'center',
                'labels' => [
                    'fontSize' => 18,
                    'fontFamily' => "Merriweather",
                ],
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 5,
                            'stepSize' => 1,
                            'fontSize' => 18,
                            'autoSkip' => false,
                            'maxRotation' => 25,
                            'minRotation' => 0,
                        ],
                    ],
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 5,
                            'stepSize' => 1,
                            'fontSize' => 20,
                            'autoSkip' => false,
                            'maxRotation' => 0,
                            'minRotation' => 0,
                        ],
                    ],
                ],
            ],
            'plugins' => "{
                'datalabels': {
                    'color': '#ffffff',
                    'font' : {
                        'weight': 'bold',
                        'size' : '22',
                        'family' : 'Merriweather',
                    },
                    formatter: function(value, context) {
                        return value.toFixed(2);
                    }
                }

            }"
        ]);

        return $chart;
    }
}
