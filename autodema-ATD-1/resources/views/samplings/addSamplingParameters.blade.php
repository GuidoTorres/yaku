@extends('layouts.app', ['page' => 'groups-create'])

@section('content')
    <div class="container container-form">


        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Agregar data de muestreo"),
                    'icon' => "users"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ route('samplings.storeParameters', $sampling->id) }}"
            novalidate
            enctype="multipart/form-data"
        >
            @csrf
            <div class="form-group input-files-group">
                <label for="">Seleccione el archivo de parámetros medidos</label><br>
                 @error('parameters_list')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror


                <div class="input-group-wrapp">
                    <div class="input-group">
                        <div class="custom-file">
                            <input
                                type="file"
                                class="custom-file-input form-control {{ $errors->has('parameters_list') ? 'is-invalid': '' }}"
                                name="parameters_list"
                                id="parameters_list"
                                placeholder=""
                                value=""
                            >
                            <label  class="custom-file-label" for="parameters_list">
                                Buscar archivo
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-secondary">
                    {{ __("Añadir parámetros") }}
                </button>
            </div>

        </form>

    </div>

@endsection
@push('scripts')
    <script>

        $(document).ready(function() {

            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click",".btn-danger",function(){
                $(this).parents(".control-group").remove();
            });

        });
        /*
        * Función para agregar el nombre del archivo
        * al input file
        */
        $(document).on('change', '.custom-file-input', function(){
            console.log("Cambió");
            var filename = $(this).val().split('\\').pop();
            console.log(filename);

            $(this).closest(".input-group-wrapp").addClass("input-group-wrapp-selected");

            $(this).siblings('.custom-file-label').html("<span>"+filename+"</span>");
        });

        $(document).on("click",".remove-btn",function(){
            console.log("click");
            $(this).closest(".input-group-wrapp").remove();
        });
        $(document).on("click",".btn-add-file",function(){
            console.log("click");
            var html = $(".clone").html();
            $(".input-files-group").append(html);
        });

    </script>
@endpush
