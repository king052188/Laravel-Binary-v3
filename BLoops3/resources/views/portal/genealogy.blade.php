@extends('layouts.app')

@section('content')
<div class="container" style="width: 80%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Genealogy</div>

                <div class="panel-body" style="height: 440px;">

                  <!-- Trigger the modal with a button -->
                  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

                </div>
            </div>
        </div>

    </div>

</div>

<style>
  table.tbl_encode tr td{ text-align: left;}
</style>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Encoding Form</h4>
      </div>

      <div class="modal-body">

        <div class="container-fluid">

          <div class="form-horizontal">

            <fieldset>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">First Name</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input  name="first_name" placeholder="First Name" class="form-control"  type="text">
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label" >Last Name</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="last_name" placeholder="Last Name" class="form-control"  type="text">
                  </div>
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label">E-Mail</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                      <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">Phone #</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                      <input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">Address</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                      <input name="address" placeholder="Address" class="form-control" type="text">
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">City</label>
                  <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                      <input name="city" placeholder="city" class="form-control"  type="text">
                  </div>
                </div>
              </div>

              <!-- Select Basic -->

              <div class="form-group">
                <label class="col-md-3 control-label">State</label>
                <div class="col-md-9 selectContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                    <select name="state" class="form-control selectpicker" >
                  <option value=" " >Please select your state</option>
                  <option>Alabama</option>
                  <option>Alaska</option>
                  <option >Arizona</option>
                  <option >Arkansas</option>
                  <option >California</option>
                  <option >Colorado</option>
                  <option >Connecticut</option>
                  <option >Delaware</option>
                  <option >District of Columbia</option>
                  <option> Florida</option>
                  <option >Georgia</option>
                  <option >Hawaii</option>
                  <option >daho</option>
                  <option >Illinois</option>
                  <option >Indiana</option>
                  <option >Iowa</option>
                  <option> Kansas</option>
                  <option >Kentucky</option>
                  <option >Louisiana</option>
                  <option>Maine</option>
                  <option >Maryland</option>
                  <option> Mass</option>
                  <option >Michigan</option>
                  <option >Minnesota</option>
                  <option>Mississippi</option>
                  <option>Missouri</option>
                  <option>Montana</option>
                  <option>Nebraska</option>
                  <option>Nevada</option>
                  <option>New Hampshire</option>
                  <option>New Jersey</option>
                  <option>New Mexico</option>
                  <option>New York</option>
                  <option>North Carolina</option>
                  <option>North Dakota</option>
                  <option>Ohio</option>
                  <option>Oklahoma</option>
                  <option>Oregon</option>
                  <option>Pennsylvania</option>
                  <option>Rhode Island</option>
                  <option>South Carolina</option>
                  <option>South Dakota</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option> Uttah</option>
                  <option>Vermont</option>
                  <option>Virginia</option>
                  <option >Washington</option>
                  <option >West Virginia</option>
                  <option>Wisconsin</option>
                  <option >Wyoming</option>
                </select>
                  </div>
                </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                <label class="col-md-3 control-label">Zip Code</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                    <input name="zip" placeholder="Zip Code" class="form-control"  type="text">
                  </div>
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label">Placement</label>
                <div class="col-md-9 inputGroupContainer">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                      <input name="website" placeholder="Placement" class="form-control" type="text">
                  </div>
                </div>
              </div>

              <!-- radio checks -->
              <div class="form-group">
                <label class="col-md-3 control-label">Position</label>
                <div class="col-md-9">
                    <div class="radio">
                        <label>
                            <input type="radio" name="hosting" value="yes" /> Left
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="hosting" value="no" /> Right
                        </label>
                    </div>
                </div>
              </div>

            </fieldset>
          </div>

        </div>

      </div><!-- /.container -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Encode</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
      </div>
    </div>

  </div>
</div>
@endsection
