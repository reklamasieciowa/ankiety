<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionOption;
use Illuminate\Http\Request;
use App\Http\Requests\CreateQuestionOption;

class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = QuestionOption::with('translations')->get();
        $questions = Question::where('question_type_id','=', '2')->with('translations')->get();

        //dd($questions);

        return view('admin.question_options.index')->with(compact('options', 'questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateQuestionOption $request)
    {
        $validated = $request->validated();

        $questionOption = QuestionOption::create([
                'question_id' => $validated['question_id'],
                'value' => $validated['value'],
                'pl'  => ['name' => $validated['name_pl']],
                'en'  => ['name' => $validated['name_en']],
            ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Opcja '.$questionOption->name.' zapisana.');

        return redirect()->route('admin.questions.options.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionOption $questionOption)
    {
        $questionOption = $questionOption->load('translations');

        $questions = Question::where('question_type_id','=', '2')->with('translations')->get();

        //dd($questionOption);

        return view('admin.question_options.edit')->with(compact('questionOption', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function update(CreateQuestionOption $request, QuestionOption $questionOption)
    {
        $validated = $request->validated();

        $questionOption->update([
                'question_id' => $validated['question_id'],
                'value' => $validated['value'],
                'pl'  => ['name' => $validated['name_pl']],
                'en'  => ['name' => $validated['name_en']],
            ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Opcja '.$questionOption->name.' zapisana.');

        return redirect()->route('admin.questions.options.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionOption $questionOption, Request $request)
    {
        //dd($questionOption->question->answers);

        if(isset($questionOption->question->answers) && count($questionOption->question->answers)) {

            $request->session()->flash('class', 'alert-danger');
            $request->session()->flash('info', 'Opcja '.$questionOption->name.' jest przypisana do pytań z odpowiedziami. Nie została usunięta.');
        } else {
            $questionOption->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Opcja '.$questionOption->name.' usunięta.');
        }

        return redirect()->route('admin.questions.options.index');
    }
}
