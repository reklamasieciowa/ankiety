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
        height: 400,                 
        minHeight: null,             
        maxHeight: null,
        disableDragAndDrop: true,
        colors: [
            ['#00c3ff', '#000000', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#F7F7F7', '#FFFFFF'],
            ['#FF0000', '#FF9C00', '#FFFF00', '#00FF00', '#00FFFF', '#0000FF', '#9C00FF', '#FF00FF'],
            ['#F7C6CE', '#FFE7CE', '#FFEFC6', '#D6EFD6', '#CEDEE7', '#CEE7F7', '#D6D6E7', '#E7D6DE'],
            ['#E79C9C', '#FFC69C', '#FFE79C', '#B5D6A5', '#A5C6CE', '#9CC6EF', '#B5A5D6', '#D6A5BD'],
            ['#E76363', '#F7AD6B', '#FFD663', '#94BD7B', '#73A5AD', '#6BADDE', '#8C7BC6', '#C67BA5'],
            ['#CE0000', '#E79439', '#EFC631', '#6BA54A', '#4A7B8C', '#3984C6', '#634AA5', '#A54A7B'],
            ['#9C0000', '#B56308', '#BD9400', '#397B21', '#104A5A', '#085294', '#311873', '#731842'],
            ['#630000', '#7B3900', '#846300', '#295218', '#083139', '#003163', '#21104A', '#4A1031']
        ],
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['forecolor']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['picture', 'hr']],
          ['misc', ['codeview']],
        ],
      });
    });
  </script>
@endsection