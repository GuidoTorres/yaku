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
            action="{{ ! $eca->id ? route('ecas.store'): route('ecas.update', $eca->id) }}"
            novalidate
        >
            @if($eca->id)
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
                    value="{{ old('name') ?: $eca->name }}"
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
                    required>{{ old('description') ?: $eca->description }}</textarea>
                @if($errors->has('description'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="state">Es ECA de transición</label>
                <select
                    class="form-control {{ $errors->has('state') ? 'is-invalid': '' }}"
                    name="is_transition"
                    id="is_transition"
                    required
                >
                    <option
                        {{ (int) old('is_transition') == "0" || $eca->is_transition == "0" ? 'selected' : '' }}
                        value="0"
                    >No</option>
                    <option
                        {{ (int) old('is_transition') == "1" || $eca->is_transition == "1" ? 'selected' : '' }}
                        value="1"
                    >Si</option>
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
