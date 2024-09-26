<div class="head-page">
    @include('partials.title', [
        'title' => __("Estándares de Calidad Ambiental para Agua"),
        'icon' => "thermometer"
    ])

    <form action="{{ route('ecas.search') }}" method="get" class="col-sm-12 form-search-villamares">
        <div class="form-group row">
            <label
                for=""
                class="col-sm-3 col-form-label"
            >
                Filtro:
            </label>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Nombre") }}"
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
