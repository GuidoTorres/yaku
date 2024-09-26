@extends('layouts.app', ['page' => 'companies'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Nuevo contacto de  ").$company->company_name,
                    'icon' => "building"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $companyContact->id ? route('companyContacts.store'): route('companyContacts.update', $companyContact->id) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @if($companyContact->id)
                @method('PUT')
            @endif

            @csrf
            <div class="form-group d-none">
                <label for="company_id">Empresa</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('company_id') ? 'is-invalid': '' }}"
                    name="company_id"
                    id="company_id"
                    value="{{ old('company_id') ?: $company->id }}"
                >
                @if($errors->has('company_id'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('company_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="name">Nombres</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}"
                    name="name"
                    id="name"
                    value="{{ old('name') ?: $companyContact->name }}"
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
                    value="{{ old('last_name') ?: $companyContact->last_name }}"
                >
                @if($errors->has('last_name'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">Correo</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('email') ? 'is-invalid': '' }}"
                    name="email"
                    id="email"
                    value="{{ old('email') ?: $companyContact->email }}"
                >
                @if($errors->has('email'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
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
                    value="{{ old('cellphone') ?: $companyContact->cellphone }}"
                >
                @if($errors->has('cellphone'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('cellphone') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="principal">Contacto principal</label>
                <select
                    class="form-control {{ $errors->has('principal') ? 'is-invalid': '' }}"
                    name="principal"
                    id="principal"
                    required
                >
                    <option
                        {{ (int) old('principal') === \App\CompanyContact::SECONDARY || $companyContact->principal === \App\CompanyContact::SECONDARY ? 'selected' : '' }}
                        value="{{ \App\CompanyContact::SECONDARY }}"
                    >No</option>
                    <option
                        {{ (int) old('principal') === \App\CompanyContact::PRINCIPAL || $companyContact->principal === \App\CompanyContact::PRINCIPAL ? 'selected' : '' }}
                        value="{{ \App\CompanyContact::PRINCIPAL }}"
                    >Si</option>
                </select>
            </div>
            <div class="form-group">
                <label for="user_owner_id">Propietario</label>
                <select
                    class="form-control {{ $errors->has('user_owner_id') ? 'is-invalid': '' }}"
                    name="user_owner_id"
                    id="user_owner_id"
                    required
                >
                    @foreach(\App\User::pluck('name', 'id') as $id => $name)
                        <option
                                @if(old('user_owner_id'))
                                    {{ (int) old('user_owner_id') === $id ? 'selected' : '' }}
                                @elseif($companyContact->id)
                                    {{ (int) $companyContact->user_owner_id === $id ? 'selected' : '' }}
                                @else
                                    {{ (int) auth()->id() === $id ? 'selected' : '' }}
                                @endif
                            value="{{ $id }}"
                        >{{ $name }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <button type="submit" class="btn btn-thales-secondary">
                    {{ __($btnText) }}
                </button>
            </div>

        </form>

    </div>
@endsection
