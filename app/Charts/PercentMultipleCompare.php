<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class PercentMultipleCompare extends Chart
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
            "#55bcc9",
            "#1768AC",
            "#8ee4af",
            "#98a0a9",
            "#cafafe",
            "#557a95",
            "#1768AC",
            "#2541B2",
        ];

        $altfillColors = [
            "red",
            "green",
            "blue",
            "black",
            "orange",
        ];

        $chart = new PercentMultiple;
        //$chart->labels($data['keys']);
        $chart->labels($data['keys']);

        $chart->dataset('Poniżej oczekiwań', $type, $data['data']['01'])
            ->backgroundcolor($fillColors[6]);

        $chart->dataset('Spełnia oczekiwania', $type, $data['data']['02'])
            ->backgroundcolor($fillColors[2]);

        $chart->dataset('Powyżej oczekiwań', $type, $data['data']['03'])
            ->backgroundcolor($fillColors[1]);

        $chart->displayAxes(true);
        $chart->options([
            'layout' => [
                'padding' => [
                    'bottom' => 30,
                ],
            ],
            'tooltips' => [
                'enabled' => false
            ],
            'defaultFontFamily' => "Merriweather",
            'legend' => [
                'position' => 'top',
                'labels' => [
                    'fontSize' => 18,
                    'fontFamily' => "Merriweather",
                    'padding' => 10,
                ],
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'stacked' => true,
                        'ticks' => [
                            'beginAtZero' => true,
                            'stepSize' => 10,
                            'fontSize' => 18,
                            'autoSkip' => false,
                            'maxRotation' => 80,
                            'minRotation' => 20,
                            'categorySpacing' => 0,
                            'max' => 100,

                        ],
                    ],
                ],
                'yAxes' => [
                    [
                        'stacked' => true,
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 100,
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
                        return Math.round(value) + '$valueSuffix';
                    }
                }
            }"
        ]);

        return $chart;
    }
}
