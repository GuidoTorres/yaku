@extends('layouts.app', ['page' => 'users'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Nuevo usuario"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $user->id ? route('users.store'): route('users.update', $user->id) }}"
            novalidate
        >
            @if($user->id)
                @method('PUT')
            @endif

            @csrf
            <div class="form-group">
                <label for="role_id">Rol</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('role_id') ? 'is-invalid': '' }}"
                    name="role_id"
                    id="role_id"
                >
                    @foreach(\App\Role::pluck('name', 'id') as $id => $name)
                        <option
                            {{ (int) old('role_id') === $id || $user->role_id === $id ? 'selected' : '' }}
                            value="{{ $id }}"
                        >{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Nombres</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}"
                    name="name"
                    id="name"
                    placeholder=""
                    value="{{ old('name') ?: $user->name }}"
                    required
                >
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="last_name">Apellidos</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('last_name') ? 'is-invalid': '' }}"
                    name="last_name"
                    id="last_name"
                    placeholder=""
                    value="{{ old('last_name') ?: $user->last_name }}"
                    required
                >
                @if($errors->has('last_name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="cellphone">Celular</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('cellphone') ? 'is-invalid': '' }}"
                    name="cellphone"
                    id="cellphone"
                    placeholder=""
                    value="{{ old('cellphone') ?: $user->cellphone }}"
                    required
                >
                @if($errors->has('cellphone'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('cellphone') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input
                    type="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid': '' }}"
                    name="email"
                    id="email"
                    placeholder=""
                    value="{{ old('email') ?: $user->email }}"
                >
                @if($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="text">Contraseña</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('password') ? 'is-invalid': '' }}"
                    name="password"
                    id="password"
                    placeholder=""
                    value=""
                    required
                >
                @if($errors->has('password'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            @foreach(range(1, 3) as $number)
            <div class="form-group parameter-user parameter-1">
                <label for="parameter_{{ $number }}">Parámetro {{ $number }}</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('parameter_'.$number) ? 'is-invalid': '' }}"
                    name="parameter_{{ $number }}"
                    id="parameter_{{ $number }}"
                >
                    <option value="0">Elige el parámetro</option>
                    @foreach(\App\Parameter::pluck('name', 'id') as $id => $name)
                        <option
                            {{ (int) old('parameter_'.$number) === $id
                            ||
                            ( isset($parameters[$number -1]) && $parameters[$number -1] === $id  )  ? 'selected' : '' }}
                            value="{{ $id }}"
                        >{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
            <div class="form-group">
                <label for="state">Estado</label>
                <select
                    class="form-control {{ $errors->has('state') ? 'is-invalid': '' }}"
                    name="state"
                    id="state"
                    required
                >
                    <option
                        {{
                            (int) old('state') === \App\User::ACTIVE
                            ||
                            (int) $user->state === \App\User::ACTIVE
                            ?
                            'selected' : ''
                        }}
                        value="{{ \App\User::ACTIVE }}"
                    >Activo</option>
                    <option
                        {{
                            (int) old('state') === \App\User::INACTIVE
                            ||
                            (int) $user->state === \App\User::INACTIVE
                            ?
                            'selected' : ''
                        }}
                        value="{{ \App\User::INACTIVE }}"
                    >Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary">
                    {{ __($btnText) }}
                </button>
            </div>

        </form>

    </div>
@endsection

@push('scripts')
    <script>

        $(document).ready(function() {
            var role_selected = $("#role_id").val();
            showParameters(role_selected);
            $("#role_id").on('input change', function (e) {
                var role_selected = $("#role_id").val();
                showParameters(role_selected);
            });
        });

        function showParameters(role){
            if(role == 5){
                $(".parameter-user").show();
            }else{
                $(".parameter-user").hide();
            }
        }
    </script>
@endpush
