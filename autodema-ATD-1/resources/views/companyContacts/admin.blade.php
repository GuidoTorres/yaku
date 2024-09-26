@extends('layouts.app', ['page' => 'companies'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Contacto"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-hover table-light">
                <tbody>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $companyContact->name." ".$companyContact->last_name }}</td>
                </tr>
                <tr>
                    <th>CORREO</th>
                    <td>{{ $companyContact->email }}</td>
                </tr>
                <tr>
                    <th>CELULAR</th>
                    <td>{{ $companyContact->cellphone }}</td>
                </tr>
                <tr>
                    <th>REGISTRÓ</th>
                    <td>{{ $companyContact->user->name." ".$companyContact->user->last_name }}</td>
                </tr>
                <tr>
                    <th>PROPIETARIO</th>
                    <td>{!! $companyContact->userOwner->name."<br> ".$companyContact->userOwner->last_name !!}</td>
                </tr>
                <tr>
                    <th>REGISTRÓ</th>
                    <td>{{ $companyContact->user->name." ".$companyContact->user->last_name }}</td>
                </tr>
                <tr>
                    <th>CREADO</th>
                    <td>{{ $companyContact->created_at }}</td>
                </tr>
                <tr>
                    <th>EMPRESA</th>
                    <td>
                        <a class="btn btn-outline-info" href="{{ route('companies.admin', $companyContact->company->id) }}">
                            {{ $companyContact->company->company_name }}
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
