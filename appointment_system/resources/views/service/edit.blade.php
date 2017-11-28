@extends('service.default')

@section('service-content')
<div class="page-header">
       <h3 class="w3-center">Services</h3> 
    </div>
<div class="col-md-6 col-md-offset-3 w3-margin-top">
                <div class="w3-container">
                    <div class="panel panel-default">
                      <div class="panel-heading"><h5>Edit Service</h5></div>
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
                          <form id="services_form" class="form-horizontal panel-body w3-padding-24" action="/service/update/{{$data['organization_id']}}/{{$data['id']}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label class="control-label col-sm-3" for="name">Name:</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" required>
                                  </div>
                                </div>
                              </form>
                                <div class="form-group">
                                  <label class="control-label col-sm-3" for="description">Description:</label>
                                  <div class="col-sm-9">
                                      <textarea form="services_form" rows="4" type="text" class="form-control" id="description" name="description"></textarea>
                                  </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-5 w3-margin-top">
                                    <button id="service-btn" class="center w3-btn w3-white w3-border w3-border-blue w3-round">Save</button>
                                    </div>
                                </div>
                          </div>
                    </div>
                </div>
   </div>
@isset($data)
<script>
        $('#service-btn').click(function(){
            $('#services_form').submit();
        });
        $('.form-group #name').val("{{$data['name']}}");
        $('.form-group #description').val("{{$data['description']}}");
</script>
@endisset

@endsection