<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') - EduGest</title>
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('dist/assets/images/favicon.png') }}" />
    @yield('styles')
  </head>
  <body>
    <div class="container-scroller">

      <!-- NAVBAR -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="background: linear-gradient(135deg, #74b9ff, #a29bfe);">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start" style="background: linear-gradient(135deg, #89f7fe, #66a6ff);">
          <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}">
            <span style="color:blue;font-size:18px;font-weight:700;">EduGest</span>
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
            <span style="color:blue;font-size:16px;font-weight:700;">EG</span>
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
                  <div style="width:36px;height:36px;border-radius:50%;background:#e74c3c;display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:14px;">
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
        <nav class="sidebar sidebar-offcanvas" id="sidebar" style="background: linear-gradient(135deg, #8e2de2, #c2a8ff); color: white;box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
          <ul class="nav">
            <li class="nav-item nav-profile">

            </li>
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-title">Tableau de bord</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.students.index') }}">
                <span class="menu-title">Eleves</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.teachers.index') }}">
                <span class="menu-title">Enseignants</span>
                <i class="mdi mdi-account-tie menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.parents.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.parents.index') }}">
                <span class="menu-title">Parents</span>
                <i class="mdi mdi-account-heart menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.classes.index') }}">
                <span class="menu-title">Classes</span>
                <i class="mdi mdi-domain menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.subjects.index') }}">
                <span class="menu-title">Matieres</span>
                <i class="mdi mdi-book-open-variant menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.enrollments.index') }}">
                <span class="menu-title">Inscriptions</span>
                <i class="mdi mdi-card-account-details menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.grades.index') }}">
                <span class="menu-title">Notes</span>
                <i class="mdi mdi-star menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.attendances.index') }}">
                <span class="menu-title">Absences</span>
                <i class="mdi mdi-calendar-remove menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.report_cards.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.report_cards.index') }}">
                <span class="menu-title">Bulletins</span>
                <i class="mdi mdi-file-document menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.schedules.index') }}">
                <span class="menu-title">Emploi du temps</span>
                <i class="mdi mdi-clock-outline menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admin.payments.index') }}">
                <span class="menu-title">Paiements</span>
                <i class="mdi mdi-cash menu-icon"></i>
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
                <span class="page-title-icon bg-gradient-primary text-white me-2">
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

            @hasSection('topbar-actions')
            <div class="row mb-3">
              <div class="col-md-12 text-right">
                @yield('topbar-actions')
              </div>
            </div>
            @endif

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