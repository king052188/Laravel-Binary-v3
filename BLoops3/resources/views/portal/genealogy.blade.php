@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Genealogy Structure
                  <a href="#" id="btnShowDetails" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Summary Details</a>
                </div>
                <div class="panel-body">
                  <div id="div_gHistoryDetails" style="display: none;">
                    <h3>Summary</h3>
                    <table class="tbl_history" id="tbl_gHistory" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                        <tr>
                          <th>Account#</th>
                          <th style="width: 227px;">Available Amount</th>
                          <th style="width: 50px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>***</td>
                          <td>***</td>
                          <td>***</td>
                        </tr>
                      </tbody>
                    </table>

                    <h3>Details</h3>
                    <table class="tbl_history" id="tbl_gHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th colspan="3">Summary Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Affliate</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Referral</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Indirect</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Leveling</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">-</td>
                          <td style="text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Points</td>
                          <td style="text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Wallet</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Total</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <h3>Structure</h3>
                  @if($structure["Code"] == 200)
                    <div id="g_structure_container" class="container-fluid" style="background-color: #eaedf1; border-radius: 5px;">
                      <!-- // Head Leader -->
                      <div class="row">
                        <?php $Top_Leader = $structure["Data"]["Top_Leader"]; ?>
                        <div class="col-md-12" style="margin: 30px 0 0 0;">
                          <div style="margin: 0 auto; width: 30px; height: 85px;">
                              <a class="g_link" href="/genealogy" >
                                  <img class="g_image" style="margin: 0 0 0 -10px;" src="{{ app()->getUrl(false, 'images/top-img.png') }}" />
                                  <p class="g_title">
                                    {{ $Top_Leader->username }}
                                  </p>
                              </a>
                          </div>
                        </div>
                      </div>
                      <!-- // Level 1 -->
                      <div class="L1" >
                        <?php $level_1 = $structure["Data"]["Level_1"]; ?>
                        <div class="col-md-12" style="margin: 10px 0 0 0;">
                          <div class="col-md-6" style="height: 85px;">
                              <div style="margin: 0 auto; width: 60px;">
                                @if( $level_1[0]["username"] != null )
                                  <a class="g_link" href="?p={{ $level_1[0]['username'] . $activate['affliliate'] }}">
                                    <?php $type = $level_1[0]["type_"] == 2 ? "" : "-cd" ?>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                    <p class="g_title"> {{ $level_1[0]["username"] }} </p>
                                  </a>
                                @else
                                  <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $Top_Leader->member_uid }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                    <p class="g_title"> N/A </p>
                                  </a>
                                @endif
                              </div>
                          </div>
                          <div class="col-md-6" style="height: 85px;">
                              <div style="margin: 0 auto; width: 60px;">
                                @if( $level_1[1]["username"] != null )
                                  <a class="g_link" href="?p={{ $level_1[1]['username'] . $activate['affliliate'] }}">
                                    <?php $type = $level_1[1]["type_"] == 2 ? "" : "-cd" ?>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                    <p class="g_title"> {{ $level_1[1]["username"] }} </p>
                                  </a>
                                @else
                                  <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $Top_Leader->member_uid }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                    <p class="g_title"> N/A </p>
                                  </a>
                                @endif
                              </div>
                          </div>
                        </div>
                      </div>

                      <!-- // level 2 -->
                      <div class="L2">
                        <?php $level_2 = $structure["Data"]["Level_2"]; ?>

                        <div class="col-md-6" style="margin: 20px 0 0 0;">
                          <div class="col-md-6" style="height: 85px;">
                              <div style="margin: 0 auto; width: 60px;">
                                @if( $level_2[0][0]["username"] != null )
                                  <a class="g_link" href="?p={{ $level_2[0][0]['username'] . $activate['affliliate'] }}">
                                    <?php $type = $level_2[0][0]["type_"] == 2 ? "" : "-cd" ?>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                    <p class="g_title"> {{ $level_2[0][0]["username"] }} </p>
                                  </a>
                                @else
                                  <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_1[0]['member_uid'] }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                    <p class="g_title"> N/A </p>
                                  </a>
                                @endif
                              </div>
                          </div>
                          <div class="col-md-6" style="height: 85px;">
                              <div style="margin: 0 auto; width: 60px;">
                                @if( $level_2[0][1]["username"] != null )
                                  <a class="g_link" href="?p={{ $level_2[0][1]['username'] . $activate['affliliate'] }}">
                                    <?php $type = $level_2[0][1]["type_"] == 2 ? "" : "-cd" ?>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                    <p class="g_title"> {{ $level_2[0][1]["username"] }} </p>
                                  </a>
                                @else
                                  <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_1[0]['member_uid'] }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                    <p class="g_title"> N/A </p>
                                  </a>
                                @endif
                              </div>
                          </div>
                        </div>

                        <div class="col-md-6" style="margin: 20px 0 0 0;">
                          <div class="col-md-6" style="height: 85px;">
                              <div style="margin: 0 auto; width: 60px;">
                                @if( $level_2[1][0]["username"] != null )
                                  <a class="g_link" href="?p={{ $level_2[1][0]['username'] . $activate['affliliate'] }}">
                                    <?php $type = $level_2[1][0]["type_"] == 2 ? "" : "-cd" ?>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                    <p class="g_title"> {{ $level_2[1][0]["username"] }} </p>
                                  </a>
                                @else
                                  <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_1[1]['member_uid'] }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                    <p class="g_title"> N/A </p>
                                  </a>
                                @endif
                              </div>
                          </div>
                          <div class="col-md-6" style="height: 85px;">
                              <div style="margin: 0 auto; width: 60px;">
                                @if( $level_2[1][1]["username"] != null )
                                  <a class="g_link" href="?p={{ $level_2[1][1]['username'] . $activate['affliliate'] }}">
                                    <?php $type = $level_2[1][1]["type_"] == 2 ? "" : "-cd" ?>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                    <p class="g_title"> {{ $level_2[1][1]["username"] }} </p>
                                  </a>
                                @else
                                  <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_1[1]['member_uid'] }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                    <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                    <p class="g_title"> N/A </p>
                                  </a>
                                @endif
                              </div>
                          </div>
                        </div>
                      </div>

                      <!-- // level 3 -->
                      <div class="L3">
                        <?php $level_3 = $structure["Data"]["Level_3"]; ?>
                        <div class="col-md-6" style="margin: 40px 0 30px 0;">
                          <!-- // 0  -->
                          <div class="col-md-6">
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[0][0]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[0][0]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[0][0]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[0][0]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[0][0]['member_uid'] }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[0][1]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[0][1]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[0][1]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[0][1]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[0][0]['member_uid'] }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                          </div>
                          <!-- // 1  -->
                          <div class="col-md-6">
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[1][0]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[1][0]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[1][0]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[1][0]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[0][1]['member_uid'] }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[1][1]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[1][1]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[1][1]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[1][1]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[0][1]['member_uid'] }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- // 2  -->
                        <div class="col-md-6" style="margin: 40px 0 20px 0;">
                          <div class="col-md-6">
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[2][0]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[2][0]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[2][0]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[2][0]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[1][0]['member_uid'] }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[2][1]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[2][1]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[2][1]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[2][1]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[1][0]['member_uid'] }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                          </div>
                          <!-- // 3  -->
                          <div class="col-md-6">
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[3][0]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[3][0]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[3][0]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/left'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[3][0]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[1][1]['member_uid'] }}" data-b="21" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-left-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 85px;">
                                <div style="margin: 0 auto; width: 60px;">
                                  @if( $level_3[3][1]["username"] != null )
                                    <a class="g_link" href="?p={{ $level_3[3][1]['username'] . $activate['affliliate'] }}">
                                      <?php $type = $level_3[3][1]["type_"] == 2 ? "" : "-cd" ?>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/right'. $type .'-img.png') }}" />
                                      <p class="g_title"> {{ $level_3[3][1]["username"] }} </p>
                                    </a>
                                  @else
                                    <a class="g_link" href="#" onclick="_event(this);" data-a="{{ $level_2[1][1]['member_uid'] }}" data-b="22" {{ $activate['data_affliliate'] }}>
                                      <img class="g_image" src="{{ app()->getUrl(false, 'images/na-right-img.png') }}" />
                                      <p class="g_title"> N/A </p>
                                    </a>
                                  @endif
                                </div>
                            </div>
                          </div>
                        </div>

                      </div>

                    </div>
                  @else
                    <h3>No Structure</h3>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal-encoding" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title">Encoding Form</h4>
      </div>

      <div class="modal-body">

        <div id="encoding-loading"><p>Please wait....</p></div>
        <div id="encoding-form" class="container-fluid" style="display: none;">

          <div class="form-horizontal">
            <fieldset>

              <div class="form-group">
                <label class="col-md-3 control-label">Username</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="_username" name="_username" placeholder="Username" class="form-control" type="text" required autofocus>
                    <img id="_username_img_loader" class="pull-right" style="margin: -31px 5px 0 0; position: relative; z-index: 9; display: none;" src="{{ app()->getUrl(false, 'images/facebook.gif') }}" />
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">First Name</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="_first_name" name="_first_name" placeholder="First Name" class="form-control" type="text" required autofocus>
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label" >Last Name</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="_last_name" name="_last_name" placeholder="Last Name" class="form-control" type="text" required autofocus>
                  </div>
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label">E-Mail</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                      <input id="_email" name="_email" placeholder="E-Mail Address" class="form-control" type="email" required autofocus>
                      <img id="_email_img_loader" class="pull-right" style="margin: -31px 5px 0 0; position: relative; z-index: 9; display: none;" src="{{ app()->getUrl(false, 'images/facebook.gif') }}" />
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">Phone #</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                      <input id="_mobile" name="_mobile" placeholder="09175551212" class="form-control" type="text" required autofocus>
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">Sponsor</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="_sponsor_username" name="_sponsor_username" placeholder="Sponsor Username" value="{{ Auth::user()->username }}" class="form-control" type="text" disabled>
                  </div>
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label">Placement</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                      <input id="_placement" name="_placement" placeholder="Placement" class="form-control" type="text" disabled>
                  </div>
                </div>
              </div>

              <!-- radio checks -->
              <div class="form-group">
                <label class="col-md-3 control-label">Position</label>
                <div class="col-md-9">
                    <div class="radio">
                        <label>
                            <input type="radio" name="_placement" id="_placement_left" value="21" disabled /> Left
                        </label>
                        <label style="margin-left: 20px;">
                            <input type="radio" name="_placement" id="_placement_right" value="22" disabled /> Right
                        </label>
                    </div>
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label">Code</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-qrcode"></i></span>
                      <input id="_activation_code" name="_activation_code" placeholder="Activation Code" class="form-control" type="text" required autofocus>
                  </div>
                </div>
              </div>

            </fieldset>
          </div>

        </div>

      </div><!-- /.container -->

      <div class="modal-footer">
        <span id="_span_error_msg" style="color: red; display: none; font-weight: 600; margin-right: 10px;">Oops, Please check the username.</span>
        <button id="btnEncode" type="submit" class="btn btn-primary" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Encode</button>
        <button id="btnCancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('style')
@endsection

@section('script')
<script>
$("#btnShowDetails").click(function() {
    if(IsShow) {
      IsShow = false;
      $("#div_gHistoryDetails").hide();
      $(this).empty().prepend('<i class="fa fa-bar-chart" aria-hidden="true"></i> Show Summary Details');
    }
    else {
      IsShow = true;
      $("#div_gHistoryDetails").show();
      $(this).empty().prepend('<i class="fa fa-bar-chart" aria-hidden="true"></i> Hide Summary Details');
      populate_genealogy_history("",false);
    }
})
</script>
@endsection
