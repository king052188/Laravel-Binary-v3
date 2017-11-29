@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Leveling</div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Structure</h3>
                    <table class="tbl_history" id="tbl_lHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th>Level</th>
                          <th>Left</th>
                          <th>Right</th>
                          <th>Profit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                          <td style="text-align: center; padding: 5px;">{{ $i }}</td>
                          <td style="text-align: center; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: center; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 200px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        @endfor
                        <tr>
                          <td colspan="3" style="text-align: right; padding: 5px; font-weight: 600;">Total Profit</td>
                          <td style="text-align: right; width: 200px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
populate_leveling_history();
</script>
@endsection
