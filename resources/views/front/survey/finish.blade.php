@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    <div class="row text-center my-5">
      <div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				 <h2 class="h2-responsive">{{ __('messages.Finish') }}</h2>
         <h2 class="h2-responsive title">
           {{ $survey->title }}
         </h2>
      			<p>{{ __('messages.Results') }}</p>
			</div>
		</div>
      </div>
    </div>

  </div>
</div>
@endsection