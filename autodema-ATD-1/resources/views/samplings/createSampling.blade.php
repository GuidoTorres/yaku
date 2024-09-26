@extends('layouts.app', ['page' => 'sampling-points'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Nuevo muestreo"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $sampling->id ? route('samplings.store'): route('samplings.update', $sampling->id) }}"
            novalidate
        >
            @if($sampling->id)
                @method('PUT')
            @endif

            @csrf
            <div class="form-group d-none">
                <label for="number">Punto de muestreo</label>
                <input
                    type="number"
                    class="form-control {{ $errors->has('sampling_point_id') ? 'is-invalid': '' }}"
                    name="sampling_point_id"
                    id="sampling_point_id"
                    placeholder=""
                    value="{{ old('sampling_point_id') ?: $samplingPoint->id }}"
                    required
                >
                @if($errors->has('sampling_point_id'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('sampling_point_id') }}</strong>
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
                    value="{{ old('utm_zone') ?: $sampling->utm_zone }}"
                    required
                >
                @if($errors->has('utm_zone'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('utm_zone') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="north">Norte</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('north') ? 'is-invalid': '' }}"
                    name="north"
                    id="north"
                    placeholder=""
                    value="{{ old('north') ?: $sampling->north }}"
                    required
                >
                Norte de punto de muestreo: {{ $samplingPoint->north }}
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
                    value="{{ old('east') ?: $sampling->east }}"
                    required
                >
                Este de punto de muestreo: {{ $samplingPoint->east }}
                @if($errors->has('east'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('east') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="deep_id">Zona de luz</label>
                <select
                    class="form-control {{ $errors->has('deep_id') ? 'is-invalid': '' }}"
                    name="deep_id"
                    id="deep_id"
                >
                    @foreach($deeps as $deep)
                        <option
                            {{ (int) old('deep_id') === $deep->id || $sampling->deep_id === $deep->id ? 'selected' : '' }}
                            value="{{ $deep->id }}"
                        >{{ $deep->name }}</option>
                    @endforeach
                </select>
            </div>


                <div class="form-group">
                    <label for="sampling_date">Fecha y hora de inicio</label>
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input
                            type="text"
                            name="sampling_date"
                            id="sampling_date"
                            class="form-control datetimepicker-input {{ $errors->has('sampling_date') ? 'is-invalid': '' }}"
                            data-target="#datetimepicker1"
                            data-toggle="datetimepicker"
                            value="{{ old('sampling_date') ?: Carbon\Carbon::parse($sampling->sampling_date)->format('d/m/Y H:i') }}"
                            autocomplete="off"
                        />
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        @if($errors->has('sampling_date'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('sampling_date') }}</strong>
                        </span>
                        @endif
                    </div>
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

            console.log("{{ Carbon\Carbon::parse($sampling->sampling_date)->format('d/m/Y H:i') }}");
            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY HH:mm',
                locale: 'es',
                @if($sampling->id)
                defaultDate: new Date("{{ Carbon\Carbon::parse($sampling->sampling_date)->format('d/m/Y H:i') }}"),
                @endif
                sideBySide: true,
                buttons: {showClose: true},
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });
            /*
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'es',
                @if($sampling->id)
                defaultDate: new Date("{{ $sampling->sampling_date }}"),
                @endif
                sideBySide: true,
                buttons: {showClose: true},
                showClose: true,
                icons: {
                    close: 'fa fa-check'
                }
            });*/
        });


    </script>
@endpush
