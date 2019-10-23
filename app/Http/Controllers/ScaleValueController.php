<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateValue;
use App\Http\Requests\UpdateValue;
use App\Scale;
use App\ScaleValue;

class ScaleValueController extends Controller
{
    public function store(CreateValue $request, Scale $scale)
    {
        $validated = $request->validated();

        //dd($scaleValue);

        $scaleValue = ScaleValue::create([
            'scale_id' => $scale->id,
            'value' => $validated['value'],
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Wartość '.$scaleValue->name.' dodana do skali '.$scale->name.'.');

        return redirect()->back();
    }

    public function edit(Scale $scale, ScaleValue $scaleValue)
    {
    	$scaleValue = $scaleValue->load('translations');
    	return view('admin.value.edit')->with(compact('scaleValue', 'scale'));
    }

    public function update(UpdateValue $request, Scale $scale, ScaleValue $scaleValue)
    {
    	$validated = $request->validated();

        //dd($validated);

        $scaleValue->update([
            'scale_id' => $scale->id,
            'value' => $validated['value'],
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Wartość '.$scaleValue->name.' zaktualizowana.');

        return redirect()->route('admin.scale.edit', ['scale' => $scale->id]);
    }

    public function destroy(Scale $scale, ScaleValue $scaleValue, Request $request)
    {
    	if(!count($scaleValue->scale->questions)) {
    		$scaleValue->delete();

    		$request->session()->flash('class', 'alert-info');
        	$request->session()->flash('info', 'Wartość '.$scaleValue->name.' usunięta.');
    	} else {
    		$request->session()->flash('class', 'alert-danger');
        	$request->session()->flash('info', 'Ta skala jest używana! Wartość '.$scaleValue->name.' nie została usunięta.');
    	}

    	

        return redirect()->route('admin.scale.edit', ['scale' => $scale->id]);
    }
}
