@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

        @include('shared.info')

    <div class="row">
      <div class="col-lg-12 text-center">
        <section class="text-center my-5">
          <h1 class="h2-responsive title">{{ config('app.name') }}</h1>
        </section>
        <img src="{{ asset('img/intro.jpg') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
      </div>
    </div>

  </div>
</div>
@endsection