@extends('layouts.app', ['page' => 'campaigns'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Campaña"),
                    'icon' => "building"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $campaign->id ? route('campaigns.store'): route('campaigns.update', $campaign->id) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @if($campaign->id)
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
                    value="{{ old('name') ?: $campaign->name }}"
                >
                @if($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="campaign_type_id">Tipo de campaña</label>
                <select
                    class="form-control {{ $errors->has('campaign_type_id') ? 'is-invalid': '' }}"
                    name="campaign_type_id"
                    id="campaign_type_id"
                    required
                >
                    @foreach(\App\CampaignType::pluck('name', 'id') as $id => $name)
                        <option
                            {{ (int) old('campaign_type_id') === $id || $campaign->campaign_type_id === $id ? 'selected' : '' }}
                            value="{{ $id }}"
                        >{{ $name }}</option>
                    @endforeach
                </select>
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
                        {{ (int) old('state') === \App\Campaign::ACTIVE || $campaign->state === \App\Campaign::ACTIVE ? 'selected' : '' }}
                        value="{{ \App\Campaign::ACTIVE }}"
                    >Activa</option>
                    <option
                        {{ (int) old('state') === \App\Campaign::INACTIVE || $campaign->state === \App\Campaign::INACTIVE ? 'selected' : '' }}
                        value="{{ \App\Campaign::INACTIVE }}"
                    >Inactiva</option>
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
