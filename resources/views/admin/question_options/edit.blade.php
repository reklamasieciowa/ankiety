   @extends('layouts.app')

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Edytuj opcję.</h1>
       </div>
     </div>

      <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2 class="h3-responsive">Edytuj opcję: {{ $questionOption->name }}</h2>
            <form action="{{ route('admin.questions.options.update', ['questionOption' => $questionOption->id]) }}" method="POST">
              @csrf
              @method('PATCH')
                <div class="form-group">
                  <label for="value">Wartość:</label>
                  <input type="number" class="form-control" id="value" name="value" value="{{ old('value') ?? $questionOption->value }}">
                </div>

                <div class="form-group">
                  <label for="name_pl">Nazwa PL:</label>
                  <input type="text" class="form-control" id="name_pl" name="name_pl" value="{{ old('name_pl') ?? $questionOption->name }}">
                </div>

                <div class="form-group">
                  <label for="name_en">Nazwa EN:</label>
                  <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ?? $questionOption->{'name:en'} }}">
                </div>

                <div class="form-group">
                  <label>Przypisz do pytania:</label>
                  @forelse($questions as $question)
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="q{{ $question->name }}" name="question_id" value="{{ $question->id }}" {{ $question->id == $questionOption->question_id ? 'checked' : '' }}>
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

  </div>
</div>
@endsection