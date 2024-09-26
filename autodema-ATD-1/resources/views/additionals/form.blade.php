@extends('layouts.app', ['page' => 'service-types'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Adicional de ").$serviceType->name,
                    'icon' => "building"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $additional->id ? route('additionals.store', $serviceType->id): route('additionals.update', $additional->id) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @if($additional->id)
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
                    value="{{ old('name') ?: $additional->name }}"
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
                    type="text"
                    class="form-control {{ $errors->has('description') ? 'is-invalid': '' }}"
                    name="description"
                    rows="5"
                    id="description">{{ old('description') ?: $additional->description }}</textarea>
                @if($errors->has('description'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input
                    type="number"
                    class="form-control {{ $errors->has('price') ? 'is-invalid': '' }}"
                    name="price"
                    id="price"
                    value="{{ old('price') ?: $additional->getRawOriginal("price") }}"
                >
                @if($errors->has('price'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
                @endif
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
