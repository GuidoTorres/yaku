@extends('layouts.app', ['page' => 'opportunitties'])

@section('content')
    <div class="container container-dashboard-opp">
        <div class="row justify-content-center" style="background-color: inherit">

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
            <div class="opportunities-wrapp">
                <div class="opportunities-inn">

                    <!-- OPPORTUNITIES HEAD -->
                    <div class="opportunities-head-wrapp">
                        <div class="opportunities-head-inn">
                            <!-- OPPORTUNITIES HEAD TITLE -->
                            <div class="opportunities-head-tit-wrapp">
                                <div class="opportunities-head-tit-inn">
                                    <div class="opportunities-head-tit">
                                        <a
                                            class="" href="{{ route('opportunities.listAll') }}"
                                        >Ver como lista</a>
                                    </div>
                                </div>
                            </div>
                            <!-- OPPORTUNITIES HEAD SEARCH -->
                            <div class="opportunities-head-srch-wrapp">
                                <div class="opportunities-head-srch-inn">
                                    <form class="opportunities-head-srch d-inline-block" method="GET" action="{{ route('opportunities.search', $userDashboard) }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search_input" placeholder="Buscar oportunidad">
                                            <div class="input-group-append">
                                                <button class="btn btn-third" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @cannot('viewOnlyHis', \App\Opportunity::class)
                                    <div class="form-inline d-inline-block">
                                        <select class="form-control user-dashboard" name="" id="">
                                            <option

                                                value="{{ route('opportunities.dashboard') }}"
                                            >Todos</option>
                                            @foreach(\App\User::where('id', '>', \App\User::DEVELOPER)->pluck('name', 'id') as $id=>$name)
                                                <option
                                                    @if($userDashboard)
                                                    {{ $userDashboard->id === $id ? 'selected' : '' }}
                                                    @endif
                                                    value="{{ route('opportunities.dashboard', $id) }}"
                                                >{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endcannot
                                </div>
                            </div>
                            <!-- OPPORTUNITIES HEAD TITLE -->
                            <div class="opportunities-add-wrapp">
                                <div class="opportunities-add-inn">
                                    <button class="btn btn-third btn-add-opp-db" data-toggle="modal" data-target="#modalAddOpportunity">Agregar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- OPPORTUNITIES BODY -->
                    <div class="opportunities-body-wrapp">
                        <div class="opportunities-body-inn">

                        @foreach($stages as $stage)
                            <!-- OPPORTUNITIES STAGE -->
                            <div class="opportunities-stage-wrapp" data-id="{{ $stage->id }}">
                                <div class="opportunities-stage-inn">
                                    <!-- OPPORTUNITIES STAGE TITLE-->
                                    <div class="opportunities-stage-title-wrapp">
                                        <div class="opportunities-stage-title-inn">
                                            <div class="opportunities-stage-title">
                                                {{ $stage->name }} ( <span class="opportunities-stage-count">{{ $stage->opportunities()->count()  }} </span> )
                                            </div>
                                            <div class="arrow-right"></div>
                                        </div>
                                    </div>
                                    <!-- OPPORTUNITIES STAGE BODY-->

                                    <div class="opportunities-stage-body opportunities-stage-body-{{ $stage->id }} ">
                                        <!-- STAGE OPPORTUNITIES LIST-->
                                        <!-- FILLED WITH AJAX -->
                                        <!-- FROM TEMPLATE ID = opportunity-template -->
                                        <!-- WITH FUNCTION addStageList -->


                                    </div>
                                    <!-- OPPORTUNITIES STAGE FOOTER-->
                                    <div class="opportunity-stage-footer-wrapp">
                                        <div class="opportunity-stage-footer-inn">
                                            <div class="opportunity-stage-footer opportunity-stage-footer">
                                                Total: S/ <span class="opportunity-stage-total-amount-{{ $stage->id }}">Cargando...</span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @endforeach


                        </div>
                    </div>

                </div>
            </div>

        </div>



        <div class="opportunities-activities-ext">
            <div class="opportunities-activities-wrap">
                <div class="opportunities-activities-inn">
                    <div class="opportunities-activities-title">
                        <div>Paquete de consultoría total</div>
                    </div>
                    <div class="opportunities-activities-subtitle">
                        Actividades
                    </div>
                    <div class="opportunities-activities-body">
                        <div class="opportunities-activities-list">

                            @for($i = 1; $i<5; $i++)
                            <div class="opportunities-activity">
                                <div class="opportunity-activity-detail opportunity-activity-date">24 de marzo del 2016</div>
                                <div class="opportunity-activity-detail opportunity-activity-user"><i class="fa fa-user"></i> Heser León</div>
                                <div class="opportunity-activity-detail opportunity-activity-name"><i class="fa fa-envelope"></i> Llamada en frío</div>
                            </div>
                            @endfor

                        </div>


                    </div>


                </div>

            </div>
        </div>

        <div id="opportunity-template" class="d-none">
            <!-- STAGE OPPORTUNITY-->
            <div class="opportunity-wrapp">
                <div class="opportunity-inn">

                    <div class="card border-secondary mb-3" style="max-width: 18rem;">
                        <div class="card-header">
                            <span class="opportunity-single-title">NAME </span>
                            <a
                                target="_blank"
                                href="#"
                                data-href="{{ route("opportunities.viewOpportunity", "replace") }}"
                                class="view-opportunity"

                            >
                                 <i class="fa fa-info-circle"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-title h5">
                                <div class="opportunity-single-company">COMPANY</div>
                            </div>
                            <div class="card-text">
                                S/<span class="opportunity-single-price">PRICE</span>
                            </div>
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
@endpush
@push('scripts')
    <script type="text/javascript"  src="{{ asset('/js/jquery.easy-autocomplete.min.js') }}"></script>

    <script>
        //VARIABLES
        let userDashboard = {{ $userDashboard? $userDashboard->id:0 }};
        let opportunity = 0;
        let company = 0;
        let search_input = "{{ isset($search_input) ? $search_input : "" }}";


        //MODELS AJAX ROUTES
        let stage_list_route = "{{ route('opportunities.listStageAjax') }}";
        let stage_price_route = "{{ route('opportunities.getStageTotalAjax') }}";
        let opportunity_update_route = "{{ route('opportunities.updateOpportunityAjax') }}";
        let company_contacts_route = "{{ route('companyContacts.getCompanyContactsAjax') }}";
        //MODELS HTM WRAPPERS
        let opportunities_stage_html = "opportunities-stage-wrapp";
        let opportunities_html_wrapper = "opportunities-stage-body";
        let opportunities_price_html_wrapper = "opportunity-stage-total-amount";



        $(document).ready(function() {

            //////AUTOCOMPLETE SETUP///////
            //DEFINIMOS LAS EMPRESAS COMO JSON

            var companies = @json($companies);
            console.log(companies);


            let company_options = [];
            $.each(companies, function (key, element) {
                let company_obj = {id:element.id, name: element.company_name};
                company_options.push(company_obj);
            });
            console.log(company_options);
            var options = {
                data: company_options,
                getValue: "name",
                list: {
                    onSelectItemEvent: function() {
                        var value = $("#company_name").getSelectedItemData().id;
                        $("#company_id").val(value).trigger("change");
                    },
                    match: {
                        enabled: true
                    },
                    maxNumberOfElements: 5,
                }
            };
            $("#company_name").easyAutocomplete(options);

            $('#company_id').on('input change', function (e) {
                $('#company_contact_id').html("Cargando...");
                let company = $(this).val();

                addCompanyContacts(company, company_contacts_route);
            });

            //////AUTOCOMPLETE SETUP///////



            //GET DASHBOARD OF USER
            $('.user-dashboard').on('change', function (e) {
                let user_dashboard = $(this).val();

                window.location.href = user_dashboard;
            });
            $( ".opportunities-stage-wrapp" ).each(function( index ) {
                let stage_id = $(this).attr("data-id");
                addStageList(stage_id, stage_list_route, opportunities_stage_html, opportunities_html_wrapper, search_input, userDashboard);
                addTotalPrice(stage_id, stage_price_route, opportunities_price_html_wrapper, search_input, userDashboard);
                console.log( "Stage ID: "+stage_id);
            });

            $(document).on('click', '.search-button', function(e){
                e.preventDefault();
                let element = $(this);
                search(element, e);
            });
            $(document).on('keyup', "input.search_input",function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let element = $(this);
                    search(element, e);
                }
            });






        });



    </script>
@endpush
