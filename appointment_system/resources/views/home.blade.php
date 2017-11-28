@extends('layouts.default')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="sidebar-inner w3-bar-block w3-card-2">
                @include('includes.sidebar')
</div>
<div class="container content-container">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3 col-xs-10 col-xs-offset-1">
          <form id="search-box-form" class="input-group">
            <input id="search-input" type="text" class="form-control input-lg" placeholder="Search for..." autocomplete="off" autofocus>
            <span class="input-group-btn">
              <button id="home-search-btn" class="btn btn-default btn-lg" type="submit">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
              </button>
            </span>
          </form>
          <div class="search-chkbox-div">
            @if(Session::get('role_id')==1)
            <div class="col-xs-4"><input class="search-chkbox" type="checkbox" value="div-Organization" checked>Organization</div>
            <div class="col-xs-4"><input class="search-chkbox" type="checkbox" value="div-Admin" checked>Admin</div>
            @endif
            @if(Session::get('role_id')==1 || Session::get('role_id')==2)
            <div class="col-xs-4"><input class="search-chkbox" type="checkbox" value="div-Employee" checked>Employee</div>
            <div class="col-xs-4"><input class="search-chkbox" type="checkbox" value="div-Service" checked>Service</div>
            @endif
            <div class="col-xs-4"><input class="search-chkbox" type="checkbox" value="div-Appointment" checked>Appointment</div>
            <div class="col-xs-4"><input class="search-chkbox" type="checkbox" value="div-Client" checked>Client</div>
          </div>
        </div>
        <div class="col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
              <div id="search-results"></div>
        </div>
    </div>
</div>
<script type="text/babel">
class Link extends React.Component{
  render(){
    let url;
    let result = this.props.result;
    switch (result.type){
      case "Appointment":
        url="appointment/organization/"+result.org_id+'/'+result.emp_id+'?d='+result.date+'&n='+result.id;
        break;
      case "Admin":
        url='admin/edit/'+result.id;
        break;
      case "Employee":
        url='employee/edit/'+result.id;
        break;
      case "Organization":
        url="organization/edit/"+result.id;
        break;
      case "Service":
        url="service/edit/"+result.org_id+'/'+result.id;
        break;
    }
    return(<a className="search-result-link" href={url} >{this.props.result.title}</a>)
  }
}
class SearchResult extends React.Component{
    constructor(props){
      super(props);
      this.elements = [];
    }
    fadeInElements(elements){
      $('.search-chkbox-div>div').fadeIn(600);
      $('.search-chkbox').change(function(){
        let element = '.'+$(this).val();
        if(this.checked)
          $(element).fadeIn(600);
        else
          $(element).fadeOut(600);
      });
      $('#search-results').removeClass('loading');
      $('.search-result-div').hide();
      let intervalId = null;
      let i = 0;
      function interval(){
        if(i<=elements.length){
          let el = '#element-'+i;
          $(el).fadeIn(600);
          i++;
        }
        else{
          clearInterval(intervalId);
        }
      }
      intervalId = setInterval(interval, 120);
    }
    componentDidMount(){
      this.fadeInElements(this.elements);
      this.elements = [];
    }
    componentDidUpdate(){
      this.fadeInElements(this.elements);
      this.elements = [];
    }
    render(){
            var that = this;
      return(<div className="w3-margin-top">
              {this.props.results.map(function(result, index){
                let id = 'element-'+index;
                that.elements.push(id);
                return(<div key={index} id={id} className={"search-result-div col-xs-12 col-sm-6 w3-padding-16 w3-round-large div-"+result.type}>
                          <div className="w3-margin-bottom"><Link result={result} /></div>
                          <div>
                              <p className="text-dark-gray result-type inline">{result.type}</p>
                              <p className="pull-right inline text-dark-gray">Added on: {result.created_at}</p>
                          </div>
                       </div>)
              })}
            </div>)
    }
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#search-box-form').submit(function(e){
    e.preventDefault();
    $('#search-results').addClass('loading');
    let query = $('#search-input').val();
    let url = '/search';
    $.getJSON(
        url,
        {query:query},
        function(results){
          $('#search-box-form').animate({marginTop:"5vmin"}, 600);
          $('#home-search-btn, #search-input').animate({
                height:"34px",
                padding:"6px 10px 6px 10px",
                fontSize:"14px"
            },600);
          ReactDOM.render(<SearchResult results={results} />, document.querySelector('#search-results'));
        }
      );
});
</script>
@endsection
