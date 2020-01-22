<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class NumberHrbpBusinessMultiple extends Chart
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

        $chart = new Percent;
        $chart->labels($data['keys']);

        unset($data['keys']);

        $i = 0;

        foreach($data as $name=>$group) {
            $chart->dataset($name.' HRBP', $type, $group[0])
            ->backgroundcolor($fillColors[$i])
            ->color($fillColors[$i])
            ->fill(false);
            $i += 2;

            $chart->dataset($name.' Business', $type, $group[1])
                ->backgroundcolor($fillColors[$i])
                ->color($fillColors[$i])
                ->fill(false);
            $i += 2;
        }

        // $chart->dataset('HRBP', $type, $data[0])
        //     ->backgroundcolor('#00b0f0')
        //     ->color('#00b0f0')
        //     ->fill(false);

        // $chart->dataset('Business', $type, $data[1])
        //     ->backgroundcolor('#1768AC')
        //     ->color('#1768AC')
        //     ->fill(false);

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
                    'fontSize' => 22,
                    'fontFamily' => "Merriweather",
                ],
            ],
            'scale' => [
                'angleLines' => [
                    'display' => true,
                ],
                'pointLabels' => [
                    'display' => true,
                    'fontSize' => 20,
                ],
                'ticks' => [
                    'beginAtZero' => true,
                    'max' => 5,
                    'stepSize' => 1,
                ],
            ],
            'scales' => [
                'xAxes' => [
                    'display' => false,
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
                    'display' => false,
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
                    'color': '#ff0000',
                    'display': false,
                    'align': 'left',
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
