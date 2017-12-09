<html>
    <head>
        <title>Direct Lookup</title>
        <script type="text/javascript" src="kpa_helper.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
        <style>
           body {
            font-family: 'Roboto Mono', monospace;
            font-size: 0.8em;
           }
           h2 { text-align: center; }
           .done {
               color: black;
           }
           .fetching {
               color: green;
               font-weight: 600;
               font-size: 0.8em;
           }
           .container { width: 100%; }
           .container .inner { width: 1550px; margin: 0 auto; }
           table { width: 1550px; }
           table thead tr th { background-color: #62894E; color: #fff; border: 1px solid #E1E1E1; }
           table tbody tr td { border: 1px solid #E1E1E1; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="inner">
                <h2>Direct Lookup</h2>
                <!-- table -->
                <table border="0" cellspacing="0" cellpadding="4">
                    <thead>
                      <tr>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Account Type</th>
                        <th>Created</th>
                      <tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < COUNT($data["Data"]); $i++)

                            <?php
                              $count = $i + 1;
                              $level = "Level_{$count}";
                              $datas = $data["Data"][$i][$level];
                            ?>

                            <tr>
                              <td colspan="4">LEVEL {{ $count }}</td>
                            </tr>

                            @for($l = 0; $l < COUNT($datas); $l++)
                              <tr>
                                <td>{{ $datas[$l]->fullname }}</td>
                                <td>{{ $datas[$l]->username }}</td>
                                <td>{{ $datas[$l]->user_type }}</td>
                                <td>{{ $datas[$l]->created_at }}</td>
                              </tr>
                            @endfor


                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
