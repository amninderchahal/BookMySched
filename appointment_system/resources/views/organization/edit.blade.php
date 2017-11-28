@extends('organization.default')

@section('organization-content')
<div class="page-header">
       <h3 class="w3-center">Organizations</h3> 
  </div>
<div class="col-md-6 col-md-offset-3 w3-margin-top">
                <div class="w3-container">
                    <div class="panel panel-default">
                      <div class="panel-heading"><h5>Edit Organization</h5></div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                      <div class="panel-body">
                          @isset($msg)
                            {!!$msg!!}
                          @endisset
                          <form class="form-horizontal panel-body w3-padding-24" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="name">Name:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="name" name="name" required>
                                  </div>
                                </div>
                                <div class="form-group w3-center">        
                                    <div class="col-sm-12 w3-margin-top">
                                    <button type="submit" class="center w3-btn w3-white w3-border w3-border-blue w3-round">Save</button>
                                    </div>
                                </div>
                            </form>
                          </div>
                    </div>
                </div>
   </div>
@isset($name)
<script>
        $('.form-group #name').val("{{$name}}");
</script>                    
@endisset

@endsection