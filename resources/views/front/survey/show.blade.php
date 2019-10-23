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
      <div class="col-lg-12 mb-5">
        <svg id="logo_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 365.39 96.31"><defs><style>.a,.b{fill:#1d1d1b;}.a{fill-rule:evenodd;}</style></defs><title>wncl</title><path class="a" d="M252.07,321.89h12l6-21.23c1-3.67,2-8.31,2-8.39h.17c0,.08.94,4.62,1.89,8.39l5.3,21.23h12l12.85-45H292.05l-4.79,18.66c-1,3.68-2.06,8.66-2.06,8.74H285c0-.08-.95-5.15-1.89-9.17l-4.45-18.23H266.37l-4.54,18.23c-1.11,4.37-2,9.09-2,9.17h-.18c0-.08-.85-4.54-1.88-8.57l-4.71-18.83H239.32Z" transform="translate(-239.32 -250.19)"/><path class="a" d="M365.57,321.89h11.56V301.17c0-3.5-.26-6.84-.26-6.93H377c.09.17,1.71,2.82,5.13,7.53l14.55,20.12h11.73v-45H396.91v18.75c0,3.5.34,7.62.34,7.79h-.18a70.76,70.76,0,0,0-5.31-8.31l-13.18-18.23h-13Z" transform="translate(-239.32 -250.19)"/><path class="a" d="M496.36,322.66c7.71,0,12.57-2.48,15.32-4.45L506.8,309a16,16,0,0,1-9.93,3.08c-7.45,0-11.3-5.23-11.3-13.11,0-7.44,4.11-12.32,11.21-12.32a14.84,14.84,0,0,1,9.08,2.57l5.39-9.33c-3.59-2.58-8.22-3.84-14.38-3.84C480,276,471.7,287,471.7,299.38S479.58,322.66,496.36,322.66Z" transform="translate(-239.32 -250.19)"/><polygon class="a" points="334.66 71.7 365.38 71.7 365.38 61.5 347.67 61.5 347.67 26.67 334.66 26.67 334.66 71.7"/><polygon class="b" points="90.77 96.31 90.77 0 94.97 0 94.97 96.31 90.77 96.31 90.77 96.31"/><polygon class="b" points="199.77 96.31 199.77 0 203.94 0 203.94 96.31 199.77 96.31 199.77 96.31"/><polygon class="b" points="299.37 96.31 299.37 0 303.55 0 303.55 96.31 299.37 96.31 299.37 96.31"/></svg>
      </div>  

      <div class="col-lg-12">
          <img src="{{ asset('img/intro.jpg') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
          <h1 class="h3-responsive title">{{ $survey->title }}</h1>
          <p class="lead grey-text w-responsive mx-auto mb-5">{!!html_entity_decode($survey->description)!!}</p>

          <a href="{{ route('survey.personal.info', ['locale' => App::getLocale(), 'survey' => $survey->id]) }}" class="btn btn-success">{{ __('messages.Start') }}</a>

      </div>
    </div>

  </div>
</div>
@endsection