@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    @include('front.survey.title')

    @include('front.survey.stepper')

    <div class="row mt-5" id="info">
      <div class="col-lg-12">
        <h3 class="h3-responsive">Skala ocen:</h3>
          @foreach($scales as $scale)
            <p>{{ $scale->value }} - {{ $scale->name }}</p>
          @endforeach
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card my-5">
          <div class="card-body">
            <h2 class="card-title">{{ $currentCategory->name }}</h2>
            @if(count($questions))
              <form action="{{ url()->current() }}" method="POST">
                @csrf

                @foreach($categories as $category)
                  @if(isset($questions[$category->id]))
                    @foreach($questions[$category->id] as $question)
                      @include('front.survey.renderQuestion')
                    @endforeach
                  @endif
                @endforeach

                <div class="form-group">
                  <button class="btn btn-info" type="submit">{{ __('messages.Next') }}</button>
                </div>
              </form> 
            @endif   
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection