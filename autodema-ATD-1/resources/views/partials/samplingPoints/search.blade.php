<div class="head-page">
    @include('partials.title', [
        'title' => __("PUNTOS DE MUESTREO"),
        'icon' => "thermometer"
    ])

    <form action="{{ route('samplingPoints.search') }}" method="get" class="col-sm-12 form-search-villamares">
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
                <label for="name_search">Identificación</label>
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Identificación") }}"
                >
            </div>
            <div class="col-sm-3">
                <label for="zone_id_search">Zona</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control"
                    name="zone_id_search"
                    id="zone_id_search"
                >
                    <option
                        value=""
                    >Seleccionar</option>
                    @foreach(\App\Zone::get() as $zone)
                        <option
                            value="{{ $zone->id }}"
                        >{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <label for="basin_id_search">Cuenca</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control"
                    name="basin_id_search"
                    id="basin_id_search"
                >
                    <option
                        value=""
                    >Seleccionar</option>
                    @foreach(\App\Basins::get() as $basin)
                        <option
                            value="{{ $basin->id }}"
                        >{{ $basin->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <label for="reservoir_id_search">Embalse</label>
                <select
                    style="text-transform: capitalize"
                    class="form-control"
                    name="reservoir_id_search"
                    id="reservoir_id_search"
                >
                    <option
                        value=""
                    >Seleccionar</option>
                    @foreach(\App\Reservoir::get() as $reservoir)
                        <option
                            value="{{ $reservoir->id }}"
                        >{{ $reservoir->name }}</option>
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
