@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Parámetro"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $parameter->id ? route('parameters.store'): route('parameters.update', $parameter->id) }}"
            novalidate
        >
            @if($parameter->id)
                @method('PUT')
            @endif

            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}"
                    name="name"
                    id="name"
                    placeholder=""
                    value="{{ old('name') ?: $parameter->name }}"
                    required
                >
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea
                    class="form-control {{ $errors->has('description') ? 'is-invalid': '' }}"
                    name="description"
                    id="description"
                    placeholder=""
                    required>{{ old('description') ?: $parameter->description }}</textarea>
                @if($errors->has('description'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="code">Código</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('code') ? 'is-invalid': '' }}"
                    name="code"
                    id="code"
                    placeholder=""
                    value="{{ old('code') ?: $parameter->code }}"
                    required
                >
                @if($errors->has('code'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('code') }}</strong>
                </span>
                @endif
            </div>


            <div class="form-group">
                <label for="data_type">Tipo de data</label>
                <select
                    class="form-control {{ $errors->has('data_type') ? 'is-invalid': '' }}"
                    name="data_type"
                    id="data_type"
                    required
                >

                    @foreach(\App\Parameter::DATA_TYPE_TEXT as $index=>$dataType)
                        <option
                            {{ (int) old('data_type') === $index || $parameter->data_type === $index ? 'selected' : '' }}
                            value="{{ $index }}"
                        >{{ $dataType }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="eca_id">Unidades</label>
                <select
                    style=""
                    class="form-control {{ $errors->has('unit_id') ? 'is-invalid': '' }}"
                    name="unit_id"
                    id="unit_id"
                >
                    @foreach($units as $unit)
                        <option
                            {{ (int) old('unit_id') === $unit->id || $parameter->unit_id === $unit->id ? 'selected' : '' }}
                            value="{{ $unit->id }}"
                        >{{ $unit->unit }} ({!! $unit->symbol !!} )</option>
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

@endpush
@push('scripts')

@endpush
