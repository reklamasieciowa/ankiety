<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class Line extends Chart
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
            "#8e92a0",
            "#a7aab5",
            "#c0c3ca",
            "#98a0a9",
            "#0077f0",
            "#073d31",
            "#6f2297",
            "#5eec50",
            "#ff0000",
            "#064534",
            "#b750ec",
            "#0a4506",
            "#000000",
            "#ec50db",
            "#ff008a",
            "#57f04b",
            "#73b8ff",
        ];

        $chart = new Line;

        $i = 0;

        foreach ($data as $key => $industry) {
            $chart->labels($industry->keys());
            $chart->dataset($key, $type, $industry->values())
                ->backgroundcolor($fillColors[$i])
                ->color($fillColors[$i])
                ->fill(false)
                ->lineTension(0);
            $i++;
        }

        $chart->displayAxes(true);
        $chart->options([
            'responsive' => true,
            'tooltips' => [
                'enabled' => true
            ],
            'elements' => [
                'line' => [
                    'borderWidth' => 5,
                ],
            ],
            'legend' => [
            	'display' => true,
                'position' => 'top',
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
                            'stepSize' => .2,
                            'fontSize' => 16,
                            'autoSkip' => true,
                            'maxRotation' => 0,
                            'minRotation' => 0,
                        ],
                    ],
                ],
            ],
            'plugins' => "{
                'datalabels': {
                    'color': '#000000',
                    'font' : {
                        'weight': 'bold',
                        'size' : '0',
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
