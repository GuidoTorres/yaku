@extends('layouts.app', ['page' => 'sampling-points'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => "PARÁMETRO",
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>NOMBRE</th>
                    <td>{{ $parameter->name }}</td>
                </tr>
                <tr>
                    <th>DESCRIPCIÓN</th>
                    <td>{{ $parameter->description }}</td>
                </tr>
                <tr>
                    <th>CÓDIGO</th>
                    <td>{{ $parameter->code }}</td>
                </tr>
                <tr>
                    <th>MAGNITUD</th>
                    <td>{{ $parameter->unit->magnitude }}</td>
                </tr>
                <tr>
                    <th>UNIDAD</th>
                    <td>{{ $parameter->unit->unit }}</td>
                </tr>
                <tr>
                    <th>SÍMBOLO</th>
                    <td>{{ $parameter->unit->symbol }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
