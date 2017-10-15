<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users Transactions</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
      table { width: 100%;}
      table thead tr th, tbody tr td { padding: 5px; }
    </style>
  </head>
  <body>

  <div id="app">

      <table id="tbl_usersTransactions" border="1" cellSpacing="0" cellPadding="5">
        <thead>
          <tr>
            <th>#</th>
            <th>Account</th>
            <th>Descriptions</th>
            <th>TimeStamp</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
