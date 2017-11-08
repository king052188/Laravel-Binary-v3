<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #464646;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;

            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width: 50%;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            table { width: 100%; margin-top: 10px; }
            table thead tr th { padding: 5px; }
            table thead tr th, tbody tr td { text-align: center; }
            table thead tr th { background-color: #3E3E3E; color: #fff; border: 1px solid #E1E1E1; }
            table tbody tr td { border: 1px solid #E1E1E1; font-weight: 600; }
        </style>
    </head>
    <body>
      <div id="app">
        <div id="notifyUsers"></div>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ app()->getUrl(true, '/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ app()->getUrl(true, '/login') }}">Login</a>
                        <a href="{{ app()->getUrl(true, '/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{ config('app.name', 'Wazzel') }}
                </div>
                <h3>Loading Real-Time Transactions</h3>
                <table id="tbl_usersTransactions" border="0" cellSpacing="0" cellPadding="5">
                  <thead>
                    <tr>
                      <th>Trans#</th>
                      <th>Requester</th>
                      <th>Descriptions</th>
                      <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
        </div>
      </div>
      <script src="{{ app()->getUrl(false, '/js/app.js') }}"></script>
    </body>
</html>
