<a class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small" href="/home">Home</a>
@if(session('role_id')==1)
<!---------organization links----------->
<button type="button" data-toggle="collapse" data-target="#org-link" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small">
    Organizations<span class="caret"></span>
</button>
<div id="org-link" class="collapse">
    <a href="/organization?page=1" class="accordian-link w3-bar-item w3-button w3-small">List Organizations</a>
    <a href="/organization/new" class="accordian-link w3-bar-item w3-button w3-small">Add New Organization</a>
    <a href="/organization/trashed?page=1" class="accordian-link w3-bar-item w3-button w3-small">Deleted Organizations</a>
</div>

<!---------Admin links----------->
<button type="button" data-toggle="collapse" data-target="#admin-link" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small">
    Admins<span class="caret"></span>
</button>
<div id="admin-link" class="collapse">
    <a href="/admin/organization/{{session('organization_id')}}?page=1" class="accordian-link w3-bar-item w3-button w3-small">List Admins</a>
    <a href="/admin/new" class="accordian-link w3-bar-item w3-button w3-small"> Add New Admin</a>
    <a href="/admin/trashed/{{session('organization_id')}}?page=1" class="accordian-link w3-bar-item w3-button w3-small"> Deleted Admins</a>
</div>
@endif
@if(session('role_id')==1||session('role_id')==2)
<!---------Employees links----------->
<button type="button" data-toggle="collapse" data-target="#emp-link" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small">
    Employees<span class="caret"></span>
</button>
<div id="emp-link" class="collapse">
    <a href="/employee/organization/{{session('organization_id')}}?page=1" class="accordian-link w3-bar-item w3-button w3-small">List Employees</a>
    <a href="/employee/new" class="accordian-link w3-bar-item w3-button w3-small"> Add New Employee</a>
    <a href="/employee/trashed/{{session('organization_id')}}?page=1" class="accordian-link w3-bar-item w3-button w3-small"> Deleted Employee</a>
</div>
<!---------Services links----------->
<button type="button" data-toggle="collapse" data-target="#service-link" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small">
    Services<span class="caret"></span>
</button>
<div id="service-link" class="collapse">
    <a href="/service/organization/{{session('organization_id')}}?page=1" class="accordian-link w3-bar-item w3-button w3-small">List Services</a>
    <a href="/service/new" class="accordian-link w3-bar-item w3-button w3-small"> Add New Service</a>
    <a href="/service/trashed/{{session('organization_id')}}?page=1" class="accordian-link w3-bar-item w3-button w3-small"> Deleted Services</a>
</div>
<!---------Schedule links----------->
<a href="/schedule/organization/{{session('organization_id')}}" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small"> Employee Schedule</a>

<a href="/appointment/organization/{{session('organization_id')}}" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small">Appointments</a>
@else
<a href="/appointment/organization/{{session('organization_id')}}/{{session('id')}}" class="sidebar-link w3-hover-blue-gray w3-bar-item w3-button w3-small">Appointments</a>
@endif

<script>
    function toggleSideBar() {
        $("#mySidebar").slideToggle();  
    }
</script>