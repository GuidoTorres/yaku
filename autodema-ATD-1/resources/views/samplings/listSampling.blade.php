@extends('layouts.app', ['page' => 'sampling-points'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.samplings.searchSampleParameter')
        </div>
        <div class="row">
            <div class="col-12">
                <button
                    class="btn btn-outline-secondary ml-2"
                    data-toggle="modal"
                    data-target="#mdalAlerta"


                >Enviar notificación </button>
                <button
                    class="btn btn-outline-secondary ml-2 dwn-parameter-csv"

                >Descargar </button>
            </div>
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light table-parameters">
                <thead>
                <tr>
                    <th scope="col">Parámetro</th>
                    <th scope="col">Valor</th>
                    <th scope="col">ECA</th>
                    <th scope="col">ECA de transición</th>
                    <th scope="col">Alerta</th>
                </tr>
                </thead>
                <tbody>
                @forelse($parametersVerified as $index => $parameter)
                    <tr>
                        <td>{{ $parameter->parameter_name }} (<b>{!! $parameter->parameter_symbol !!} </b>)</td>
                        <td class="input-type" data-csv="{{ $parameter->value }} {!! $parameter->parameter_symbol  !!}">
                            <form id="approve-form{{ $parameter->id }}" action="{{ route('samplings.updateSampling', $parameter->id) }}" method="POST" style="display: inline-block; width: 80px;">
                                @method('PUT')
                                <input class="form-control" value="{{ $parameter->value }}" name="value" style="display: inline-block; width: 80px;">
                                @csrf
                            </form>
                            <a
                                href="#"
                                onclick="event.preventDefault();
                                 document.getElementById('approve-form'+{{ $parameter->id }}).submit();"
                                class="btn btn-info"
                            ><i class="fa fa-pencil"></i></a>
                            <form id="delete-form{{ $parameter->id }}" action="{{ route('samplings.deleteSampling', $parameter->id) }}" method="POST" style="display: none;">
                                @method('PUT')
                                @csrf
                            </form>
                            <a
                                href="#"
                                onclick="event.preventDefault();
                                 document.getElementById('delete-form'+{{ $parameter->id }}).submit();"
                                class="btn btn-danger"
                            ><i class="fa fa-times"></i></a>
                            <b>{!! $parameter->parameter_symbol  !!}</b>
                        </td>
                        <td>
                            @if($parameter->eca_type == \App\Sampling::ECA_MIN_MAX)
                                Min: {{ $parameter->min_value }} <b>{!! $parameter->parameter_symbol !!}</b><br>
                                Max: {{ $parameter->max_value }} <b>{!!  $parameter->parameter_symbol !!}</b>
                            @elseif($parameter->eca_type == \App\Sampling::ECA_MIN)
                                Min: {{ $parameter->min_value }} <b>{!!  $parameter->parameter_symbol !!}</b><br>
                            @elseif($parameter->eca_type == \App\Sampling::ECA_MAX)
                                Max: {{ $parameter->max_value }} <b>{!!  $parameter->parameter_symbol !!}</b>
                            @elseif($parameter->eca_type == \App\Sampling::ECA_ALLOWED)
                                Valor permitido: {{ $parameter->allowed_value }}
                            @elseif($parameter->eca_type == \App\Sampling::ECA_NULL)
                                Sin restricción
                            @endif

                        </td>
                        <td>
                            @if(isset($parameters_eca2_verified[$index]))
                                @if($parameters_eca2_verified[$index]->eca_type == \App\Sampling::ECA_MIN_MAX)
                                    Min: {{ $parameters_eca2_verified[$index]->min_value }} <b>{!! $parameters_eca2_verified[$index]->parameter_symbol !!}</b><br>
                                    Max: {{ $parameters_eca2_verified[$index]->max_value }} <b>{!!  $parameters_eca2_verified[$index]->parameter_symbol !!}</b>
                                @elseif($parameters_eca2_verified[$index]->eca_type == \App\Sampling::ECA_MIN)
                                    Min: {{ $parameters_eca2_verified[$index]->min_value }} <b>{!!  $parameters_eca2_verified[$index]->parameter_symbol !!}</b><br>
                                @elseif($parameters_eca2_verified[$index]->eca_type == \App\Sampling::ECA_MAX)
                                    Max: {{ $parameters_eca2_verified[$index]->max_value }} <b>{!!  $parameters_eca2_verified[$index]->parameter_symbol !!}</b>
                                @elseif($parameters_eca2_verified[$index]->eca_type == \App\Sampling::ECA_ALLOWED)
                                    Valor permitido: {{ $parameters_eca2_verified[$index]->allowed_value }}
                                @elseif($parameters_eca2_verified[$index]->eca_type == \App\Sampling::ECA_NULL)
                                    Sin restricción
                                @endif

                            @else
                                Sin restricción
                            @endif
                        </td>
                        <td>
                            @if($parameter->state == \App\Sampling::NORMAL_PARAMETER)
                                <span class="alerta-eca-verde">
                                    @if($parameter->message == "Normal")
                                        -{{ $parameter->message }}.
                                    @else
                                        -{{ $parameter->message }}
                                    @endif
                                </span>
                            @elseif($parameter->state == \App\Sampling::NEAR_BELLOW_LIMIT || $parameter->state == \App\Sampling::NEAR_UPPER_LIMIT)
                                <span class="alerta-eca-amarilla">
                                    -{{ $parameter->message }}
                                </span>
                            @elseif($parameter->state == \App\Sampling::BELLOW_LIMIT || $parameter->state == \App\Sampling::UPPER_LIMIT || $parameter->state == \App\Sampling::DIFFERENT_THAN_ALLOWED  )

                                <span class="alerta-eca-roja">
                                    -{{ $parameter->message }}
                                </span>
                            @endif
                            <br>

                            @if(isset($parameters_eca2_verified[$index]))
                                @if($parameters_eca2_verified[$index]->state == \App\Sampling::NORMAL_PARAMETER)
                                    <span class="alerta-eca-verde">
                                        -{{ $parameters_eca2_verified[$index]->message }} (transición)
                                    </span>
                                @elseif($parameters_eca2_verified[$index]->state == \App\Sampling::NEAR_BELLOW_LIMIT || $parameters_eca2_verified[$index]->state == \App\Sampling::NEAR_UPPER_LIMIT)
                                            <span class="alerta-eca-amarilla">
                                        -{{ $parameters_eca2_verified[$index]->message }} (transición)
                                    </span>
                                @elseif($parameters_eca2_verified[$index]->state == \App\Sampling::BELLOW_LIMIT || $parameters_eca2_verified[$index]->state == \App\Sampling::UPPER_LIMIT || $parameters_eca2_verified[$index]->state == \App\Sampling::DIFFERENT_THAN_ALLOWED  )
                                    <span class="alerta-eca-roja">
                                        -{{ $parameters_eca2_verified[$index]->message }} (transición)
                                    </span>
                                @endif
                            @else
                                <span class="alerta-eca-verde">
                                    -Normal (transición).
                                </span>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay muestras disponibles")}}</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="5" class="no-show">
                        <span>Agregar muestra</span>
                        <form id="add-p-form" action="{{ route('samplings.addSampling', $sampling->id) }}" method="POST">
                            <select class="form-control" style="display: inline-block;width: 250px;" name="parameter_id">

                                @foreach(\App\Parameter::where('enabled',1)->pluck('name', 'id') as $id => $name)
                                    <option
                                        value="{{ $id }}"
                                    >{{ $name }}</option>
                                @endforeach
                            </select>
                            <input class="form-control" name="value" style="display: inline-block; width: 80px;">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i></button>
                            @csrf
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal para las notas -->
        <!-- The Modal -->

        <div class="modal" id="mdalAlerta">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Enviar notificación</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body modal-ajax-content">
                        <form class="modal-body-msg-wrapp"
                              method="POST"
                              action="{{  route('samplings.alertNotification', $sampling->id) }}"
                              novalidate
                        >
                            @csrf
                            <div class="form-group d-none">
                                <label for="dominant">RESERVOIR NAME</label>
                                <input class="form-control" id="reservoir_name" name="reservoir_name" value="{{ $reservoir->name }}">
                            </div>
                            <div>
                                @if($alert == \App\Sampling::GREEN_ALERT )
                                    <span class="alerta-eca-verde">ALERTA VERDE</span>
                                @elseif($alert == \App\Sampling::YELLOW_ALERT )
                                    <span class="alerta-eca-amarilla">ALERTA AMARILLA</span>
                                @elseif($alert == \App\Sampling::RED_ALERT )
                                    <span class="alerta-eca-roja">ALERTA ROJA</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="note">Nota adicional a notificación</label>
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sampling_point">Punto de muestreo</label>
                                <textarea class="form-control" id="sampling_point" name="sampling_point" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="dominant">Clase dominante </label> <label><input type="checkbox" id="cursiva_dominant" name="cursiva_dominant" value="true"> Cursiva</label>
                                <textarea class="form-control" id="dominant" name="dominant" rows="3"></textarea>
                            </div>
                            <div class="form-group d-none">
                                <label for="color_alert">Alerta "Color"</label>
                                <textarea class="form-control" id="color_alert" name="color_alert" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="transition">Mostrar ECAs de transición </label> <label><input type="checkbox" id="transition" name="transition" value="true"> </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div><label>Notificar a:</label></div>
                                @foreach($users as $user)

                                <div class="form-check">
                                    <label class="form-check-label" >
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value="{{ $user->id }}"
                                            name="users[]"
                                            id="">
                                        {{ $user->name." ".$user->last_name }}, {{ $user->email }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <div><label>Parámetros:</label></div>

                                @foreach($parametersVerified as $parameter)
                                    <div class="form-check">
                                        <label class="form-check-label" >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value="{{ $parameter->parameter_id }}"
                                                name="parameters[]"
                                                id="">
                                            {{ $parameter->parameter_name }} (<b>{!! $parameter->parameter_symbol !!}</b>)
                                        </label>
                                    </div>
                                @endforeach
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-thales-secondary">
                                    Enviar notificación
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">

        </div>
        <div class="row justify-content-center d-none">
            {{ $samplingParameters->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
<script>

$(document).ready(function() {
    $('.dwn-parameter-csv').click(function() {
        console.log("push");
        var titles = [];
        var data = [];


        /*
         * Get the table headers, this will be CSV headers
         * The count of headers will be CSV string separator
         */
        $('.table-parameters th').each(function() {
            titles.push($(this).text());
        });

        /*
         * Get the actual data, this will contain all the data, in 1 array
         */
        $('.table-parameters td').each(function() {
            if($(this).hasClass("no-show")) return;


            let text = $(this).text().replace("=",'').replace(/(\r\n|\n|\r)/gm, "").replace(/\s+/g, ' ').trim()
            if($(this).hasClass("input-type")){
                text = $(this).attr("data-csv");
            }
            data.push(text);
        });

        /*
         * Convert our data to CSV string
         */
        var CSVString = prepCSVRow(titles, titles.length, '');
        CSVString = prepCSVRow(data, titles.length, CSVString);

        /*
         * Make CSV downloadable
         */
        var downloadLink = document.createElement("a");
        var blob = new Blob(["\ufeff", CSVString]);
        var url = URL.createObjectURL(blob);
        downloadLink.href = url;
        downloadLink.download = "data.csv";

        /*
         * Actually download CSV
         */
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });

    /*
 * Convert data array to CSV string
 * @param arr {Array} - the actual data
 * @param columnCount {Number} - the amount to split the data into columns
 * @param initial {String} - initial string to append to CSV string
 * return {String} - ready CSV string
 */
    function prepCSVRow(arr, columnCount, initial) {
        var row = ''; // this will hold data
        var delimeter = ','; // data slice separator, in excel it's `;`, in usual CSv it's `,`
        var newLine = '\r\n'; // newline separator for CSV row

        /*
         * Convert [1,2,3,4] into [[1,2], [3,4]] while count is 2
         * @param _arr {Array} - the actual array to split
         * @param _count {Number} - the amount to split
         * return {Array} - splitted array
         */
        function splitArray(_arr, _count) {
            var splitted = [];
            var result = [];
            _arr.forEach(function(item, idx) {
                if ((idx + 1) % _count === 0) {
                    splitted.push(item);
                    result.push(splitted);
                    splitted = [];
                } else {
                    splitted.push(item);
                }
            });
            return result;
        }
        var plainArr = splitArray(arr, columnCount);
        // don't know how to explain this
        // you just have to like follow the code
        // and you understand, it's pretty simple
        // it converts `['a', 'b', 'c']` to `a,b,c` string
        plainArr.forEach(function(arrItem) {
            arrItem.forEach(function(item, idx) {
                row += item + ((idx + 1) === arrItem.length ? '' : delimeter);
            });
            row += newLine;
        });
        return initial + row;
    }
});
    </script>
@endpush
