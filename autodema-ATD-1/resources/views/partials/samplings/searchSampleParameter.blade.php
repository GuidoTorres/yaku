<div class="head-page">
    @include('partials.title', [
        'title' => __("Muestras del ").Carbon\Carbon::parse($sampling->sampling_date)->format('d/m/Y \a \l\a\s h:i')." del embalse ".$sampling->samplingPoint->reservoir->name,
        'icon' => "building"
    ])

    <form action="{{ route('companyContacts.search') }}" method="get" class="col-sm-12 form-search-villamares d-none">
        <div class="form-group row">
            <label
                for="name_search"
                class="col-sm-3 col-form-label"
            >
                Parámetro
            </label>
            <div class="col-sm-9">
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Busque por parámetro") }}"
                >
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-4 offset-sm-3 btn-group">
                <input
                    class="btn btn-third btn-add-opp-db"
                    name="filter"
                    type="submit"
                    value="Buscar"
                >
            </div>
        </div>
    </form>
</div>
