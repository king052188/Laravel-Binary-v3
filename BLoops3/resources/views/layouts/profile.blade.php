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
    <title>{{ ucwords($users->first_name . ' ' . $users->last_name) }}</title>
    <meta property="og:url"           content="{{ app()->getUrl(true, '/') }}" />
    <meta property="og:type"          content="Website" />
    <meta property="og:title"         content="{{ ucwords($users->first_name . ' ' . $users->last_name) }} | {{ config('app.name', 'Laravel') }}" />
    <meta property="og:description"   content="{{ config('app.description', 'Application Description') }}" />
    <meta property="og:image"         content="{{ app()->getUrl(false, '/images/og_images.png') }}" />
    <!-- Styles -->
    <link rel="apple-touch-icon" href="{{ app()->getUrl(false, 'images/k-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ app()->getUrl(false, 'images/k-icon.png') }}"/>
    <link href="{{ app()->getUrl(false, 'css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ app()->getUrl(false, 'font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <style>
        body {
            font-weight: 400;
            background-color: #f0f3f5;
        }
        /*==============================*/
        /*====== siderbar user profile =====*/
        /*==============================*/
        input#_first_name { text-transform: capitalize; }
        input#_last_name { text-transform: capitalize; }
        .nav>li>a.userdd {
            padding: 5px 15px
        }
        .userprofile {
            width: 100%;
          	float: left;
          	clear: both;
          	margin: 40px auto
        }
        .userprofile .userpic {
        	height: 100px;
        	width: 100px;
        	clear: both;
        	margin: 0 auto;
        	display: block;
        	border-radius: 100%;
        	box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	-moz-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	-webkit-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	-ms-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	position: relative;
        }
        .userprofile .userpic .userpicimg {
        	height: auto;
        	width: 100%;
        	border-radius: 100%;
        }
        .username {
        	font-weight: 600;
        	font-size: 20px;
        	line-height: 20px;
        	margin-top: 20px;
        	white-space: nowrap;
        	overflow: hidden;
        	text-overflow: ellipsis;
          text-transform: capitalize;
        }
        .username+p {
        	color: #607d8b;
        	font-size: 13px;
        	line-height: 15px;
        	white-space: nowrap;
        	text-overflow: ellipsis;
        	overflow: hidden;
        }
        .settingbtn {
        	height: 30px;
        	width: 30px;
        	border-radius: 30px;
        	display: block;
        	position: absolute;
        	bottom: 0px;
        	right: 0px;
        	line-height: 30px;
        	vertical-align: middle;
        	text-align: center;
        	padding: 0;
        	box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
        	-moz-box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
        	-webkit-box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
        	-ms-box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
        }
        .userprofile.small {
        	width: auto;
        	clear: both;
        	margin: 0px auto;
        }
        .userprofile.small .userpic {
        	height: 40px;
        	width: 40px;
        	margin: 0 10px 0 0;
        	display: block;
        	border-radius: 100%;
        	box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	-moz-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	-webkit-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	-ms-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
        	position: relative;
        	float: left;
        }
        .userprofile.small .textcontainer {
        	float: left;
        	max-width: 100px;
        	padding: 0
        }
        .userprofile.small .userpic .userpicimg {
        	min-height: 100%;
        	width: 100%;
        	border-radius: 100%;
        }
        .userprofile.small .username {
        	font-weight: 400;
        	font-size: 16px;
        	line-height: 21px;
        	color: #000000;
        	margin: 0px;
        	float: left;
        	width: 100%;
        }
        .userprofile.small .username+p {
        	color: #607d8b;
        	font-size: 13px;
        	float: left;
        	width: 100%;
        	margin: 0;
        }
        /*==============================*/
        /*====== Social Profile css =====*/
        /*==============================*/
        .countlist h3 {
        	margin: 0;
        	font-weight: 400;
        	line-height: 28px;
        }
        .countlist {
        	text-transform: uppercase
        }
        .countlist li {
        	padding: 15px 30px 15px 0;
        	font-size: 14px;
        	text-align: left;
        }
        .countlist li small {
        	font-size: 12px;
        	margin: 0
        }
        .followbtn {
        	float: right;
        	margin: 22px 0 0 12px;
        }
        .userprofile.social {
        	background: url({{ app()->getUrl(false, 'images/blessed_4k_1920x1200.png') }}) no-repeat top center;
        	background-size: 100%;
        	padding: 50px 0;
        	margin: 0
        }
        .userprofile.social .username {
        	color: #ffffff
        }
        .userprofile.social .username+p {
        	color: #ffffff;
        	opacity: 0.8
        }
        .postbtn {
        	position: absolute;
        	right: 5px;
        	top: 5px;
        	z-index: 9
        }
        .status-upload {
        	width: 100%;
        	float: left;
        	margin-bottom: 15px
        }
        .posttimeline .panel {
        	margin-bottom: 15px
        }
        .commentsblock {
        	background: #f8f9fb;
        }
        .nopaddingbtm {
        	margin-bottom: 0
        }
        /*==============================*/
        /*====== Recently connected  heading =====*/
        /*==============================*/
        .memberblock {
        	width: 100%;
        	float: left;
        	clear: both;
        	margin-bottom: 15px
        }
        .member {
        	width: 24%;
        	float: left;
        	margin: 2px 1% 2px 0;
        	background: #ffffff;
        	border: 1px solid #d8d0c3;
        	padding: 3px;
        	position: relative;
        	overflow: hidden
        }
        .memmbername {
        	position: absolute;
        	bottom: -30px;
        	background: rgba(0, 0, 0, 0.8);
        	color: #ffffff;
        	line-height: 30px;
        	padding: 0 5px;
        	white-space: nowrap;
        	text-overflow: ellipsis;
        	overflow: hidden;
        	width: 100%;
        	font-size: 11px;
        	transition: 0.5s ease all;
        }
        .member:hover .memmbername {
        	bottom: 0
        }
        .member img {
        	width: 100%;
        	transition: 0.5s ease all;
        }
        .member:hover img {
        	opacity: 0.8;
        	transform: scale(1.2)
        }

        .panel-default>.panel-heading {
            color: #607D8B;
            background-color: #ffffff;
            font-weight: 400;
            font-size: 15px;
            border-radius: 0;
            border-color: #e1eaef;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.428571429;
        }

        .page-header.small {
            position: relative;
            line-height: 22px;
            font-weight: 400;
            font-size: 20px;
        }

        .favorite i {
            color: #eb3147;
        }

        .btn i {
            font-size: 17px;
        }

        .panel {
            box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
            -moz-box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
            -webkit-box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
            -ms-box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
            transition: all ease 0.5s;
            -moz-transition: all ease 0.5s;
            -webkit-transition: all ease 0.5s;
            -ms-transition: all ease 0.5s;
            margin-bottom: 35px;
            border-radius: 0px;
            position: relative;
            border: 0;
            display: inline-block;
            width: 100%;
        }

        .panel-footer {
            padding: 10px 15px;
            background-color: #ffffff;
            border-top: 1px solid #eef2f4;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            color: #607d8b;
        }

        .panel-blue {
            color: #ffffff;
            background-color: #03A9F4;
        }

        .panel-red.userlist .username, .panel-green.userlist .username, .panel-yellow.userlist .username, .panel-blue.userlist .username {
            color: #ffffff;
        }

        .panel-red.userlist p, .panel-green.userlist p, .panel-yellow.userlist p, .panel-blue.userlist p {
            color: rgba(255, 255, 255, 0.8);
        }

        .panel-red.userlist p a, .panel-green.userlist p a, .panel-yellow.userlist p a, .panel-blue.userlist p a {
            color: rgba(255, 255, 255, 0.8);
        }

        .progress-bar-success, .status.active, .panel-green, .panel-green > .panel-heading, .btn-success, .fc-event, .badge.green, .event_green {
            color: white;
            background-color: #8BC34A;
        }

        .progress-bar-warning, .panel-yellow, .status.pending, .panel-yellow > .panel-heading, .btn-warning, .fc-unthemed .fc-today, .badge.yellow, .event_yellow {
            color: white;
            background-color: #FFC107;
        }

        .progress-bar-danger, .panel-red, .status.inactive, .panel-red > .panel-heading, .btn-danger, .badge.red, .event_red {
            color: white;
            background-color: #F44336;
        }

        .media-object {
            max-width: 50px;
            border-radius: 50px;
            margin-top: 3px;
            margin-left: 3px;
            -webkit-border-radius: 150px;
            -moz-border-radius: 150px;
            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
        }

        .media:first-child {
            margin-top: 15px;
        }

        .media-object {
            display: block;
        }

        .dotbtn {
            height: 40px;
            width: 40px;
            background: none;
            border: 0;
            line-height: 40px;
            vertical-align: middle;
            padding: 0;
            margin-right: -15px;
        }

        .dots {
            height: 4px;
            width: 4px;
            position: relative;
            display: block;
            background: rgba(0,0,0,0.5);
            border-radius: 2px;
            margin: 0 auto;
        }

        .dots:after, .dots:before {
            content: " ";
            height: 4px;
            width: 4px;
            position: absolute;
            display: inline-block;
            background: rgba(0,0,0,0.5);
            border-radius: 2px;
            top: -7px;
            left: 0;
        }

        .dots:after {
            content: " ";
            top: auto;
            bottom: -7px;
            left: 0;
        }

        .photolist img {
            width: 100%;
        }

        .photolist {
            background: #e1eaef;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .profilegallery .grid-item a {
            height: 100%;
            display: block;
        }

        .grid a {
            width: 100%;
            display: block;
            float: left;
        }

        .media-body {
            color: #607D8B;
            overflow: visible;
            margin-bottom: 20px;
        }

        .media {
            margin-bottom: 10px;
        }

        a:hover, a:focus {
          color: #2a6496;
          text-decoration: underline;
        }
        .btn-group.open .dropdown-toggle {
            -webkit-box-shadow: inset 0 0 0 rgba(0, 0, 0, 0.125);
            box-shadow: inset 0 0 0 rgba(0, 0, 0, 0.125);
        }
        #btnSignIn { display: block; }
        @media screen and (max-width: 699px) {
          #btnSignIn { display: none; }
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.css">
</head>
<body>
<div id="app">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center ">
        <div class="panel panel-default">
          <div class="userprofile social ">
            <div class="userpic"> <img src="{{ app()->getUrl(false, 'images/nobody_m.original.jpg') }}" alt="" class="userpicimg"> </div>
            <h3 class="username">{{ $users->first_name . ' ' . $users->last_name }}</h3>
            <!-- <p>{{ $users->city . ', ' . $users->country }}</p> -->
            <p>Olongapo City, PH</p>
            <div class="socials tex-center"> <a href="#" class="btn btn-circle btn-primary ">
            <i class="fa fa-facebook"></i></a> <a href="#" class="btn btn-circle btn-danger ">
            <i class="fa fa-google-plus"></i></a> <a href="#" class="btn btn-circle btn-info ">
            <i class="fa fa-twitter"></i></a> <a href="#" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a>
            </div>
          </div>
          <div class="col-md-12 border-top border-bottom">
            <ul class="nav nav-pills pull-left countlist" role="tablist">
              <li role="presentation">
                <h3>{{ number_format($follower[0]->follower, 0) }}<br>
                  <small>Follower</small> </h3>
              </li>
              <li role="presentation">
                <h3>{{ number_format($follower[0]->active, 0) }}<br>
                  <small>Active</small> </h3>
              </li>
            </ul>
            @if (Auth::guest())
              <a href="{{ route('login') }}" id="btnSignIn" class="btn btn-default followbtn"> <i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</a>
              @if($users->type <=5)
              <button id="btnJoin" class="btn btn-primary followbtn"> <i class="fa fa-users" aria-hidden="true"></i> Follow and Join</button>
              @endif
            @else
              <a href="/" id="btnSignIn" class="btn btn-default followbtn"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</a>
            @endif
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 pull-right">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="page-header small">Personal</h1>
            <p class="page-subtitle small">Email: {{ $users->email }}</p>
            <p class="page-subtitle small">Phone: {{ $users->mobile }}</p>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="page-header small">Activities</h1>
            <p class="page-subtitle small">Like to work from different business</p>
            <div class="col-ld-12">
              <ul class="list-group">
                <li class="list-group-item"><span class="fa fa-male"></span> Worked with 1000+ people</li>
                <li class="list-group-item"><span class="fa fa-institution"></span> 60+ offices</li>
                <li class="list-group-item"><span class="fa fa-user"></span> 50000+ satify customers</li>
                <li class="list-group-item"><span class="fa fa-clock-o"></span> Work hours many and many still counting</li>
                <li class="list-group-item"><span class="fa fa-heart"></span> Customer satisfaction for servics</li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div id="sign-up-form" class="col-md-8 col-sm-12 pull-left posttimeline" style="display: none;">
        <div class="panel panel-default">
          <div class="btn-group pull-right postbtn">
            <button type="button" class="dotbtn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="dots"></span> </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <li><a href="javascript:void(0)">Hide this</a></li>
              <li><a href="javascript:void(0)">Report</a></li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="media">
              <div class="media-left">
                <a href="javascript:void(0)">
                  <img src="{{ app()->getUrl(false, 'images/nobody_m.original.jpg') }}" class="media-object" style="width:60px">
                </a>
              </div>
              <div class="media-body">
                <div>
                  <h4 class="media-heading" style="margin: 9px 0 0 0; font-weight: 600;">{{ ucwords($users->first_name . ' ' . $users->last_name) }}</h4>
                  <p><small>Please complete the form below.</small></p>
                </div>
              </div>
              <div style="margin: 20px 0 0 0;"></div>
              <div class="col-md-12">
                  <div class="panel panel-default">
                      <div class="panel-heading">Sign Up Form</div>
                      <div class="panel-body">
                          <div class="form-horizontal">
                              <div class="form-group">
                                  <label for="name" class="col-md-4 control-label">First Name</label>
                                  <div class="col-md-6 inputGroupContainer">
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="_first_name" type="text" class="form-control" name="_first_name" placeholder="First Name" required autofocus>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="name" class="col-md-4 control-label">Last Name</label>
                                  <div class="col-md-6 inputGroupContainer">
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="_last_name" type="text" class="form-control" name="_last_name" placeholder="Last Name" required autofocus>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                  <div class="col-md-6 inputGroupContainer">
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input id="_email" type="email" class="form-control" name="_email" placeholder="Email Address" required>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="mobile" class="col-md-4 control-label">Mobile</label>
                                  <div class="col-md-6 inputGroupContainer">
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                        <input id="_mobile" type="text" class="form-control" name="_mobile" placeholder="Mobile Number" required>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button id="btnSignUp" type="submit" class="btn btn-primary"><i aria-hidden="true" class="fa fa-floppy-o"></i> Sign Up</button>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-8 col-sm-12 pull-left posttimeline">
        <div class="panel panel-default">
          <div class="btn-group pull-right postbtn">
            <button type="button" class="dotbtn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="dots"></span> </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <li><a href="javascript:void(0)">Hide this</a></li>
              <li><a href="javascript:void(0)">Report</a></li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="media">
              <div class="media-left">
                <a href="javascript:void(0)">
                  <img src="{{ app()->getUrl(false, 'images/nobody_m.original.jpg') }}" class="media-object" style="width:60px">
                </a>
              </div>
              <div class="media-body">
                <div>
                  <a href="javascript:void(0)">
                    <h4 class="media-heading" style="margin: 9px 0 0 0; font-weight: 600;">Web Administrator</h4>
                    <p><small ><i class="fa fa-clock-o"></i> Yesterday, 2:00 am</small></p>
                  </a>
                </div>
                <div style="margin: 15px 0 0 -60px;">
                  <p>Thank You for trusting us. From <a href="#" title="">@web.administrator</a> </p>
                  <a href="#" title=""><i class="glyphicon glyphicon-thumbs-up"></i> 23k</a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<script src="{{ app()->getUrl(true, 'js/app.js') }}"></script>
<script>
  var IsEncoding = false;
  $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#btnJoin").click(function() {
      $("#sign-up-form").show();
      $('html,body').animate({
        scrollTop: $("#sign-up-form").offset().top},
        'slow');
    });
    $("#btnSignUp").click(function() {
      var suid = "{{ $users->id }}";
      var smuid = "{{ $users->member_uid }}";
      var first_name = $("#_first_name").val();
      var last_name = $("#_last_name").val();
      var email = $("#_email").val();
      var mobile = $("#_mobile").val();
      if(first_name=="") {
        swal(
          'Oops...',
          'Please check the First name.',
          'warning'
        )
        return false;
      }
      if(last_name=="") {
        swal(
          'Oops...',
          'Please check the Last name.',
          'warning'
        )
        return false;
      }
      if(!isValidEmailAddress(email)) {
        swal(
          'Oops...',
          'Please use a valid email address.',
          'warning'
        )
        return false;
      }
      if(mobile=="") {
        swal(
          'Oops...',
          'Please check the Phone#',
          'warning'
        )
        return false;
      }
      var data = {
        suid: suid,
        smuid : smuid,
        first_name: first_name,
        last_name: last_name,
        email: email,
        mobile: mobile
      };
      var url = "/referral/sign-up/"+suid+"/"+smuid;
      if(!IsEncoding) {
        IsEncoding = true;
        ajax_exec(url, data, this);
      }
      else {
        swal(
          'Oops...',
          'Please wait. The system is processing...',
          'warning'
        )
        location.reload();
      }
    });
    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };
  })
  function ajax_exec(url, data, control) {
      $(document).ready(function() {
          $.ajax({
              dataType: 'json',
              type:'POST',
              url: url,
              data: data,
              beforeSend: function () {
                $(control).empty().prepend("Please wait...");
              }
          }).done(function(json){
              if(json.Status == 200) {
                swal({
                  title: 'Hooray!',
                  text: "You have successfully registered. You should received a welcome message with your login info.",
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then(function () {
                  setInterval(function(){ location.reload(); }, 500);
                })
                return false;
              }
              if(json.Status != 200 || json.Status != 500) {
                swal(
                  'Oops...',
                  json.Message,
                  'error'
                )
                $(control).empty().prepend("<i class='fa fa-floppy-o' aria-hidden='true'></i> Encode");
                return false;
              }
              swal(
                'Oops...',
                'Something went wrong! Please inform your UP-Line.',
                'error'
              )
          });
      })
  }
</script>
</body>
</html>
