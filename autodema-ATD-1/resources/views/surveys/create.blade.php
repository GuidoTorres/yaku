@extends('layouts.app', ['page' => 'surveys'])

@section('content')
    <div class="container container-form">

        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => "Crear encuesta",
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $survey->id ? route('surveys.store'): route('surveys.update', ['id'=>$survey->id]) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @if($survey->id)
                @method('PUT')
            @endif

            @csrf

            <div class="form-group">
                <label for="name">Nombre de encuesta</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}"
                    name="name"
                    id="name"
                    placeholder=""
                    value="{{ old('name') ?: $survey->name }}"
                    required
                    autocomplete="off"
                >
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="state">Estado</label>
                <select
                    class="form-control {{ $errors->has('state') ? 'is-invalid': '' }}"
                    name="state"
                    id="state"
                    required
                >
                    <option
                        {{
                            (int) old('state') === \App\Survey::ACTIVE
                            ||
                            (int) $survey->state === \App\Survey::ACTIVE
                            ?
                            'selected' : ''
                        }}
                        value="{{ \App\Survey::ACTIVE }}"
                    >Activo</option>
                    <option
                        {{
                            (int) old('state') === \App\Survey::INACTIVE
                            ||
                            (int) $survey->state === \App\Survey::INACTIVE
                            ?
                            'selected' : ''
                        }}
                        value="{{ \App\Survey::INACTIVE }}"
                    >Inactivo</option>
                </select>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-thales-secondary">
                    {{ __($btnText) }}
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
    <script>

    </script>
@endpush
