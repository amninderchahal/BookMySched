@extends('organization.default')

@section('organization-content')
<div class="page-header">
       <h3 class="w3-center">Deleted Organizations</h3>
  </div>
<div class="col-md-10 col-md-offset-1">
                <div class="w3-container">
                    @if (count($organizations) > 0)
                    <div id="organizations-table"></div>
                     @if($data['last_page']>1)
                        <div class="w3-center">
                            <ul class="pagination">
                            @if($data['current_page']==1)
                                <li class="disabled"><a href="/organization/trashed/show/{{$data['current_page']-1}}">Prev</a></li>
                                <li><a href="/organization/trashed/show/{{$data['current_page']+1}}">Next</a></li>
                            @elseif($data['current_page']==$data['last_page'])
                                <li><a href="/organization/trashed/show/{{$data['current_page']-1}}">Prev</a></li>
                                <li class="disabled"><a href="/organization/trashed/show/{{$data['current_page']+1}}">Next</a></li>
                            @else
                                <li><a href="/organization/trashed/show/{{$data['current_page']-1}}">Prev</a></li>
                                <li><a href="/organization/trashed/show/{{$data['current_page']+1}}">Next</a></li>
                            @endif
                            </ul>
                        </div>
                        @endif
                      @else
                    <div class="w3-center alert alert-success">
                      <strong>No deleted organizations!</strong>
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
                    <a className={'w3-text-indigo td-link-'+this.props.name} href={this.props.link+'/'+this.props.id}>{this.props.name}</a>
                )
            }
        }

        class OrganizationElement extends React.Component{
            componentDidMount() {
                $('.td-link-Restore').click(function(e){
                    if(!confirm("Do you really want to restore this Organization?"))
                        e.preventDefault();
                });
                window.responsiveTable();
              }
            render(){
                const rowElement = function(row){
                    return(<tr key={row.id}  className="w3-small w3-hover-light-gray">
                             <TdData data={row.name} />
                             <td><TdLink link="{{$uri['view_uri']}}" id={row.id} name="View" /></td>
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
                            <th>Addresses</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            {this.props.data.map(rowElement)}
                        </tbody>
                    </table>
                );
            }
        }

        let results = {!!$organizations!!};

        ReactDOM.render(<OrganizationElement data= {results.organizations.data} />, document.getElementById('organizations-table'));
   </script>

@endsection
