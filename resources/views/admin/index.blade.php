@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-xs-12 col-lg-12">
            <h2 class="h2-responsive">
                Ankiety: {{ $surveys->count() }}
            </h2>
            <div class="row my-4">
                @foreach($surveys as $survey)
                <div class="col-lg-6 my-3">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.survey.show', ['survey' => $survey]) }}">{{ $survey->title }}</a>
                        </div>
                        <div class="card-body">
                            <p>Pytań: {{ $survey->questions->count() }}</p>
                            <p>Kategorii: {{ $survey->categories->count() }}</p>
                              <p>Ankietowanych: {{ $survey->people->count() }}</p>
                              <p>Odpowiedzi: {{ $survey->answers->count() }}</p>
                              <p>Pytania z odpowiedziami: {{ $survey->percentAnswered() }}</p>
                              <p>Niedokończone ankiety: {{ $survey->peopleUnfinished() }}</p>
                              <p>Ankietowani bez żadnych odpowiedzi: {{ $survey->peopleWithoutAnswersCount() }} </p>
                              <p>Firma: {{ $survey->company->name ?? '-' }}</p>
                              <p>Status: {{ $survey->finished ? 'Zakończona' : 'Aktywna' }} <a href="{{route('admin.survey.status.change', ['survey' => $survey->id])}}">Zmień <i class="fas fa-random"></i></a></p>
                              <p>Link pl: <a href="{{ route('survey.start', ['locale' => 'pl', 'survey_uuid' => $survey->uuid]) }}" target="_blank">{{ route('survey.start', ['locale' => 'pl', 'survey_uuid' => $survey->uuid]) }}</a></p>
                              <p>Link en: <a href="{{ route('survey.start', ['locale' => 'en', 'survey_uuid' => $survey->uuid]) }}" target="_blank">{{ route('survey.start', ['locale' => 'en', 'survey_uuid' => $survey->uuid]) }}</a></p>
                            <hr>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.survey.show', ['survey' => $survey]) }}">
                                Zobacz <i class="far fa-eye"></i>
                            </a>
                            <a class="btn btn-accent btn-sm" href="{{ route('admin.survey.edit', ['survey' => $survey->id]) }}">
                                Edytuj <i class="fas fa-edit"></i>
                            </a>

                            <a class="btn btn-accent btn-sm" href="{{ route('admin.survey.attachCategoriesForm', ['survey' => $survey]) }}">
                                Dodaj kategorie <i class="far fa-list-alt"></i></i>
                            </a>

                            <a class="btn btn-accent btn-sm" href="{{ route('admin.survey.attachQuestionsForm', ['survey' => $survey]) }}">
                                Dodaj pytania <i class="far fa-list-alt"></i></i>
                            </a>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xs-12 col-lg-3">
            <div class="card">
                <div class="card-header">Odpowiedzi:</div>
                <div class="card-body">
                <p class="big-count">
                    {{ $answers->count() }}
                </p>
                <a class="btn btn-success btn-sm" href="">
                    Zobacz <i class="far fa-eye"></i>
                </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3">
            <div class="card">
                <div class="card-header">Pytania:</div>
                <div class="card-body">
                <p class="big-count">
                    {{ $questions->count() }}
                </p>
                <a class="btn btn-success btn-sm" href="{{ route('admin.questions.index') }}">
                    Zobacz <i class="far fa-eye"></i>
                </a>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3">
            <div class="card">
                <div class="card-header">Kategorie pytań:</div>
                <div class="card-body">
                    <p class="big-count">
                        {{ $categories->count() }}
                    </p>
                <a class="btn btn-success btn-sm" href="{{ route('admin.category.index') }}">
                    Zobacz <i class="far fa-eye"></i>
                </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3">
            <div class="card">
                <div class="card-header">Ankietowani:</div>
                <div class="card-body">
                    <p class="big-count">
                        {{ $people->count() }}
                    </p>
                <a class="btn btn-success btn-sm" href="">
                    Zobacz <i class="far fa-eye"></i>
                </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
