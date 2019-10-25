@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Opcje pytań: {{ $options->count() }}</h1>
      </div>
    </div>

      <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2 class="h3-responsive">Dodaj opcję:</h2>
            <form action="{{ route('admin.questions.options.store') }}" method="POST">
              @csrf
              @method('PUT')
                <div class="form-group">
                  <label for="value">Wartość:</label>
                  <input type="number" class="form-control" id="value" name="value" value="{{old('value') ?? ''}}">
                </div>

                <div class="form-group">
                  <label for="name_pl">Nazwa PL:</label>
                  <input type="text" class="form-control" id="name_pl" name="name_pl" value="{{old('name_pl') ?? ''}}">
                </div>

                <div class="form-group">
                  <label for="name_en">Nazwa EN:</label>
                  <input type="text" class="form-control" id="name_en" name="name_en" value="{{old('name_en') ?? ''}}">
                </div>

                <div class="form-group">
                  <label>Przypisz do pytania:</label>
                  @forelse($questions as $question)
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="q{{ $question->name }}" name="question_id" value="{{ $question->id }}">
                      <label class="custom-control-label" for="q{{ $question->name }}">{{ $question->name }}</label>
                    </div>
                  @empty
                    <p>Brak pytań, które mogą mieć opcje.</p>
                  @endforelse
                </div>

                <div class="form-group">
                  <button class="btn btn-info" type="submit">Zapisz</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                  @forelse($options as $option)
                    <div class="row question_prev">
                      <div class="col-lg-1">
                        <p>ID: {{ $option->id }}</p>
                      </div>
                      <div class="col-lg-7">
                        <p><strong>Nazwa: </strong>{{ $option->name }}</p>
                        <p><strong>Przypisana do pytania:</strong> {{ $option->question->name ?? '-' }}</p>
                      </div>
                      <div class="col-lg-2">
                        <a class="btn btn-accent btn-sm" href="{{ route('admin.questions.options.edit', ['questionOption' => $option->id]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>
                      </div>
                      <div class="col-lg-2">
                        <form method="POST" action="{{ route('admin.questions.options.destroy', ['questionOption' => $option->id]) }}">
                          @csrf
                          @method('DELETE')
                          
                          <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                        
                        </form>
                      </div>
                    </div>
                @empty
                  <p>Brak opcji.</p>
                @endforelse

              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection