@extends('layouts.app', ['page' => 'campaigns'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.campaigns.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">
                        Campaña
                        <a
                            class="btn btn-third"
                            href="{{ route("campaigns.create") }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Estado</th>
                </tr>
                </thead>
                <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td>

                            <a href="{{ route('campaigns.admin', $campaign->id) }}">{{ $campaign->name }}</a>
                            @can('update', [\App\Campaign::class, $campaign])
                                <a
                                    class="btn btn-edit"
                                    href="{{ route('campaigns.edit', $campaign->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Editar información de campaña"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endcan
                        </td>
                        <td>{{ $campaign->campaignType->name }}</td>
                        <td>
                            @if($campaign->state == \App\Campaign::ACTIVE)
                                Activa
                            @elseif($campaign->state == \App\Campaign::INACTIVE)
                                Inactiva
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay campañas disponibles")}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Modal para las notas -->
        <!-- The Modal -->
        <div class="modal" id="modalNotes">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Notas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body modal-ajax-content"></div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            {{ $campaigns->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
