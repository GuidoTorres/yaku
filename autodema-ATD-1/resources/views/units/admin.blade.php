@extends('layouts.app', ['page' => 'sampling-points'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => "UNIDAD",
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>MAGNITUD</th>
                    <td>{{ $unit->magnitude }}</td>
                </tr>
                <tr>
                    <th>UNIDAD</th>
                    <td>{{ $unit->unit }}</td>
                </tr>
                <tr>
                    <th>SÍMBOLO</th>
                    <td>{!! $unit->symbol !!} </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
