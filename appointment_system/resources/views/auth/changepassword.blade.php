@extends('layouts.default')

@section('content')
<div class="container">
<div class="col-sm-8 col-sm-offset-2 col-md-5 col-md-offset-3 w3-margin-top">
    <div class="panel panel-default">
        <div class="panel-heading"><h5>Login</h5></div>
        <form class="form-horizontal panel-body" method="post">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{ csrf_field() }}
            @isset($msg)
               <p class="w3-center w3-medium text text-danger">{!!$msg!!}</p>
            @endisset
            <div class="form-group w3-margin-top">
              <label class="control-label col-sm-5" for="current_password">Current Password:</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" id="current_password" name="current_password" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-5" for="new_password">New Password:</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" id="new_password" name="new_password" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-5" for="repeat_password">Repeat Password:</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" id="repeat_password" name="new_password_confirmation" required>
              </div>
            </div>
            <div class="form-group w3-center">        
              <div class="col-sm-12 w3-margin-top">
                <button type="submit" class="w3-btn w3-white w3-border w3-border-blue w3-round">Save</button>
              </div>
            </div>
        </form>
   </div>
</div>
</div>
@endsection
