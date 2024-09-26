@extends('layouts.app', ['page' => 'users'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Usuario"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-hover table-light">
                <tbody>
                <tr>
                    <th>NOMBRES</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>APELLIDOS</th>
                    <td>{{ $user->last_name }}</td>
                </tr>
                <tr>
                    <th>CORREO</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>CELULAR</th>
                    <td>{{ $user->cellphone }}</td>
                </tr>
                <tr>
                    <th>ESTADO</th>
                    <td>
                        @if($user->state == \App\User::ACTIVE)
                            Activo
                        @elseif($user->state == \App\User::INACTIVE)
                            Inactivo
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>CREADO</th>
                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
