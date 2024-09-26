@extends('layouts.app', ['page' => 'companies'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Empresa"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-hover table-light">
                <tbody>
                <tr>
                    <th>EMPRESA</th>
                    <td>{{ $company->company_name }}</td>
                </tr>
                <tr>
                    <th>FAN PAGE</th>
                    <td><a href="{{ $company->fanpage }}" target="_blank">{{ $company->fanpage }}</a></td>
                </tr>
                <tr>
                    <th>WEBSITE</th>
                    <td><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></td>
                </tr>
                <tr>
                    <th>CORREO</th>
                    <td>{{ $company->email }}</td>
                </tr>
                <tr>
                    <th>TELÉFONO</th>
                    <td>{{ $company->phone }}</td>
                </tr>
                <tr>
                    <th>GIRO DE LA EMPRESA</th>
                    <td>{{ $company->turn }}</td>
                </tr>
                <tr>
                    <th>REGISTRÓ</th>
                    <td>{{ $company->user->name." ".$company->user->last_name }}</td>
                </tr>
                @can('viewContacts', [\App\Company::class, $company])
                <tr>
                    <th>CONTACTOS</th>
                    <td>
                        <a class="btn btn-outline-info" href="{{ route("companyContacts.listCompany", $company->id) }}">
                            Ver
                        </a>
                        <a class="btn btn-outline-info" href="{{ route("companyContacts.create", $company->id) }}">
                            Crear
                        </a>
                    </td>
                </tr>
                </tbody>
                @endcan
                @can('viewOpportunities', [\App\Company::class, $company])
                <tr>
                    <th>OPORTUNIDADES</th>
                    <td>
                        <a class="btn btn-outline-info" href="{{ route("opportunities.listCompany", $company->id) }}">
                            Ver
                        </a>
                    </td>
                </tr>
                </tbody>
                @endcan
            </table>
        </div>
    </div>
@endsection
