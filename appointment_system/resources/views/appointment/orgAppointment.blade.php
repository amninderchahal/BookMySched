@extends('appointment.default')

@section('appointment-content')
<div class="page-header">
       <h3 id="header-title" class="w3-center">Employee Appointments</h3>
    </div>
<div class="col-md-8 col-md-offset-2">
                <div class="w3-container">
                @if (session('role_id')==1)
                    @include('includes.orgFilter')
                @endif
                @if ($count> 0)
                    <div id="employees-list"></div>
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
        class EmployeeSchedule extends React.Component{
            constructor(props) {
               super(props)
               this.uri = '{{$uri['view_uri']}}'
             }
             componentDidMount(){
                 window.responsiveTable();
             }
            render(){
                const rowElement = function(row){
                    return(<tr className="w3-small w3-hover-light-gray" key={row.id}>
                             <td>{row.firstname+' '+row.lastname}</td>
                             <td>
                                <a className='w3-text-indigo span-link-view' href={this.uri+row.id}>View</a>
                             </td>
                           </tr>)
                };
                return(<table className="w3-table w3-bordered w3-border w3-hoverable">
                         <thead>
                          <tr className="w3-dark-grey">
                            <th>Name</th>
                            <th>Schedule</th>
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
            ReactDOM.render(<EmployeeSchedule org={organization} data= {results.employees.data} />, document.getElementById('employees-list'));
        @endif

        $(document).ready(function(){
            let title = $('#header-title').text();
            $('#header-title').text(organization.name+' - '+title);
        });
   </script>
@endsection
