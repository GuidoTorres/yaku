@extends('layouts.app', ['page' => 'companies'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.companies.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>s
                <tr>
                    <th scope="col">Empresa
                        <a
                            class="btn btn-third"
                            href="{{ route("companies.create") }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Información</th>
                    <th scope="col">Ver</th>
                </tr>
                </thead>
                <tbody>
                @forelse($companies as $company)
                    <tr>
                        <td>
                            <a href="{{ route('companies.admin', $company->id) }}">{{ $company->company_name }}</a>

                            @can('update', [\App\Company::class, $company])
                                <a
                                    class="btn btn-edit"
                                    href="{{ route('companies.edit', $company->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Editar información del cliente"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endcan

                        </td>
                        <td>{{ $company->phone }}<br>{{ $company->email }}</td>
                        <td>
                            <div class="btn-group">
                                @can('viewContacts', [\App\Company::class, $company])
                                <a
                                    class="btn btn-outline-info"
                                    href="{{ route('companyContacts.listCompany', $company->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Contactos"
                                >
                                    <i class="fa fa-users"></i>
                                </a>
                                @endcan
                                @can('viewOpportunities', [\App\Company::class, $company])
                                <a
                                    class="btn btn-outline-info"
                                    href="{{ route('opportunities.listCompany', $company->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Oportunidades"
                                >
                                    <i class="fa fa-briefcase"></i>
                                </a>
                                @endcan
                            </div>
                        </td>
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
            {{ $companies->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
