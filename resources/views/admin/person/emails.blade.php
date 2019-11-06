@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="container">

    @include('shared.info')

    @include('shared.errors')

    <div class="row mt-5 text-center">
      <div class="col-lg-12">
       <h1 class="h2-responsive title">Maile: {{ $emails->count() }}</h1>

     </div>
   </div>

   <div class="row mt-5">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row question_prev">
            <div class="col-lg-12">
              <p><strong>Lista maili do wysyłki wiadomości UDW:</strong></p>
              <p>
                @forelse($emails as $email)
                  @if ($loop->last)
                    {{ $email }}
                  @else
                    {{ $email }},
                  @endif
                @empty
                  Brak maili.
                @endforelse
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</div>
@endsection