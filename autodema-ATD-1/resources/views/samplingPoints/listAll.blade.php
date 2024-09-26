@extends('layouts.app', ['page' => 'puntos'])

@section('content')
<div class="container">
    <div class="row">
        @include('partials.samplingPoints.search')
    </div>
    <div class="row justify-content-center">
        <table class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Estación
                        <a class="btn btn-third" href="{{ route("samplingPoints.create") }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">UTM WGS84</th>
                    <th scope="col">Latitud/Longitud</th>
                    <th scope="col">Información</th>
                    <th scope="col">Ver</th>
                </tr>
            </thead>
            <tbody>
                @forelse($samplingPoints as $samplingPoint)
                <tr>
                    <td>
                        <a href="{{ route('samplingPoints.admin', $samplingPoint->id) }}">{{ $samplingPoint->name }}</a>

                        <a class="btn btn-edit" href="{{ route('samplingPoints.edit', $samplingPoint->id) }}" data-toggle="tooltip" data-placement="top" title="Editar información de punto de muestreo">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-delete delete-sp" href="{{ route('samplingPoints.delete', $samplingPoint->id) }}" data-toggle="tooltip" data-placement="top" title="Editar información">
                            <i class="fa fa-times"></i>
                        </a>
                        <br>
                        @if( $samplingPoint->type == \App\SamplingPoint::FIXED_POINT )
                        {{ \App\SamplingPoint::FIXED_TITLE }}
                        @elseif($samplingPoint->type == \App\SamplingPoint::FLOAT_POINT)
                        {{ \App\SamplingPoint::FLOAT_TITLE }}
                        @endif

                    </td>
                    <td>
                        <b>Este:</b> {{ $samplingPoint->east }}<br>
                        <b>Norte:</b> {{ $samplingPoint->north }}
                    </td>
                    <td>
                        <b>Latitud:</b> {{ $samplingPoint->latitude }}<br>
                        <b>Longitud:</b> {{ $samplingPoint->longitude }}
                    </td>
                    <td>
                        <b>Zona: </b>{{ $samplingPoint->zone->name }}<br>
                        <b>Embalse/otros: </b>{{ $samplingPoint->reservoir->name }}<br>
                        <b>Cuenca: </b>{{ $samplingPoint->basin->name }}

                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-outline-info" href="{{ route('samplings.listPoint', $samplingPoint->id) }}" data-toggle="tooltip" data-placement="top" title="Muestreos">
                                <i class="fa fa-thermometer"></i>
                            </a>
                            <a class="btn btn-outline-info btn-block btn-notes" data-toggle="modal" data-target="#modalNotes" href="#modalNotes" data-id="{{ $samplingPoint->id }}">
                                <i class="fa fa-tag"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td>{{ __("No hay clientes disponibles")}}</td>
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
    <!-- Modal para editar las notas -->
    <!-- The Modal -->
    <div class="modal" id="modalEditNotes">
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
        {{ $samplingPoints->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script>
    //Variable globar para guardar el id del cliente seleccionad
    let point_id_actual;
    /*
     * Función para ver las notas del cliente
     */
    $(document).on('click', '.btn-notes', function() {
        $(".modal-ajax-content").html('Cargando los datos...');

        let point_id = $(this).attr('data-id');

        //console.log(company_search);

        //Enviamos una solicitud con el ruc de la empresa
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: '{{route('pointNotes.modalSeeForm')}}',
            data: {
                point_id: point_id
            },
            success: function(data) {
                if (data.includes("Error")) {
                    alert("Ocurrió algún problema. Inténtelo de nuevo más tarde.");
                } else {
                    point_id_actual = point_id;
                    $(".modal-ajax-content").html(data);
                    console.log("cargó: " + new Date());
                }

            },
            error: function() {
                console.log(data);
            }
        });
    });
    /*
     * Función para paginar las notase
     */
    $(document).on('click', '.notes-pagination .pagination a', function(e) {
        e.preventDefault();
        console.log("Se hizo click");

        $(".modal-ajax-content").html('Cargando los datos...');

        var url = $(this).attr('href') + "&point_id=" + point_id_actual;

        console.log(url);

        //Enviamos una solicitud con el ruc de la empresa
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: url,
            success: function(data) {
                if (data.includes("Error")) {
                    alert("Ocurrió algún problema. Inténtelo de nuevo más tarde.");
                } else {
                    $(".modal-ajax-content").html(data);
                }

            },
            error: function() {
                console.log(data);
            }
        });
    });


    /*
     * Función para ver las notas del cliente
     */
    $(document).on('click', '.agregar-nota', function() {
        $(this).hide();
        $("#form-nota").show();

    });


    $(document).ready(function() {
        $("a.delete-sp").click(function(e) {
            if (!confirm('¿Está seguro(a) de eliminar este punto?')) {
                e.preventDefault();
                return false;
            }
            return true;
        });
    });

    $(document).on('click', '.prev-note-img-btn', function() {
        console.log("Cambió");
        let img_src = $(this).attr("data-href");
        let note_id = $(this).attr("data-id");

        $("#tr-" + note_id).toggle();

        let elem_src = $("#tr-" + note_id + " img.note-prev").attr("src");
        if (elem_src) {
            console.log("Ya tiene src");
        } else {
            $("#tr-" + note_id + " img.note-prev").attr("src", img_src);
        }
    });
</script>
@endpush
