@extends('layouts.app')
@section('content')
<div class="container" style="width: 80%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body" style="height: 440px;">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    Hello <b>{{ Auth::guest() ? "" : strtoupper(Auth::user()->name) }}</b> You are logged in! <br />
                    <h3>Members Loading Transactions</h3>
                    <table class="tbl_loading" id="tbl_usersTransactions" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                        <tr>
                          <th>Trans#</th>
                          <th>Account</th>
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
    </div>
</div>
@endsection
