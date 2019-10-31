   @extends('layouts.app')

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Dodaj firmę:</h1>
       </div>
     </div>

   <div class="row mt-5">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.company.store') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="name">Nazwa firmy:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{old('name') ?? ''}}">
            </div>

            <div class="form-group">
              <p>Domyślny poziom stanowiska</p>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="postnone" name="post_id" value="" checked>
                <label class="custom-control-label" for="postnone">Brak</label>
              </div>

              @forelse($posts as $post)
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="post{{ $post->id }}" name="post_id" value="{{ $post->id }}">
                <label class="custom-control-label" for="post{{ $post->id }}">{{ $post->name }}</label>
              </div>
              @empty
              <p>Brak zawodów.</p>
              @endforelse
            </div>

            <div class="form-group">
              <p>Domyślny dział</p>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="departmentnone" name="department_id" value="" checked>
                <label class="custom-control-label" for="departmentnone">Brak</label>
              </div>
              @forelse($departments as $department)
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="department{{ $department->id }}" name="department_id" value="{{ $department->id }}">
                <label class="custom-control-label" for="department{{ $department->id }}">{{ $department->name }}</label>
              </div>
              @empty
              <p>Brak działów.</p>
              @endforelse
            </div>

            <div class="form-group">
              <p>Domyślna branża</p>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="industrynone" name="industry_id" value="" checked>
                <label class="custom-control-label" for="industrynone">Brak</label>
              </div>
              @forelse($industries as $industry)
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="industry{{ $industry->id }}" name="industry_id" value="{{ $industry->id }}">
                <label class="custom-control-label" for="industry{{ $industry->id }}">{{ $industry->name }}</label>
              </div>
              @empty
              <p>Brak branż.</p>
              @endforelse
            </div>

            <div class="form-group">
              <p>Pytanie o email</p>
              
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="emailyes" name="emails" value="1" checked>
                  <label class="custom-control-label" for="emailyes">Tak</label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="emailno" name="emails" value="0">
                  <label class="custom-control-label" for="emailno">Nie</label>
                </div>

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