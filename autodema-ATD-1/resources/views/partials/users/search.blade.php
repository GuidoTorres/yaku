<div class="head-page">
    @include('partials.title', [
        'title' => __("Usuarios"),
        'icon' => "building"
    ])

    <form action="{{ route('users.search') }}" method="get" class="col-sm-12 form-search-villamares">
        <div class="form-group row">
            <label
                for="name_search"
                class="col-sm-3 col-form-label"
            >
                Nombre
            </label>
            <div class="col-sm-9">
                <input
                    class="form-control"
                    name="name_search"
                    id="name_search"
                    type="text"
                    placeholder="{{ __("Ingrese nombres o apellidos") }}"
                >
            </div>
        </div>
        <div class="form-group row">
            <label
                for="role_search"
                class="col-sm-3 col-form-label"
            >
                Rol
            </label>
            <div class="col-sm-9">
                <select
                    class="form-control"
                    name="role_search"
                    id="role_search"
                >
                    <option value="">Seleccionar</option>
                    @foreach(\App\Role::get() as $role)
                        <option
                            value="{{ $role->id }}"
                        >{{ $role->name." ".$role->last_name }}</option>
                    @endforeach
                </select>
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
