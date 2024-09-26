@extends('layouts.app', ['page' => 'service-types'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Adicional de ").$serviceType->name,
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-hover table-light">
                <tbody>
                <tr>
                    <th>NOMBRE</th>
                    <td>{{ $additional->name }}</td>
                </tr>
                <tr>
                    <th>DESCRIPCIÓN</th>
                    <td>{!! nl2br(e($additional->description)) !!}</td>
                </tr>
                <tr>
                    <th>PRECIO</th>
                    <td>S/{{ $additional->price }}</td>
                </tr>
                <tr>
                    <th>CREADO</th>
                    <td>{{ $additional->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <a class="btn btn-outline-secondary" href="{{ route('additionals.listAll', $serviceType->id) }}">Ver adicionales</a>
    </div>
@endsection
