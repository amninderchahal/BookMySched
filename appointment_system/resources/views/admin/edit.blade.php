@extends('admin.default')

@section('admin-content')
<div class="page-header">
       <h3 class="w3-center">Admins</h3>
    </div>
<div class="col-md-6 col-md-offset-3 w3-margin-top">
                <div class="w3-container">
                    <div class="panel panel-default">
                      <div class="panel-heading"><h5>Edit Admin Info</h5></div>
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
                          <form class="form-horizontal w3-padding-24" action="/admin/update/{{$data['id']}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="firstname">First Name:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="lastname">Last Name:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="email">Email:</label>
                                  <div class="col-sm-7">
                                    <input type="email" class="form-control" id="email" name="email" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="organization">Organization:</label>
                                  <div id="select-component" class="col-sm-6"></div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="role">Role:</label>
                                  <div class="col-sm-6" id="role_div">
                                    <select class="form-control" id="role" name="role_id">
                                        <option value="2">Admin</option>
                                        <option value="3">Employee</option>
                                    </select>
                                  </div>
                                </div>
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
                                    <button type="submit" class="w3-center w3-btn w3-white w3-border w3-border-blue w3-round">Save</button>
                                    </div>
                                </div>
                            </form>
                          </div>
                    </div>
                </div>
   </div>
@isset($data)
<script type="text/babel">
        class SelectComponent extends React.Component{
            componentDidMount() {
                let id = {{$data['organization_id']}};
                $('.form-group #firstname').val("{{$data['firstname']}}");
                $('.form-group #lastname').val("{{$data['lastname']}}");
                $('.form-group #email').val("{{$data['email']}}");
                $('.form-group #organization').val(id);
                $('.form-group #role_div select').val(2);
                $('.form-group #street').val("{{$data['street']}}");
                $('.form-group #city').val("{{$data['city']}}");
                $('.form-group #country').val("{{$data['country']}}");
                $('.form-group #postal_code').val("{{$data['postal_code']}}");
                $('.form-group #phone_number').val("{{$data['phone_number']}}");
              }
            render(){
                return(
                    <select className="form-control" id="organization" name="organization_id" required>
                         <option value="">Select</option>
                         {this.props.organizations.map(function(org){
                             return (<option key={org.id} value={org.id}>{org.name}</option>);
                         })}
                     </select>
                );
            }
        }

        let data = {!!$organizations!!};
        ReactDOM.render(<SelectComponent organizations={data.organizations} />, document.getElementById('select-component'));
</script>
@endisset

@endsection
