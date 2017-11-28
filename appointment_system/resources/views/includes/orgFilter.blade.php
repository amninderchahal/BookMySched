<div id="filter-options" OnLoad="" class="w3-margin-bottom"></div>
<script type="text/babel" >
                    var orgData = {!!$organizations!!};
                    
                    class SelectElement extends React.Component{
                    render(){
                        return(
                            <span>
                                <span id="filter-dropdown" className="dropdown w3-margin-left">
                                  <button className="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Select Organization <span className="caret"></span></button>
                                  <ul className="dropdown-menu w3-text-black">
                                    {this.props.organizations.map(function(org){
                                        return(<li key={org.id}><a href={'{{$uri['filter_uri']}}'+org.id+'?page=1'}>{org.name}</a></li>);
                                    })}
                                  </ul>
                                </span>
                             </span>
                        )}
                    }

                    // Render filter options
                    
                    ReactDOM.render(<SelectElement organizations={orgData.organizations} />, document.getElementById('filter-options'));
            
</script>