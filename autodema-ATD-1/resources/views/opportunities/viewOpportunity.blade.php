@extends('layouts.app', ['page' => 'opportunitties'])

@section('content')
    <div class="container">
        <div class="row">

        </div>
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
        </div>




        <div class="opportunity-page-container-wrapp">

            <div class="opportunity-page-container-inn">
                <div class="opportunity-page-title-wrapp">
                    <div class="opportunity-page-title-inn text-center">
                        <div class="opportunity-page-title">
                            <div class="opportunity-page-title-dscr">
                                Cotización
                            </div>
                            <div class="opportunity-page-title-name">
                                {{ $opportunity->name }}
                            </div>
                            <h5 class="">
                                {{ $opportunity->code }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="opportunity-page-content-wrapp col-12">
                    <div class="opportunity-page-content-inn row">
                        <div class="col-4">
                            <div class="activities-section-wrapp">
                                <div class="activities-title-wrapp">
                                    <div class="activities-title-inn text-center">
                                        <div class="activities-title h3">Actividades
                                            <button class="btn btn-outline-info" data-toggle="modal" data-target="#modalAddActivity">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="activities-wrapp">
                                    <div class="activities-inn" id="activities-list">
                                        <!-- ACTIVITIES LIST-->
                                        @foreach($activities as $activity)
                                            <div class="card mb-2" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="fa fa-{{ $activity->activityType->icon }}"></i>
                                                        {{ $activity->name }}
                                                    </h5>
                                                    <h6 class="card-subtitle mb-2 text-muted" >
                                                        <a
                                                            type="button"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-html="true"
                                                            title='<div class="d-inline-flex w-100 justify-content-between"><b>Contacto</b><div type="button" class="btn close close-popover m-0 p-0" data-dismiss="popover">×</div></div>'
                                                            data-content="<div>Correo: {{ $activity->companyContact->email }}</div><div>Teléfono: {{ $activity->companyContact->cellphone }}</div>">
                                                            <i class="fa fa-user"></i> {{ $activity->companyContact->name }}
                                                        </a>

                                                        <a
                                                            href="{{ route('companyContacts.admin', $activity->companyContact->id) }}"
                                                            target="_blank"
                                                        >
                                                             <i class="fa fa-external-link"></i>
                                                        </a>
                                                    </h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">
                                                        <i class="fa fa-calendar"></i>
                                                        {{ \Carbon\Carbon::parse($activity->did_at )->format('d/m/Y \a \l\a\s h:i') }}
                                                    </h6>
                                                    <p
                                                        class="card-text activity-description"
                                                        id="activity-description-{{ $activity->id }}"
                                                    >{{ $activity->description }}</p>
                                                    <a class="card-link more_less d-none" href="#activity-description-{{ $activity->id }}"></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="detail-section-wrapp">
                                <div class="detail-title-wrapp">
                                    <div class="detail-title-inn text-center">
                                        <div class="detail-title h3">Detalle</div>
                                    </div>
                                </div>
                                <div class="detail-wrapp">
                                    <div class="detail-inn">
                                        <form class="form row" method="POST" action="{{ route('opportunities.update',$opportunity->id ) }}" novalidate>
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group col-6">
                                                <label for="name_o">Nombre</label>
                                                <input type="text" class="form-control" id="name_o" name="name" value="{{ $opportunity->name }}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="stage_id">Estado</label>
                                                <select
                                                    class="form-control"
                                                    name="stage_id"
                                                    id="stage_id"
                                                >
                                                    @foreach(\App\Stage::pluck('name', 'id') as $id => $name)
                                                        <option
                                                            {{ $opportunity->stage->id === $id ? 'selected' : '' }}
                                                            value="{{ $id }}"
                                                        >{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="name">Empresa</label>
                                                <div class=" " id="name">
                                                    <a href="{{ route("companies.admin", $opportunity->company->id) }}">{{ $opportunity->company->company_name }}</a>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="company_contact_id">Contacto de empresa</label>
                                                <select
                                                    class="form-control"
                                                    name="company_contact_id"
                                                    id="company_contact_id"
                                                >
                                                    @foreach(\App\CompanyContact::where("company_id", $opportunity->company->id)->pluck('name', 'id') as $id => $name)
                                                        <option
                                                            {{ $opportunity->companyContact->id === $id ? 'selected' : '' }}
                                                            value="{{ $id }}"
                                                        >{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="opportunity_type_id">Tipo de negocio</label>
                                                <select
                                                    class="form-control"
                                                    name="opportunity_type_id"
                                                    id="opportunity_type_id"
                                                >
                                                    @foreach(\App\OpportunityType::pluck('name', 'id') as $id => $name)
                                                        <option
                                                            {{ $opportunity->opportunityType->id === $id ? 'selected' : '' }}
                                                            value="{{ $id }}"
                                                        >{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="campaign_id">Campaña</label>
                                                <select
                                                    class="form-control"
                                                    name="campaign_id"
                                                    id="campaign_id"
                                                >
                                                    @foreach(\App\Campaign::pluck('name', 'id') as $id => $name)
                                                        <option
                                                            {{ $opportunity->campaign->id === $id ? 'selected' : '' }}
                                                            value="{{ $id }}"
                                                        >{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="user_owner_id">Propietario</label>
                                                <select
                                                    class="form-control"
                                                    name="user_owner_id"
                                                    id="user_owner_id"
                                                >
                                                    @foreach(\App\User::pluck('name', 'id') as $id => $name)
                                                        <option
                                                            {{ $opportunity->userOwner->id === $id ? 'selected' : '' }}
                                                            value="{{ $id }}"
                                                        >{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="name">Creó</label>
                                                <div class=" " id="name">{{ $opportunity->user->name }}</div>
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="budget">Presupuesto de cliente</label>
                                                <input type="text" class="form-control" id="budget" name="budget" value="{{ $opportunity->getRawOriginal("budget") }}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="service_price">Propuesta económica</label>
                                                <input type="text" class="form-control" id="service_price" name="service_price" value="{{ $opportunity->getRawOriginal("service_price") }}">
                                            </div>


                                            <div class="form-group col-6">
                                                <label for="probability">Percepción de venta</label>
                                                <select
                                                    class="form-control"
                                                    name="probability"
                                                    id="probability"
                                                >
                                                    <option value="1" {{ $opportunity->probability === 1 ? 'selected' : '' }}>Muy baja</option>
                                                    <option value="2" {{ $opportunity->probability === 2 ? 'selected' : '' }}>Baja</option>
                                                    <option value="3" {{ $opportunity->probability === 3 ? 'selected' : '' }}>Media</option>
                                                    <option value="4" {{ $opportunity->probability === 4 ? 'selected' : '' }}>Alta</option>
                                                    <option value="5" {{ $opportunity->probability === 5 ? 'selected' : '' }}>Muy alta</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="service_price">Cerrada</label>
                                                <div class=" " id="name">{{ $opportunity->closed_at }}</div>
                                            </div>

                                            <div class="form-group col-12 text-center">
                                                <div
                                                    data-toggle="dropdown"
                                                    class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                >Servicios ofrecidos</div>
                                                <ul class="dropdown-menu dropdown-menu-form dropdown-services-list">
                                                    @foreach(\App\ServiceType::pluck('name', 'id') as $id => $name)
                                                        <li>
                                                            <label class="checkbox">
                                                                <input
                                                                    class="form-check-input service-type-check"
                                                                    type="checkbox"
                                                                    value="{{ $id }}"
                                                                    id="service_type_{{ $id }}"
                                                                    data-id="{{ $id }}"
                                                                    name="service_types[]"
                                                                    {{ in_array($id, $serviceTypesArr) ? 'checked' : '' }}
                                                                >{{ $name }}
                                                            </label>
                                                        </li>
                                                        @foreach(\App\Additional::where("service_type_id", $id)->pluck('name', 'id') as $id_additional => $name_additional)
                                                            <li
                                                                class="dropdown-service-type-additionals dropdown-service-type-{{ $id }}"
                                                                {!! in_array($id, $serviceTypesArr) ? 'style="display: list-item;"' : '' !!}
                                                            >
                                                                <label class="checkbox">
                                                                    <input
                                                                        class="form-check-input"
                                                                        data-service=""
                                                                        type="checkbox"
                                                                        value="{{ $id_additional }}"
                                                                        id="additional_{{ $id_additional }}"
                                                                        name="additionals[]"
                                                                        {{ in_array($id_additional, $additionalssArr) ? 'checked' : '' }}
                                                                    >{{ $name_additional }}
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="form-group col-12">

                                            </div>
                                            <div class="form-group col-12 text-center pt-3">
                                                <input type="submit" class="btn btn-outline-secondary" value="Guardar">
                                            </div>

                                            <div class="form-group col-12">
                                                <div class="d-inline-block">Cotización</div>
                                                <div class="d-inline-block">
                                                    @if($opportunity->quotation)
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            target="_blank"
                                                            href="{{ route('documents.editDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::QUOTATION,"documentType"=>\App\Document::DOCS  ]) }}">Editar</a>
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            target="_blank"
                                                            href="{{ route('documents.downloadDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::QUOTATION ]) }}">Descargar</a>
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            href="{{ route('documents.createOpportunityDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::QUOTATION,"documentType"=>\App\Document::DOCS ]) }}">Crear nuevamente</a>


                                                    @else
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            href="{{ route('documents.createOpportunityDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::QUOTATION,"documentType"=>\App\Document::DOCS ]) }}">Crear</a>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="d-inline-block">Contrato</div>
                                                <div class="d-inline-block">
                                                    @if($opportunity->contract)
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            target="_blank"
                                                            href="{{ route('documents.editDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::CONTRACT,"documentType"=>\App\Document::DOCS ]) }}">Editar</a>
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            target="_blank"
                                                            href="{{ route('documents.downloadDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::CONTRACT ]) }}">Descargar</a>
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            href="{{ route('documents.createOpportunityDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::CONTRACT ,"documentType"=>\App\Document::DOCS ]) }}">Crear nuevamente</a>
                                                    @else
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            href="{{ route('documents.createOpportunityDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::CONTRACT ,"documentType"=>\App\Document::DOCS ]) }}">Crear</a>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="d-inline-block">Orden de trabajo</div>
                                                <div class="d-inline-block">
                                                    @if($opportunity->work_order)
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            target="_blank"
                                                            href="{{ route('documents.editDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::WORK_ORDER,"documentType"=>\App\Document::SHEETS ]) }}">Editar</a>
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            target="_blank"
                                                            href="{{ route('documents.downloadDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::WORK_ORDER ]) }}">Descargar</a>
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            href="{{ route('documents.createOpportunityDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::WORK_ORDER,"documentType"=>\App\Document::SHEETS ]) }}">Crear nuevamente</a>

                                                    @else
                                                        <a
                                                            class="btn btn-outline-secondary"
                                                            href="{{ route('documents.createOpportunityDocument', ["opportunity"=>$opportunity->id,"type"=>\App\Document::WORK_ORDER,"documentType"=>\App\Document::SHEETS ]) }}">Crear</a>

                                                    @endif
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para agregar oportunidades -->
        <!-- The Modal -->
    @include('partials.modals.modalAddActivity')

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
    <script>
        $(document).on('click', '.dropdown-services-list', function (e) {
            e.stopPropagation();
        });

        $(document).ready(function() {
            //SHOW MORE LESS
            // Configure/customize these variables.
            var showChar = 50;  // How many characters are shown by default
            var ellipsestext = "...";
            var moretext = "Ver más";
            var lesstext = "Ver menos";
            $('.activity-description').each(function() {
                var content = $(this).html();
                //console.log("content"+content+"lenght"+content.length);
                if(content.length > showChar) {
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="#" class="morelink">' + moretext + '</a></span>';
                    $(this).html(html);
                }
            });
            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
            //SHOW MORE LESS

            $(document).on('keyup', "input.search_input",function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let element = $(this);
                    search(element, e);
                }
            });

            //SHOW ADDITIONALS PER SERVICE TYPE
            $('body').on('click', '.service-type-check', function() {
                let element = $(this);
                let element_data_id = element.attr("data-id");
                let element_status = element.is(":checked");
                console.log( element_data_id );
                console.log( element_status );

                if(element_status){
                    $(".dropdown-service-type-"+element_data_id).show();
                }else{
                    $(".dropdown-service-type-"+element_data_id).hide();


                    $(".dropdown-service-type-"+element_data_id+" input").prop('checked', false);
                }
            });




        });



    </script>
@endpush
