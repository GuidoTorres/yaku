<div class="modal" id="modalAddActivity">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Actividad</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form
                    method="POST"
                    action="{{ route('activities.store') }}"
                    novalidate
                    enctype="multipart/form-data"
                >
                    @csrf


                    <div class="form-group d-none">
                        <label for="opportunity_id">Oportunidad</label>
                        <input
                            type="number"
                            name="opportunity_id"
                            id="opportunity_id"
                            value="{{ $opportunity->id }}"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="did_at">Realizado</label>
                        <div class="input-group date" id="did_at_tp" data-target-input="nearest">
                            <input
                                type="text"
                                name="did_at"
                                id="did_at"
                                class="form-control datetimepicker-input"
                                data-target="#did_at_tp"
                                data-toggle="datetimepicker"
                                autocomplete="off"
                            />
                            <div class="input-group-append" data-target="#did_at_tp" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="activity_type_id">Tipo</label>
                        <select
                            class="form-control"
                            name="activity_type_id"
                            id="activity_type_id"
                        >
                            @foreach(\App\ActivityType::pluck('name', 'id') as $id => $name)
                                <option
                                    value="{{ $id }}"
                                >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="company_contact_id">Contacto</label>
                        <select
                            class="form-control"
                            name="company_contact_id"
                            id="company_contact_id"
                        >
                            @foreach(\App\CompanyContact::where('company_id',$opportunity->company_id)->pluck('name', 'id') as $id => $name)
                                <option
                                    value="{{ $id }}"
                                >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Título</label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="name"
                            placeholder=""
                            autocomplete="off"
                        >
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea
                            class="form-control"
                            name="description"
                            id="description"
                            placeholder=""
                            autocomplete="off"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">
                            Agregar
                        </button>
                    </div>

                </form>


            </div>

        </div>
    </div>
</div>
@push('styles')
    <link rel="stylesheet"  href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript"  src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function () {
            $('#did_at_tp').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'es',
                stepping: 15,
                sideBySide: true,
                showClose: true
            });
        });

    </script>
@endpush
