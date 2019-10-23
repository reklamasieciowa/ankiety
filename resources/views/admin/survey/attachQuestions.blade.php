@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Dodaj pytania do ankiety {{ $survey->title }}</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Wybierz pytania:
                  <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                      <label class="custom-control-label" for="checkAll">Zaznacz wszystkie</label>
                  </div>
              </div>
              <div class="card-body">
                 <form method="POST" action="{{ route('admin.survey.attachQuestions', ['survey' => $survey->id]) }}">
                  @csrf
                  
                  @foreach($questions as $question)
                    <div class="question">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="q{{ $question->id }}" name="questions[]" value="{{ $question->id }}" {{ $survey->questions->contains($question->id) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="q{{ $question->id }}">{{ $question->name }}<br><strong>Kategoria:</strong> {{ $question->category->name }}</label>
                      </div>
                    </div>
                  @endforeach
                  
                  <button type="submit" class="btn btn-accent"> Zapisz</button>
                </form>
              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('footer-scripts')
<script>
  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>
@endsection