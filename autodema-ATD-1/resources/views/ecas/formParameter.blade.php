@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("ESTÁNDARES DE CALIDAD AMBIENTAL PARA AGUA"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $ecaParameter->id ? route('ecas.storeParameter'): route('ecas.updateParameter', $ecaParameter->id) }}"
            novalidate
        >
            @if($ecaParameter->id)
                @method('PUT')
            @endif

            @csrf

            <div class="form-group d-none">
                <label for="eca_id">ECA</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('eca_id') ? 'is-invalid': '' }}"
                    name="eca_id"
                    id="eca_id"
                    placeholder=""
                    value="{{ $eca->id ?: $ecaParameter->eca_id }}"
                    required
                >
                @if($errors->has('eca_id'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('eca_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group @if($ecaParameter->id) d-none @endif">
                <label for="parameter_id">Parámetro</label>
                <select
                    class="form-control {{ $errors->has('parameter_id') ? 'is-invalid': '' }}"
                    name="parameter_id"
                    id="parameter_id"
                    required
                >
                    @foreach(\App\Parameter::where('enabled',1)->pluck('name', 'id') as $id => $name)
                        <option
                            {{ (int) old('parameter_id') === $id || $ecaParameter->parameter_id === $id ? 'selected' : '' }}
                            value="{{ $id }}"
                        >{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="min_value">Valor mínimo (opcional)</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('min_value') ? 'is-invalid': '' }}"
                    name="min_value"
                    id="min_value"
                    placeholder=""
                    value="{{ old('min_value') ?: $ecaParameter->min_value }}"
                    required
                >
                @if($errors->has('min_value'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('min_value') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="near_min_value">Valor intermedio mínimo (opcional)</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('near_min_value') ? 'is-invalid': '' }}"
                    name="near_min_value"
                    id="near_min_value"
                    placeholder=""
                    value="{{ old('near_min_value') ?: $ecaParameter->near_min_value }}"
                    required
                >
                @if($errors->has('near_min_value'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('near_min_value') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="max_value">Valor máximo (opcional)</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('max_value') ? 'is-invalid': '' }}"
                    name="max_value"
                    id="max_value"
                    placeholder=""
                    value="{{ old('max_value') ?: $ecaParameter->max_value }}"
                    required
                >
                @if($errors->has('max_value'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('max_value') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="near_max_value">Valor intermedio máximo (opcional)</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('near_max_value') ? 'is-invalid': '' }}"
                    name="near_max_value"
                    id="near_max_value"
                    placeholder=""
                    value="{{ old('near_max_value') ?: $ecaParameter->near_max_value }}"
                    required
                >
                @if($errors->has('near_max_value'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('near_max_value') }}</strong>
            </span>
                @endif
            </div>
            <div class="form-group">
                <label for="allowed_value">Valor permitido (opcional)</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('allowed_value') ? 'is-invalid': '' }}"
                    name="allowed_value"
                    id="allowed_value"
                    placeholder=""
                    value="{{ old('allowed_value') ?: $ecaParameter->allowed_value }}"
                    required
                >
                @if($errors->has('allowed_value'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('allowed_value') }}</strong>
                </span>
                @endif
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

@endpush
@push('scripts')

@endpush
