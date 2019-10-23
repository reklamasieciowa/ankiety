   @extends('layouts.app')

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Edytuj skalę: {{ $scale->name }}</h1>
       </div>
     </div>

     <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.scale.update', ['scale' => $scale->id]) }}" method="POST">
              @csrf
              @method('PATCH')

                <div class="form-group">
                  <label for="name">Nazwa Skali:</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{old('name') ?? $scale->name }}">
                </div>

              <div class="form-group">
                <button class="btn btn-info" type="submit">Zapisz</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <label>Wartości:</label>
            <ul>
              @forelse($scale->values as $value)
                <li>{{ $value->value }} - {{ $value->name }}
                  <a href="{{ route('admin.scale.value.edit', ['scale' => $scale->id, 'scaleValue' => $value->id]) }}">
                    Edytuj <i class="fas fa-edit"></i>
                  </a>

                  <form style="display: inline;" action="{{ route('admin.scale.value.destroy', ['scale' => $scale->id, 'scaleValue' => $value->id ]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                            
                    <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                  </form>
                </li>
              @empty
                <p>Brak wartości.</p>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.scale.value.store', ['scale' => $scale->id]) }}" method="POST">
              @csrf
              @method('PUT')
                <input type="hidden" name="scale_id" value="{{ $scale->id }}">

                <div class="form-group">
                  <label for="value">Wartość:</label>
                  <input type="number" class="form-control" id="value" name="value" value="{{ old('value') }}">
                </div>

                <div class="form-group">
                  <label for="name_pl">Nazwa PL:</label>
                  <input type="text" class="form-control" id="name_pl" name="name_pl" value="{{ old('name_pl') }}">
                </div>

                <div class="form-group">
                  <label for="name_en">Nazwa EN:</label>
                  <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') }}">
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