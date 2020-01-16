@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Wyniki:</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                <p>
                  <strong>Ankietowani wg stanowisk:</strong>
                  <a href="{{ route('admin.result.post') }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Ankietowani wg branż:</strong>
                  <a href="{{ route('admin.result.industry') }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Ankietowani wg działów:</strong>
                  <a href="{{ route('admin.result.department') }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                    <strong>Średnia wszystkich kategorii - wszyscy:</strong>
                    <a href="{{ route('admin.result.categories') }}" target="_blank">Zobacz</a>
                  </p>
                <p>
                    <strong>Średnia wszystkich kategorii - tylko business:</strong>
                    <a href="{{ route('admin.result.categories.business') }}" target="_blank">Zobacz</a>
                  </p>
                <p>
                    <strong>Średnia wszystkich kategorii - HRBP vs business:</strong>
                    <a href="{{ route('admin.result.categories.hrbpbusiness') }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Średnia wszystkich kategorii - stanowiska <i class="fas fa-chart-line fa-lg"></i>:</strong>
                    <a href="{{ route('admin.result.categories.posts') }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Średnia wszystkich kategorii - stanowiska <i class="far fa-file-excel fa-lg"></i></i>:</strong>
                    <a href="{{ route('admin.export.all.category.post') }}" target="_blank">Pobierz</a>
                  </p>
                  <p>
                    <strong>Średnia wszystkich kategorii - branże <i class="fas fa-chart-line fa-lg"></i>:</strong>
                    <a href="{{ route('admin.result.categories.industries') }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Średnia wszystkich kategorii - branże <i class="far fa-file-excel fa-lg"></i></i>:</strong>
                    <a href="{{ route('admin.export.all.category.industry') }}" target="_blank">Pobierz</a>
                  </p>
                <hr>
                @foreach($categories as $category)
                  <p>
                    <strong>Średnia kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.result.category', ['category_id' => $category->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Rozkład wyników kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.result.category.values', ['category_id' => $category->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <hr>
                @endforeach

                <p>
                  <strong>Top5 najlepiej ocenianych HRBP:</strong>
                  <a href="{{ route('admin.result.top5', ['group' => 'hrbp', 'order' => 'best']) }}" target="_blank">Zobacz</a>
                </p>
                <p>
                  <strong>Top5 najgorzej ocenianych HRBP:</strong>
                  <a href="{{ route('admin.result.top5', ['group' => 'hrbp', 'order' => 'worst']) }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Top5 najlepiej ocenianych Business:</strong>
                  <a href="{{ route('admin.result.top5', ['group' => 'business', 'order' => 'best']) }}" target="_blank">Zobacz</a>
                </p>
                <p>
                  <strong>Top5 najgorzej ocenianych Business:</strong>
                  <a href="{{ route('admin.result.top5', ['group' => 'business', 'order' => 'worst']) }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Odpowiedzi na pytania otwarte:</strong>
                  <a href="{{ route('admin.result.openQuestions') }}" target="_blank">Zobacz</a>
                </p>

              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection