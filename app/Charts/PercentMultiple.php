<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class PercentMultiple extends Chart
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

    public static function generateChart($data, $type, $valueSuffix)
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
        ];

        $altfillColors = [
            "red",
            "green",
            "blue",
            "black",
            "orange",
        ];

        $chart = new PercentMultiple;
        $chart->labels($data['keys']);

        //1 dataset same 0-1
        //2 dataset same 2-3
        //3 dataset same 4-5
        //zestawia obok wartość 1 z każdego datasetu

        //dataset 1 p1 0-1  p2 0-1  p3 0-1
        //dataset 2 p1 2-3
        //dataset 3 p1 4-5


        $chart->dataset('0-1', $type, $data['data']['01'])
            ->backgroundcolor($fillColors[6]);

        $chart->dataset('2-3', $type, $data['data']['02'])
            ->backgroundcolor($fillColors[2]);

        $chart->dataset('4-5', $type, $data['data']['03'])
            ->backgroundcolor($fillColors[1]);
        

        $chart->displayAxes(true);
        $chart->options([
            'tooltips' => [
                'enabled' => false
            ],
            'defaultFontFamily' => "Merriweather",
            'legend' => [
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
                            'stepSize' => 1,
                            'fontSize' => 18,
                            'autoSkip' => false,
                            'maxRotation' => 80,
                            'minRotation' => 0,
                            'categorySpacing' => 0,

                        ],
                    ],
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 1,
                            'fontSize' => 20,
                            'autoSkip' => false,
                            'maxRotation' => 0,
                            'minRotation' => 0,
                            'categorySpacing' => 0,
                        ],
                    ],
                ],
            ],
            'plugins' => "{
                'datalabels': {
                    'color': '#000000',
                    'font' : {
                        'weight': 'bold',
                        'size' : '12',
                        'family' : 'Merriweather',
                    },
                    formatter: function(value, context) {
                        return Math.round(value*100) + '$valueSuffix';
                    }
                }
            }"
        ]);

        return $chart;
    }
}
