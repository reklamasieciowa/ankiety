   @extends('layouts.app')

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Edytuj wartość: {{ $scaleValue->name }}</h1>
       </div>
     </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.scale.value.update', ['scale' => $scale->id, 'scaleValue' => $scaleValue->id]) }}" method="POST">
              @csrf
              @method('PATCH')
                <input type="hidden" name="scale_id" value="{{ $scale->id }}">
                
                <div class="form-group">
                  <label for="value">Wartość:</label>
                  <input type="number" class="form-control" id="value" name="value" value="{{ old('value') ?? $scaleValue->value }}">
                </div>

                <div class="form-group">
                  <label for="name_pl">Nazwa PL:</label>
                  <input type="text" class="form-control" id="name_pl" name="name_pl" value="{{ old('name_pl') ?? $scaleValue->name }}">
                </div>

                <div class="form-group">
                  <label for="name_en">Nazwa EN:</label>
                  <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ?? $scaleValue->{'name:en'} }}">
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