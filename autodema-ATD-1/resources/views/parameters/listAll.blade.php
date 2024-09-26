@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.parameters.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Parámetro
                        <a
                            class="btn btn-plus"
                            href="{{ route("parameters.create") }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Código</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Tipo de dato</th>
                </tr>
                </thead>
                <tbody>
                @forelse($parameters as $parameter)
                    <tr>
                        <td>
                            <a href="{{ route('parameters.admin', $parameter->id) }}">{{ $parameter->name }}</a>

                            <a
                                class="btn btn-edit"
                                href="{{ route('parameters.edit', $parameter->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar información de punto de muestreo"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn btn-edit btn-eliminar-eca" href="#" data-toggle="tooltip" data-placement="top" title="eliminar ECA" onclick='eliminarParametro({{ $parameter->id }})'>
                                <i class="fa fa-close"></i>
                            </a>

                        </td>
                        <td>
                            {{ $parameter->code }}
                        </td>
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
