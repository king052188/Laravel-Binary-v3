@extends('layouts.app')
@section('content')
<div class="container" style="width: 80%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body" style="height: 440px;">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    Hello <b style="text-transform: capitalize;">{{ Auth::guest() ? "" : Auth::user()->first_name . " " . Auth::user()->last_name }}</b>, this is your temporary profile page.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
