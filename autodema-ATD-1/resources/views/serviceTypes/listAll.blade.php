@extends('layouts.app', ['page' => 'service-types'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.serviceTypes.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">
                        Servicio
                        <a
                            class="btn btn-third"
                            href="{{ route("serviceTypes.create") }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Precio S/</th>
                </tr>
                </thead>
                <tbody>
                @forelse($serviceTypes as $serviceType)
                    <tr>
                        <td>
                            <a href="{{ route('serviceTypes.admin', $serviceType->id) }}">{{ $serviceType->name }}</a>
                            <a
                                class="btn btn-edit"
                                href="{{ route('serviceTypes.edit', $serviceType->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar información del servicio"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a
                                class="btn btn-edit"
                                href="{{ route('additionals.listAll', $serviceType->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Agregar adicionales"
                            >
                                <i class="fa fa-plus"></i>
                            </a>

                        </td>
                        <td>{{ $serviceType->price }}</td>

                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay servicios disponibles")}}</td>
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
            {{ $serviceTypes->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
