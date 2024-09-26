@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.users.searchParameter')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Visible {{ $user->id }}</th>
                    <th scope="col">Parámetros de rol</th>
                    <th scope="col">Código</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Tipo de dato</th>
                </tr>
                </thead>
                <tbody>
                @forelse($parameters as $parameter)
                    <tr>
                        <td>
                            @php
                                $checked = $user->parameters()->where('id', $parameter->id)->exists() ? 'checked': '';
                            @endphp
                            <input
                                class="form-check-input activate-parameter-role"
                                type="checkbox"
                                {{ $checked }}
                                value="{{ $parameter->id }}"
                                id="service_type_{{ $parameter->id }}"
                                data-id="{{ $parameter->id }}"
                                name="service_types[]"
                                style="margin-left: 0"
                            ></td>
                        <td>{{ $parameter->name }}</td>
                        <td>{{ $parameter->code }}</td>
                        <td>
                            <b>Magnitud:</b> {{ $parameter->unit->magnitude }}<br>
                            <b>Unidad:</b> {{ $parameter->unit->unit}}<br>
                            <b>Símbolo:</b> {!! $parameter->unit->symbol !!}
                        </td>
                        <td>{{ \App\Parameter::DATA_TYPE_TEXT[$parameter->data_type] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay parámetros disponibles")}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>


        <div class="row justify-content-center">
            {{ $parameters->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        var user_id = {{ $user->id }};

        $(document).on('click', '.activate-parameter-role', function() {
            console.log("Cambió");
            let parameter_id = $(this).attr("data-id");
            let activated = $(this).is(":checked");

            console.log(parameter_id);
            console.log(activated);
            console.log(user_id);
            $.ajax({
                url: '/users/activate-parameter',
                type: 'POST',
                tryCount: 0,
                retryLimit: 3,
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    parameter_id: parameter_id,
                    user_id: user_id,
                    activated: activated,
                },
                success: function success(data) {
                    //console.log("-----------------STAGE "+stage_id+"----------------");
                    if(data == 200){
                        if(activated){
                            alert("Se activó el parametro");
                        }else{
                            alert("Se desactivó el parametro");
                        }
                    }else{
                        alert("Ocurrió un error. Por favor inténtelo de nuevo.")
                    }
                },
                error: function error(data) {
                    console.log("-----------------ERROR----------------");
                    this.tryCount++;
                    console.log("Try: " + this.tryCount + " out of " + this.retryLimit + ".");

                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        return;
                    }

                    console.log(data);
                    console.log("-----------------ERROR----------------");
                }
            });
        });

        function eliminarParametro(id){
            var confirmar = confirm("¿Está seguro que desea eliminar el parámetro? Se perderán todos los datos relacionados");

            if(confirmar){

                //Enviamos una solicitud con el ruc de la empresa
                $.ajax({
                    type: 'DELETE',
                    //THIS NEEDS TO BE GET
                    url: '/parameters/delete',
                    tryCount: 0,
                    retryLimit: 3,
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        parameter_id: id,
                    },
                    success: function success(data) {
                        //console.log("-----------------STAGE "+stage_id+"----------------");
                        if(data == 200){
                            window.location.reload();
                        }else{
                            alert("Ocurrió un error. Por favor inténtelo de nuevo.")
                        }
                    },
                    error: function error(data) {
                        console.log("-----------------ERROR----------------");
                        this.tryCount++;
                        console.log("Try: " + this.tryCount + " out of " + this.retryLimit + ".");

                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }

                        console.log(data);
                        console.log("-----------------ERROR----------------");
                    }
                });
            }

        }

    </script>
@endpush
