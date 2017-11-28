@extends('employee.default')

@section('employee-content')
<div class="page-header">
       <h3 class="w3-center">Employees</h3>
    </div>
<div class="col-md-6 col-md-offset-3 w3-margin-top">
                <div class="w3-container">
                    <div class="panel panel-default">
                      <div class="panel-heading"><h5>Add New Employee</h5></div>
                      <div class="panel-body">
                          @isset($msg)
                            <p class="text-danger" >{$msg}</p>
                          @endisset
                          <form class="form-horizontal panel-body w3-padding-24" onsubmit="return validatePassword();" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="firstname">First Name:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="lastname">Last Name:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="email">Email:</label>
                                  <div class="col-sm-8">
                                    <input type="email" class="form-control" id="email" name="email" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="password">Password:</label>
                                  <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="confirm_password">Confirm Password:</label>
                                  <div class="col-sm-8">
                                    <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="organization">Organization:</label>
                                  <div id="select-component" class="col-sm-6"></div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="role">Role:</label>
                                  <div class="col-sm-6">
                                    <select class="form-control" id="role" name="role">
                                        <option value="2">Admin</option>
                                        <option value="3">Employee</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="street">Street:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="street" name="street" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="city">City:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="city" name="city" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="country">Country:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="country" name="country" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="postal_code">Postal Code:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-4" for="phone_number">Phone Number:</label>
                                  <div class="col-sm-8">
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
<script type="text/babel">
        class SelectComponent extends React.Component{
            componentDidMount() {
                $('.form-group #role').val(3);
              }
            render(){
                return(
                    <select className="form-control" id="organization" name="organization" required>
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
@endsection
