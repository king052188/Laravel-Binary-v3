@extends('layouts.app')
@section('content')
<div class="container" style="width: 80%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Administrator
                  <a href="#" id="btnShowCorpoAccount" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a>
                </div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="margin: 10px 0 0 0;">
                     <span style="font-size: 1.6em;">Summary</span>
                     <span style="font-size: 1em;">wallet</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                    </div>
                    <table class="tbl_history" id="tblMembers" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                          <tr>
                            <th style="width: 200px;">Account</th>
                            <th style="width: 100px;">Username</th>
                            <th>Fullname</th>
                            <th style="width: 100px;">Mobile</th>
                            <th style="width: 100px;">Joined</th>
                          </tr>
                      </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script>
$(document).ready(function() {
  $('#tblMembers').DataTable( {
      "ajax": '/members/data.json'
  } );

} );
</script>
@endsection
