@extends('layouts.app', ['page' => 'service-types'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Servicio"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-hover table-light">
                <tbody>
                <tr>
                    <th>NOMBRE</th>
                    <td>{{ $serviceType->name }}</td>
                </tr>
                <tr>
                    <th>DESCRIPCIÓN</th>
                    <td>{!! nl2br(e($serviceType->description)) !!}</td>
                </tr>
                <tr>
                    <th>PRECIO</th>
                    <td>S/{{ $serviceType->price }}</td>
                </tr>
                <tr>
                    <th>CREADO</th>
                    <td>{{ $serviceType->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
