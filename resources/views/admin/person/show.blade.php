@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h3-responsive title">Ankietowany: {{ $person->id }}</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Dane
              </div>
              <div class="card-body">
                  <p>
                    <i class="fas fa-briefcase"></i> {{ $person->post->name }}, {{ $person->department->name }}
                  </p>
                  <p>
                    <i class="far fa-envelope"></i> {{ $person->email ?? '-' }},  <i class="far fa-calendar-alt"></i> {{ $person->created_at }}
                  </p>
                  <p>
                    <i class="far fa-list-alt"></i> {{ $person->survey->title }}
                  </p>
              </div>
          </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Odpowiedzi: {{ $person->answers->count() }}
              </div>
              <div class="card-body">

                  @foreach($person->answers as $answer)
                    <div class="row question_prev">
                      <div class="col-lg-12">
                        <p>
                          <strong>Pytanie: </strong>{{ $answer->question->name }}
                        </p>
                        <p>
                          <strong>Kategoria: </strong>{{ $answer->question->category->name }}
                        </p>
                        <p>
                          <strong>Odpowiedź: </strong>{{ $answer->value }}
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