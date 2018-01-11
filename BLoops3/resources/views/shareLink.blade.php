<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Create Share Link - {{ config('app.name', 'Wazzel') }}</title>
        <meta property="og:url"           content="{{ app()->getUrl(true, '/') }}" />
        <meta property="og:type"          content="Website" />
        <meta property="og:title"         content="{{ config('app.name', 'Laravel') }}" />
        <meta property="og:description"   content="{{ config('app.description', 'Application Description') }}" />
        <meta property="og:image"         content="{{ app()->getUrl(false, '/images/og_images.png') }}" />
        <!-- Styles -->
        <link rel="apple-touch-icon" href="{{ app()->getUrl(false, 'images/k-icon.png') }}">
    		<link rel="shortcut icon" type="image/png" href="{{ app()->getUrl(false, 'images/k-icon.png') }}"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600,400" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #F5F5F5;
                color: #222222;
                font-family: 'Raleway', sans-serif;
                font-weight: 400;
                height: 100vh;
                margin: 0;
            }

            input {
                font-weight: 400;
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
                color: #fff;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .links > a:hover {
                text-decoration: underline;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @media screen and (max-width: 1300px) {
              .content {
                  text-align: center;
                  width: 100%;
              }
              img { width: 256px; }
            }
        </style>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-5109247563829937",
            enable_page_level_ads: true
          });
        </script>
    </head>
    <body id="body">
      <div id="app">
        <div id="notifyUsers"></div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="form-group">
                  <label for="url">Enter Your Url Link</label>
                  <input type="text" class="form-control" id="url" placeholder="Your link here...">
                </div>
                <div class="form-group">
                  <label for="new-url">Your New Url Link</label>
                  <input type="text" class="form-control" id="new-url" placeholder="Your new link">
                </div>
                <div class="form-group">
                  <label for="new-bitly">Your Bit.ly Link</label>
                  <input type="text" class="form-control" id="new-bitly" placeholder="Your link from bit.ly">
                </div>
                <button type="submit" class="btn btn-default">Create</button>
            </div>
        </div>
      </div>
      <script>
      $(document).ready(function() {
         $("#body").css("background-color", bgColors[i]);
         i = (i + 1) % bgColors.length;
      })
      </script>
    </body>
</html>
