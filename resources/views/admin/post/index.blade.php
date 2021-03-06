@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Stanowiska: {{ $posts->count() }}</h1>
         
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2 class="h4-responsive">
              Dodaj stanowisko:
            </h2>
            <form method="POST" action="{{ route('admin.post.store') }}">
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
               
                  @forelse($posts as $post)
                    <div class="row question_prev">
                      <div class="col-lg-1">
                        <p>ID: {{ $post->id }}</p>
                      </div>
                      <div class="col-lg-7">
                        <p><strong>Nazwa PL: </strong>{{ $post->name }}</p>
                        <p><strong>Nazwa EN: </strong>{{ $post->{'name:en'} }}</p>
                      </div>
                      <div class="col-lg-2">
                        <a class="btn btn-accent btn-sm" href="{{ route('admin.post.edit', ['post' => $post->id]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>
                      </div>
                      <div class="col-lg-2">
                        <form method="POST" action="{{ route('admin.post.destroy', ['post' => $post->id]) }}">
                          @csrf
                          @method('DELETE')
                          
                          <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                        
                        </form>
                      </div>
                    </div>
                  @empty
                    <p>Brak firm.</p>
                  @endforelse
              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection