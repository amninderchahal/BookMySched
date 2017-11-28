<nav class="navbar navbar-fixed-top navbar-xs w3-text-light-gray">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/home">BookMySched</a>
      <div id="nav-header-dropdown" class="dropdown navbar-dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                    @if(Session::has('is_authenticated'))
                        <li class="name"><h6><strong>{{session('firstname')}} {{session('lastname')}} </strong></h6></li>
                        <li class="divider"></li>
                        <li><a href="/changepassword"> Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    @else
                        <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    @endif
            </ul>
      </div>
    </div>
      <div id="navbar-dropdown" class="dropdown navbar-dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              @if(Session::has('is_authenticated'))
                        <li class="name"><h6><strong>{{session('firstname')}} {{session('lastname')}} </strong></h6></li>
                        <li class="divider"></li>
                        <li><a href="/changepassword"> Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    @else
                        <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    @endif
            </ul>
      </div>
  </div>
</nav>
