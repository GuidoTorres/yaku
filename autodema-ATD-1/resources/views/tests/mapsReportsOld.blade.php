@extends('layouts.map', ['page' => 'visor'])

@section('content')
    <div class="container">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="map-tab" data-toggle="tab" href="#map-section" role="tab" aria-controls="home" aria-selected="true">Mapa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="statistics-tab" data-toggle="tab" href="#statistics-section" role="tab" aria-controls="profile" aria-selected="false">Estadísticos de parámetro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="comparative-tab" data-toggle="tab" href="#comparative-section" role="tab" aria-controls="contact" aria-selected="false">Comparativa de puntos</a>
            </li>
        </ul>
        <div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="map-section" role="tabpanel" aria-labelledby="map-tab">
                    <div class="dashboard">
                        <div class="element mapa-wrapp">
                            <div class="grid">

                                <div class="form-group">

                                    <div class="d-inline-block visor-filter-points-wrapp" data-filter="type">

                                        <div data-toggle="dropdown" class="btn dropdown-toggle" type="button">Tipo de punto</div>
                                        <ul class="dropdown-menu dropdown-menu-form dropdown-services-list" style="z-index: 2000">
                                            <li>
                                                <label class="checkbox">
                                                    <input class="form-check-input select-deselect" type="checkbox" data-targets="type" checked="checked"> Seleccionar/deseleccionar
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox">
                                                    <input class="form-check-input service-type-check point_check_input" data-filter-type="type" type="checkbox" value="1" data-id="1" checked="checked">Estaciones de monitoreo fijas
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox">
                                                    <input class="form-check-input service-type-check point_check_input" data-filter-type="type" type="checkbox" value="2" data-id="2" checked="checked">Estaciones de monitoreo asociadas
                                                </label>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="d-inline-block visor-filter-points-wrapp" data-filter="basin_id">

                                        <div data-toggle="dropdown" class="btn dropdown-toggle" type="button">Cuenca</div>
                                        <ul class="dropdown-menu dropdown-menu-form dropdown-services-list" style="z-index: 2000">
                                            <li>
                                                <label class="checkbox">
                                                    <input class="form-check-input select-deselect" type="checkbox" data-targets="basin_id" checked="checked"> Seleccionar/deseleccionar
                                                </label>
                                            </li>
                                            @foreach($basins as $basin)
                                                <li>
                                                    <label class="checkbox">
                                                        <input class="form-check-input service-type-check point_check_input" data-filter-type="basin_id" type="checkbox" value="{{ $basin->id }}" checked="checked">{{ $basin->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                    <div class="d-inline-block visor-filter-points-wrapp" data-filter="reservoir_id">

                                        <div data-toggle="dropdown" class="btn dropdown-toggle" type="button">Embalses / Infraestructura Hidráulica</div>
                                        <ul class="dropdown-menu dropdown-menu-form dropdown-services-list" style="z-index: 2000">
                                            <li>
                                                <label class="checkbox">
                                                    <input class="form-check-input select-deselect" type="checkbox" data-targets="reservoir_id" checked="checked"> Seleccionar/deseleccionar
                                                </label>
                                            </li>
                                            @foreach($reservoirs as $reservoir)
                                                <li>
                                                    <label class="checkbox">
                                                        <input class="form-check-input service-type-check point_check_input reservoir_input" data-filter-type="reservoir_id" type="checkbox" value="{{ $reservoir->id }}" data-points="{{ $reservoir->samplingPoints->pluck('id')->toJson() }}" checked="checked">{{ $reservoir->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                    <div class="d-inline-block visor-filter-points-wrapp" data-filter="zone_id">

                                        <div data-toggle="dropdown" class="btn dropdown-toggle" type="button">Zona</div>
                                        <ul class="dropdown-menu dropdown-menu-form dropdown-services-list" style="z-index: 2000">
                                            <li>
                                                <label class="checkbox">
                                                    <input class="form-check-input select-deselect" type="checkbox" data-targets="zone_id" checked="checked"> Seleccionar/deseleccionar
                                                </label>
                                            </li>
                                            @foreach($zones as $zone)
                                                <li>
                                                    <label class="checkbox">
                                                        <input class="form-check-input service-type-check point_check_input zones_input" data-filter-type="zone_id" type="checkbox" value="{{ $zone->id }}" data-points="{{ $zone->samplingPoints->pluck('id')->toJson() }}" checked="checked">{{ $zone->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                    <div class="d-inline-block">

                                        <button class="map-btn multiple-points-modal-btn" style="cursor: pointer" href="#modalMultiplesPuntos" data-toggle="modal" data-target="#modalMultiplesPuntos">
                                            Generar gráfico
                                        </button>

                                    </div>
                                    <div class="d-none visor-filter-points-wrapp" data-filter="id">

                                        <div data-toggle="dropdown" class="btn dropdown-toggle" type="button">Punto</div>
                                        <ul class="dropdown-menu dropdown-menu-form dropdown-services-list" style="z-index: 2000">
                                            @foreach($samplingPoints as $samplingPoint)
                                                <li>
                                                    <label class="checkbox">
                                                        <input class="form-check-input service-type-check point_check_input" data-filter-type="id" type="checkbox" value="{{ $samplingPoint->id }}" checked="checked">{{ $samplingPoint->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>
                                <div class="btn-group">
                                </div>

                            </div>
                            <div id="mapid"></div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="statistics-section" role="tabpanel" aria-labelledby="statistics-tab">
                    <div class="elements graficos-wrapp d-flex flex-wrap">
                        <div class="element w-100 p-2">

                            <div class="w100" style="padding-bottom: 20px;">
                                <button  class="map-btn zoom-in-graph d-none">
                                    <i class="fa fa-search-plus"></i>
                                </button>
                                <button  class="map-btn zoom-out-graph d-none">
                                    <i class="fa fa-search-minus"></i>
                                </button>
                                <button  class="map-btn editar-grafico-modal-btn" href="#modalEditarGrafico" data-toggle="modal" data-target="#modalEditarGrafico">
                                    Editar gráfico
                                </button>
                                <button  class="map-btn ver-estadisticos-modal-btn" href="#modalEstadisticos" data-toggle="modal" data-target="#modalEstadisticos">
                                    Ver estadísticos
                                </button>
                                <button  class="map-btn restart-graph">
                                    Reiniciar
                                </button>
                                <button  class="map-btn download-graph">
                                    Descargar
                                </button>
                            </div>
                        </div>
                        <div class="element w-100 p-2">
                            <div class="w100 graph-canvas-wrapp">
                                <div id='chartjsLegend' class='chartjsLegend'></div>
                                <canvas id="samplings_canvas" class="canvas-report" ></canvas>
                            </div>

                        </div>
                        <div class="element w-50 p-2">
                            <div class="graph-canvas-wrapp">
                                <div class="samplings_canvas_regression_wrapp">
                                    <canvas id="samplings_canvas_regression" class="canvas-report" ></canvas>
                                </div>
                                <div class="regresion-formulas">

                                </div>
                            </div>

                        </div>
                        <div class="element w-50 p-2 boxes-wrapp">
                            <canvas id="samplings_canvas_box" class="canvas-report"></canvas>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="comparative-section" role="tabpanel" aria-labelledby="comparative-tab">
                    <div class="elements comparisson-wrapp">
                        <div class="element">
                            <canvas id="samplings_canvas_comparisson" class="canvas-report"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="pcc" class="pcc" style="width: 150px"></div>


    </div>


    <!-- The Modal -->

    <div class="modal" id="modalMultiplesPuntos">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar múltiples puntos a gráfico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body modal-ajax-content">

                    <div class="modal-body-msg-wrapp">
                        <div class="pb-3">Seleccione la información del parámetro que desea añadir:</div>

                        <div>


                            <div class="form-group">

                                <div class="d-none">
                                    <div class="form-group">
                                        <input class="form-control" type="sampling_point_id" id="sampling_point_id" name="sampling_point_id" placeholder="sampling point">
                                    </div>
                                </div>
                                <div class="d-none">

                                    <div class="form-group">
                                        <input class="form-control" type="text" id="point_name" name="point_name" placeholder="sampling point">
                                    </div>
                                </div>



                            </div>
                            <div class="d-flex">

                                <div class="w-50">
                                    <div class="d-block">
                                        <label for="multiple_deep_id" style="font-weight: bold">Zona de luz </label>
                                        <div class="form-group">
                                            <select class="form-control" name="" id="multiple_deep_id">
                                                <option
                                                    value=""
                                                >Seleccionar</option>
                                                @foreach($deeps as $deep)
                                                    <option value="{{ $deep->id }}">{{ $deep->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-block">
                                        <label for="multiple_sampling_date" style="font-weight: bold">Inicio</label>
                                        <div class="form-group">
                                            <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                                <input type="text" name="multiple_sampling_date" id="multiple_sampling_date" class="form-control datetimepicker-input" data-target="#datetimepicker3" data-toggle="datetimepicker" value="" autocomplete="off" />
                                                <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block">
                                        <div class="w-100">

                                            <div class="form-group">
                                                <label for="multiple_sampling_date2" style="font-weight: bold">Fin</label>
                                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                                    <input type="text" name="multiple_sampling_date2" id="multiple_sampling_date2" class="form-control datetimepicker-input" data-target="#datetimepicker4" data-toggle="datetimepicker" value="" autocomplete="off" />
                                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <div class="form-group w-50">

                                            <label style="font-weight: bold; width: 100%">Tipo de gráfico  <label><input type="checkbox" class="graph-type" name="multiple-area-type" id="multiple-area-type"> Área</label> <label><input type="checkbox" class="graph-type" name="multiple-scale-type" id="multiple-scale-type"> Escala exponencial</label></label>
                                            <div class="btn-group mt-1">
                                                <label class="btn graph-type-btn graph-multiple">
                                                    <input class="form-control graph-type d-none" value="line" name="multiple-graph-type" type="radio">
                                                    <span class="fa fa-line-chart"></span>
                                                </label>
                                                <label class="btn graph-type-btn graph-multiple">
                                                    <input class="form-control graph-type d-none" value="bar" name="multiple-graph-type" type="radio">
                                                    <span class="fa fa-bar-chart"></span>
                                                </label>
                                                <label class="btn graph-type-btn graph-multiple">
                                                    <input class="form-control graph-type d-none" value="scatter" name="multiple-graph-type" type="radio">
                                                    <div class="scatter-wrapp">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 205.34 154"
                                                            className="fa-scatter"
                                                        >
                                                            <polygon points="13 141.48 13 0 0 0 0 141.48 0 154 13 154 205.34 154 205.34 141.48 13 141.48" />
                                                            <circle cx="78.5" cy="44.5" r="13.17" />
                                                            <circle cx="39.84" cy="113.5" r="13.17" />
                                                            <circle cx="91.67" cy="95.5" r="13.17" />
                                                            <circle cx="132.67" cy="85.5" r="13.17" />
                                                            <circle cx="177.67" cy="16.83" r="13.17" />
                                                            <circle cx="169.34" cy="113.5" r="13.17" />
                                                        </svg>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group w-50">
                                            <label style="font-weight: bold">Comparar puntos</label>
                                            <div class="form-group">
                                                <div class="btn-group mt-1">
                                                    <label class="btn graph-type-btn graph-multiple">
                                                        <input class="form-control graph-type d-none" value="radar" name="multiple-graph-type" type="radio">
                                                        <span class="fa fa-connectdevelop"></span>
                                                    </label>
                                                    <input class="form-control form-control-color" type="color" id="radial-color" style="width: 50px" value="#000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="w-50">

                                    @for($i=1; $i<5; $i++)
                                        <div class="d-block">
                                            <label for="parametersAutocomplete" style="font-weight: bold">Parámetro {{ $i }}</label>
                                            <div class="form-group">
                                                <!--
                                                <input placeholder="ingrese el nombre del parámetro" type="text" id="parametersAutocomplete" class="form-control" />
                                                <input placeholder="Parámetro" type="number" id="parameter_id" class="form-control d-none" />
                                                   -->
                                                <select class="form-control parameter_multiple" name="" id="multiple_parameter_id_{{ $i }}">
                                                    <option
                                                        value=""
                                                    >Seleccionar</option>
                                                    @foreach($parameters as $parameter)
                                                        <option value="{{ $parameter->id }}" data-name="{{ $parameter->name }}">{!! $parameter->name." (".$parameter->unit->symbol.")" !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endfor

                                </div>


                            </div>



                            <div class="last-row-graph-conf">
                                <div class="d-inline-block btn-primary multiple-add-parameter " style="cursor: pointer">
                                    Generar gráfico
                                </div>
                            </div>
                            <div class="last-row-graph-conf loading-data-info" style="display: none">
                                Cargando información...
                            </div>



                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="modalPuntos">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar parámetro a gráfico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body modal-ajax-content">

                    <div class="modal-body-msg-wrapp">
                        <div>Seleccione la información del parámetro que desea añadir:</div>
                        <div>


                            <div class="form-group">

                                <div class="d-none">
                                    <div class="form-group">
                                        <input class="form-control" type="sampling_point_id" id="sampling_point_id" name="sampling_point_id" placeholder="sampling point">
                                    </div>
                                </div>
                                <div class="d-none">

                                    <div class="form-group">
                                        <input class="form-control" type="text" id="point_name" name="point_name" placeholder="sampling point">
                                    </div>
                                </div>



                            </div>
                            <div class="d-flex">

                                <div class="w-50">
                                    <div class="d-block">
                                        <label for="deep_id" style="font-weight: bold">Zona de luz </label>
                                        <div class="form-group">
                                            <select class="form-control" name="" id="deep_id">
                                                <option
                                                    value=""
                                                >Seleccionar</option>
                                                @foreach($deeps as $deep)
                                                    <option value="{{ $deep->id }}">{{ $deep->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-block">
                                        <label for="sampling_date" style="font-weight: bold">Inicio</label>
                                        <div class="form-group">
                                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                                <input type="text" name="sampling_date" id="sampling_date" class="form-control datetimepicker-input" data-target="#datetimepicker1" data-toggle="datetimepicker" value="" autocomplete="off" />
                                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block">
                                        <div class="w-100">

                                            <div class="form-group">
                                                <label for="sampling_date2" style="font-weight: bold">Fin</label>
                                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                                    <input type="text" name="sampling_date2" id="sampling_date2" class="form-control datetimepicker-input" data-target="#datetimepicker2" data-toggle="datetimepicker" value="" autocomplete="off" />
                                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block">
                                        <div class="form-group">

                                            <div style="font-weight: bold; width: 100%">Tipo de gráfico <label><input type="checkbox" class="graph-type graph-single" name="area-type" id="area-type"> Área</label> <label><input type="checkbox" class="graph-type graph-single" name="scale-type" id="scale-type"> Escala exponencial</label></div>
                                            <div class="btn-group mt-1">
                                                <label class="btn graph-type-btn graph-single">
                                                    <input class="form-control graph-type d-none" value="line" name="graph-type" type="radio">
                                                    <span class="fa fa-line-chart"></span>
                                                </label>
                                                <label class="btn graph-type-btn graph-single">
                                                    <input class="form-control graph-type d-none" value="bar" name="graph-type" type="radio">
                                                    <span class="fa fa-bar-chart"></span>
                                                </label>
                                                <label class="btn graph-type-btn graph-single active">
                                                    <input class="form-control graph-type d-none" value="scatter" name="graph-type" type="radio" checked>
                                                    <div class="scatter-wrapp">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 205.34 154"
                                                            className="fa-scatter"
                                                        >
                                                            <polygon points="13 141.48 13 0 0 0 0 141.48 0 154 13 154 205.34 154 205.34 141.48 13 141.48" />
                                                            <circle cx="78.5" cy="44.5" r="13.17" />
                                                            <circle cx="39.84" cy="113.5" r="13.17" />
                                                            <circle cx="91.67" cy="95.5" r="13.17" />
                                                            <circle cx="132.67" cy="85.5" r="13.17" />
                                                            <circle cx="177.67" cy="16.83" r="13.17" />
                                                            <circle cx="169.34" cy="113.5" r="13.17" />
                                                        </svg>
                                                    </div>
                                                </label>
                                                <label class="btn graph-type-btn graph-single d-none">
                                                    <input class="form-control graph-type d-none" value="boxplot" name="graph-type" type="radio">
                                                    <div class="scatter-wrapp">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Layer_1" viewBox="0 0 32 32" xml:space="preserve">
<path id="box--plot_1_" d="M31,31.36H1c-0.199,0-0.36-0.161-0.36-0.36V1h0.72v29.64H31V31.36z M14,27.36H6v-0.72h3.64v-3.28H6  c-0.199,0-0.36-0.161-0.36-0.36V11c0-0.199,0.161-0.36,0.36-0.36h3.64V7.36H6V6.64h8v0.72h-3.64v3.28H14  c0.199,0,0.36,0.161,0.36,0.36v12c0,0.199-0.161,0.36-0.36,0.36h-3.64v3.279H14V27.36z M6.36,22.64h7.28v-5.28H6.36V22.64z   M6.36,16.64h7.28v-5.28H6.36V16.64z M28,23.36h-8v-0.72h3.64v-3.28H20c-0.199,0-0.36-0.161-0.36-0.36V7  c0-0.199,0.161-0.36,0.36-0.36h3.64V3.36H20V2.64h8v0.72h-3.64v3.28H28c0.199,0,0.36,0.161,0.36,0.36v12  c0,0.199-0.161,0.36-0.36,0.36h-3.64v3.279H28V23.36z M20.36,18.64h7.279v-5.28H20.36V18.64z M20.36,12.64h7.279V7.36H20.36V12.64z"/>
                                                            <rect id="_Transparent_Rectangle" style="fill:none;" width="32" height="32"/>
                                                    </svg>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="w-50">

                                    @for($i=1; $i<5; $i++)
                                        <div class="d-block">
                                            <label for="parametersAutocomplete" style="font-weight: bold">Parámetro {{ $i }}</label>
                                            <div class="form-group">
                                                <!--
                                                <input placeholder="ingrese el nombre del parámetro" type="text" id="parametersAutocomplete" class="form-control" />
                                                <input placeholder="Parámetro" type="number" id="parameter_id" class="form-control d-none" />
                                                   -->
                                                <select class="form-control parameter_single" name="" id="parameter_id_{{ $i }}">
                                                    <option
                                                        value=""
                                                    >Seleccionar</option>
                                                    @foreach($parameters as $parameter)
                                                        <option value="{{ $parameter->id }}" data-name="{{ $parameter->name }}"
                                                        >{!! $parameter->name." (".$parameter->unit->symbol.")" !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endfor

                                </div>


                            </div>



                            <div class="last-row-graph-conf">
                                <div class="d-inline-block btn-primary add-parameter " style="cursor: pointer">
                                    Generar gráfico
                                </div>
                            </div>
                            <div class="last-row-graph-conf loading-data-info" style="display: none">
                                Cargando información...
                            </div>



                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="modalEditarGrafico">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar gráfico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body modal-ajax-content">

                    <div class="modal-body-msg-wrapp">

                        <div>Color de fondo: <input type="color" id="edit-background-canvas" value="#ffffff"></div>
                        <div class="editar-grafico-body-modal">



                        </div>
                        <div class="editar-grafico-body-modal-wrapp">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr>
                                    <th scope="col" style="max-width: 250px;">Datos</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">ECA</th>
                                    <th scope="col">Tipo de gráfico</th>
                                </tr>
                                </thead>
                                <tbody class="editar-grafico-tbody"></tbody>
                            </table>

                        </div>
                        <button class="btn-primary editar-grafico-btn mt-5" style="cursor: pointer">
                            Generar gráfico
                        </button>



                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="modalEstadisticos">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ver estadísticos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body modal-ajax-content">
                    <div class="modal-body-msg-wrapp">
                        <h4 class="modal-title ml-5 mb-0">Resúmenes estadísticos </h4>
                        <div class="table-statistics-wrapp m-5">
                            <table class="table table-bordered table-statistics table-responsive" style="display: none">

                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Estadístico</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="statistics statistics-sum">
                                    <td scope="row" style="font-weight: bold;">Sum</td>
                                </tr>
                                <tr class="statistics statistics-mean">
                                    <td scope="row" style="font-weight: bold;">Media</td>
                                </tr>
                                <tr class="statistics statistics-mode">
                                    <td scope="row" style="font-weight: bold;">Moda</td>
                                </tr>
                                <tr class="statistics statistics-median">
                                    <td scope="row" style="font-weight: bold;">Mediana</td>
                                </tr>
                                <tr class="statistics statistics-deviation">
                                    <td scope="row" style="font-weight: bold;">Desviación</td>
                                </tr>
                                <tr class="statistics statistics-q1">
                                    <td scope="row" style="font-weight: bold;">Percentil 25</td>
                                </tr>
                                <tr class="statistics statistics-q3">
                                    <td scope="row" style="font-weight: bold;">Percentil 75</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>



                    </div>
                    <div class="">
                        <button class="map-btn dwn-estadisticos-csv">
                            Descargar estadísticos
                        </button>
                        <button class="map-btn download-statistics-image">
                            Descargar estadísticos en imagen
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="table-statistics-clone-wrapp">

        <table class="table table-bordered table-responsive" style="display: none">

            <thead class="thead-dark">
            <tr>
                <th scope="col">Estadístico</th>
            </tr>
            </thead>
            <tbody>
            <tr class="statistics statistics-point">
                <td scope="row" style="font-weight: bold;">Estación</td>
            </tr>
            <tr class="statistics statistics-start">
                <td scope="row" style="font-weight: bold;">Inicio de muestreo</td>
            </tr>
            <tr class="statistics statistics-end">
                <td scope="row" style="font-weight: bold;">Fin de muestreo</td>
            </tr>
            <tr class="statistics statistics-eca">
                <td scope="row" style="font-weight: bold;">ECA</td>
            </tr>
            <tr class="statistics statistics-length">
                <td scope="row" style="font-weight: bold;">N° de datos</td>
            </tr>
            <tr class="statistics statistics-first">
                <td scope="row" style="font-weight: bold;">1<sup>er</sup> dato</td>
            </tr>
            <tr class="statistics statistics-last">
                <td scope="row" style="font-weight: bold;">Últ. dato</td>
            </tr>
            <tr class="statistics statistics-max">
                <td scope="row" style="font-weight: bold;">Máximo</td>
            </tr>
            <tr class="statistics statistics-min">
                <td scope="row" style="font-weight: bold;">Mínimo</td>
            </tr>
            <tr class="statistics statistics-range">
                <td scope="row" style="font-weight: bold;">Rango</td>
            </tr>
            <tr class="statistics statistics-sum">
                <td scope="row" style="font-weight: bold;">Suma</td>
            </tr>
            <tr class="statistics statistics-mean">
                <td scope="row" style="font-weight: bold;">Media</td>
            </tr>
            <tr class="statistics statistics-mode">
                <td scope="row" style="font-weight: bold;">Moda</td>
            </tr>
            <tr class="statistics statistics-median">
                <td scope="row" style="font-weight: bold;">Mediana</td>
            </tr>
            <tr class="statistics statistics-variance">
                <td scope="row" style="font-weight: bold;">Varianza</td>
            </tr>
            <tr class="statistics statistics-deviation">
                <td scope="row" style="font-weight: bold;">Desviación est.</td>
            </tr>
            <tr class="statistics statistics-cv">
                <td scope="row" style="font-weight: bold;">CV</td>
            </tr>
            <tr class="statistics statistics-avdv">
                <td scope="row" style="font-weight: bold;">Desviación media</td>
            </tr>
            <tr class="statistics statistics-se">
                <td scope="row" style="font-weight: bold;">Error estandar</td>
            </tr>
            <tr class="statistics statistics-skew">
                <td scope="row" style="font-weight: bold;">Skew</td>
            </tr>
            <tr class="statistics statistics-kurtosis">
                <td scope="row" style="font-weight: bold;">Kurtosis</td>
            </tr>
            <tr class="statistics statistics-ks10">
                <td scope="row" style="font-weight: bold;">Critical K-S stat, alpha=.10</td>
            </tr>
            <tr class="statistics statistics-ks05">
                <td scope="row" style="font-weight: bold;">Critical K-S stat, alpha=.05</td>
            </tr>
            <tr class="statistics statistics-ks01">
                <td scope="row" style="font-weight: bold;">Critical K-S stat, alpha=.01</td>
            </tr>
            <tr class="statistics statistics-kolmogorovSmirnov">
                <td scope="row" style="font-weight: bold;">Kolmogorov-Smirnov</td>
            </tr>
            <tr class="statistics statistics-q1">
                <td scope="row" style="font-weight: bold;">Percentil 25</td>
            </tr>
            <tr class="statistics statistics-q3">
                <td scope="row" style="font-weight: bold;">Percentil 75</td>
            </tr>
            <tr class="statistics statistics-confInt95">
                <td scope="row" style="font-weight: bold;">Intervalo de conf. 95%</td>
            </tr>
            <tr class="statistics statistics-confInt99">
                <td scope="row" style="font-weight: bold;">Intervalo de conf. 99%</td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="{{ asset('/css/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/easy-autocomplete.themes.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
    <style>
        #mapid {
            height: 87%;
            width: 100%
        }

        .my-custom-pin span::before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-top: 5px;
            margin-left: 5px;
            border-radius: 100%;
            background-color: #eee;
            border: 1px solid #888;
        }
        .my-custom-pin span.pmsfloat::before {
            display:none;
        }

        .chartjsLegend  {
            text-align: center;
        }
        .chartjsLegend li {
            list-style-type: none;
            display: inline-block;
            padding: 0 5px;
        }

        .chartjsLegend li span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
            border-radius: 25px;
            padding-bottom: 20px;
            font-size: 16px;
        }

        .legend {
            padding-bottom: 20px;
        }
        .shape {
            width: 15px;
            height: 15px;
            display: inline-block;
            border: 1px solid #999;
        }
        .circle {
            border-radius: 50%;
        }
        .cross {
            position: relative;
            border: 0;
        }
        .cross:before,
        .cross:after {
            position: absolute;
            left: 7px;
            content: ' ';
            height: 16px;
            width: 3px;
            background-color: #999;
        }
        .cross:before {
            transform: rotate(90deg);
        }

        .crossRot {
            position: relative;
            transform: rotate(45deg);
            border: 0;
        }
        .crossRot:before,
        .crossRot:after {
            position: absolute;
            left: 7px;
            content: ' ';
            height: 16px;
            width: 3px;
            background-color: #999;
        }
        .crossRot:before {
            transform: rotate(90deg);
        }
        .dash {
            border: 0;
            border-bottom: 2px dashed #999;
        }
        .line {
            border: 0;
            border-bottom: 2px solid #999;
        }
        .rect {
            border-radius: 2px;
        }
        .rectRounded {
            border-radius: 5px;
        }
        .rectRot {
            transform: rotate(45deg);
        }
        .star {
            background-color: #999;
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
            display: inline-block;
            height: 15px;
            width: 15px;
        }
        .triangle {
            width: 0;
            height: 0;
            border: 0;
            border-left: 7.5px solid transparent;
            border-right: 7.5px solid transparent;
            border-bottom: 15px solid #999;
        }


    </style>

@endpush
@push('scripts')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/chartjs-plugin-annotation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.easy-autocomplete.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-chart-box-and-violin-plot/2.4.0/Chart.BoxPlot.min.js" integrity="sha512-wThQu2PZG8h1zgYe9HNYAblGSRzSeZ7g584vrTiizIZJHw7gG1LCDZsLy/YHVnw3lp7pXXNJNa4ilECz1DiqPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://pomgui.github.io/chartjs-plugin-regression/dist/chartjs-plugin-regression-0.2.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/1.3.1/proj4.js" integrity="sha512-HPIkVeN4JL8hrWD1Mov+imhpp5AKR8ZnWYMeKOIg13HVSIZoq3TzFbXqMiJ0Ic5r9B0a/z3+MWd/H55MM9qycw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js" ></script>
    <script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        //BOX SETUP

        let sampling_point_box_array = new Array();
        let min_box = null;
        let max_box = null;
        //BOX SETUP
        let parameters_data_global_array = new Array();
        let deeps = @json(\App\Deep::pluck('name', 'id')->toArray());
        let sampling_point_filtered_array = new Array();
        let max_dataset_graph_index = 0;
        let offset = true;
        let mapa_width = 49;
        let graficos_width = 49;
        let legendLabelsArr = new Array();



        var $chartUserWon;
        var $chartRegression;
        var $charComparisson;
        var $charBox;
        var user_won_arr = @json($samplingResults);
        var user_won_arr2 = @json($samplingResults2);
        var samplingPoints = @json($samplingPoints);
        var parameters = @json($parameters);
        let users_won_canvas_html = "samplings_canvas";
        let regression_canvas_html = "samplings_canvas_regression";
        let comparisson_canvas_html = "samplings_canvas_comparisson";
        let box_canvas_html = "samplings_canvas_box";
        let users_won_title = "Temperatura de agua °C";
        let users_won_chart_type = "line";

        //MODELS AJAX ROUTES
        let parameter_data_route = "{{ route('tests.getSamplingParameterData') }}";
        let parameter_data_comparisson_route = "{{ route('tests.getSamplingParameterDataComparisson') }}";

        let pointStylesArr = ['circle', 'cross', 'crossRot', 'dash', 'line', 'rect', 'rectRounded', 'rectRot', 'star', 'triangle'];
        let pointStyleSpanishArr = {
            'circle': '<div class="shape circle"></div>',
            'cross': '<div class="shape cross"></div>',
            'crossRot': '<div class="shape crossRot"></div>',
            'dash': '<div class="shape dash"></div>',
            'line': '<div class="shape line"></div>',
            'rect': '<div class="shape rect"></div>',
            'rectRounded': '<div class="shape rectRounded"></div>',
            'rectRot': '<div class="shape rectRot"></div>',
            'star': '<div class="shape star"></div>',
            'triangle': '<div class="shape triangle"></div>'
        };
        let pointStyleBasin = [];
        let samplePointArr = [];

        function transparentColor(hexColor) {
            // Remove the "#" symbol from the beginning of the hexadecimal color code
            hexColor = hexColor.replace("#", "");

            // Convert the hexadecimal color code to an RGB color code
            var red = parseInt(hexColor.substring(0, 2), 16);
            var green = parseInt(hexColor.substring(2, 4), 16);
            var blue = parseInt(hexColor.substring(4, 6), 16);

            // Return the new hexadecimal color code with an alpha value of 0.5
            return "rgba(" + red + ", " + green + ", " + blue + ", 0.5)";
        }

        $(function() {
            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'es',
                sideBySide: true,
                buttons: {
                    showClose: true
                },
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });
            $('#datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'es',
                maxDate: new Date(),
                sideBySide: true,
                buttons: {
                    showClose: true
                },
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });
            $('#datetimepicker3').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'es',
                sideBySide: true,
                buttons: {
                    showClose: true
                },
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });
            $('#datetimepicker4').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'es',
                maxDate: new Date(),
                sideBySide: true,
                buttons: {
                    showClose: true
                },
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });
        });


        $(document).ready(function() {
            var greyIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
                //shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var greyIconFloating = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
                //shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var blueIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
                //shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });



            var mymap = L.map('mapid').setView([-16.18054, -71.2355378], 12.1);
            L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: '&copy;RedYaku',
                maxZoom: 18,
                //id: 'satellite-streets-v9',
                id: 'outdoors-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'sk.eyJ1IjoiaW5vbG9vcCIsImEiOiJja3V0czJqcHY1cndnMnVvOGZnbTAxZXhsIn0.tu0myQBz0e3p0rxge6qwzQ'
            }).addTo(mymap);

            jQuery.each(samplingPoints, function(i, samplingPoint) {
                let sp_id = samplingPoint.id;
                let latitude = parseFloat(samplingPoint.latitude);
                let longitude = parseFloat(samplingPoint.longitude);
                let north = parseFloat(samplingPoint.north);
                let east = parseFloat(samplingPoint.east);
                let name = samplingPoint.name;

                let type = samplingPoint.type;
                let basin_id = samplingPoint.basin_id;
                let reservoir_id = samplingPoint.reservoir_id;
                let zone_id = samplingPoint.zone_id;

                const myCustomColour = '#999';
                const myCustomColourFloat = '#120088';

                const markerHtmlStyles = `
                      background-color: ${myCustomColour};
                      width: 30px;
                      height: 30px;
                      display: block;
                      left: -15px;
                      top: -15px;
                      position: relative;
                      border-radius: 10px 20px 0;
                      transform: rotate(45deg);
                      border: 2px solid #eee`;
                const markerHtmlStylesFloat = `
                      background-color: ${myCustomColourFloat};
                        width: 14px;
                        height: 14px;
                        display: block;
                        left: -7px;
                        top: -7px;
                        position: relative;
                        border-radius: 100%;`;

                const icon2 = new L.divIcon({
                    className: "my-custom-pin",
                    iconAnchor: [0, 24],
                    labelAnchor: [-6, 0],
                    popupAnchor: [0, -36],
                    html: `<span class="point-marker-span" style="${markerHtmlStyles}" />`
                });

                const icon2float = new L.divIcon({
                    className: "my-custom-pin",
                    iconAnchor: [0, 24],
                    labelAnchor: [-6, 0],
                    popupAnchor: [0, -36],
                    html: `<span class="point-marker-span pmsfloat" style="${markerHtmlStylesFloat}" />`
                });


                let icon = icon2;

                if (type == 2) {
                    icon = icon2float;
                }

                let marker = L.marker([latitude, longitude], {
                        icon: icon
                    }).bindPopup($("#pcc")[0]).addTo(mymap),
                    options = {
                        index: sp_id,
                        name: name,
                        latitude: latitude,
                        longitude: longitude,
                        north: north,
                        east: east,
                    };

                $(marker._icon).attr("filter_type", type);
                $(marker._icon).attr("filter_basin_id", basin_id);
                $(marker._icon).attr("filter_reservoir_id", reservoir_id);
                $(marker._icon).attr("filter_zone_id", zone_id);
                $(marker._icon).attr("filter_id", sp_id);
                $(marker._icon).attr("filter_true", 0);
                $(marker._icon).attr("sampling_point", sp_id);

                marker.on("click", onMarkerClickPopupChart, options);

            });


            var $markers = $('.leaflet-marker-icon');
            sampling_point_filtered_array =[];

            $markers.each(function() {
                let sampling_point = $(this).attr("sampling_point");
                sampling_point_filtered_array.push(sampling_point);
            });

            // Add the ID
            function onMarkerClickPopupChart(e) {
                var index = this.index;
                var name = this.name;
                var latitude = this.latitude;
                var longitude = this.longitude;
                var north = this.north;
                var east = this.east;

                let $addBtn = $('<a/>', {
                    text: 'Agregar a gráfico',
                    class: 'add-graph-modal-btn',
                    href: '#modalPuntos',
                    'data-toggle': 'modal',
                    'data-point': index,
                    'data-name': name,
                    'data-target': '#modalPuntos',
                }).click(function() {
                    $("#sampling_point_id").val(index);
                    $("#point_name").val(name);
                    $(".loading-data-info").hide();
                });

                $("#pcc").html(
                    "<b>Punto</b>: " + name + "<br/>" +
                    "<b>Latitud:</b> " + latitude + "<br/>" +
                    "<b>Longitud:</b> " + longitude + "<br/>" +
                    "<b>E:</b> " + north + "<br/>" +
                    "<b>N:</b> " + east + "<br/>"
                ).append($addBtn);
            }

            $charBox = drawBoxChartNew(samplingPoints, box_canvas_html);
            $charComparisson = drawChartRadarNew(samplingPoints, comparisson_canvas_html);
            $chartUserWon = drawChartNew(user_won_arr, users_won_canvas_html, users_won_title, users_won_chart_type);
            $chartRegression = drawChartRegressionNew(user_won_arr, regression_canvas_html, users_won_title, users_won_chart_type);


            /*AUTOCOMPETE*/

            //////AUTOCOMPLETE SETUP///////
            let parameters_options = [];
            $.each(parameters, function(key, element) {
                let name = element.name + " (" + element.unit.symbol + ")";
                let parameters_obj = {
                    id: element.id,
                    name: name
                };
                parameters_options.push(parameters_obj);
            });

            var options = {
                data: parameters_options,
                getValue: "name",
                list: {
                    onSelectItemEvent: function() {
                        event.preventDefault();
                        var value = $("#parametersAutocomplete").getSelectedItemData().id;
                        $("#parameter_id").val(value);
                        return false;
                    },
                    match: {
                        enabled: true
                    },
                    maxNumberOfElements: 5,
                }
            };

            var optionsMultiple = {
                data: parameters_options,
                getValue: "name",
                list: {
                    onSelectItemEvent: function() {
                        var value = $("#multipleParametersAutocomplete").getSelectedItemData().id;
                        $("#multiple_parameter_id").val(value);
                    },
                    match: {
                        enabled: true
                    },
                    maxNumberOfElements: 5,
                }
            };
            $("#parametersAutocomplete").easyAutocomplete(options);
            $("#multipleParametersAutocomplete").easyAutocomplete(optionsMultiple);
            //////AUTOCOMPLETE SETUP///////

            $(document).on('change', '.point_check_input', function() {
                let number_of_filters = $(".visor-filter-points-wrapp").length;
                var $filterWrapps = $(".visor-filter-points-wrapp");

                //REMOVEMOS LOS FILTROS QUE SE HAN AGREGADO
                for (let i = 1; i <= number_of_filters; i++) {
                    $('.leaflet-marker-icon').removeClass("filtro_" + i);
                }

                let temp_filter_true = 1;

                $filterWrapps.each(function() {
                    let filter_type = $(this).attr("data-filter");

                    let $filter_inputs = $(this).find('.point_check_input:checked');

                    $filter_inputs.each(function() {
                        let filter_value = $(this).val();
                        let filter = "filter_" + filter_type;
                        $('.leaflet-marker-icon[' + filter + '=' + filter_value + ']').addClass("filtro_" + temp_filter_true);
                    });

                    temp_filter_true++;
                });

                var $markers = $('.leaflet-marker-icon');
                $markers.hide();
                sampling_point_filtered_array =[];

                $markers.each(function() {

                    let numberFilters = 0;
                    for (let i = 1; i <= number_of_filters; i++) {
                        let hasFilterClass = $(this).hasClass("filtro_" + i);
                        if (hasFilterClass) {
                            numberFilters++;
                        }
                    }
                    if (numberFilters == number_of_filters) {
                        $(this).show();
                        let sampling_point = $(this).attr("sampling_point");
                        sampling_point_filtered_array.push(sampling_point);
                    }


                });


            });

            $(document).on('change', '.reservoir_input', function() {
                $('.zones_input').each(function(i, obj) {
                    $(obj).prop('checked', false);
                    $(obj).hide();
                    $(obj).closest('label').hide();
                });
                $('.reservoir_input').each(function(i, reservoirObj) {
                    var is_checked = $(reservoirObj).is(":checked")
                    var data_points_reservoir = JSON.parse($(reservoirObj).attr('data-points'));

                    if(is_checked){
                        $('.zones_input').each(function(i, obj) {
                            var data_points_zone = JSON.parse($(this).attr('data-points'));

                            $.each(data_points_zone, function(index, data_point){
                                // IF POINT IN COMMON
                                if($.inArray(data_point,data_points_reservoir)!=-1){
                                    $(obj).prop('checked', true);
                                    $(obj).show();
                                    $(obj).closest('label').show();
                                }
                            });

                        });
                    }

                });
            });
            /*FIXING PROBLEM FOR LEAFLET ON TAB: https://gis.stackexchange.com/questions/349295/leaflet-tiles-are-not-loading-for-multiple-bootstrap-tabs*/
            var mapSectionTab = document.getElementById('map-section');
            var observer1 = new MutationObserver(function(){
                if(mapSectionTab.style.display != 'none'){
                    mymap.invalidateSize();
                }
            });
            observer1.observe(mapSectionTab, {attributes: true});

            $('body').on('click', '.multiple-points-modal-btn', function() {
                $(".loading-data-info").hide();

            });
            $('body').on('click', '.graph-type-btn.graph-single', function() {
                $(".graph-type-btn.graph-single").removeClass("active");
                $(this).addClass("active");
                let graph_type = $('input[name=graph-type]:checked').val();
            });
            $('body').on('click', '.editar-grafico-btn', function() {
                $chartUserWon.destroy();
                $chartUserWon = drawChartNew(user_won_arr, users_won_canvas_html, users_won_title, users_won_chart_type);
                max_dataset_graph_index = 0;
                let color_background = $("#edit-background-canvas").val();

                $("#samplings_canvas").css("background-color", color_background);

                let temp_parameters_arr = [];
                let dataset_graph_index = 0;
                $.each($(".row-graph-edit"), function(index, data) {
                    let index_in_global_arr = $(this).attr("data-graph");

                    let color = $(this).find(".color-edit").val();
                    let graph_type = $(this).find(".graph-type-edit").val();
                    let show_ecas = $(this).find(".ecas-edit").is(":checked");

                    let parameter_obj = parameters_data_global_array[index_in_global_arr];

                    let samplingData = parameter_obj.data;
                    let pointStyle = parameter_obj.point_style;
                    let samplingPoint = parameter_obj.sampling_point_id;
                    let parameter_name = parameter_obj.parameter_name;
                    let point_name = parameter_obj.point_name;
                    let deep_id = parameter_obj.deep_id;
                    console.log("BBBBBBBBBB")
                    console.log(parameter_obj)
                    console.log(parameter_obj.deep_id)
                    //let dataset_graph_index = parameter_obj.dataset_graph_index;
                    //let type_graph_data = parameter_obj.type_graph_data;
                    let eca = parameter_obj.eca;

                    if (!show_ecas) {
                        eca = {
                            allowed_value: null,
                            max_value: null,
                            min_value: null,
                            parameter_id: 1
                        };
                    }

                    let type_graph_data = 0;
                    if (temp_parameters_arr.length == 0) {
                        type_graph_data = 0;
                        temp_parameters_arr[parameter_obj.parameter_id] = 0;
                    } else {
                        if(temp_parameters_arr[parameter_obj.parameter_id] >= 0){
                            type_graph_data = 1;
                            dataset_graph_index = temp_parameters_arr[parameter_obj.parameter_id];
                        }else{
                            type_graph_data = 2;
                            dataset_graph_index = max_dataset_graph_index + 1;
                            max_dataset_graph_index = dataset_graph_index;
                            temp_parameters_arr[parameter_obj.parameter_id] = dataset_graph_index;
                        }
                    }

                    parameter_obj.type_graph_data =type_graph_data;
                    parameter_obj.dataset_graph_index =dataset_graph_index;
                    parameters_data_global_array[index_in_global_arr] = parameter_obj;
                    addDataToGraph(samplingData, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, eca, type_graph_data, false, false, deep_id);

                    parameters_data_global_array[index_in_global_arr].color = color;
                    parameters_data_global_array[index_in_global_arr].graph_type = graph_type;


                    $(".leaflet-marker-icon[sampling_point=" + samplingPoint + "] .point-marker-span").css("background-color", color);
                });

                $("#modalEditarGrafico").modal("hide");


            });
            $('body').on('click', '.editar-grafico-modal-btn', function() {
                $(".editar-grafico-tbody").html("");

                $.each(parameters_data_global_array, function(index, data) {

                    var $tr = $('<tr>', {
                        class: 'row-graph-edit'
                    }).append(
                        $('<td>').html("<b>" + data.parameter_name + " en " + data.point_name + "</b>"),
                        $('<td>').html("<input type='color' value='" + data.color + "' class='color-edit'>"),
                        $('<td>').html("<input type='checkbox' class='ecas-edit'>"),
                    ).attr("data-graph", index).prependTo('.editar-grafico-tbody');

                    let select_wrapp_html = $('<td/>', {
                        class: 'form-group',
                    }).appendTo($tr);

                    let select_html = $('<select/>', {
                        class: 'form-control graph-type-edit d-inline-block w-100',
                    }).appendTo(select_wrapp_html);

                    if (data.graph_type == "line") {
                        let option_line = $('<option/>', {
                            value: 'line',
                            html: 'Linea',
                            selected: "selected"
                        }).appendTo(select_html);
                    } else {
                        let option_line = $('<option/>', {
                            value: 'line',
                            html: 'Linea',
                        }).appendTo(select_html);
                    }

                    if (data.graph_type == "bar") {
                        let option_line = $('<option/>', {
                            value: 'bar',
                            html: 'Barra',
                            selected: "selected"
                        }).appendTo(select_html);
                    } else {
                        let option_line = $('<option/>', {
                            value: 'bar',
                            html: 'Barra',
                        }).appendTo(select_html);
                    }

                    if (data.graph_type == "scatter") {
                        let option_line = $('<option/>', {
                            value: 'scatter',
                            html: 'Puntos',
                            selected: "selected"
                        }).appendTo(select_html);
                    } else {
                        let option_line = $('<option/>', {
                            value: 'scatter',
                            html: 'Puntos',
                        }).appendTo(select_html);
                    }



                    //addDataToGraph(data.samplingData, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, data.eca, type_graph_data);
                });


            });
            $('body').on('click', '.zoom-in-graph', function() {
                if(mapa_width > 20){
                    mapa_width = mapa_width - 10;
                    graficos_width = graficos_width +10;

                    $(".mapa-wrapp").css("width", mapa_width+"%");
                    $(".graficos-wrapp").css("width", graficos_width+"%");

                    $chartUserWon.resize();
                    $charComparisson.resize();
                    $charBox.resize();
                    ///$(window).trigger('resize');
                }
            });
            $('body').on('click', '.zoom-out-graph', function() {
                if(graficos_width > 20){
                    mapa_width = mapa_width + 10;
                    graficos_width = graficos_width - 10;

                    $(".mapa-wrapp").css("width", mapa_width+"%");
                    $(".graficos-wrapp").css("width", graficos_width+"%");

                    $chartUserWon.resize();
                    $charComparisson.resize();
                    $charBox.resize();
                    //$(window).trigger('resize');
                }
            });

            $('body').on('click', '.select-deselect', function() {

                let targets = $(this).attr("data-targets");

                $.each($(".point_check_input[data-filter-type="+targets+"]"), function(index, chk_point) {
                    $(this).click();
                });



            });
            $('body').on('click', '.graph-type-btn.graph-multiple', function() {
                $(".graph-type-btn.graph-multiple").removeClass("active");
                $(this).addClass("active");
                let graph_type = $('input[name=multiple-graph-type]:checked').val();
            });
            $('body').on('click', '.add-parameter', function() {
                $(".loading-data-info").show();

                let samplingPoint = $("#sampling_point_id").val();
                let point_name = $("#point_name").val();

                $.each($(".parameter_single"), function(index, sample) {
                    if($(this).val()){
                        let parameter = $(this).val();

                        //let parameter_name = $("#parametersAutocomplete").val();
                        let parameter_name = $( this ).find('option:selected').text();
                        let sampling_date_inicio = $("#sampling_date").val();
                        let sampling_date_fin = $("#sampling_date2").val();
                        let deep = $("#deep_id").val();
                        let graph_type = $('input[name=graph-type]:checked').val();
                        let area_type = $('#area-type').is(':checked');
                        let scale_type = $('#scale-type').is(':checked');
                        let color = randomColor();
                        obtenerDatosMuestreo(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin, area_type, scale_type, color);
                        //obtenerDatosMuestreoRegression(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin, area_type, scale_type, color);
                        obtenerDatosMuestreoBox(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin);
                    }
                });
                $("#statistics-tab").click();
            });
            $('body').on('click', '.multiple-add-parameter', function() {
                $(".loading-data-info").show();

                let sampling_date_inicio = $("#multiple_sampling_date").val();
                let sampling_date_fin = $("#multiple_sampling_date2").val();
                let deep = $("#multiple_deep_id").val();
                let graph_type = $('input[name=multiple-graph-type]:checked').val();
                let area_type = $('#multiple-area-type').is(':checked');
                let scale_type = $('#multiple-scale-type').is(':checked');

                console.log("bbbbbbbbbbbbbbbbbb");
                $.each($(".parameter_multiple"), function(index, sample) {
                    console.log(index);
                    if($(this).val()){
                        console.log("aaaaaaaaaaaaaaaaaaa");
                        let parameter = $(this).val();
                        let parameter_name = $( this ).find('option:selected').text();


                        if (graph_type == "radar") {
                            obtenerDatosMuestreoCompararPuntos(deep, parameter_name, parameter, sampling_date_inicio, sampling_date_fin);
                            $("#comparative-tab").click();
                        } else {
                            let temp = 0;
                            $.each(samplingPoints, function(index, data) {
                                let samplingPoint = data.id;
                                let point_name = data.name;

                                let color = randomColor();
                                if(jQuery.inArray(samplingPoint.toString(), sampling_point_filtered_array) !== -1){
                                    temp++;
                                    //obtenerDatosMuestreo(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin);
                                    obtenerDatosMuestreo(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin, area_type, scale_type, color);
                                    obtenerDatosMuestreoBox(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin);
                                }
                                console.log(temp);
                            });
                            if(temp == 0){
                                $("#modalPuntos").modal("hide");
                                $("#modalMultiplesPuntos").modal("hide");
                                alert("No se seleccionó ningún punto. Por favor seleccione por lo menos un punto.");
                            }else{
                                $("#statistics-tab").click();
                            }
                        }

                    }

                });

            });
            /*
                    $('body').on('click', '.dwn-estadisticos-csv', function() {

                    });*/
            $('.dwn-estadisticos-csv').click(function() {
                var titles = [];
                var data = [];

                /*
                 * Get the table headers, this will be CSV headers
                 * The count of headers will be CSV string separator
                 */
                $('.table-statistics th').each(function() {
                    titles.push($(this).text());
                });

                /*
                 * Get the actual data, this will contain all the data, in 1 array
                 */
                $('.table-statistics td').each(function() {
                    data.push($(this).text());
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


            $('body').on('click', '.ver-estadisticos-modal-btn', function() {

                var $table = $('.table-statistics-clone-wrapp table').clone().addClass("table-statistics");
                $('.table-statistics-wrapp').html($table);


                for (let i = 0; i < parameters_data_global_array.length; i++) {
                    let parameter_index_on_global_array = i;

                    let parameter_data = parameters_data_global_array[parameter_index_on_global_array];
                    let parameter_data_sample = parameter_data.data;
                    let label = parameter_data.parameter_name + " en " + parameter_data.point_name;

                    let parameter_data_sample_values = new Array();

                    let minDate = moment();
                    let maxDate = null;
                    $.each(parameter_data_sample, function(index, sample) {

                        parameter_data_sample_values.push(parseFloat(sample.value));
                        let date = moment(sample.sampling_date);
                        if(date < minDate ){
                            minDate = date;
                        }
                        if(date > maxDate || !maxDate){
                            maxDate = date;
                        }
                        /*
                            let date = moment(sample.sampling_date).format('DD/MM/YYYY');
                            var $tr = $('<tr>').append(
                                $('<th>').attr("data-date", date).text(date),
                                $('<td>').attr("data-set", parameter_index_on_global_array).text(sample.value),
                            ).attr("data-date", date).prependTo('.table-statistics tbody');
        */
                    });

                    let statistical_data = getStatistics(parameter_data_sample_values);

                    let ecaHtml = "";
                    if(parameter_data.eca.allowed_value){
                        ecaHtml =  ecaHtml + ("<div>Valor permitido: " + parameter_data.eca.allowed_value + "</div>");
                    }
                    if(parameter_data.eca.max_value){
                        ecaHtml =  ecaHtml + ("<div>Valor máximo permitido: " + parameter_data.eca.max_value + "</div>");
                    }
                    if(parameter_data.eca.min_value){
                        ecaHtml =  ecaHtml + ("<div>Valor mínimo permitido: " + parameter_data.eca.min_value + "</div>");
                    }
                    ecaHtml = ("<div>" + ecaHtml + "</div>");

                    //thead
                    $('<th>').append($('<span>').text(label)).appendTo('.table-statistics thead tr');
                    //thead

                    //tbody
                    $('<td>').append($('<span>').text(parameter_data.point_name)).appendTo('.table-statistics .statistics-point');
                    $('<td>').append($('<span>').text(minDate.format('DD/MM/YYYY'))).appendTo('.table-statistics .statistics-start');
                    $('<td>').append($('<span>').text(maxDate.format('DD/MM/YYYY'))).appendTo('.table-statistics .statistics-end');
                    $('<td>').append($('<span>').html(ecaHtml)).appendTo('.table-statistics .statistics-eca');
                    $('<td>').append($('<span>').text(statistical_data.range)).appendTo('.table-statistics .statistics-range');
                    $('<td>').append($('<span>').text(statistical_data.first)).appendTo('.table-statistics .statistics-first');
                    $('<td>').append($('<span>').text(statistical_data.last)).appendTo('.table-statistics .statistics-last');
                    $('<td>').append($('<span>').text(statistical_data.length)).appendTo('.table-statistics .statistics-length');
                    $('<td>').append($('<span>').text(statistical_data.max)).appendTo('.table-statistics .statistics-max');
                    $('<td>').append($('<span>').text(statistical_data.min)).appendTo('.table-statistics .statistics-min');
                    $('<td>').append($('<span>').text(statistical_data.sum)).appendTo('.table-statistics .statistics-sum');
                    $('<td>').append($('<span>').text(statistical_data.mean)).appendTo('.table-statistics .statistics-mean');
                    $('<td>').append($('<span>').text(statistical_data.median)).appendTo('.table-statistics .statistics-median');
                    $('<td>').append($('<span>').text(statistical_data.mode)).appendTo('.table-statistics .statistics-mode');
                    $('<td>').append($('<span>').text(statistical_data.variance)).appendTo('.table-statistics .statistics-variance');
                    $('<td>').append($('<span>').text(statistical_data.std)).appendTo('.table-statistics .statistics-deviation');
                    $('<td>').append($('<span>').text(statistical_data.cv)).appendTo('.table-statistics .statistics-cv');
                    $('<td>').append($('<span>').text(statistical_data.avdv)).appendTo('.table-statistics .statistics-avdv');
                    $('<td>').append($('<span>').text(statistical_data.se)).appendTo('.table-statistics .statistics-se');
                    $('<td>').append($('<span>').text(statistical_data.skew)).appendTo('.table-statistics .statistics-skew');
                    $('<td>').append($('<span>').text(statistical_data.kurtosis)).appendTo('.table-statistics .statistics-kurtosis');
                    $('<td>').append($('<span>').text(statistical_data.ks10)).appendTo('.table-statistics .statistics-ks10');
                    $('<td>').append($('<span>').text(statistical_data.ks05)).appendTo('.table-statistics .statistics-ks05');
                    $('<td>').append($('<span>').text(statistical_data.ks01)).appendTo('.table-statistics .statistics-ks01');
                    $('<td>').append($('<span>').text(statistical_data.kolmogorovSmirnov)).appendTo('.table-statistics .statistics-kolmogorovSmirnov');
                    $('<td>').append($('<span>').text(statistical_data.q25)).appendTo('.table-statistics .statistics-q1');
                    $('<td>').append($('<span>').text(statistical_data.q75)).appendTo('.table-statistics .statistics-q3');
                    $('<td>').append($('<span>').text("("+statistical_data.confInt95[0]+", "+statistical_data.confInt95[1]+")")).appendTo('.table-statistics .statistics-confInt95');
                    $('<td>').append($('<span>').text("("+statistical_data.confInt99[0]+", "+statistical_data.confInt99[1]+")")).appendTo('.table-statistics .statistics-confInt99');
                    //tbody


                    $(".table-statistics").show();


                }


            });

            $('body').on('click', '.download-graph', function() {
                html2canvas(document.querySelector(".graph-canvas-wrapp")).then(canvas => {
                    saveAs(canvas.toDataURL(), 'datos-1.png');
                });
                html2canvas(document.querySelector("#samplings_canvas_comparisson")).then(canvas => {
                    saveAs(canvas.toDataURL(), 'datos-2.png');
                });

                $(".samplings_canvas_regression_wrapp .canvas-report").each(function (index, element) {
                    let element_id = $(this).attr('id');
                    html2canvas(document.querySelector("#"+element_id)).then(canvas => {
                        saveAs(canvas.toDataURL(), 'datos-reg-'+index+'.png');
                    });
                });

                $(".boxes-wrapp .canvas-report").each(function (index, element) {
                    let element_id = $(this).attr('id');
                    html2canvas(document.querySelector("#"+element_id)).then(canvas => {
                        saveAs(canvas.toDataURL(), 'datos-box-'+index+'.png');
                    });
                });
                /*
                            html2canvas($(".graph-canvas-wrapp"), {
                                onrendered: function(canvas) {
                                    saveAs(canvas.toDataURL(), 'canvas.png');
                                }
                            });
                            */
            });

            $('body').on('click', '.download-statistics-image', function() {
                html2canvas(document.querySelector(".table-statistics")).then(canvas => {
                    saveAs(canvas.toDataURL(), 'estadisticos.png');
                });
                /*
                            html2canvas($(".graph-canvas-wrapp"), {
                                onrendered: function(canvas) {
                                    saveAs(canvas.toDataURL(), 'canvas.png');
                                }
                            });
                            */
            });

            function saveAs(uri, filename) {
                var link = document.createElement('a');

                if (typeof link.download === 'string') {
                    link.href = uri;
                    link.download = filename;

                    //Firefox requires the link to be in the body
                    document.body.appendChild(link);

                    //simulate click
                    link.click();

                    //remove the link when done
                    document.body.removeChild(link);
                } else {
                    window.open(uri);
                }
            }
            $('body').on('click', '.restart-graph', function() {
                pointStylesArr = ['circle', 'cross', 'crossRot', 'dash', 'line', 'rect', 'rectRounded', 'rectRot', 'star', 'triangle'];
                pointStyleBasin = [];
                samplePointArr = [];

                $chartUserWon.destroy();
                $chartRegression.destroy();
                $("#chartjsLegend").html("");
                $(".regresion-formulas").html("");

                parameters_data_global_array = new Array();
                max_dataset_graph_index = 0;
                offset = true;

                $(".leaflet-marker-icon .point-marker-span").css("background-color", "#999");

                $chartUserWon = drawChartNew(user_won_arr, users_won_canvas_html, users_won_title, users_won_chart_type);
                //$chartRegression = drawChartRegressionNew(user_won_arr, regression_canvas_html, users_won_title, users_won_chart_type);

                let labels_radar_arr = [];
                $(samplingPoints).each(function (index, samplingPoint) {
                    let name = samplingPoint.name;
                    labels_radar_arr.push(name);
                });
                //DIBUJAMOS LA DATA
                var ctx2 = $('#samplings_canvas_comparisson');
                $charComparisson = new Chart(ctx2, {
                    type: "radar",
                    data: {
                        labels: labels_radar_arr,
                    },
                    options: {
                        elements: {
                            line: {
                                borderWidth: 3
                            }
                        },
                        scales: {
                            yAxes: [
                            ],
                        },
                    }
                });

                // RESTART BOX
                $(".boxes-wrapp").html("<canvas id='samplings_canvas_box' class='canvas-report'></canvas>");
                sampling_point_box_array = [];
                drawBoxChartNew(samplingPoints, "samplings_canvas_box");

                // RESTART regression
                $(".samplings_canvas_regression_wrapp").html("<canvas id='samplings_canvas_regression' class='canvas-report' ></canvas>");
                $chartRegression = drawChartRegressionNew(user_won_arr, regression_canvas_html, users_won_title, users_won_chart_type);



            });


        });

    </script>
@endpush
