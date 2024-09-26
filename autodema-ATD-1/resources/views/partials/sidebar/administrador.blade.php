<li class="nav-companies">
    <a href="{{ route('units.listAll') }}"><i class="fa fa-thermometer-full"></i> Unidades</a>
</li>
<li class="nav-companies">
    <a href="{{ route('ecas.listAll') }}"><i class="fa fa-thermometer-full"></i> ECA</a>
</li>
<li class="nav-companies">
    <a href="{{ route('parameters.listAll') }}"><i class="fa fa-thermometer"></i> Parámetros</a>
</li>
<li class="nav-companies">
    <a href="{{ route('samplingPoints.listAll') }}"><i class="fa fa-flask"></i> Estaciones de monitoreo</a>
</li>
<li class="nav-reports">
    <a href="{{ route('tests.mapsReports') }}"><i class="fa fa-area-chart"></i> Visualización</a>
</li>
<li class="nav-users">
    <a href="{{ route('users.listAll') }}"><i class="fa fa-users"></i> Usuarios</a>
</li>
<li class="nav-roles d-none">
    <a href="{{ route('roles.listAll') }}"><i class="fa fa-users"></i> Roles</a>
</li>
@include('partials.sidebar.logged')
