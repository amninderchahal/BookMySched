@extends('admin.default')

@section('admin-content')
<div class="page-header">
       <h3 class="w3-center">Deleted Admins</h3>
    </div>
<div class="col-md-10 col-md-offset-1">
                <div class="w3-container">
                    @if ($count > 0)
                        <div id="admins-table"></div>
                        @if($data['last_page']>1)
                            <div class="w3-center">
                                <ul class="pagination">
                                @if($data['current_page']==1)
                                    <li class="disabled"><a href="/admin/trashed/show/{{$data['current_page']-1}}">Prev</a></li>
                                    <li><a href="/admin/trashed/show/{{$data['current_page']+1}}">Next</a></li>
                                @elseif($data['current_page']==$data['last_page'])
                                    <li><a href="/admin/trashed/show/{{$data['current_page']-1}}">Prev</a></li>
                                    <li class="disabled"><a href="/admin/trashed/show/{{$data['current_page']+1}}">Next</a></li>
                                @else
                                    <li><a href="/admin/trashed/show/{{$data['current_page']-1}}">Prev</a></li>
                                    <li><a href="/admin/trashed/show/{{$data['current_page']+1}}">Next</a></li>
                                @endif
                                </ul>
                            </div>
                        @endif
                    @else
                    <div class="w3-center alert alert-success">
                      <strong>No deleted admins!</strong>
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
                $('.td-link-Restore').click(function(e){
                    if(!confirm("Do you really want to restore this Admin?"))
                        e.preventDefault();
                });
                window.responsiveTable();
              }
            render(){
                const rowElement = function(row){
                    return(<tr key={row.id}  className="w3-small w3-hover-light-gray">
                             <TdData data={row.firstname+' '+row.lastname} />
                             <TdData data={row.email} />
                             <TdData data={row.organization} />
                             <TdData data={row.street+', '+row.city+', '+row.country} />
                             <TdData data={row.postal_code} />
                             <TdData data={row.phone_number} />
                             <td>
                                  <TdLink link="{{$uri['restore_uri']}}" id={row.id} name="Restore" />
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

        let results = {!!$admins!!};

        let organizations = results.organizations;

        results.admins.data.map(function(admin){
            organizations.map(function(org){
                if(org.id == admin.organization_id){
                    admin.organization = org.name;
                }
            });
        });

        ReactDOM.render(<OrganizationElement data= {results.admins.data} />, document.getElementById('admins-table'));
</script>
@endsection
