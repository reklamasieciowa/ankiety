<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class Number extends Chart
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
        $chart->labels($data->keys());
        $chart->dataset('data', $type, $data->values())
            ->backgroundcolor($fillColors);

        $chart->displayAxes(true);
        $chart->options([
            'responsive' => true,
            'tooltips' => [
                'enabled' => false
            ],
            'legend' => [
            	'display' => false,
                'position' => 'right',
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
