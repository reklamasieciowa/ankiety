@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Wybierz firmę do porównania:</h1>
      </div>
    </div>
    <div class="row mt-5">

      @forelse($surveys as $survey)
          <div class="col-lg-6 my-3">
              <div class="card">
                <div class="card-body">
                  <p>
                    <strong>{{ $survey->company->name }}</strong>
                  </p>
                  <p>
                    <a href="{{ route('admin.compare', ['survey' => $survey->id]) }}">Zobacz</a>
                  </p>
                </div>
              </div>
          </div>
      @empty
      <div class="col-lg-12">
        <p>
          Brak firm.
        </p>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection