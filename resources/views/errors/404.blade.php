@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    <div class="row mb-3">
      <div class="col-lg-12 text-center my-5">
          <h2 class="h2-responsive">
           {{ __('messages.404') }}
          </h2>
          <a href="{{ route('front.index', ['locale' => App::getLocale()]) }}" class="btn btn-success">{{ __('messages.back_to_home') }}</a>
      </div>
    </div>

  </div>
</div>
@endsection