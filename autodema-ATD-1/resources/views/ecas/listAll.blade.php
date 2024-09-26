@extends('layouts.app', ['page' => 'parameters'])

@section('content')
<div class="container">
    <div class="row">
        @include('partials.ecas.search')
    </div>
    <div class="row justify-content-center">
        <table class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">ECA
                        <a class="btn btn-plus" href="{{ route("ecas.create") }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Parámetros</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ecas as $eca)
                <tr>
                    <td class="font-weight-bold">
                        <div>
                            <a href="{{ route('ecas.admin', $eca->id) }}">{{ $eca->name }}</a>
                            @if($eca->is_transition == 1)
                                (Transición)
                            @endif
                            <a class="btn btn-edit" href="{{ route('ecas.edit', $eca->id) }}" data-toggle="tooltip" data-placement="top" title="Editar información de ECA">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn btn-edit btn-eliminar-eca" href="#" data-toggle="tooltip" data-placement="top" title="eliminar ECA" onclick='eliminarEca({{ $eca->id }})'>
                                <i class="fa fa-close"></i>
                            </a>
                        </div>

                    </td>
                    <td style="max-width: 30vw; text-align: justify;">
                        {{ $eca->description }}
                    </td>
                    <td style="text-align:center;">
                        <a class="btn btn-param" href="{{ route('ecas.listParameters', $eca->id) }}" data-toggle="tooltip" data-placement="top" title="Ver parámetros">
                            <i class="fa fa-thermometer"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td>{{ __("No hay clientes disponibles")}}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="row justify-content-center">
        {{ $ecas->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script>
    function eliminarEca(id){
        var confirmar = confirm("¿Está seguro que desea eliminar el ECA?");

        if(confirmar){


            //Enviamos una solicitud con el ruc de la empresa
            $.ajax({
                type: 'DELETE',
                //THIS NEEDS TO BE GET
                url: '/ecas/delete',
                tryCount: 0,
                retryLimit: 3,
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    eca_id: id,
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
