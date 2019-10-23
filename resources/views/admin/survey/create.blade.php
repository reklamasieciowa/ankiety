   @extends('layouts.app')

   @section('header')
    <link href="{{asset('summernote/summernote-bs4.css')}}" rel="stylesheet">
   @endsection

   @section('content')
   <div class="container-fluid">
    <div class="container">

      @include('shared.info')

      @include('shared.errors')

      <div class="row mt-5 text-center">
        <div class="col-lg-12">
          <h1 class="h2-responsive title">Dodaj ankietę:</h1>
       </div>
     </div>

     <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.survey.create') }}" method="POST">
              @csrf
              @method('PUT')

              <div class="form-group">
                <label for="name_pl">Nazwa ankiety PL</label>
                <textarea class="form-control rounded-0" id="name_pl" name="name_pl" rows="2">{{old('name_pl') ?? ''}}</textarea>
              </div>

              <div class="form-group">
                <label for="description_pl">Opis ankiety PL</label>
                <textarea class="form-control rounded-0" id="description_pl" name="description_pl" rows="10">{{old('description_pl') ?? ''}}</textarea>
              </div>

              <div class="form-group">
                <label for="name_en">Nazwa ankiety EN</label>
                <textarea class="form-control rounded-0" id="name_en" name="name_en" rows="2">{{old('name_en') ?? ''}}</textarea>
              </div>

              <div class="form-group">
                <label for="description_en">Opis ankiety EN</label>
                <textarea class="form-control rounded-0" id="description_en" name="description_en" rows="10">{{old('description_pl') ?? ''}}</textarea>
              </div>

               <div class="form-group">
                <label>Przypisz do firmy:</label>
                <select class="browser-default custom-select" id="company_id" name="company_id">
                  <option value="" >Wybierz firmę.</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{old('company_id') == $company->id ? 'selected' : ''}}>{{ $company->name }}</option>
                @endforeach
                </select>
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

@section('footer-scripts')
  <script src="{{asset('summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('summernote/lang/summernote-pl-PL.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('#description_pl, #description_en').summernote({
        lang: 'pl-PL',
        height: 300,                 
        minHeight: null,             
        maxHeight: null,
        disableDragAndDrop: true,
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
         
        ],
      });
    });
  </script>
@endsection