<div class="modal" id="modalAddOpportunity">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Negocio</h4>
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
                        <label for="name">Título de negocio</label>
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
                                            class="form-check-input"
                                            type="checkbox"
                                            value="{{ $id }}"
                                            id="service_type_{{ $id }}"
                                            name="service_types[]"
                                        >{{ $name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="probability">Probabilidad</label>
                        <select
                            class="form-control"
                            name="probability"
                            id="probability"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                            <option value="70">70</option>
                            <option value="80">80</option>
                            <option value="90">90</option>
                            <option value="100">100</option>
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
                        <label for="service_price">Costo del servicio</label>
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
                        <button type="submit" class="btn btn-danger">
                            Agregar
                        </button>
                    </div>

                </form>


            </div>

        </div>
    </div>
</div>
