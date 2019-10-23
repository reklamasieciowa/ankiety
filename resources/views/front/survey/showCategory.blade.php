@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    @include('front.survey.title')

    @include('front.survey.stepper')

    <div class="row mt-4 mb-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
              <h2 class="card-title category-title">{{ $currentCategory->name }}</h2>
            </div>
          <div class="card-body">
            @if(count($questions))
              <form action="{{ url()->current() }}" method="POST">
                @csrf
                @foreach($questions as $question)
                  <div class="question">
                    @include('front.survey.renderQuestion')
                  </div>
                @endforeach
                <div class="form-group">
                  <button class="btn btn-info" type="submit">{{ __('messages.Next') }}</button>
                </div>
              </form> 
            @else
               <div class="question">
                 <p>Kategoria nie zawiera pytań.</p>
               </div>
            @endif   
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection