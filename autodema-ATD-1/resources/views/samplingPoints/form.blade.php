@extends('layouts.app', ['page' => 'sampling-points'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Punto de Muestreo"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $samplingPoint->id ? route('samplingPoints.store'): route('samplingPoints.update', $samplingPoint->id) }}"
            novalidate
        >
            @if($samplingPoint->id)
                @method('PUT')
            @endif

            @csrf

            <div class="form-group">
                <label for="name">Identificación</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}"
                    name="name"
                    id="name"
                    placeholder=""
                    value="{{ old('name') ?: $samplingPoint->name }}"
                    required
                >
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="hidrographic_unit">Unidad hidrográfica</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('hidrographic_unit') ? 'is-invalid': '' }}"
                    name="hidrographic_unit"
                    id="hidrographic_unit"
                    placeholder=""
                    value="{{ old('hidrographic_unit') ?: $samplingPoint->hidrographic_unit }}"
                    required
                >
                @if($errors->has('hidrographic_unit'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('hidrographic_unit') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="utm_zone">Zona UTM</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('utm_zone') ? 'is-invalid': '' }}"
                    name="utm_zone"
                    id="utm_zone"
                    placeholder=""
                    value="{{ old('utm_zone') ?: $samplingPoint->utm_zone }}"
                    required
                >
                @if($errors->has('utm_zone'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('utm_zone') }}</strong>
                </span>
                @endif
            </div>

                <div class="form-group">
                    <label for="type">Tipo</label>
                    <select
                        class="form-control {{ $errors->has('type') ? 'is-invalid': '' }}"
                        name="type"
                        id="type"
                        required
                    >
                        <option
                            {{
                                (int) old('type') === \App\SamplingPoint::FIXED_POINT
                                ||
                                (int) $samplingPoint->type === \App\SamplingPoint::FIXED_POINT
                                ?
                                'selected' : ''
                            }}
                            value="{{ \App\SamplingPoint::FIXED_POINT }}"
                        >{{ \App\SamplingPoint::FIXED_DESCRIPTION }}</option>
                        <option
                            {{
                                (int) old('type') === \App\SamplingPoint::FLOAT_POINT
                                ||
                                (int) $samplingPoint->type === \App\SamplingPoint::FLOAT_POINT
                                ?
                                'selected' : ''
                            }}
                            value="{{ \App\SamplingPoint::FLOAT_POINT }}"
                        >{{ \App\SamplingPoint::FLOAT_DESCRIPTION }}</option>
                    </select>
                </div>

                <div class="form-group">
                <label for="north">Norte</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('north') ? 'is-invalid': '' }}"
                    name="north"
                    id="north"
                    placeholder=""
                    value="{{ old('north') ?: $samplingPoint->north }}"
                    required
                >
                @if($errors->has('north'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('north') }}</strong>
            </span>
                @endif
            </div>
            <div class="form-group">
                <label for="east">Este</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('east') ? 'is-invalid': '' }}"
                    name="east"
                    id="east"
                    placeholder=""
                    value="{{ old('east') ?: $samplingPoint->east }}"
                    required
                >
                @if($errors->has('east'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('east') }}</strong>
            </span>
                @endif
            </div>
            <div class="form-group">
                <label for="eca_id">ECA</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('eca_id') ? 'is-invalid': '' }}"
                    name="eca_id"
                    id="eca_id"
                >
                    @foreach($ecas as $eca)
                        <option
                            {{ (int) old('eca_id') === $eca->id || $samplingPoint->eca_id === $eca->id ? 'selected' : '' }}
                            value="{{ $eca->id }}"
                        >{{ $eca->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="eca_2_id">ECA de transición</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('eca_2_id') ? 'is-invalid': '' }}"
                    name="eca_2_id"
                    id="eca_2_id"
                >
                    @foreach($transitionEcas as $eca)
                        <option
                            {{ (int) old('eca_2_id') === $eca->id || $samplingPoint->eca_2_id === $eca->id ? 'selected' : '' }}
                            value="{{ $eca->id }}"
                        >{{ $eca->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="basin_id">Cuenca</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('basin_id') ? 'is-invalid': '' }}"
                    name="basin_id"
                    id="basin_id"
                >
                    @foreach($basins as $basin)
                        <option
                            {{ (int) old('basin_id') === $basin->id || $samplingPoint->basin_id === $basin->id ? 'selected' : '' }}
                            value="{{ $basin->id }}"
                        >{{ $basin->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="reservoir_id">Embalse</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('reservoir_id') ? 'is-invalid': '' }}"
                    name="reservoir_id"
                    id="reservoir_id"
                >
                    @foreach($reservoirs as $reservoir)
                        <option
                            {{ (int) old('reservoir_id') === $reservoir->id || $samplingPoint->reservoir_id === $reservoir->id ? 'selected' : '' }}
                            value="{{ $reservoir->id }}"
                        >{{ $reservoir->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="zone_id">Zona</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control {{ $errors->has('zone_id') ? 'is-invalid': '' }}"
                    name="zone_id"
                    id="zone_id"
                >
                    @foreach($zones as $zone)
                        <option
                            {{ (int) old('zone_id') === $zone->id || $samplingPoint->zone_id === $zone->id ? 'selected' : '' }}
                            value="{{ $zone->id }}"
                        >{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-secondary">
                    {{ __($btnText) }}
                </button>
            </div>

        </form>

    </div>
@endsection
@push('styles')
    <link rel="stylesheet"  href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript"  src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'es',
                minDate: new Date(),
                sideBySide: true,
                buttons: {showClose: true},
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });
        });


    </script>
@endpush
