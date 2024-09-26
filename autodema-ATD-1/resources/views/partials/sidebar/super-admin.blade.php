<li class="nav-opportunitties">
    <a href="{{ route('opportunities.dashboard') }}"><i class="fa fa-files-o"></i> Negocios</a>
</li>
<li class="nav-companies">
    <a href="{{ route('companies.listAll') }}"><i class="fa fa-building"></i> Empresas</a>
</li>
<li class="nav-campaigns">
    <a href="{{ route('campaigns.listAll') }}"><i class="fa fa-files-o"></i> Campañas</a>
</li>
<li class="nav-service-types">
    <a href="{{ route('serviceTypes.listAll') }}"><i class="fa fa-files-o"></i> Servicios</a>
</li>
<li class="nav-reports">
    <a href="{{ route('reports.dashboard') }}"><i class="fa fa-users"></i> Reportes</a>
</li>
<li class="nav-users">
    <a href="{{ route('users.listAll') }}"><i class="fa fa-users"></i> Usuarios</a>
</li>
<li class="nav-surveys">
    <a href="{{ route('surveys.listAll') }}"><i class="fa fa-file"></i> Encuestas</a>
</li>
<li class="nav-roles d-none">
    <a href="{{ route('roles.listAll') }}"><i class="fa fa-users"></i> Roles</a>
</li>
@include('partials.sidebar.logged')
