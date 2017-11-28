@extends('layouts.default')

@section('content')
<div class="container content-container">
<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-2 w3-margin-top">
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
              <label class="control-label col-sm-3" for="email">Email:</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Password:</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
            </div>
            <div class="form-group w3-center">
              <div class="col-sm-12 w3-margin-top">
                <button type="submit" class="w3-btn w3-white w3-border w3-border-blue w3-round">Login</button>
                <a class="btn btn-link" href="/forgotpassword">Forgot Your Password?</a>
              </div>
            </div>
        </form>
   </div>
</div>
</div>
@endsection
