@extends('layouts.app', ['page' => 'sampling-points'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.samplings.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Muestreo

                        <a
                            class="btn btn-third"
                            href="{{ route("samplings.create", $samplingPoint->id) }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">UTM WGS84</th>
                    <th scope="col">Latitud/Longitud</th>
                    <th scope="col">Zona de luz</th>
                    <th scope="col">Estado</th>
                </tr>
                </thead>
                <tbody>
                @forelse($samplings as $sampling)
                    <tr>
                        <td>


                            <a
                                class=""
                                href="{{ route('samplings.listSampling', $sampling->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Ver detalle"
                            >
                                {{ Carbon\Carbon::parse($sampling->sampling_date)->format('d/m/Y H:i') }}
                            </a>
                            <a
                                class="btn btn-edit"
                                href="{{ route('samplings.edit', $sampling->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar información"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a
                                class="btn btn-delete delete-sampling"
                                href="{{ route('samplings.delete', $sampling->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar información"
                            >
                                <i class="fa fa-times"></i>
                            </a>

                        </td>
                        <td>
                            <b>Este:</b> {{ $sampling->east }}<br>
                            <b>Norte:</b> {{ $sampling->north }}
                        </td>
                        <td>
                            <b>Latitud:</b> {{ $sampling->latitude }}<br>
                            <b>Longitud:</b> {{ $sampling->longitude }}
                        </td>
                        <td>{{ $sampling->deep->name }}</td>
                        <td>
                            @if($sampling->state == 1)
                                Por aprobar<br>
                                <a
                                    href="{{ route('samplings.approve', $sampling->id) }}"
                                    onclick="event.preventDefault();
                                 document.getElementById('approve-form').submit();"

                                >Aprobar</a>
                                <form id="approve-form" action="{{ route('samplings.approve', $sampling->id) }}" method="POST" style="display: none;">
                                    @method('PUT')
                                    @csrf
                                </form>
                            @elseif($sampling->state == 2)
                                Aprobado
                            @elseif($sampling->state == 3)
                                No aprobado
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay muestreos disponibles")}}</td>
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

        </div>
        <div class="row justify-content-center">
            {{ $samplings->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet"  href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript"  src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $("a.delete-sampling").click(function(e){
                if(!confirm('¿Está seguro(a) de eliminar este punto?')){
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });
    </script>
@endpush
