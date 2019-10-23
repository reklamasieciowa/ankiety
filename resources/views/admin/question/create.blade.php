   @extends('layouts.app')

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Dodaj pytanie:</h1>
       </div>
     </div>

     <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.questions.store') }}" method="POST">
              @csrf
              @method('PUT')

              <div class="form-group">
                <label for="pl">Treść pytania PL</label>
                <textarea class="form-control rounded-0" id="pl" name="pl" rows="2">{{old('pl') ?? ''}}</textarea>
              </div>
              <div class="form-group">
                <label for="en">Treść pytania EN</label>
                <textarea class="form-control rounded-0" id="en" name="en" rows="2">{{old('en') ?? ''}}</textarea>
              </div>

              <div class="form-group">
                <label>Typ pytania:</label>
                @foreach($question_types as $type)
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="t{{ $type->id }}" name="question_type_id" value="{{ $type->id }}" {{old('question_type_id') == $type->id ? 'checked' : ''}}>
                  <label class="custom-control-label" for="t{{ $type->id }}">{{ $type->display_name }}</label>
                </div>
                @endforeach
              </div>

              <div class="form-group">
                <label>Pytanie wymagane:</label>
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="required" name="required" value="1" {{ old('required') == 1 ? 'checked' : ''}}>
                  <label class="custom-control-label" for="required">Tak</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="notrequired" name="required" value="0" {{old('required') == 0 ? 'checked' : ''}}>
                  <label class="custom-control-label" for="notrequired">Nie</label>
                </div>
              </div>

              <div class="form-group">
                <label>Kategoria:</label>
                @foreach($categories as $category)
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="c{{ $category->id }}"  name="category_id" value="{{ $category->id }}" {{old('category_id') == $category->id ? 'checked' : ''}}>
                  <label class="custom-control-label" for="c{{ $category->id }}">{{ $category->name }}</label>
                </div>
                @endforeach
              </div>

              <div class="form-group">
                <label for="order">Pozycja w kategorii:</label>
                <input type="number" id="order" name="order" class="form-control" value="{{old('order') ?? ''}}">
              </div>

              <div class="form-group">
                <label>Przypisz do ankiet:</label>

                @foreach($surveys as $survey)
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="s{{ $survey->id }}" name="surveys[]" value="{{ $survey->id }}">
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