@extends('layouts.app', ['page' => 'users'])

@section('content')
<div class="container">
    <div class="row">
        @include('partials.users.search')
    </div>
    <div class="row justify-content-center">
        <table class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Usuario
                        <a class="btn btn-plus" href="{{ route("users.create") }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Información</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Parametros</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>

                        <a href="{{ route('users.admin', $user->id) }}">
                            {{ $user->name." ".$user->last_name }}
                        </a>
                        <a class="btn btn-edit" href="{{ route('users.edit', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>{{ $user->email }}<br>{{ $user->cellphone }}</td>
                    <td style="text-transform: capitalize">{{ $user->role->name }}</td>
                    <td>
                        @if($user->role_id == 5)
                            <a class="btn btn-edit" href="{{ route('users.listUserParameters', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                <i class="fa fa-pencil"></i>
                            </a>
                        @endif
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
