@extends('layouts.app', ['page' => 'companies'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.comanyContacts.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Contacto

                        <a
                            class="btn btn-third"
                            href="{{ route("companyContacts.create", $company->id) }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Información</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Ver</th>
                </tr>
                </thead>
                <tbody>
                @forelse($companyContacts as $companyContact)
                    <tr>
                        <td>{{ $companyContact->name." ".$companyContact->last_name }}</td>
                        <td>{{ $companyContact->cellphone }}<br>{{ $companyContact->email }}</td>
                        <td>{!! $companyContact->userOwner->name."<br> ".$companyContact->userOwner->last_name !!}</td>
                        <td>
                            <div class="btn-group mb-2">
                                <a
                                    class="btn btn-outline-info"
                                    href="{{ route('companyContacts.admin', $companyContact->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Ver detalle"
                                >
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                <a
                                    class="btn btn-outline-info"
                                    href="{{ route('companyContacts.edit', $companyContact->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Editar información"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
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
            <a class="btn btn-outline-secondary" href="{{ route('companies.admin', $company->id) }}">Ver empresa</a>
        </div>
        <div class="row justify-content-center">
            {{ $companyContacts->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
