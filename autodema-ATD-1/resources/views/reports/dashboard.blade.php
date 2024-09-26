@extends('layouts.app', ['page' => 'reports'])

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row justify-content-center" style="background-color: #fff">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="reports-wrapp">
                <div class="reports-inn">

                    <div class="reports-period d-flex justify-content-center flex-wrap">

                        <div class="w-100 text-center">PERÍODO <span class="year-period"></span> <span class="months-period text-uppercase"></span></div>
                        <div class="w-100 text-center">
                            <select id="year" name="year" class="form-control d-inline-block w-auto">
                                {{ $last= date('Y')+30 }}
                                {{ $now = date('Y') }}

                                @for ($i = 2021; $i <= $last; $i++)
                                    <option value="{{ $i }}" {{ $i == $now? 'selected':'' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <div class="form-group d-inline-block  w-auto">
                                <div
                                    data-toggle="dropdown"
                                    class="btn btn-outline-secondary dropdown-toggle" type="button"
                                >Mes</div>
                                <ul class="dropdown-menu dropdown-menu-form dropdown-services-list months-list">
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="1" id="months_1" name="months[]">Enero</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="2" id="months_2" name="months[]">Febrero</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="3" id="months_3" name="months[]">Marzo</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="4" id="months_4" name="months[]">Abril</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="5" id="months_5" name="months[]">Mayo</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="6" id="months_6" name="months[]">Junio</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="7" id="months_7" name="months[]">Julio</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="8" id="months_8" name="months[]">Agosto</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="9" id="months_9" name="months[]">Septiembre</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="10" id="months_10" name="months[]">Octubre</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="11" id="months_11" name="months[]">Noviembre</label></li>
                                    <li><label class="checkbox"><input class="form-check-input" type="checkbox" value="12" id="months_12" name="months[]">Diciembre</label></li>
                                </ul>
                            </div>
                            <input type="button" class="btn btn-outline-secondary report-button" value="Obtener reporte" data-value="{{ route("reports.dashboard") }}">

                        </div>
                    </div>
                    <div class="row">
                        <div class="users-won-wrapp col-12">
                            <div class="users-won-inn p-3">
                                <h5 class="text-center">TOTAL GANADO</h5>
                                <h1 class="text-center">{{ number_format($totalWon, 2, ".","'") }}</h1>
                            </div>
                        </div>
                        <div class="users-won-wrapp col-6">
                            <div class="users-won-inn">
                                <h5 class="text-center">Ganado por usuario</h5>
                                <canvas
                                    id="users_won_canvas"
                                    class="canvas-report"
                                    width="800"
                                    height="800"
                                ></canvas>
                            </div>
                        </div>
                        <div class="services-won-wrapp  col-6">
                            <div class="services-won-inn">
                                <h5 class="text-center">Número de servicios ganados</h5>
                                <canvas
                                    id="services_won_canvas"
                                    class="canvas-report"
                                    width="800"
                                    height="800"
                                ></canvas>
                            </div>
                        </div>
                        <div class="companies-won-wrapp  col-6">
                            <div class="companies-won-inn">
                                <h5 class="text-center">Ganado por empresa</h5>
                                <canvas
                                    id="companies_won_canvas"
                                    class="canvas-report"
                                    width="800"
                                    height="800"
                                ></canvas>
                            </div>
                        </div>
                        <div class="stage-total-wrapp  col-6">
                            <div class="stage-total-inn">
                                <h5 class="text-center">Total por etapa</h5>
                                <canvas
                                    id="stages_total_canvas"
                                    class="canvas-report"
                                    width="800"
                                    height="800"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="users-opportunities-wrapp">
                        <div class="users-opportunities-inn">
                            <canvas
                                id="users_opportunities_sum_canvas"
                                class="canvas-report"
                                width="800"
                                height="800"
                            ></canvas>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Modal para agregar oportunidades -->
        <!-- The Modal -->
    @include('partials.modals.modalAddOpportunity')

    <!-- Modal para las notas -->
        <!-- The Modal -->
        <div class="modal" id="modalViewOpportunity">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Negocio</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body modal-ajax-content">a</div>

                </div>
            </div>
        </div>

    </div>
@endsection
@push('styles')
    <link rel="stylesheet"  href="{{ asset('/css/easy-autocomplete.min.css') }}">
    <link rel="stylesheet"  href="{{ asset('/css/easy-autocomplete.themes.min.css') }}">
    <link rel="stylesheet"  href="{{ asset('/css/Chart.min.css') }}">

@endpush
@push('scripts')
    <script type="text/javascript"  src="{{ asset('/js/jquery.easy-autocomplete.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('/js/Chart.min.js') }}"></script>


    <script>
        //VARIABLES
        let year ="{{ $year }}";
        let months = @json($months);
        var chartUserWon;
        var chartServicesWon;
        var chartCompaniesWon;
        var chartStagesTotal;


        var user_won_arr = @json($usersWon);
        var services_won_arr = @json($servicesWon);
        var companies_won_arr = @json($companiesWon);
        var stages_total_arr = @json($stagesTotal);

        console.log(companies_won_arr);
        console.log(stages_total_arr);

        //MODELS HTM WRAPPERS
        let users_won_canvas_html = "users_won_canvas";
        let services_won_canvas_html = "services_won_canvas";
        let companies_won_canvas_html = "companies_won_canvas";
        let stages_total_canvas_html = "stages_total_canvas";
        //TITLES
        let users_won_title = "Negocios ganados S/";
        let services_won_title = "Servicios ganados #";
        let companies_won_title = "Ganado por empresa S/";
        let stages_total_title = "Total en etapa S/";
        //CHART TYPES
        let users_won_chart_type = "bar";
        let services_won_chart_type = "pie";
        let companies_won_chart_type = "bar";
        let stages_total_chart_type = "bar";

        $(document).ready(function() {

            $(".year-period").html(year);
            $(".months-period").html(getMonthDescription(months));

            //USERS WON
            drawChart(user_won_arr, users_won_canvas_html, chartUserWon, users_won_title, users_won_chart_type);
            drawChart(services_won_arr, services_won_canvas_html, chartServicesWon, services_won_title, services_won_chart_type);
            drawChart(companies_won_arr, companies_won_canvas_html, chartCompaniesWon, companies_won_title, companies_won_chart_type);
            drawChart(stages_total_arr, stages_total_canvas_html, chartStagesTotal, stages_total_title, stages_total_chart_type);


            $('.report-button').on('click', function (e) {
                let base_href = $(this).attr("data-value");
                let year = $("#year").val();

                //CREATING MONTHS ARRAY
                let months = new Array();
                $('.months-list input[type=checkbox]').each(function() {
                    if ($(this).is(":checked")) {
                        months.push($(this).val());
                    }
                });

                //MONTHS ARRAY INTO COMMA SEPARATED STRNG
                months = months.toString();

                let complete_url = (base_href+"/"+year+"/"+months);

                console.log(base_href);
                console.log(year);
                console.log(months);
                console.log(complete_url);

                window.location.href = complete_url;

            });

        });







    </script>
@endpush
