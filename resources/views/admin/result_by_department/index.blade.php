@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Wyniki działu {{ $department->name }} firmy {{$survey->company->name}}:</h1>
         <p><a href="{{ route('admin.resultbydepartment.select.department', ['survey' => $survey->id]) }}">Wróć do listy działów</a></p>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 text-center">
        <i class="fas fa-user-alt"></i> {{$people}} / {{ $survey->people->count() }}
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                <p>
                  <strong>Ankietowani wg stanowisk:</strong>
                  <a href="{{ route('admin.resultbydepartment.post', ['survey' => $survey->id, 'department' => $department->id]) }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                    <strong>Średnia wszystkich kategorii:</strong>
                    <a href="{{ route('admin.resultbydepartment.categories', ['survey' => $survey->id, 'department' => $department->id]) }}" target="_blank">Zobacz</a>
                  </p>
                <hr>
                @foreach($categories as $category)
                  <p>
                    <strong>Średnia kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.resultbydepartment.category', ['survey' => $survey->id, 'department' => $department->id, 'category' => $category->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Rozkład wyników kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.resultbydepartment.category.values', ['survey' => $survey->id, 'department' => $department->id, 'category' => $category->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <hr>
                @endforeach

                <p>
                  <strong>Top5 najlepiej ocenianych:</strong>
                  <a href="{{ route('admin.resultbydepartment.top5', ['survey' => $survey->id, 'department' => $department->id, 'order' => 'best']) }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Top5 najgorzej ocenianych:</strong>
                  <a href="{{ route('admin.resultbydepartment.top5', ['survey' => $survey->id, 'department' => $department->id, 'order' => 'worst']) }}" target="_blank">Zobacz</a>
                </p>

              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection