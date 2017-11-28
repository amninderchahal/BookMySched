
@extends('employee.default')

@section('employee-content')
<div class="page-header">
       <h3 id="header-title" class="w3-center">Employees</h3>
    </div>
<div class="col-md-10 col-md-offset-1">
                <div class="w3-container">
                @if (session('role_id')==1)
                    @include('includes.orgFilter')
                @endif
                @if ($count> 0)
                    <div id="employees-table"></div>
                    @if($data['last_page']>1)
                            <div class="w3-center">
                                @include('includes.pagination')
                            </div>
                        @endif
                    @else
                    <div class="w3-center alert alert-success">
                      <strong>No employees!</strong>
                    </div>
                    @endif
                </div>
   </div>
  <script type="text/babel">
        class TdData extends React.Component{
            render(){
                return (
                    <td>{this.props.data}</td>
                )
            }
        }
        class TdLink extends React.Component{
            render(){
                return (
                    <a className={'w3-text-indigo td-link-'+this.props.name} href={this.props.link+this.props.id}>{this.props.name}</a>
                )
            }
        }
        class OrganizationElement extends React.Component{

            componentDidMount() {
                $('.td-link-Delete').click(function(e){
                    if(!confirm("Do you really want to delete this Employee?"))
                        e.preventDefault();
                });
                window.responsiveTable();
              }
            render(){
                const rowElement = function(row){
                    return(<tr key={row.id}  className="w3-small w3-hover-light-gray">
                             <TdData data={row.firstname+' '+row.lastname} />
                             <TdData data={row.email} />
                             <TdData data={this.props.org.name} />
                             <TdData data={row.street+', '+row.city+', '+row.country} />
                             <TdData data={row.postal_code} />
                             <TdData data={row.phone_number} />
                             <td>
                                  <TdLink link="{{$uri['edit_uri']}}" id={row.id} name="Edit " />
                                  <TdLink link="{{$uri['delete_uri']}}" id={row.id} name="Delete" />
                             </td>
                         </tr>)
                };
                return(
                    <table className="w3-table w3-bordered w3-border w3-hoverable">
                         <thead>
                          <tr className="w3-dark-grey">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Address</th>
                            <th>Postal Code</th>
                            <th>Phone Number</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            {this.props.data.map(rowElement.bind(this))}
                        </tbody>
                    </table>
                );
            }
        }

        let results = {!!$employees!!};

        let organization = results.organization;

        @if ($count> 0)
            ReactDOM.render(<OrganizationElement org={organization} data= {results.employees.data} />, document.getElementById('employees-table'));
        @endif

        let title = $('#header-title').text();
        $('#header-title').text(organization.name+' - '+title);
   </script>
@endsection
