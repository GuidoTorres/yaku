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
@include('partials.sidebar.logged')
