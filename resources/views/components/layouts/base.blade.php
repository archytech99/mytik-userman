<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon" />

    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet">
    @isset($styles)
        {{-- New Styles per Page/Content --}}
        {{ $styles }}
    @endisset

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
@isset($page_container)
    {{-- New Styles per Page/Content --}}
    {{ $page_container }}
@else
    <div id="wrapper">
        <div class="topbar">
            <div class="topbar-left">
                <a href="{{ route('index') }}" class="logo">
                    <img src="{{ asset('assets/images/logo-light.png') }}" class="logo-lg" alt="" height="22">
                    <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="" height="24">
                </a>
            </div>

            <nav class="navbar-custom">
                <ul class="navbar-right list-inline float-right mb-0">
                    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                        <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                            <i class="fas fa-expand noti-icon"></i>
                        </a>
                    </li>
                    <li class="dropdown notification-list list-inline-item">
                        <div class="dropdown notification-list nav-pro-img">
                            <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('assets/images/user.png') }}" alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock screen</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault();$('#logout-form').submit();">
                                    <i class="mdi mdi-power text-danger"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf

                                    <input type="hidden" name="username" value="{{ Auth::user()->username }}">
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <x-sidebar />

        <div class="content-page">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ session('success') }}
            </div>

        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ session('error') }}
            </div>

        @endif

            {{ $slot }}

            <x-footer />

        </div>
    </div>
@endisset

    {{-- jQuery --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/waves.min.js') }}"></script>

    {{-- Vendor --}}
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-blockui/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweet-alert2/sweetalert2.min.js') }}"></script>
    @isset($scripts)
        {{-- New Scripts per Page/Content --}}
        {{ $scripts }}
    @endisset

    {{-- App JS --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
