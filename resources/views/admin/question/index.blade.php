@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Pytania: {{ $questions->count() }}</h1>
         <p><a href="{{ route('admin.questions.create') }}" class="btn btn-accent btn-sm">Dodaj pytanie <i class="fas fa-plus-circle"></i></a></p>
         <p class="alert alert-info"><strong>Uwaga:</strong> Zmiana/usunięcie pytania spowoduje zmianę/usunięcie we wszystkich ankietach do których jest przypisane.</p>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">

                  @foreach($questions as $question)
                    <div class="row question_prev">
                      <div class="col-lg-1">
                        <p>ID: {{ $question->id }}</p>
                      </div>
                      <div class="col-lg-11">
                        <p><strong>PL: </strong>{{ $question->name }}</p>
                        <p><strong>EN: </strong>{{ $question->{'name:en'} }}</p>
                        <p><strong>Kategoria: </strong>{{ $question->category->name }}</p>
                        <p><strong>Kolejność w kategorii: </strong>{{ $question->order ?? '-'}}</p>
                        <p><strong>Typ pytania: </strong>{{ $question->question_type->display_name }}</p>
                        @if($question->hasScale())
                          <p><strong>Skala odpowiedzi:</strong> {{ $question->scale->name }}</p>
                        @endif
                        @if($question->canHaveOptions())
                          <p><strong>Dodane Opcje: </strong>
                          @if($question->getOptions())
                              @foreach($question->getOptions() as $option)
                                {{ $option->name }},
                              @endforeach
                          @else
                            brak. Dodaj opcje do tego pytania.
                          @endif
                          </p>
                        @endif
                        <p><strong>Wymagane:</strong> {{ $question->required ? 'Tak' : 'Nie' }}</p>
                        <p><strong>Przypisane do ankiet:</strong> 
                          @if(count($question->surveys))
                            @foreach($question->surveys as $survey)
                              {{ $survey->title }} <a href="{{ route('admin.questions.detach', ['question' => $question->id, 'survey' => $survey->id]) }}">Odepnij <i class="fas fa-minus-circle"></i></a>, 
                            @endforeach
                          @else
                          -
                          @endif
                        </p>
                        <p>
                          <a class="btn btn-accent btn-sm" href="{{ route('admin.questions.edit', ['question' => $question->id]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>

                          <form method="POST" action="{{ route('admin.questions.destroy', ['question' => $question->id]) }}">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                          
                          </form>

                        </p>
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