<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Wazzel') }}</title>
    <meta property="og:url"           content="{{ app()->getUrl(true, '/') }}" />
    <meta property="og:type"          content="Website Application" />
    <meta property="og:title"         content="{{ config('app.name', 'Laravel') }}" />
    <meta property="og:description"   content="{{ config('app.description', 'Application Description') }}" />
    <meta property="og:image"         content="{{ app()->getUrl(false, 'images/k-icon.png') }}" />
    <!-- Styles -->
    <link rel="apple-touch-icon" href="{{ app()->getUrl(false, 'images/k-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ app()->getUrl(false, 'images/k-icon.png') }}"/>
    <link href="{{ app()->getUrl(false, 'css/app.css') }}" rel="stylesheet">
    <style>
      table { width: 100%; margin-top: 10px; }
      table thead tr th { padding: 5px; }
      table thead tr th, tbody tr td { text-align: center; }
      table thead tr th { background-color: #3E3E3E; color: #fff; border: 1px solid #E1E1E1; }
      table tbody tr td { border: 1px solid #E1E1E1; }

      
    </style>
</head>
<body>
    <div id="app">
        <div id="notifyUsers"></div>
        @if( IsSet($top_notifier['Type']) )
          <div class="alert alert-{{ $top_notifier['Type'] }}" role="alert" style="text-align: center; margin-bottom: 0;">
            {!! $top_notifier['Message'] !!}
          </div>
        @endif
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ app()->getUrl(true, '/login') }}">Login</a></li>
                            <li><a href="{{ app()->getUrl(true, '/register') }}">Register</a></li>
                        @else
                            <li><a href="{{ app()->getUrl(true, '/dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ app()->getUrl(true, '/dashboard') }}">Services</a></li>
                            <li><a href="{{ app()->getUrl(true, '/dashboard') }}">Genealogy</a></li>
                            <li><a href="{{ app()->getUrl(true, '/dashboard') }}">Message</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ app()->getUrl(true, '/dashboard') }}">Profile</a></li>
                                    <li><a href="{{ app()->getUrl(true, '/dashboard') }}">Settings</a></li>
                                    <li>
                                        <a href="{{ app()->getUrl(true, '/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ app()->getUrl(true, '/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ app()->getUrl(true, 'js/app.js')  }}"></script>
</body>
</html>
