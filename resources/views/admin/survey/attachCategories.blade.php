@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Dodaj kategorie do ankiety {{ $survey->title }}</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  Wybierz kategorie:
                  <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                      <label class="custom-control-label" for="checkAll">Zaznacz wszystkie</label>
                  </div>
              </div>
              <div class="card-body">
                 <form method="POST" action="{{ route('admin.survey.attachCategories', ['survey' => $survey->id]) }}">
                  @csrf
                  
                  @foreach($categories as $category)
                    <div class="question">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="q{{ $category->id }}" name="categories[]" value="{{ $category->id }}" {{ $survey->categories->contains($category->id) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="q{{ $category->id }}">{{ $category->name }}<br><strong>Pytań w kategorii:</strong> {{ count($category->questions) }}</label>
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