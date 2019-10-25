@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
       <h1 class="h2-responsive title">Ankietowani: {{ $people->count() }}</h1>

     </div>
   </div>

   <div class="row mt-5">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">

          @forelse($people as $person)
          <div class="row question_prev">
            <div class="col-lg-1">
              <p>ID: {{ $person->id }}</p>
            </div>
            <div class="col-lg-11">
              <div class="row">
                <div class="col-lg-12">
                  <p>
                    <i class="fas fa-briefcase"></i> {{ $person->post->name }}, {{ $person->department->name }}
                  </p>
                  <p>
                    <i class="far fa-envelope"></i> {{ $person->email ?? '-' }},  <i class="far fa-calendar-alt"></i> {{ $person->created_at }}
                  </p>
                  <p>
                    <i class="far fa-list-alt"></i> {{ $person->survey->title }} {{  isset($person->survey->company->name) ? 'Firma: '.$person->survey->company->name : ''}}
                  </p>
                  <hr>
                  <p>
                    <strong>Odpowiedzi:</strong> {{ $person->countAnswers() }}/{{ count($person->survey->requiredQuestions()) }} ({{ $person->percentAnswered() }})
                    <a class="btn btn-accent btn-sm" href="{{ route('admin.people.show', ['person' => $person->id]) }}">
                      Zobacz <i class="far fa-eye"></i>
                    </a>
                  </p>
                  
                </div>
                <div class="col-lg-12">
                  <hr>
                  
                  <form method="POST" action="{{ route('admin.people.destroy', ['person' => $person]) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>

                  </form>

                </div>
              </div>
            </div>


          </div>
          @empty
          <p>Brak ankietowanych.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>

</div>
</div>
@endsection