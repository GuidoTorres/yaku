<div class="head-page">
    @include('partials.title', [
        'title' => __("Muestras de ").$samplingPoint->name,
        'icon' => "building"
    ])

    <form action="{{ route('samplings.search') }}" method="get" class="col-sm-12 form-search-villamares">
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
                <div class="form-group d-none">
                    <label for="number">Punto de muestreo</label>
                    <input
                        type="number"
                        class="form-control"
                        name="sampling_point_id_search"
                        id="sampling_point_id_search"
                        placeholder=""
                        value="{{ $samplingPoint->id }}"
                        required
                    >
                </div>
                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                    <label for="sampling_date_search" style="width: 100%">Muestreo</label>
                    <input
                        type="text"
                        name="sampling_date_search"
                        id="sampling_date_search"
                        class="form-control datetimepicker-input"
                        data-target="#datetimepicker1"
                        data-toggle="datetimepicker"
                        value=""
                        autocomplete="off"
                        placeholder="Fecha"
                    />
                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="deep_id_search">Zona de luz</label>
                <select
                    style=""
                    class="form-control"
                    name="deep_id_search"
                    id="deep_id_search"
                >
                    <option
                        value=""
                    >Seleccionar</option>
                    @foreach(\App\Deep::get() as $deep)
                        <option
                            value="{{ $deep->id }}"
                        >{{ $deep->name }}</option>
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

<script>
    $(function () {

        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es',
            sideBySide: true,
            buttons: {showClose: true},
            showClose: true,
            icons: {
                close: 'fa fa-check'
            }
        });
    });


</script>
