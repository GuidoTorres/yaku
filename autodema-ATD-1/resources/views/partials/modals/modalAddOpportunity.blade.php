<div class="modal" id="modalAddOpportunity">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Cotización</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form
                    method="POST"
                    action="{{ route('opportunities.store') }}"
                    novalidate
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="form-group">
                        <label for="name">Asunto de cotización</label>
                        <input
                            type="name"
                            class="form-control"
                            name="name"
                            id="name"
                            placeholder=""
                            autocomplete="off"
                        >
                    </div>


                    <div class="form-group">
                        <label for="company_name">Empresa (Ingrese el nombre y selecciónelo de la lista)</label>
                        <input
                            type="text"
                            class="form-control"
                            name="company_name"
                            id="company_name"
                            placeholder=""
                            value=""
                            required
                            autocomplete="off"
                        >
                    </div>
                    <div class="form-group d-none">
                        <label for="company_id">Id de empresa</label>
                        <input
                            type="text"
                            class="form-control"
                            name="company_id"
                            id="company_id"
                            placeholder=""
                            value=""
                            required
                            autocomplete="off"
                        >
                    </div>
                    <div class="form-group">
                        <label for="company_contact_id">Contacto</label>
                        <select
                            class="form-control"
                            name="company_contact_id"
                            id="company_contact_id"
                        >
                            <option value="0">Seleccione una empresa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="opportunity_type_id">Tipo de oportunidad</label>
                        <select
                            class="form-control"
                            name="opportunity_type_id"
                            id="opportunity_type_id"
                        >
                            @foreach(\App\OpportunityType::pluck('name', 'id') as $id => $name)
                                <option
                                    value="{{ $id }}"
                                >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="campaign_id">Campaña</label>
                        <select
                            class="form-control"
                            name="campaign_id"
                            id="campaign_id"
                        >
                            @foreach(\App\Campaign::orderBy("id", "desc")->where("state", \App\Campaign::ACTIVE)->pluck('name', 'id') as $id => $name)
                                <option
                                    value="{{ $id }}"
                                >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stage_id">Etapa de negocio</label>
                        <select
                            class="form-control"
                            name="stage_id"
                            id="stage_id"
                        >
                            @foreach(\App\Stage::pluck('name', 'id') as $id => $name)
                                <option
                                    value="{{ $id }}"
                                >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Servicios ofrecidos: </label>
                        <div
                            data-toggle="dropdown"
                            class="btn btn-outline-secondary dropdown-toggle" type="button"
                        >Seleccionar servicios</div>
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
                                        >{{ $name }}
                                    </label>
                                </li>

                                @foreach(\App\Additional::where("service_type_id", $id)->pluck('name', 'id') as $id_additional => $name_additional)
                                    <li class="dropdown-service-type-additionals dropdown-service-type-{{ $id }}">
                                        <label class="checkbox">
                                            <input
                                                class="form-check-input"
                                                data-service=""
                                                type="checkbox"
                                                value="{{ $id_additional }}"
                                                id="additional_{{ $id_additional }}"
                                                name="additionals[]"
                                            >{{ $name_additional }}
                                        </label>
                                    </li>
                                @endforeach

                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="probability">Percepción de venta</label>
                        <select
                            class="form-control"
                            name="probability"
                            id="probability"
                        >
                            <option value="1">Muy baja</option>
                            <option value="2">Baja</option>
                            <option value="3">Media</option>
                            <option value="4">Alta</option>
                            <option value="5">Muy alta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="budget">Presupuesto de cliente</label>
                        <input
                            type="number"
                            class="form-control"
                            name="budget"
                            id="budget"
                            placeholder=""
                            autocomplete="off"
                        >
                    </div>
                    <div class="form-group">
                        <label for="service_price">Precio de cotización</label>
                        <input
                            type="number"
                            class="form-control"
                            name="service_price"
                            id="service_price"
                            placeholder=""
                            autocomplete="off"
                        >
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-third btn-add-opp-db">
                            Agregar
                        </button>
                    </div>

                </form>


            </div>

        </div>
    </div>
</div>

<script>
    $(function() {
        console.log( "ready!" );

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
