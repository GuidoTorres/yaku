@extends('layouts.app', ['page' => 'users'])

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Información</th>
                    <th scope="col">Puesto</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}<br>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}<br>{{ $user->cellphone }}</td>
                        <td>{{ $user->position }}</td>
                        <td>
                            <a
                                class="btn btn-outline-info"
                                href="{{ route('users.admin', $user->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Ver usuario"
                            >
                                <i class="fa fa-info-circle"></i>
                            </a>
                            <a
                                class="btn btn-outline-info"
                                href="{{ route('users.edit', $user->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay usuarios disponibles")}}</td>
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
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
