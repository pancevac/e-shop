<header class="header_area">
  <div class="top_menu row m0">
    <div class="container-fluid">
      <div class="float-left">
        <p>Call Us: 012 44 5698 7456 896</p>
      </div>
      <div class="float-right">
        <ul class="right_side">
          <li>
            <a href="login.html">
              Login/Register
            </a>
          </li>
          <li>
            <a href="#">
              My Account
            </a>
          </li>
          <li>
            <a href="contact.html">
              Contact Us
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="main_menu">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand logo_h" href="index.html">
          <img src="img/logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
          <div class="row w-100">
            <div class="col-lg-7 pr-0">
              <ul class="nav navbar-nav center_nav pull-right">

                @if(!empty($mainMenu))
                  @foreach($mainMenu as $link)

                    @if($link->children->count())

                      <li class="nav-item submenu dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $link->title }}</a>
                        <ul class="dropdown-menu">
                          @foreach($link->children as $child)

                            <li class="nav-item {{ request()->is($child->link) ? 'active' : '' }}">
                              <a class="nav-link" href="{{ url($child->link) }}">{{ $child->title }}</a>
                            </li>

                          @endforeach
                        </ul>
                      </li>

                    @else
                      <li class="nav-item {{ request()->is($link->link) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url($link->link) }}">{{ $link->title }}</a>
                      </li>
                    @endif

                  @endforeach
                @endif

              </ul>
            </div>

            <div class="col-lg-5">
              <ul class="nav navbar-nav navbar-right right_nav pull-right">
                <hr>
                <li class="nav-item">
                  <a href="#" class="icons">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </a>
                </li>

                <hr>

                <li class="nav-item">
                  <a href="#" class="icons">
                    <i class="fa fa-user" aria-hidden="true"></i>
                  </a>
                </li>

                <hr>

                <li class="nav-item">
                  <a href="#" class="icons">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                  </a>
                </li>

                <hr>

                <li class="nav-item">
                  <a href="#" class="icons">
                    <i class="lnr lnr lnr-cart"></i>
                  </a>
                </li>

                <hr>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>