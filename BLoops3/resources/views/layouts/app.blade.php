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
    <link rel="stylesheet" href="{{ app()->getUrl(false, 'font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <style>
      table.tbl_loading { width: 100%; margin-top: 10px; }
      table.tbl_loading thead tr th { padding: 5px; }
      table.tbl_loading thead tr th, tbody tr td { text-align: center; }
      table.tbl_loading thead tr th { background-color: #3E3E3E; color: #fff; border: 1px solid #E1E1E1; }
      table.tbl_loading tbody tr td { border: 1px solid #E1E1E1; }

      a.g_link { color: #000000; text-decoration: none; font-family: "Raleway", sans-serif; }
      a.g_link:hover { color: #b8074c; text-decoration: none; }
      img.g_image {
         width: 60px;
         height: 60px;
         border-radius: 150px;
         background-color: #fff;
         -webkit-border-radius: 150px;
         -moz-border-radius: 150px;
         box-shadow: 0 0 8px rgba(0, 0, 0, .8);
         -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
         -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);

      }
      p.g_title { margin: 0; padding: 0; text-align: center; font-weight: 600; }
    </style>
</head>
<body>
    <div id="app">
        <div id="notifyUsers"></div>
        <!-- @if( IsSet($top_notifier['Type']) )
          <div class="alert alert-{{ $top_notifier['Type'] }}" role="alert" style="text-align: center; margin-bottom: 0;">
            {!! $top_notifier['Message'] !!}
          </div>
        @endif -->
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
                            <li><a href="{{ app()->getUrl(true, '/') }}">Home</a></li>
                            <li><a href="{{ app()->getUrl(true, '/') }}">Services</a></li>
                            <li><a href="{{ app()->getUrl(true, '/genealogy') }}">Genealogy</a></li>
                            <li><a href="{{ app()->getUrl(true, '/leveling') }}">Leveling</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ app()->getUrl(true, '/') }}">Profile</a></li>
                                    <li><a href="{{ app()->getUrl(true, '/') }}">Settings</a></li>
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
    <script>
      var _a, _b;
      function _event(x) {

        _a = $(x).data("a");
        _b = parseInt($(x).data("b"));

        console.log(_a);
        console.log(_b);
        if(_b == 0) {
          alert("Oops, Something went wrong...");
          return false;
        }

        if(_b == 21) {
          $("#_placement_left").attr('checked', true);
          $("#_placement_right").attr('checked', false);
        }
        else {
          $("#_placement_left").attr('checked', false);
          $("#_placement_right").attr('checked', true);
        }


        $('#modal-encoding').modal({
            show: true
        });

      }

      setInterval(function(){ $("#encoding-form").show(3500); }, 2000);
    </script>
</body>
</html>
