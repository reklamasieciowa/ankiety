   @extends('layouts.app')

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Edytuj firmę:</h1>
       </div>
     </div>

     <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.company.update', ['company' => $company->id]) }}" method="POST">
              @csrf
              @method('PATCH')

                <div class="form-group">
                  <label for="name">Nazwa firmy:</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$company->name}}">
                </div>

              <div class="form-group">
                <button class="btn btn-info" type="submit">Zapisz</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection