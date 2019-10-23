@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    <div class="row text-center my-5">
      <div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				 <h2 class="h2-responsive">Dziękujemy za wypełnienie ankiety</h2>
         <h2 class="h2-responsive title">
           {{ $survey->title }}
         </h2>
      			<p>Jeżeli podałeś/aś adres email i wyraziłeś odpowiednie zgody, wyślemy Ci prezentację wyników.</p>
			</div>
		</div>
      </div>
    </div>

  </div>
</div>
@endsection