@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    @include('front.survey.title')

    <div class="row my-5">
      <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

               <h2 class="card-title">{{ __('messages.Personal_info') }}</h2>
                  <form method="POST" action="{{ route('person.store', ['locale' => App::getLocale(), 'survey_uuid' => $survey->uuid]) }}">
                    @csrf
                    <input type="hidden" name="survey_uuid" value="{{ $survey->uuid }}">
                   
                      @if(isset($survey->company->post_id))
                        <input type="hidden" id="post_id" name="post_id" value="{{ $survey->company->post_id }}">
                      @else
                        <div class="form-group">
                          <p>{{ __('messages.Post') }}</p>
                          @forelse($posts as $post)
                            <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="post{{ $post->id }}" name="post_id" value="{{ $post->id }}" required>
                              <label class="custom-control-label" for="post{{ $post->id }}">{{ $post->name }}</label>
                            </div>
                          @empty
                            <p>Brak zawodów.</p>
                          @endforelse
                        </div>
                      @endif

                    @if(isset($survey->company->department_id))
                        <input type="hidden" id="department_id" name="department_id" value="{{ $survey->company->department_id }}">
                    @else
                      <div class="form-group">
                        <p>{{ __('messages.Department') }}</p>
                        @forelse($departments as $department)
                          <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="department{{ $department->id }}" name="department_id" value="{{ $department->id }}" required>
                            <label class="custom-control-label" for="department{{ $department->id }}">{{ $department->name }}</label>
                          </div>
                        @empty
                          <p>Brak działów.</p>
                        @endforelse
                      </div>
                    @endif

                    @if(isset($survey->company->industry_id))
                        <input type="hidden" id="industry_id" name="industry_id" value="{{ $survey->company->industry_id }}">
                    @else
                      <div class="form-group">
                        <p>{{ __('messages.Industry') }}</p>
                        @forelse($industries as $industry)
                          <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="industry{{ $industry->id }}" name="industry_id" value="{{ $industry->id }}" required>
                            <label class="custom-control-label" for="industry{{ $industry->id }}">{{ $industry->name }}</label>
                          </div>
                        @empty
                          <p>Brak branż.</p>
                        @endforelse
                      </div>
                    @endif

                    <div class="form-group">
                      <label for="email">{{ __('messages.Email') }}</label>
                      <small>{{ __('messages.Email_info') }}</small>
                      <input type="text" id="email" name="email" class="form-control">
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="agree" name="agree" value="1">
                        <label class="custom-control-label" for="agree">{{ __('messages.Agree') }}</label>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-info" type="submit">{{ __('messages.Next') }}</button>
                    </div>
                </form>
            </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection