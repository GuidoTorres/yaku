<div class="head-page">
    @include('partials.title', [
        'title' => __("UNIDADES"),
        'icon' => "thermometer"
    ])

    <form action="{{ route('units.search') }}" method="get" class="col-sm-12 form-search-villamares">
        <div class="form-group row d-none">
            <label
                for=""
                class="col-sm-3 col-form-label"
            >
                Filtro:
            </label>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="name_search">Unidad</label>
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Ingrese el término de búsqueda") }}"
                >
            </div>

        </div>
        <div class="form-group row">
            <div class="col-sm-4 btn-group">
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
