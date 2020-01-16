@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Porównanie wyników firmy {{$survey->company->name}}:</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        Wszystkich ankietowanych: {{ $survey->people->count() }}.
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                <!-- <p>
                  <strong>Ankietowani wg stanowisk:</strong>
                  <a href="{{ route('admin.result.post') }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Ankietowani wg branż:</strong>
                  <a href="{{ route('admin.result.industry') }}" target="_blank">Zobacz</a>
                </p>
                <hr> -->
                <p>
                    <strong>Średnia wszystkich kategorii:</strong>
                    <a href="{{ route('admin.result.compare.categories', ['survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                  </p>
                <hr>
                @foreach($categories as $category)
                  <p>
                    <strong>Średnia kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.result.compare.category', ['category_id' => $category->id, 'survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Rozkład wyników kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.result.compare.category.values', ['category_id' => $category->id, 'survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <hr>
                @endforeach

<!--                 <p>
                  <strong>Top5 najlepiej ocenianych:</strong>
                  <a href="{{ route('admin.result.compare.top5', ['survey' => $survey->id, 'order' => 'best']) }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Top5 najgorzej ocenianych:</strong>
                  <a href="{{ route('admin.result.compare.top5', ['survey' => $survey->id, 'order' => 'worst']) }}" target="_blank">Zobacz</a>
                </p>
                <hr> -->

                <p>
                  <strong>Porównanie po branżach:</strong>
                  <a href="{{ route('admin.result.compare.industries.values', ['survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                </p>
                <hr>

                <p>
                  <strong>Odpowiedzi na pytania otwarte:</strong>
                  <a href="{{ route('admin.result.compare.openQuestions', ['survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                </p>
              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection