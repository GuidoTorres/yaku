@extends('layouts.app', ['page' => 'pointnotes'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Notas"),
                    'icon' => "building"
                ])
            </div>
        </div>



<form
    method="POST"
    action="{{ route('pointNotes.update', $note->id) }}"
    novalidate
    id="form-nota"
    enctype="multipart/form-data"
>
    @if($note->id)
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{ $note->samplingPoint->id }}" name="sampling_point_id" id="sampling_point_id">
    <div class="form-group input-files-group">
        <label for="" style="font-weight: bold">
            @if($note->url)
                Cambiar foto
            @else
                Agregar foto
            @endif
        </label><br>
        <div class="input-group-wrapp">
            <div class="input-group">
                <div class="custom-file">
                    <input
                        type="file"
                        class="custom-file-input form-control"
                        name="url"
                        id="url"
                        placeholder=""
                        value=""
                    >
                    <label  class="custom-file-label" for="url">
                        Buscar archivo
                    </label>
                </div>
            </div>
        </div>

    </div>
    <textarea
        class="form-control"
        name="description"
        id="description"
        placeholder="Ingrese la descripción de la nota"
    >{!! nl2br(e(old('description') ?: $note->description))   !!}</textarea>
    <button type="submit" class="btn btn-outline-secondary">Editar</button>
</form>

    </div>
@endsection

@push('scripts')
<script>
    $(document).on('change', '.custom-file-input', function(){
        console.log("Cambió");
        var filename = $(this).val().split('\\').pop();
        console.log(filename);

        $(this).closest(".input-group-wrapp").addClass("input-group-wrapp-selected");

        $(this).siblings('.custom-file-label').html("<span>"+filename+"</span>");
    });

</script>
@endpush
