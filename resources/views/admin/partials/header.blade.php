    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img src="{{asset('img/logo.png')}}" alt="" style="width: auto !important; height: auto !important; max-width: 35%;">
        <img class="navbar-brand-minimized" src="{{ asset('img/favicon.png')}} }}" width="30" height="30" alt=" ">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img class="img-avatar" src="{{asset('img/logo.png')}}" alt="">
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ URL('logout') }}">
              <i class="fa fa-sign-out"></i> Logout</a>
          </div>
        </li>
      </ul>

    </header>
