@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Porównanie HRBP vs Business w firmie {{$survey->company->name}}:</h1>
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
                <p>
                    <strong>Średnia wszystkich kategorii:</strong>
                    <a href="{{ route('admin.hrbp.categories', ['survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                  </p>
                <hr>
                @foreach($categories as $category)
                  <p>
                    <strong>Średnia kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.hrbp.category', ['category_id' => $category->id, 'survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <p>
                    <strong>Rozkład wyników kategorii {{ $category->name }}:</strong>
                    <a href="{{ route('admin.hrbp.category.values', ['category_id' => $category->id, 'survey' => $survey->id]) }}" target="_blank">Zobacz</a>
                  </p>
                  <hr>
                @endforeach
                <p>
                  <strong>Top5 najlepiej ocenianych HRBP:</strong>
                  <a href="{{ route('admin.hrbp.top5', ['survey' => $survey->id, 'order' => 'best', 'group' => 'hrbp']) }}" target="_blank">Zobacz</a>
                </p>
                
                <p>
                  <strong>Top5 najgorzej ocenianych HRBP:</strong>
                  <a href="{{ route('admin.hrbp.top5', ['survey' => $survey->id, 'order' => 'worst', 'group' => 'hrbp']) }}" target="_blank">Zobacz</a>
                </p>
                <hr>
                <p>
                  <strong>Top5 najlepiej ocenianych Business:</strong>
                  <a href="{{ route('admin.hrbp.top5', ['survey' => $survey->id, 'order' => 'best', 'group' => 'business']) }}" target="_blank">Zobacz</a>
                </p>
                
                <p>
                  <strong>Top5 najgorzej ocenianych Business:</strong>
                  <a href="{{ route('admin.hrbp.top5', ['survey' => $survey->id, 'order' => 'worst', 'group' => 'business']) }}" target="_blank">Zobacz</a>
                </p>
              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection