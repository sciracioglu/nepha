<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <title>
            NEPHA
        </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="description" content="Page Title">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="msapplication-tap-highlight" content="no">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/vendors.bundle.css') }}">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/app.bundle.css') }}">
        <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
        <link id="myskin" rel="stylesheet" media="screen, print" href="{{ asset('css/skins/skin-master.css') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
        <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    </head>
    <body class="mod-bg-1 ">
        <div class="page-wrapper">
            <div class="page-inner">
                <aside class="page-sidebar">
                    <div class="page-logo">
                        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                            <img src="{{ asset('img/nepha.png') }}" alt="NEPHA" aria-roledescription="logo" style="width: 220px; height: auto;">
                        </a>
                    </div>
                    <!-- BEGIN PRIMARY NAVIGATION -->
                    @if(Auth::user())
                    <nav id="js-primary-nav" class="primary-nav" role="navigation">
                        <div class="nav-filter">
                            <div class="position-relative">
                                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                                    <i class="fal fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-card-text text-center">
                                <a href="#" class="d-flex align-items-center text-white">

                                </a>
                            </div>
                            <img src="{{ asset('img/card-backgrounds/cover-2-lg.png') }}" class="cover" alt="cover">

                        </div>
                        <ul id="js-nav-menu" class="nav-menu">
                            <li class="{{ Request::is('/') ? 'active' : '' }}">
                                <a href="/" title="Dashboard">
                                    <i class="fal fa-analytics"></i>
                                    <span class="nav-link-text" data-i18n="nav.blankpage">Dashboard</span>
                                </a>
                            </li>
                            @if(Auth::user()->role === 2)
                            <li class="{{ Request::is('sale') ? 'active' : '' }}" >
                                <a href="/sale" title="Satış">
                                    <i class="fal fa-handshake"></i>
                                    <span class="nav-link-text" data-i18n="nav.blankpage">Satış</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('medicine') ? 'active' : '' }}">
                                <a href="/medicine" title="Satış">
                                    <i class="fal fa-flask"></i>
                                    <span class="nav-link-text" data-i18n="nav.blankpage">Ürünler</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('user') ? 'active' : '' }}">
                                <a href="/user" title="Kullanıcılar">
                                    <i class="fal fa-users"></i>
                                    <span class="nav-link-text" data-i18n="nav.blankpage">Kullanıcılar</span>
                                </a>
                            </li>
                            @endif
                            <li class="{{ Request::is('user') ? 'active' : '' }}">
                                <a href="/reports" title="Raporlar">
                                    <i class="fal fa-file-chart-line"></i>
                                    <span class="nav-link-text" data-i18n="nav.blankpage">Raporlar</span>
                                </a>
                            </li>
                        </ul>
                        <div class="filter-message js-filter-message bg-success-600"></div>
                    </nav>
                    @endif
                </aside>
                <div class="page-content-wrapper">
                    <header class="page-header" role="banner">
                        <div class="page-logo">
                            <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                                <img src="img/logo.png" alt="NEPHA" aria-roledescription="logo">
                                <span class="page-logo-text mr-1">NEPHA</span>
                                <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                            </a>
                        </div>
                        <div class="hidden-md-down dropdown-icon-menu position-relative">
                            <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
                                <i class="ni ni-menu"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                                        <i class="ni ni-minify-nav"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                                        <i class="ni ni-lock-nav"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="hidden-lg-up">
                            <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                                <i class="ni ni-menu"></i>
                            </a>
                        </div>
                        <div class="ml-auto d-flex">

                                @guest
                                    @if (Route::has('login'))
                                        <div>
                                            <a class="header-icon" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </div>
                                    @endif
                                    @if (Route::has('register'))
                                        <div>
                                            <a class="header-icon" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </div>
                                    @endif
                                @else
                                <div>
                                    <a href="#" data-toggle="dropdown" title="{{ Auth::user()->email }}" class="header-icon d-flex align-items-center justify-content-center ml-2">
                                        <!-- <img src="img/demo/avatars/avatar-admin.png" class="profile-image rounded-circle" alt="Serkan Çıracıoğlu"> -->
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                                        <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                            <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                                <!-- <span class="mr-2">
                                                    <img src="img/demo/avatars/avatar-admin.png" class="rounded-circle profile-image" alt="Serkan Çıracıoğlu">
                                                </span> -->
                                                <div class="info-card-text">
                                                    <div class="fs-lg text-truncate text-truncate-lg">{{ Auth::user()->name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item fw-500 pt-3 pb-3" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                            <span class="float-right fw-n"></span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                                @endguest

                        </div>
                    </header>
                    <main id="app" role="main" class="page-content">
                        <div class="subheader">
                            <h1 class="subheader-title">
                                @yield('title')
                                <span class='fw-300'>@yield('sub_title')</span>
                            </h1>
                        </div>
                       @yield('content')
                    </main>
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
                    <footer class="page-footer" role="contentinfo">
                        <div class="d-flex align-items-center flex-1 text-muted">
                            <span class="hidden-md-down fw-700">{{ date('Y') }} © NEPHA</span>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <script src="js/vendors.bundle.js"></script>
        @yield('script')
    </body>
</html>