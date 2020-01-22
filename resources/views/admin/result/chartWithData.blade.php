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
    <div class="col-lg-12" style="height: 800px;">

          {!! $chart->container() !!}

    </div>
    <div class="col-lg-12">
      @if(isset($questions))
        @foreach($questions as $question)
          <p>{{ $loop->index }}: {{ $question->{'name:en'} }}</p>
        @endforeach
      @endif
    </div>

    <div class="col-lg-12 my-5">

      @if(isset($answersValues))
        <table class="table table-bordered">

          <th>Grupa</th>
          @foreach($answersValues['keys'] as $key)
            <th>{{ $key }}</th>
          @endforeach
          
          <tbody>
            @foreach($answersValues as $name => $groupresults)

              @if($name !== 'keys')
              <tr>
                <td>{{ $name }} HRBP</td>
                @foreach($groupresults[0] as $key => $result)
                    <td>{{round($result, 2)}}</td>
                @endforeach
              </tr>
              <tr>
                <td>{{ $name }} Business</td>
                @foreach($groupresults[1] as $result)
                    <td>{{round($result, 2)}}</td>
                @endforeach
              </tr>

              @endif
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </div>

  <div class="row mt-5">
    <div class="col-lg-12">
      <button class="btn btn-success" onclick="DownloadCanvasAsImage()">Pobierz</button>
    </div>
  </div>



</div>
</div>
@endsection

@section('footer-scripts')
  {!! $chart->script() !!}
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
  <script>

    function DownloadCanvasAsImage(){
      let downloadLink = document.createElement('a');
      downloadLink.setAttribute('download', '{{ $title }}.png');
      let canvas = document.getElementById('{{ $chart->id }}');
      let dataURL = canvas.toDataURL('image/png');
      let url = dataURL.replace(/^data:image\/png/,'data:application/octet-stream');
      downloadLink.setAttribute('href', url);
      downloadLink.click();
  }
  </script>

  <script>
    Chart.Legend.prototype.afterFit = function() {
      this.height = this.height + 30;
  };
  </script>
@endsection