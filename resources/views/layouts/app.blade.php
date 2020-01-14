<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/mdb.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  @yield('header')

</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('img/wncl.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          @guest
            <span class="navbar-text white-text">
                {{ config('app.name') }}
            </span>     
          @else
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-cogs fa-lg"></i> Pulpit</a>
              </li> 

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarSurveys" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Ankiety</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarSurveys">
                  <a class="dropdown-item" href="{{ route('admin.index') }}">Pulpit <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.survey.create') }}">Dodaj ankietę <i class="fas fa-plus-circle"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.company.index') }}">Firmy <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.company.create') }}">Dodaj firmę <i class="fas fa-plus-circle"></i></a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarQuestions" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Pytania</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarQuestions">
                  <a class="dropdown-item" href="{{ route('admin.questions.index') }}">Zobacz <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.questions.create') }}">Dodaj <i class="fas fa-plus-circle"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.category.index') }}">Kategorie pytań <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.questions.options.index') }}">Opcje pytań <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.scale.index') }}">Skale odpowiedzi <i class="far fa-eye"></i></a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarPeople" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Dane osób</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarPeople">
                  <a class="dropdown-item" href="{{ route('admin.post.index') }}">Stanowiska <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.department.index') }}">Działy <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.industry.index') }}">Branże <i class="far fa-eye"></i></a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarPeople" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Ankietowani</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarPeople">
                  <a class="dropdown-item" href="{{ route('admin.people.index') }}">Zobacz <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.people.emails') }}">Lista maili <i class="far fa-envelope"></i></a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarUsers" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Użytkownicy</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarUsers">
                  <a class="dropdown-item" href="{{ route('admin.user.index') }}">Zobacz <i class="far fa-eye"></i></a>
                  <a class="dropdown-item" href="{{ route('admin.user.create') }}">Dodaj <i class="fas fa-plus-circle"></i></a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarResults" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Wyniki</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarResults">
                   <a class="dropdown-item" href="{{ route('admin.result') }}"><i class="fas fa-poll fa-lg"></i> Wszystkie</a>
                   <div class="dropdown-divider"></div>
                   <a class="dropdown-item" href="{{ route('admin.compare.select') }}"><i class="fas fa-poll fa-lg"></i> Porównanie firmy</a>
                   <a class="dropdown-item" href="{{ route('admin.resultbydepartment.select.survey') }}"><i class="fas fa-poll fa-lg"></i> Działy firmy</a>
                   <a class="dropdown-item" href="{{ route('admin.hrbp.select') }}"><i class="fas fa-poll fa-lg"></i> Firma: HRBP vs Business</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.export.all') }}"><i class="fas fa-file-excel fa-lg"></i> Exportuj Wszystkie</a>
                    <a class="dropdown-item" href="{{ route('admin.export.survey.select') }}"><i class="fas fa-file-excel fa-lg"></i> Exportuj Ankietę</a>
                   
                </div>
              </li> 

            </ul>
                       
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
           
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Wyloguj
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
          
        </ul>
        @endif
      </div>
    </div>
  </nav>

  <main class="py-4">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="page-footer font-small mt-5">

    <div class="container text-center text-center">
      <div class="row">
        <div class="col-md-12 py-5">
          <a class="footer-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/wncl.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
          </a>
        </div>
      </div>
    </div>

    <div class="footer-copyright bg-dark text-white text-center py-3">
      {{ config('app.name') }} © 2019 by <a href="https://mediaeffectivegroup.pl">MEG</a>
    </div>
    
  </footer>
</div>

<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>

@yield('footer-scripts')

</body>
</html>
