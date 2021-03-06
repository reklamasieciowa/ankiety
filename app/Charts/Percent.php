<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class Percent extends Chart
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
            "#354a62",
            "#2541B2",
        ];

        $chart = new Percent;
        $chart->labels($data->keys());
        $chart->dataset('dataset', $type, $data->values())
            ->backgroundcolor($fillColors);

        $chart->displayAxes(false);
        $chart->options([
            'tooltip' => [
                'show' => false
            ],
            'legend' => [
                'position' => 'right',
                'labels' => [
                    'fontSize' => 18,
                    'fontFamily' => "Merriweather",
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
                        return Math.round(value*100) + '$valueSuffix';
                    }
                }
            }"
        ]);

        return $chart;
    }
}
