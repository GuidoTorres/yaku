@extends('layouts.app', ['page' => 'roles'])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Roles</th>
                    <th scope="col">Parámetros </th>
                </tr>
                </thead>
                <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>

                            @if($role->id == 5)
                                <a class="btn btn-edit" href="{{ route('roles.listRoleParameters', $role->id) }}" data-toggle="tooltip" data-placement="top" title="Editar">
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
            {{ $roles->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
