@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Edytuj branżę: {{ $industry->name }}</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('admin.industry.update', ['industry' => $industry->id]) }}">
              @csrf
              @method('PATCH')

              <div class="form-group">
                <label for="name_pl">Nazwa PL</label>
                <input type="text" class="form-control" id="name_pl" name="name_pl" value="{{old('name_pl') ?? $industry->name }}">
              </div>
              <div class="form-group">
                <label for="name_en">Nazwa EN</label>
                <input type="text" class="form-control" id="name_en" name="name_en" value="{{old('name_en') ?? $industry->{'name:en'} }}">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-accent">Zapisz</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection