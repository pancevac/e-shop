<header class="default-header" style="z-index: 999">
  <nav class="navbar navbar-expand-lg  navbar-light">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('img/logo.png') }}" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="lnr lnr-menu"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
        <ul class="navbar-nav">

          @foreach($mainMenu as $menu)

            @if ($menu->children->count())

              <li class="dropdown">
                <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                  {{ $menu->title }}
                </a>
                <div class="dropdown-menu">

                  @foreach($menu->children as $children)
                    <a class="dropdown-item" href="{{ url($children->link) }}">{{ $children->title }}</a>
                  @endforeach

                </div>
              </li>

            @else
              <li><a href="{{ url($menu->link) }}">{{ $menu->title }}</a></li>
            @endif

          @endforeach

          {{-- Login --}}
            @guest
              <li><a href="{{ route('login') }}">Prijava</a></li>
            @else
              <li class="dropdown">
                <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">{{ auth()->user()->name }}</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('profile') }}">Moj profil</a>
                  <a class="dropdown-item" href="{{ route('logout') }}">Odjavite se</a>
                </div>
              </li>
            @endguest

        </ul>
      </div>
    </div>
  </nav>
</header>