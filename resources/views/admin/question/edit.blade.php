@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Edytuj pytanie: {{ $question->id }}</h1>
         <p class="alert alert-info"><strong>Uwaga:</strong> Zmiana pytania spowoduje zmianę we wszystkich ankietach do których jest przypisane.</p>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">

                 <form action="{{ route('admin.questions.update', ['question' => $question->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                      <label for="pl">Treść pytania PL</label>
                      <textarea class="form-control rounded-0" id="pl" name="pl" rows="2">{{ $question->name }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="en">Treść pytania EN</label>
                      <textarea class="form-control rounded-0" id="en" name="en" rows="2">{{ $question->translate('en')->name }}</textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Typ pytania:</label>
                      @foreach($question_types as $type)
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="t{{ $type->id }}" name="question_type_id" value="{{ $type->id }}" {{ $question->question_type_id === $type->id ? 'checked' : '' }}>
                        <label class="custom-control-label" for="t{{ $type->id }}">{{ $type->display_name }}</label>
                      </div>
                      @endforeach
                    </div>

                    @if($question->hasScale())
                      <div class="form-group">
                        <label>Skala odpowiedzi:</label>
                        @foreach($scales as $scale)
                        <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="s{{ $scale->id }}" name="scale_id" value="{{ $scale->id }}" {{$question->scale->id == $scale->id ? 'checked' : ''}}>
                          <label class="custom-control-label" for="s{{ $scale->id }}">{{ $scale->name }}</label>
                        </div>
                        @endforeach
                      </div>
                    @endif

                    <div class="form-group">
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
                    </div>

                    <div class="form-group">
                      <label>Pytanie wymagane:</label>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="required" name="required" value="1" {{$question->required == 1 ? 'checked' : ''}}>
                        <label class="custom-control-label" for="required">Tak</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="notrequired" name="required" value="0" {{$question->required == 0 ? 'checked' : ''}}>
                        <label class="custom-control-label" for="notrequired">Nie</label>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Kategoria:</label>
                      @foreach($categories as $category)
                        <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="c{{ $category->id }}"  name="category_id" value="{{ $category->id }}" {{ $question->category_id === $category->id ? 'checked' : '' }}>
                          <label class="custom-control-label" for="c{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                      @endforeach
                    </div>

                    <div class="form-group">
                      <label for="order">Pozycja w kategorii</label>
                      <input type="number" id="order" name="order" class="form-control" value="{{ $question->order }}">
                    </div>

                    <div class="form-group">
                      <label>Przypisz do ankiet:</label>
                      @foreach($surveys as $survey)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="s{{ $survey->id }}" name="surveys[]" value="{{ $survey->id }}" {{ $question->surveys->contains($survey->id) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="s{{ $survey->id }}">{{ $survey->title }}</label>
                        </div>
                      @endforeach
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