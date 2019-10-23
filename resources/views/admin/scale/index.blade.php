@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Skale: {{ $scales->count() }}</h1>
         <p class="alert alert-info"><strong>Uwaga:</strong> Zmiana/usunięcie wartości skali spowoduje zmianę/usunięcie we wszystkich ankietach do których jest przypisana.</p>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2 class="h4-responsive">Dodaj skalę:</h2>
            <form action="{{ route('admin.scale.store') }}" method="POST">
              @csrf
              @method('PUT')
                <div class="form-group">
                  <label for="name">Nazwa skali:</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{old('name') ?? ''}}">
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

                  @forelse($scales as $scale)
                    <div class="row question_prev">
                      <div class="col-lg-1">
                        <p>ID: {{ $scale->id }}</p>
                      </div>
                      <div class="col-lg-9">
                        <p>
                          <strong>{{ $scale->name }}</strong>
                        </p>  
                        <p>
                          <strong>Wartości:</strong>
                          <ul>
                            @forelse($scale->values as $value)
                               <li>{{ $value->value }} - {{ $value->name }}</li>
                            @empty
                              <p>Brak wartości.</p>
                            @endforelse
                          </ul>
                        </p>
                        <p>
                          <strong>Przypisana do pytań:</strong> {{count($scale->questions)}}
                        </p>
                      </div>
                      <div class="col-lg-2">
                          <a class="btn btn-accent btn-sm" href="{{ route('admin.scale.edit', ['scale' => $scale->id]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>

                          <form method="POST" action="{{ route('admin.scale.destroy', ['scale' => $scale->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                          </form>

                        
                      </div>

                    </div>
                  @empty
                  <p>Brak skal.</p>
                  @endforelse

              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection