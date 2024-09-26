<div class="head-page">
    @include('partials.title', [
        'title' => __("Empresas"),
        'icon' => "building"
    ])

    <form action="{{ route('companies.search') }}" method="get" class="col-sm-12 form-search-villamares">
        <div class="form-group row">
            <label
                for="company_name_search"
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
                    placeholder="{{ __("Buscar por nombre de empresa") }}"
                >
            </div>
        </div>
        <div class="form-group row">
            <label
                for="tax_number_search"
                class="col-sm-3 col-form-label"
            >
                RUC
            </label>
            <div class="col-sm-9">
                <input
                    class="form-control"
                    name="tax_number_search"
                    id="tax_number_search"
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
