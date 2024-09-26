<div class="head-page">
    @include('partials.title', [
        'title' => __("Oportunidades"),
        'icon' => "building"
    ])
    <form action="{{ route('opportunities.searchList') }}" method="get" class="col-sm-12 form-search-villamares">
        <div class="form-group row">
            <label
                for="name_search"
                class="col-sm-3 col-form-label"
            >
                Oportunidad
            </label>
            <div class="col-sm-9">
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Buscar por nombre de oportunidad") }}"
                >
            </div>
        </div>
        <div class="form-group row">
            <label
                for="tax_number_search"
                class="col-sm-3 col-form-label"
            >
                Empresa
            </label>
            <div class="col-sm-9">
                <input
                    class="form-control"
                    name="company_name_search"
                    id="company_name_search"
                    type="text"
                    placeholder="{{ __("Buscar por RUC") }}"
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
