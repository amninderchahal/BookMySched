@extends('layouts.default')

@section('content')

<script src="{{ asset('js/jquery.timepicker.min.js') }}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.timepicker.css') }}">
<div class="sidebar-inner w3-bar-block w3-card-2">
                @include('includes.sidebar')
</div>
<div class="container content-container">
    @if(Session::has('msg'))
        <div class="msg-fadeout w3-center alert alert-{{Session::get('className')}} alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>{{Session::get('msg')}}</strong>
        </div>
    @endisset
    <div class="row">
        @yield('schedule-content')
    </div>
</div>
@endsection
