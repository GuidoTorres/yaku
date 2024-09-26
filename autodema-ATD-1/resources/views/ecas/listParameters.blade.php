@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.ecas.searchParameters')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Parámetro
                        <a
                            class="btn btn-third"
                            href="{{ route("ecas.createParameter", $eca->id) }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>

                        @if($showCopyParameters)
                            <form
                                method="POST"
                                action="{{ route('ecas.copy', $eca->id) }}"
                                class="d-inline-flex"
                                novalidate
                            >
                                @csrf
                                <select
                                    class="form-control"
                                    name="eca_to_copy"
                                    id="eca_to_copy"
                                    style="width: 180px;"
                                    required
                                >
                                    @foreach(\App\Eca::pluck('name', 'id') as $id => $name)
                                        <option
                                            value="{{ $id }}"
                                        >{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-secondary">
                                        Copiar parámetros
                                    </button>
                                </div>
                            </form>
                        @endif

                    </th>
                    <th scope="col">ECA</th>
                </tr>
                </thead>
                <tbody>
                @forelse($ecaParameters as $ecaParameter)
                    <tr>
                        <td>
                            <a
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Ver información de parámetro"
                                href="{{ route('parameters.admin', $ecaParameter->parameter->id) }}"
                            >{{ $ecaParameter->parameter->name }}</a>

                            <a
                                class="btn btn-edit"
                                href="{{ route('ecas.editParameter', $ecaParameter->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar eca de parámetro"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>

                        </td>
                        <td>
                            @if(isset($ecaParameter->min_value))
                                <b>Mínimo:</b> {{ $ecaParameter->min_value }} {!! $ecaParameter->parameter->unit->symbol !!}<br>
                            @endif
                            @if(isset($ecaParameter->near_min_value))
                                <b>Intermedio mínimo:</b> {{ $ecaParameter->near_min_value }} {!! $ecaParameter->parameter->unit->symbol !!}<br>
                            @endif
                            @if(isset($ecaParameter->max_value))
                                <b>Máximo:</b> {{ $ecaParameter->max_value }} {!! $ecaParameter->parameter->unit->symbol !!}<br>
                            @endif
                            @if(isset($ecaParameter->near_max_value))
                                <b>Intermedio máximo:</b> {{ $ecaParameter->near_max_value }} {!! $ecaParameter->parameter->unit->symbol !!}<br>
                            @endif
                            @if(isset($ecaParameter->allowed_value))
                                <b>Valor permitido:</b> {{ $ecaParameter->allowed_value }}
                            @endif
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


        <div class="row justify-content-center">
            {{ $ecaParameters->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
