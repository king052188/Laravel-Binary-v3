<!--
// Author:    me@kpa21.info
// Mobile:    09177715380
// Facebook:  https://kpa.ph/18BA96
// Twitter:   https://kpa.ph/6DEB8A
-->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Wazzel') }} (Administrator)</title>
    <meta property="og:url"           content="{{ app()->getUrl(true, '/') }}" />
    <meta property="og:type"          content="Website" />
    <meta property="og:title"         content="{{ config('app.name', 'Laravel') }}" />
    <meta property="og:description"   content="{{ config('app.description', 'Application Description') }}" />
    <meta property="og:image"         content="{{ app()->getUrl(false, '/images/og_images.png') }}" />
    <!-- Styles -->
    <link rel="apple-touch-icon" href="{{ app()->getUrl(false, 'images/k-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ app()->getUrl(false, 'images/k-icon.png') }}"/>
    <link href="{{ app()->getUrl(false, 'css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ app()->getUrl(false, 'font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ app()->getUrl(false, 'css/bootcomplete.css') }}">
    <style>
      table.tbl_loading { width: 100%; margin-top: 10px; }
      table.tbl_loading thead tr th { padding: 5px; }
      table.tbl_loading thead tr th, tbody tr td { text-align: center; }
      table.tbl_loading thead tr th { background-color: #3E3E3E; color: #fff; border: 1px solid #E1E1E1; }
      table.tbl_loading tbody tr td { border: 1px solid #E1E1E1; }

      table.tbl_history { width: 100%; margin-top: 10px; }
      table.tbl_history thead tr th { padding: 5px; }
      table.tbl_history thead tr th, tbody tr td { text-align: center; font-size: 1em; }
      table.tbl_history thead tr th { background-color: #eaedf1; color: #3E3E3E; border: 1px solid #E1E1E1; }
      table.tbl_history tbody tr td { border: 1px solid #E1E1E1; }
      .ddlBtnMenu { top: 194px; margin-right: 32px; }
      .ddlBtnMenuAffliate { margin-right: 77px; }

      a.title_link { color: #3097D1; text-decoration: none; font-size: .99em; }
      a.title_link:hover { color: #6d8a0a; text-decoration: none; border-bottom: 1px solid; padding-bottom: -2px; }

      input#_username { text-transform: lowercase; }
      input#_first_name { text-transform: capitalize; }
      input#_last_name { text-transform: capitalize; }
      a.g_link { color: #000000; text-decoration: none; font-family: "Raleway", sans-serif; text-transform: lowercase; }
      a.g_link:hover { color: #6d8a0a; text-decoration: none; }
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
      p.g_title { margin: 10px 0 0 0; padding: 0; text-align: center; font-weight: 600;  }
      .container { width: 80%; }
      #nav_container { width: 55%; }

      .kpa_notification { background-color: #fff; color: #921794; padding: 5px; border-radius: 25px; font-weight: 600; }

      @media screen and (max-width: 1500px) {
        #g_structure_container { overflow: scroll; max-height: 480px;  }
        #nav_container { width: 100%; }
        .container { width: 100%; }
      }

    </style>
    @yield('style')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/1.5.6/numeral.min.js"></script>
    <script src="{{ app()->getUrl(false, 'js/helper.js') }}"></script>
    <script src="{{ app()->getUrl(true, 'js/app.js') }}"></script>
    <script src="{{ app()->getUrl(true, 'js/jquery.bootcomplete.js') }}"></script>
    <script src="{{ app()->getUrl(true, 'js/jquery.dev.js') }}"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-5109247563829937",
        enable_page_level_ads: true
      });
    </script>
    @yield('script-top')
</head>
<body>
    <div id="app">
    </div>
    <div>
        <div id="notifyUsers"></div>
        <!-- @if( IsSet($top_notifier['Type']) )
          <div class="alert alert-{{ $top_notifier['Type'] }}" role="alert" style="text-align: center; margin-bottom: 0;">
            {!! $top_notifier['Message'] !!}
          </div>
        @endif -->
        <nav class="navbar navbar-default navbar-static-top" >
            <div id="nav_container" class="container">
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
                            <li><a href="{{ app()->getUrl(true, '/') }}">Home</a></li>
                            <!-- <li><a href="{{ app()->getUrl(true, '/login') }}">Login</a></li> -->
                            <!-- <li><a href="{{ app()->getUrl(true, '/register') }}">Register</a></li> -->
                        @else
                            <li><a href="{{ app()->getUrl(true, '/') }}">Home</a></li>

                            @if(Auth::user()->type >= 20)
                              <li><a href="{{ app()->getUrl(true, '/members') }}">Members</a></li>
                              <li><a href="{{ app()->getUrl(true, '/loadcharge') }}">Load Charge</a></li>
                              @if(Auth::user()->type == 20 || Auth::user()->type == 22)
                              <li><a href="{{ app()->getUrl(true, '/finance') }}">Finance <span id="finance_noti" class="kpa_notification">1</span></a></li>
                              @endif
                            @else
                            <!-- <li><a href="{{ app()->getUrl(true, '/') }}">Services</a></li> -->
                            <li><a href="{{ app()->getUrl(true, '/genealogy') }}">Genealogy</a></li>
                            <li><a href="{{ app()->getUrl(true, '/leveling') }}">Leveling</a></li>
                            @endif

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="text-transform: capitalize;">
                                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ app()->getUrl(true, '/' . Auth::user()->username) }}">Profile</a></li>
                                    <li><a href="{{ app()->getUrl(true, '/reset-password') }}">Reset Password</a></li>
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

    @yield('script')
</body>
</html>
