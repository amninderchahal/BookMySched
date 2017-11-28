@extends('layouts.default')

@section('content')
<div class="container content-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Error</div>

                <div class="panel-body">
                    {{session('error')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection