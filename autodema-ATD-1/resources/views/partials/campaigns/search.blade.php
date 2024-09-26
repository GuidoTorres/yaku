<div class="head-page">
    @include('partials.title', [
        'title' => __("Campañas"),
        'icon' => "building"
    ])

    <form action="{{ route('campaigns.search') }}" method="get" class="col-sm-12 form-search-villamares">
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
                    placeholder="{{ __("Buscar por nombre de campaña") }}"
                >
            </div>
        </div>
        <div class="form-group row">
            <label
                for="campaign_type_search"
                class="col-sm-3 col-form-label"
            >
                Tipo
            </label>
            <div class="col-sm-9">
                <select
                    class="form-control"
                    name="campaign_type_search"
                    id="campaign_type_search"
                >
                    <option value="">Seleccionar</option>
                    @foreach(\App\CampaignType::get() as $user)
                        <option
                            value="{{ $user->id }}"
                        >{{ $user->name." ".$user->last_name }}</option>
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
