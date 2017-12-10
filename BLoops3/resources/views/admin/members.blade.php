@extends('layouts.app')
@section('content')
<div class="container">
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
                     <span style="font-size: 1.6em;">Members</span>
                     <span style="font-size: 1em;">list</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                    </div>
                    <table id="tblMembers" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                          <tr>
                            <th scope="col" style="width: 170px;">Account</th>
                            <th scope="col" style="width: 190px;">Username</th>
                            <th scope="col">Fullname</th>
                            <th scope="col" style="width: 110px;">Mobile</th>
                            <th scope="col" style="width: 100px;">Joined</th>
                            <th scope="col" style="width: 50px;">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($members as $member)
                            <tr>
                              <td scope="row" data-label="Account">{{ $member->member_uid }}</td>
                              <td data-label="Username">{{ $member->username }}</td>
                              <td data-label="Fullname"><span id="fullname">{{ $member->first_name . " " . $member->last_name }}</span></td>
                              <td data-label="Mobile">{{ $member->mobile }}</td>
                              <td data-label="Joined">{{ $member->created_at->toDateString() }}</td>
                              <td data-label="Action"><button id="btn_{{ $member->id }}"><i class='fa fa-tasks' aria-hidden='true'></i></button></td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('style')
<style>
  table {
    border: 1px solid #E1E1E1;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
    margin-top: 10px;
  }
  table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
  }
  table tr {
    border: 1px solid #ddd;
  }
  table tr th {
    background: #eaedf1;
    border: 1px solid #ddd;
    color: #3E3E3E;
  }
  table th,
  table td {
    padding: 5px;
    text-align: left;
    font-size: 1em;
    border: 1px solid #ddd;
  }
  table td span#fullname {
    text-transform: capitalize;
  }
  table.tbl_history thead tr th, tbody tr td { text-align: left; font-size: 1em; }
  table td {
    font-weight: 600;
  }
  table td:last-child {
    text-align: center;
  }
  @media screen and (max-width: 1200px) {
    table {
      border: 0;
    }
    table caption {
      font-size: 1.3em;
    }
    table thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    table tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    table td {
      border: none;
      border-bottom: 1px solid #ddd;
      display: block;
      text-align: right;
    }
    table.tbl_history thead tr th, tbody tr td { text-align: right; font-size: 1em; }
    table td:before {
      /*
      * aria-label has no advantage, it won't be read inside a table
      content: attr(aria-label);
      */
      content: attr(data-label);
      float: left;
      font-weight: 400;
    }
    table td:last-child {
      border-bottom: 0;
      text-align: right;
    }
    table td span#fullname {
      text-transform: capitalize;
    }
  }
</style>
@endsection
@section('script')
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script> -->
<script>
// $(document).ready(function() {
//   $('#tblMembers').DataTable( {
//       "ajax": '/members/data.json'
//   } );
//
// } );

// var editor; // use a global for the submit and return data rendering in the examples
//
// $(document).ready(function() {
//     editor = new $.fn.dataTable.Editor( {
//         ajax: "/members/data.json",
//         table: "#tblMembers",
//         fields: [ {
//                 label: "First name:",
//                 name: "first_name"
//             }, {
//                 label: "Last name:",
//                 name: "last_name"
//             }, {
//                 label: "Mobile:",
//                 name: "mobile"
//             }, {
//                 label: "Code:",
//                 name: "code_used"
//             }
//         ]
//     } );
//
//     var table = $('#tblMembers').DataTable( {
//         dom: "Bfrtip",
//         ajax: "/members/data.json",
//         columns: [
//             { data: null, render: function ( data, type, row ) {
//                 // Combine the first and last names into a single table field
//                 return data.first_name+' '+data.last_name;
//             } },
//             { data: "mobile" },
//             { data: "code_used" },
//         ],
//         select: true,
//         buttons: [
//             { extend: "create", editor: editor },
//             { extend: "edit",   editor: editor },
//             {
//                 extend: "selectedSingle",
//                 text: "Salary +250",
//                 action: function ( e, dt, node, config ) {
//                     // Immediately add `250` to the value of the salary and submit
//                     editor
//                         .edit( table.row( { selected: true } ).index(), false )
//                         .set( 'salary', (editor.get( 'salary' )*1) + 250 )
//                         .submit();
//                 }
//             },
//             { extend: "remove", editor: editor }
//         ]
//     } );
// } );
// </script>
@endsection
