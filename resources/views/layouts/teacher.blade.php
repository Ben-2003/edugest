<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Espace Enseignant') - EduGest</title>
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('dist/assets/images/favicon.png') }}" />
    @yield('styles')
  </head>
  <body>
    <div class="container-scroller">

      <!-- NAVBAR -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="{{ route('teacher.dashboard') }}">
            <span style="color:white;font-size:18px;font-weight:700;">EduGest</span>
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('teacher.dashboard') }}">
            <span style="color:white;font-size:16px;font-weight:700;">EG</span>
          </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <div style="width:36px;height:36px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:14px;">
                    {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->email, 0, 1)) }}
                  </div>
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{ auth()->user()->first_name ?? auth()->user()->email }}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Deconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                  @csrf
                </form>
              </div>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-power"></i>
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>

      <div class="container-fluid page-body-wrapper">

        <!-- SIDEBAR -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <div style="width:44px;height:44px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:18px;">
                    {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->email, 0, 1)) }}
                  </div>
                  <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{ auth()->user()->first_name ?? auth()->user()->email }}</span>
                  <span class="text-secondary text-small">Enseignant</span>
                </div>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('teacher.dashboard') }}">
                <span class="menu-title">Tableau de bord</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('teacher.grades.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('teacher.grades.index') }}">
                <span class="menu-title">Notes</span>
                <i class="mdi mdi-star menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('teacher.attendances.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('teacher.attendances.index') }}">
                <span class="menu-title">Absences</span>
                <i class="mdi mdi-calendar-remove menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('teacher.schedules') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('teacher.schedules') }}">
                <span class="menu-title">Emploi du temps</span>
                <i class="mdi mdi-clock-outline menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- END SIDEBAR -->

        <!-- MAIN PANEL -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-success text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span>
                @yield('page-title', 'Tableau de bord')
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span>@yield('breadcrumb', 'Accueil')</span>
                  </li>
                </ul>
              </nav>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
              <i class="mdi mdi-check-circle"></i> {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
              <i class="mdi mdi-alert-circle"></i> {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
              <i class="mdi mdi-alert-circle"></i> {{ $errors->first() }}
              <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif

            @yield('content')

          </div>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                EduGest &copy; {{ date('Y') }}
              </span>
            </div>
          </footer>
        </div>
        <!-- END MAIN PANEL -->

      </div>
    </div>

    <script src="{{ asset('dist/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('dist/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('dist/assets/js/misc.js') }}"></script>
    @yield('scripts')
  </body>
</html>