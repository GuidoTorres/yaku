@extends('layouts.app', ['page' => 'sampling-points'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => $type_title,
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>IDENTIFICACIÓN</th>
                    <td>{{ $samplingPoint->name }}</td>
                </tr>
                <tr>
                    <th>UNIDAD HIDROGRÁFICA</th>
                    <td>{{ $samplingPoint->hidrographic_unit }}</td>
                </tr>
                <tr>
                    <th style="max-width: 350px;">UTM</th>
                    <td>
                        Norte: {{ $samplingPoint->north }}<br>
                        Este: {{ $samplingPoint->east }}<br>
                    </td>
                </tr>
                <tr>
                    <th>LATITUD/LONGITUD</th>
                    <td>
                        Lat.: {{ $samplingPoint->latitude }}<br>
                        Long.:{{ $samplingPoint->longitude }}
                    </td>
                </tr>
                <tr>
                    <th>ECA</th>
                    <td>{{ $samplingPoint->eca->name }}</td>
                </tr>
                <tr>
                    <th>CUENCA</th>
                    <td>{{ $samplingPoint->basin->name }}</td>
                </tr>
                <tr>
                    <th>EMBALSE</th>
                    <td>{{ $samplingPoint->reservoir->name }}</td>
                </tr>
                <tr>
                    <th>ZONA</th>
                    <td>{{ $samplingPoint->zone->name }}</td>
                </tr>
                <tr>
                    <th>TIPO</th>
                    <td>
                        {{ $type_title }}
                    </td>
                </tr>
                <tr>
                    <th>REGISTRÓ</th>
                    <td>{{ $samplingPoint->user->name." ".$samplingPoint->user->last_name }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
