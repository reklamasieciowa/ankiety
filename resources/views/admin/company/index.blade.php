@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
       <h1 class="h2-responsive title">Firmy: {{ $companies->count() }}</h1>

       <p><a href="{{ route('admin.company.create') }}" class="btn btn-accent btn-sm">Dodaj firmę <i class="fas fa-plus-circle"></i></a></p>

     </div>
   </div>



  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          @if(count($companies))
          @foreach($companies as $company)
          <div class="row question_prev">
            <div class="col-lg-1">
              <p>ID: {{ $company->id }}</p>
            </div>
            <div class="col-lg-7">
              <p><strong>Nazwa: </strong>{{ $company->name }}</p>
              <p><strong>Przypisana do ankiety:</strong> {{ $company->survey->title ?? '-' }}</p>
              <p><strong>Domyślny poziom stanowiska:</strong> {{ $company->post->name ?? '-' }}</p>
              <p><strong>Domyślny dział:</strong> {{ $company->department->name ?? '-' }}</p>
              <p><strong>Domyślna branża:</strong> {{ $company->industry->name ?? '-' }}</p>
              <p><strong>Pytanie o email:</strong> {{ $company->email==1 ? 'tak' : 'nie' }}</p>
            </div>
            <div class="col-lg-2">
              <a class="btn btn-accent btn-sm" href="{{ route('admin.company.edit', ['company' => $company->id]) }}">
                Edytuj <i class="fas fa-edit"></i>
              </a>
            </div>
            <div class="col-lg-2">
              <form method="POST" action="{{ route('admin.company.destroy', ['company' => $company->id]) }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm"> Usuń <i class="far fa-trash-alt"></i></button>

              </form>
            </div>
          </div>
          @endforeach
          @else
          <p>Brak firm.</p>
          @endif

        </div>
      </div>
    </div>
  </div>

</div>
</div>
@endsection