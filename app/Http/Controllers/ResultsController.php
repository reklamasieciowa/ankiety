<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PostsList;
use App\Charts\PostListAlternative;
use App\Person;

class ResultsController extends Controller
{

    public function PostListChart()
    {
        $peopleCount = Person::count();

        $peopleByPost = Person::all()->load(['post.translations', 'answers'])->groupBy(function($item, $key)
        {
            return $item['post']->name;
        })->map(function ($item) use($peopleCount) {
            // Return the number of persons with that age
            return round(count($item)/$peopleCount, 4)*100;
        });

        //dd($peopleByPost);

        $title = 'Stanowiska';

        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.6)",
            "rgba(22,160,133, 0.6)",
            "rgba(255, 205, 86, 0.6)",
            "rgba(51,105,232, 0.6)",
            "rgba(244,67,54, 0.6)",
            "rgba(34,198,246, 0.6)",
            "rgba(153, 102, 255, 0.6)",
            "rgba(255, 159, 64, 0.6)",
            "rgba(233,30,99, 0.6)",
            "rgba(205,220,57, 0.6)"
        ];

        //dd(Person::all()->groupBy('post_id'));

        $data = Person::all()->groupBy('post_id')
            ->map(function ($item) {
                // Return the number of persons with that age
                return count($item);
            });

        //dd($data->keys());

        $chart = new PostsList;
        $chart->labels($peopleByPost->keys());
        $chart->dataset('Stanowiska w %.', 'pie', $peopleByPost->values())
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        $chart->displayAxes(false);
        $chart->options([
            'tooltip' => [
                'show' => false // or false, depending on what you want.
            ]
        ]);

        return view('admin.result.chart', compact('chart', 'title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
