<?php

namespace App\Http\Middleware;

use Closure;
use App\Survey;
use App;

class SurveyActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $survey = Survey::where('uuid', '=', $request->survey_uuid)->firstOrFail();
        
        if($survey->finished) 
        {

            $request->session()->flash('class', 'alert-danger');
            $request->session()->flash('info', 'Ankieta została zakończona.');
            
            return redirect()->route('front.index', ['locale' => app::getLocale()]);
        } 

        return $next($request);
    }
}
