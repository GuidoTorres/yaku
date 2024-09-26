@extends('layouts.app', ['page' => 'opportunitties'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.opportunities.search')
        </div>
        <div class="row justify-content-center">

            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Oportunidad

                        <a
                            href="#modalAddOpportunity"
                            class="btn btn-third"
                            data-toggle="modal" data-target="#modalAddOpportunity"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Etapa</th>
                    <th scope="col">Primer contacto</th>
                    <th scope="col">Último contacto</th>
                    <th scope="col">Cerrado</th>
                    <th scope="col"><div class="d-block">Precio S/</div></th>
                    <th scope="col">Propietario</th>
                </tr>
                </thead>
                <tbody>
                @forelse($opportunities as $opportunity)
                    <tr>
                        <td><a href="{{ route('opportunities.viewOpportunity',$opportunity->id ) }}">{{ $opportunity->name }}</a></td>
                        <td><a href="{{ route('companies.admin',$opportunity->company->id ) }}">{{ $opportunity->company->company_name }}</a></td>
                        <td>{{ $opportunity->stage->name }}</td>
                        <td>{{ ($first_activity = $opportunity->activities()->orderBy('did_at','asc')->first() )  ?  $first_activity->did_at:'Aún no se contactó'}}</td>
                        <td>{{ ($last_activity = $opportunity->activities()->orderBy('did_at','desc')->first() )  ?  $last_activity->did_at:'Aún no se contactó'}}</td>
                        <td>{{ ($closed_at = $opportunity->closed_at) ? $closed_at : "Aún no se cierra"   }}</td>
                        <td>{{ $opportunity->service_price }}</td>
                        <td>{{ $opportunity->userOwner->name." ".$opportunity->userOwner->last_name }}</td>

                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay clientes disponibles")}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Modal para las notas -->
        <!-- The Modal -->
        <div class="modal" id="modalNotes">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Notas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body modal-ajax-content"></div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            {{ $opportunities->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @include('partials.modals.modalAddOpportunity')

@endsection
@push('styles')
    <link rel="stylesheet"  href="{{ asset('/css/easy-autocomplete.min.css') }}">
    <link rel="stylesheet"  href="{{ asset('/css/easy-autocomplete.themes.min.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript"  src="{{ asset('/js/jquery.easy-autocomplete.min.js') }}"></script>
    <script>
    //VARIABLES

    let company_contacts_route = "{{ route('companyContacts.getCompanyContactsAjax') }}";

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



    });



    </script>

@endpush
