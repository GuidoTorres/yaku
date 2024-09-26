@extends('layouts.app', ['page' => 'sampling-points'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => "ECA",
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>NOMBRE</th>
                    <td>{{ $eca->name }}</td>
                </tr>
                <tr>
                    <th>DESCRIPCIÓN</th>
                    <td>{{ $eca->description }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
