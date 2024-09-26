@extends('layouts.app', ['page' => 'service-types'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Servicio"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $serviceType->id ? route('serviceTypes.store'): route('serviceTypes.update', $serviceType->id) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @if($serviceType->id)
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
                    value="{{ old('name') ?: $serviceType->name }}"
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
                    id="description">{{ old('description') ?: $serviceType->description }}</textarea>
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
                    value="{{ old('price') ?: $serviceType->getRawOriginal("price") }}"
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
    <script type="text/javascript"  src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        /*
        * Función para agregar el nombre del archivo
        * al input file
        */
        $(document).on('change', '.custom-file-input', function(){
            console.log("Cambió");
            var filename = $(this).val().split('\\').pop();
            console.log(filename);
            $(this).siblings('.custom-file-label').html("<i>"+filename+"</i>");
        });


    </script>
@endpush
