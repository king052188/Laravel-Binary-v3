<?php


use Illuminate\Http\Request;

Route::get('/bloops/demo', function() {
  $html = "<html>
              <head>
                  <title>Welcome | king052188/BinaryLoops</title>
              </head>
              <body style='text-align: center;'>
                <h3 style='margin: 300px 0 0 0;'>*** Well Done! You are good to go ***</h3>
                <p>@kingpauloaquino | kingpauloaquino@gmail.com</p>
                <p><a href='http://kpa.ph/kingpauloaquino'>kpa.ph/kingpauloaquino</a></p>
              </body>
          </html>";
  return $html;
});

Route::get('/bloops/info/{all?}', function($all = null) {
  $a = false;
  if($all != null) {
    $a = true;
  }
  return BinaryLoops::TestServices($a);
});

//

Route::any('/bloops/v1/encode', function(Request $request) {
  return BinaryLoops::Encode($request);
});

Route::any('/bloops/v1/placement-validation', function(Request $request) {
  return BinaryLoops::Placement_Validate($request);
});

Route::any('/bloops/v1/member-pairing-status/{username}', function($member_uid) {
  return BinaryLoops::Member_Pairing($member_uid);
});

Route::any('/bloops/v1/populate-genealogy/{username}', function($username) {
  return BinaryLoops::Populate_Genealogy($username);
});
