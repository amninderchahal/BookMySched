@extends('organization.address.default')

@section('organization-address-content')
<div class="page-header">
       <h3 class="w3-center">{{$organization['name']}} - Addresses</h3>
  </div>
<div class="col-md-10 col-md-offset-1">
                <div class="w3-container">
                    @if ($count > 0)
                       <div id="addresses-table"></div>
                    @else
                    <div class="w3-center alert alert-success">
                      <strong>No addresses!</strong>
                    </div>
                    @endif
                    <br>
                    <a class="w3-text-indigo w3-medium" href="/organization/address/add/{{$organization['id']}}">Add New Address</a>
                    <a class="w3-text-indigo w3-medium w3-right" href="/organization/address/trashed/{{$organization['id']}}">Show Deleted Addresses</a>
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
                    <a className={'w3-text-indigo td-link-'+this.props.name} href={this.props.link+'{{$organization['id']}}/'+this.props.id}>{this.props.name}</a>
                )
            }
        }

        class AddressElement extends React.Component{
            componentDidMount() {
                $('.td-link-Delete').click(function(e){
                    if(!confirm("Do you really want to delete this Address?"))
                        e.preventDefault();
                });
                window.responsiveTable();
              }
            render(){
                const rowElement = function(row){
                    return(<tr key={row.id}  className="w3-small w3-hover-light-gray">
                             <TdData data={row.street} />
                             <TdData data={row.city} />
                             <TdData data={row.country} />
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
                            <th>Street</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Postal Code</th>
                            <th>Phone Number</th>
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

        let results = {!!$data!!};

        ReactDOM.render(<AddressElement data= {results.addresses} />, document.getElementById('addresses-table'));
   </script>
@endsection
