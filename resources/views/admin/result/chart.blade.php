@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
       <h1 class="h2-responsive title"> {{ $title }} </h1>

     </div>
   </div>

   <div class="row mt-5">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          {!! $chart->container() !!}
        </div>
      </div>
    </div>
  </div>

</div>
</div>
@endsection

@section('footer-scripts')
  {!! $chart->script() !!}
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
@endsection