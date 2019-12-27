<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Person;
use App\Answer;
use App\Category;
use App\Post;
use App\Department;
use App\Company;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\CreateSurvey;
use App\Http\Requests\UpdateSurvey;
use App\Http\Requests\AttachQuestionsToSurvey;
use App\Http\Requests\AttachCategoriesToSurvey;
use Illuminate\Support\Str;

class SurveyAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::with(['translations', 'people', 'answers', 'questions', 'company', 'categories'])->get();
        $people = Person::with('answers')->get();
        $answers = Answer::all();
        $questions = Question::all();
        $categories = Category::all();

        return view('admin.index')->with('surveys', $surveys)->with('people', $people)->with('answers', $answers)->with('questions', $questions)->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        return view('admin.survey.create')->with(compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSurvey $request)
    {
        $validated = $request->validated();

        //dd($validated);

        Survey::create([
            'finished' => 0,
            'pl'  => ['title' => $validated['name_pl'], 'description' => $validated['description_pl']],
            'en'  => ['title' => $validated['name_en'], 'description' => $validated['description_en']],
            'company_id' => $validated['company_id'],
            'uuid' => (string) Str::uuid(),
        ]);


        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Ankieta zapisana.');

        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        $survey = $survey->load(['people', 'questions.translations', 'questions.category.translations', 'questions.scale']);

         $peopleByPost = $survey->peopleByPost();
         $peopleByDepartment = $survey->peopleByDepartment();
         $peopleByIndustry = $survey->peopleByIndustry();

        return view('admin.survey.show')->with(compact('survey','peopleByPost','peopleByDepartment', 'peopleByIndustry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        $companies = Company::all();

        return view('admin.survey.edit')->with(compact('companies', 'survey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurvey $request, Survey $survey)
    {
        $validated = $request->validated();

        //dd($validated);

        $survey->update([
            'finished' => $validated['finished'],
            'pl'  => ['title' => $validated['name_pl'], 'description' => $validated['description_pl']],
            'en'  => ['title' => $validated['name_en'], 'description' => $validated['description_en']],
            'company_id' => $validated['company_id'],
        ]);


        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Ankieta zapisana.');

        return redirect()->route('admin.index');
    }


    public function attachQuestionsForm(Survey $survey)
    {
        $questions = Question::with('category.translations', 'translations')->get();

        return view('admin.survey.attachQuestions')->with(compact('questions', 'survey'));
    }

    public function attachQuestions(AttachQuestionsToSurvey $request, Survey $survey)
    {
        $validated = $request->validated();

        //dd($validated);

        $survey->questions()->sync($validated['questions']);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Pytania dołączone do ankiety: '.count($validated['questions']).'.');

        return redirect()->back();
    }

    public function attachCategoriesForm(Survey $survey)
    {
        $categories = Category::with('questions', 'translations')->get();

        return view('admin.survey.attachCategories')->with(compact('categories', 'survey'));
    }

    public function attachCategories(AttachCategoriesToSurvey $request, Survey $survey)
    {
        $validated = $request->validated();

        //dd($validated);

        $survey->categories()->sync($validated['categories']);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Kategorie dołączone do ankiety: '.count($validated['categories']).'.');

        return redirect()->back();
    }

    public function statusChange(Survey $survey, Request $request)
    {
        if($survey->finished === 0) {
            $survey->finished = 1;
        } else {
            $survey->finished = 0;
        }

        $survey->save();

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Status ankiety zapisany.');

        return redirect()->back();
    }

    public function destroyEmptyPeople(Survey $survey, Request $request)
    {
        //dd($survey->peopleWithoutAnswersCollections());

        $peopleWithNoAnswers = $survey->peopleWithoutAnswersCollections();

        foreach($peopleWithNoAnswers as $person) {
            $person->delete();
        }

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Usunięto '.count($peopleWithNoAnswers).' użytkowników.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, Request $request)
    {
        //delete answers
        if(count($survey->answers)) {
            $survey->answers()->delete();
        }

        //delete people
        if(count($survey->people)) {
            $survey->people()->delete();
        }

        //detach questions
        if(count($survey->questions)) {
            $survey->questions()->detach();
        }

        //destroy survey
        $survey->delete();

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Ankieta '.$survey->id.' usunięta.');

        return redirect()->route('admin.index');
    }
}
