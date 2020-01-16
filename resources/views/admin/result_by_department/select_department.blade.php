@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Wybierz dział firmy {{$survey->company->name}}:</h1>
      </div>
    </div>
    <div class="row mt-5">
      
      @forelse($departments as $department => $value)
          <div class="col-lg-6 my-3">
              <div class="card">
                <div class="card-body">
                  <h3 class="h5-responsive">{{ $value[0] }} (<i class="fas fa-user-alt"></i> {{$value[1]}})</h3>
                  <p>
                    <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ route('admin.resultbydepartment', ['survey' => $survey->id, 'department' => $department]) }}">Zobacz <i class="far fa-eye"></i></a>
                  </p>
                </div>
              </div>
          </div>
      @empty
      <div class="col-lg-12">
        <p>
          Brak działów.
        </p>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection