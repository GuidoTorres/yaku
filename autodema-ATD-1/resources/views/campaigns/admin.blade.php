@extends('layouts.app', ['page' => 'campaigns'])
@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Campaña"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <table class="table table-hover table-light">
                <tbody>
                <tr>
                    <th>NOMBRE</th>
                    <td>{{ $campaign->name }}</td>
                </tr>
                <tr>
                    <th>TIPO</th>
                    <td>{{ $campaign->campaignType->name }}</td>
                </tr>
                <tr>
                    <th>ESTADO</th>
                    <td>
                        @if($campaign->state == \App\Campaign::ACTIVE)
                            Activa
                        @elseif($campaign->state == \App\Campaign::INACTIVE)
                            Inactiva
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>REGISTRÓ</th>
                    <td>{{ $campaign->user->name." ".$campaign->user->last_name }}</td>
                </tr>
                <tr>
                    <th>CREADO</th>
                    <td>{{ $campaign->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
