@extends('layouts.app', ['page' => 'service-types'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.additionals.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Adicional

                        <a
                            class="btn btn-third"
                            href="{{ route("additionals.create", $serviceType->id) }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Precio S/</th>
                </tr>
                </thead>
                <tbody>
                @forelse($additionals as $additional)
                    <tr>
                        <td>
                            <a href="{{ route('additionals.admin', $additional->id) }}">{{ $additional->name }}</a>
                            <a
                                class="btn btn-edit"
                                href="{{ route('additionals.edit', $additional->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar información del servicio"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>{{ $additional->price }}</td>
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
            <a class="btn btn-outline-secondary" href="{{ route('serviceTypes.listAll') }}">Ver servicios</a>
        </div>
        <div class="row justify-content-center">
            {{ $additionals->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
