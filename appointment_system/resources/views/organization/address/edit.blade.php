@extends('organization.default')

@section('organization-content')
<div class="page-header">
       <h3 class="w3-center">{{$organization['name']}} - Addresses</h3> 
  </div>
<div class="col-md-6 col-md-offset-3 w3-margin-top">
                <div class="w3-container">
                    <div class="panel panel-default">
                      <div class="panel-heading"><h5>Add New Address</h5></div>
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
                                  <label class="control-label col-sm-4" for="street">Street:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="street" name="street" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="city">City:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="city" name="city" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="country">Country:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="country" name="country" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="postal_code">Postal Code:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="phone_number">Phone Number:</label>
                                  <div class="col-sm-7">
                                    <input type="number" class="form-control" id="phone_number" name="phone_number" required>
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
@isset($data)
<script>
        $('.form-group #street').val("{{$data['street']}}");
        $('.form-group #city').val("{{$data['city']}}");
        $('.form-group #country').val("{{$data['country']}}");
        $('.form-group #postal_code').val("{{$data['postal_code']}}");
        $('.form-group #phone_number').val("{{$data['phone_number']}}");
</script>                    
@endisset
@endsection