@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Działy: {{ $departments->count() }}</h1>
         
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2 class="h4-responsive">
              Dodaj dział:
            </h2>
            <form method="POST" action="{{ route('admin.department.store') }}">
              @csrf
              @method('PUT')

              <div class="form-group">
                <label for="name_pl">Nazwa PL</label>
                <input type="text" class="form-control" id="name_pl" name="name_pl" value="{{old('name_pl') ?? ''}}">
              </div>
              <div class="form-group">
                <label for="name_en">Nazwa EN</label>
                <input type="text" class="form-control" id="name_en" name="name_en" value="{{old('name_en') ?? ''}}">
              </div>
              <div class="form-group">
                <label for="order">Kolejność</label>
                <input type="number" class="form-control" id="order" name="order" value="{{old('order') ?? ''}}">
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-accent">Zapisz</button>
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
               
                  @forelse($departments as $department)
                    <div class="row question_prev">
                      <div class="col-lg-2">
                        <p>Kolejność: {{ $department->order }}</p>
                      </div>
                      <div class="col-lg-6">
                        <p><strong>Nazwa PL: </strong>{{ $department->name }}</p>
                        <p><strong>Nazwa EN: </strong>{{ $department->{'name:en'} }}</p>
                      </div>
                      <div class="col-lg-2">
                        <a class="btn btn-accent btn-sm" href="{{ route('admin.department.edit', ['department' => $department->id ]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>
                      </div>
                      <div class="col-lg-2">
                        <form method="POST" action="{{ route('admin.department.destroy', ['department' => $department->id ]) }}">
                          @csrf
                          @method('DELETE')
                          
                          <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                        
                        </form>
                      </div>
                    </div>
                  @empty
                    <p>Brak oddziałów.</p>
                  @endforelse
              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection