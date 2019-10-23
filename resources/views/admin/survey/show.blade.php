@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">{{ $survey->title }}</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Statystyki
              </div>
              <div class="card-body">
                  <p>Pytań: {{ $survey->questions->count() }}</p>
                  <p>Ankietowanych: {{ $survey->people->count() }}</p>
                  <p>Odpowiedzi: {{ $survey->answers->count() }}</p>
                  <p>Pytania z odpowiedziami: {{ $survey->percentAnswered() }}</p>
                  <p>Niedokończone ankiety: {{ $survey->peopleUnfinished() }} </p>
                  <p>Ankietowani bez żadnych odpowiedzi: {{ $survey->peopleWithoutAnswers() }}</p>
                  <p>Firma: {{ $survey->company->name ?? '-' }}</p>
                  <p>Status: {{ $survey->finished ? 'Zakończona' : 'Aktywna' }} <a href="{{route('admin.survey.status.change', ['survey' => $survey->id])}}">Zmień <i class="fas fa-random"></i></a></p>
                  <hr>
                  <a class="btn btn-accent btn-sm" href="{{ route('admin.survey.edit', ['survey' => $survey->id]) }}">
                      Edytuj <i class="fas fa-edit"></i>
                  </a>

                  <a class="btn btn-accent btn-sm" href="{{ route('admin.survey.attachQuestionsForm', ['survey' => $survey]) }}">
                      Dodaj pytania <i class="far fa-list-alt"></i></i>
                  </a>

                   <form method="POST" action="{{ route('admin.survey.destroy', ['survey' => $survey->id]) }}">
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                  </form>
              </div>
          </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Ankietowani: {{ $survey->people->count() }}
              </div>
              <div class="card-body">
                
                  <div class="row">
                    <div class="col-lg-6">
                      <h5 class="h4-responsive">
                        Stanowiska:
                      </h5>
                      @foreach($peopleByPost as $key => $value)
                        <p><strong>{{ $key }}:</strong> {{ $value->count() }} ({{ round($value->count()/ $survey->people->count()*100,2) }}%)</p>
                      @endforeach 
                    </div>
                    <div class="col-lg-6">
                      <h5 class="h4-responsive">
                        Działy:
                      </h5>
                      @foreach($peopleByDepartment as $key => $value)
                        <p><strong>{{ $key }}:</strong> {{ $value->count() }} ({{ round($value->count()/ $survey->people->count()*100,2) }}%)</p>
                      @endforeach 
                    </div>
                  </div>
                
              </div>
          </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Pytania: {{ $survey->questions->count() }}
              </div>
              <div class="card-body">

                  @foreach($survey->questions as $question)
                    <div class="row question_prev">
                      <div class="col-lg-8">
                        <p><strong>PL: </strong>{{ $question->name }}</p>
                        <p><strong>EN: </strong>{{ $question->{'name:en'} }}</p>
                        <p><strong>Kategoria: </strong>{{ $question->category->name }}</p>
                        @if($question->hasScale())
                          <p><strong>Skala odpowiedzi:</strong> {{ $question->scale->name }}</p>
                        @endif
                        <p><strong>Wymagane:</strong> {{ $question->required ? 'Tak' : 'Nie' }}</p>
                        <p><strong>Kolejność w kategorii: </strong>{{ $question->order ?? '-'}}</p>
                      </div>
                    
                      <div class="col-lg-2">
                        <a class="btn btn-accent btn-sm" href="{{ route('admin.questions.edit', ['question' => $question->id]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>
                      </div>
                      <div class="col-lg-2">
                        <a class="btn btn-accent btn-sm" href="{{ route('admin.questions.detach', ['question' => $question->id, 'survey' => $survey->id]) }}">
                          Odepnij <i class="fas fa-minus-circle"></i>
                        </a>
                      </div>
                    </div>
                  @endforeach

              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection