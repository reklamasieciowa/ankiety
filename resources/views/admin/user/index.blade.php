@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
         <h1 class="h2-responsive title">Użytkownicy: {{ $users->count() }}</h1>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">

                  @forelse($users as $user)
                    <div class="row question_prev">
                      <div class="col-lg-1">
                        <p>ID: {{ $user->id }}</p>
                      </div>
                      <div class="col-lg-9">
                        <p>
                          <strong>{{ $user->name }}</strong>
                        </p>  
                        <p>
                          {{ $user->email }}
                        </p>

                      </div>
                      <div class="col-lg-2">
                          <a class="btn btn-accent btn-sm" href="{{ route('admin.user.edit', ['user' => $user->id ]) }}">
                            Edytuj <i class="fas fa-edit"></i>
                          </a>

                          @if($user->id !== Auth::id())
                          <form method="POST" action="{{ route('admin.user.destroy', ['user' => $user->id ]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>
                          </form>
                          @endif
                      </div>

                    </div>
                  @empty
                  <p>Brak użytkowników.</p>
                  @endforelse

              </div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection