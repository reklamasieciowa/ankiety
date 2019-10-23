<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionType;
use App\Category;
use App\Survey;
use App\Scale;
use App\Http\Requests\UpdateQuestion;
use App\Http\Requests\CreateQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::with(['translations', 'surveys.translations', 'question_type', 'category.translations', 'options', 'scale'])->get();
        
        return view('admin.question.index')->with('questions', $questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $question_types = QuestionType::all();
        $categories = Category::with('translations')->get();
        $surveys = Survey::with('translations')->get();
        $scales = Scale::all();

        return view('admin.question.create')->with(compact('question_types', 'categories', 'surveys', 'scales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateQuestion $request)
    {
        $validated = $request->validated();

        //dd($validated);

        $question = Question::create([
                'category_id' => $validated['category_id'],
                'question_type_id' => $validated['question_type_id'],
                'required' => $validated['required'],
                'pl'  => ['name' => $validated['pl']],
                'en'  => ['name' => $validated['en']],
                'order' => $validated['order'],
            ]);

        if(isset($validated['scale_id']) && !empty($validated['scale_id'])) {
            $question->scale_id = $validated['scale_id'];
            $question->save();
        }

        if(isset($validated['surveys']) && !empty($validated['surveys'])) {
            $question->surveys()->sync($validated['surveys']);
        }

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Pytanie zapisane.');

        return redirect()->route('admin.questions.index');
    }

    public function detach(Question $question, Survey $survey, Request $request)
    {
        $question->surveys()->detach($survey->id);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Pytanie '.$question->id.' odpięte od ankiety '.$survey->id.'.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $question_types = QuestionType::all();
        $categories = Category::with('translations')->get();
        $surveys = Survey::with('translations')->get();
        $scales = Scale::all();

        return view('admin.question.edit')->with(compact('question', 'question_types', 'scales', 'categories', 'surveys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestion $request, Question $question)
    {

        $validated = $request->validated();

         //dd($validated);

        if(isset($validated['scale_id']) && !empty($validated['scale_id'])) {
            $scale_id = $validated['scale_id'];
        } else {
            $scale_id = null;
        }

        $question->update([
                'category_id' => $validated['category_id'],
                'question_type_id' => $validated['question_type_id'],
                'scale_id' => $scale_id,
                'required' => $validated['required'],
                'pl'  => ['name' => $validated['pl']],
                'en'  => ['name' => $validated['en']],
                'order' => $validated['order'],
            ]);

        if(isset($validated['surveys']) && !empty($validated['surveys'])) {
            $question->surveys()->sync($validated['surveys']);
        } else {
            $question->surveys()->detach();
        }

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Pytanie '.$question->id.' zapisane.');

        return redirect()->route('admin.questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Request $request)
    {
        //check if has any answers for this question
        if(count($question->answers)) {
            $request->session()->flash('class', 'alert-danger');
            $request->session()->flash('info', 'Pytanie '.$question->id.' nie może zostać usunięte, ponieważ zawiera odpowiedzi.');

            return redirect()->back();
        }

        //check if attached to any survey
        if(count($question->surveys)) {
            $question->surveys()->detach();
        }
        
        //check if has any options
        if($question->question_type->options) {
            $question->options()->delete();
        }

        //destroy
        $question->delete();

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Pytanie '.$question->id.' usunięte.');

        return redirect()->back();
    }
}
