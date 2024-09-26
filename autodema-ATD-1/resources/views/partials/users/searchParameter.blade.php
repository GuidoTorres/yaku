<div class="head-page">
    @include('partials.title', [
        'title' => __("PARÁMETROS DE USUARIO"),
        'icon' => "thermometer"
    ])

    <form action="{{ route('users.filterParameters', ["id" => $user]) }}" method="get" class="col-sm-12 form-search-villamares">
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
                <label for="name_search">Nombre </label>
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Ingrese el nombre") }}"
                >
            </div>
            <div class="col-sm-3">
                <label for="unit_id_search">Magnitud</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control"
                    name="unit_id_search"
                    id="unit_id_search"
                >
                    <option
                        value=""
                    >Seleccionar</option>
                    @foreach(\App\Unit::get() as $unit)
                        <option
                            value="{{ $unit->id }}"
                        >{{ $unit->magnitude }}</option>
                    @endforeach
                </select>
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
