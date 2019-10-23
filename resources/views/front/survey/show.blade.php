@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

  <div class="row my-5 text-center">
    <div class="col-lg-12">
      @if (App::isLocale('pl'))
        <a href="{{ route('survey.start', ['locale' => 'en', 'survey' => $survey->id]) }}" class="btn btn-accent">Swith to english</a>
      @else
        <a href="{{ route('survey.start', ['locale' => 'pl', 'survey' => $survey->id]) }}" class="btn btn-accent">Zmień na polski</a>
      @endif
    </div>
  </div>


    <div class="row text-center">
      <div class="col-lg-12">
          <img src="{{ asset('img/intro.jpg') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
          <h1 class="h2-responsive title">{{ $survey->title }}</h1>
          <p class="lead grey-text w-responsive mx-auto mb-5">{!!html_entity_decode($survey->description)!!}</p>

          <a href="{{ route('survey.personal.info', ['locale' => App::getLocale(), 'survey' => $survey->id]) }}" class="btn btn-success">{{ __('messages.Start') }}</a>

      </div>
    </div>

  </div>
</div>
@endsection