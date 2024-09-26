@extends('layouts.app', ['page' => 'companies'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Empresa"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $company->id ? route('companies.store'): route('companies.update', $company->id) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @if($company->id)
                @method('PUT')
            @endif

            @csrf



            <div class="form-group">
                <label for="company_name">EMPRESA</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('company_name') ? 'is-invalid': '' }}"
                    name="company_name"
                    id="company_name"
                    value="{{ old('company_name') ?: $company->company_name }}"
                >
                @if($errors->has('company_name'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('company_name') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="fanpage">FAN PAGE</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('fanpage') ? 'is-invalid': '' }}"
                    name="fanpage"
                    id="fanpage"
                    value="{{ old('fanpage') ?: $company->fanpage }}"
                >
                @if($errors->has('fanpage'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('fanpage') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="website">WEBSITE</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('website') ? 'is-invalid': '' }}"
                    name="website"
                    id="website"
                    value="{{ old('website') ?: $company->website }}"
                >
                @if($errors->has('website'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">CORREO</label>
                <input
                    type="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid': '' }}"
                    name="email"
                    id="email"
                    value="{{ old('email') ?: $company->email }}"
                >
                @if($errors->has('email'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('phone') ? 'is-invalid': '' }}"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') ?: $company->phone }}"
                >
                @if($errors->has('phone'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="turn">Giro de la empresa</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('turn') ? 'is-invalid': '' }}"
                    name="turn"
                    id="turn"
                    value="{{ old('turn') ?: $company->turn }}"
                >
                @if($errors->has('turn'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('turn') }}</strong>
            </span>
                @endif
            </div>
            <div class="form-group">
                <label for="country_id">País</label>
                <select
                    class="form-control {{ $errors->has('country_id') ? 'is-invalid': '' }}"
                    name="country_id"
                    id="country_id"
                    required
                >
                    @foreach(\App\Country::pluck('name', 'id') as $id => $name)
                        <option
                            {{ (int) old('country_id') === $id || $company->country_id === $id ? 'selected' : '' }}
                            value="{{ $id }}"
                        >{{ $name }}</option>
                    @endforeach
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
