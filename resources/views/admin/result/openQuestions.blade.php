@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Pytania otwarte:</h1>
      </div>
    </div>


  @forelse($answers as $name => $items)
    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">

              <div class="card-body">
                <h4 class="card-title">{{ $name }}</h4>

                @foreach($items as $answer)
                  <p>{{ $answer->value }}</p>
                  <hr>
                @endforeach
              </div>
          </div>
      </div>
    </div>
  @empty
  <p>Brak odpowiedzi.</p>
  @endforelse

  </div>
</div>
@endsection