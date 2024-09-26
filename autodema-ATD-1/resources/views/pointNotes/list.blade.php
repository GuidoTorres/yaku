<form
    method="POST"
    action="{{ route('pointNotes.store') }}"
    novalidate
    id="form-nota"
    style="display: none"
    enctype="multipart/form-data"
>
    @csrf
    <input type="hidden" value="{{ $point_id }}" name="sampling_point_id" id="sampling_point_id">
    <div class="form-group input-files-group">
        <label for="" style="font-weight: bold">Agregar foto</label><br>
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
    ></textarea>
    <button type="submit" class="btn btn-outline-secondary">Agregar</button>
</form>
<button class="btn btn-outline-secondary agregar-nota">Agregar nota</button>
<table class="table table-striped table-light">
    <thead>
    <tr>
        <th scope="col">Registro</th>
        <th scope="col">Descripción</th>
        <th scope="col">Usuario</th>
        <th scope="col">Archivo</th>
    </tr>
    </thead>
    <tbody>
    @forelse($notes as $note)
        <tr>
            <td>
                {{ Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}
                <a
                    href="{{ route("pointNotes.edit", $note->id) }}"
                    target="_blank"
                    class="d-inline-block p-2 pb-3 prev-note-img-btn"
                >
                    <i class="fa fa-pencil"></i>
                </a>
            </td>
            <td>{!! nl2br(e($note->description)) !!}</td>
            <td>
                {{ $note->user->name." ".$note->user->last_name }}
            </td>
            <td>
                @if($note->url)
                    <a href="{{ asset('notes/'.$note->url) }}" target="_blank"><i class="fa fa-download"></i></a>
                    <a
                        data-href="{{ asset('notes/'.$note->url) }}"
                        class="d-inline-block p-2 pb-3 prev-note-img-btn"
                        data-id="{{ $note->id }}"
                    >
                        <i class="fa fa-eye"></i>
                    </a>
                @endif

            </td>
        </tr>
        <tr id="tr-{{ $note->id }}" style="display: none; text-align: center">
            <td colspan="4">
                <img class="note-prev d-inline-block" style="max-width: 250px;" alt="cargando...">
            </td>
        </tr>
    @empty
        <tr>
            <td>{{ __("No hay notas disponibles")}}</td>
        </tr>
    @endforelse
    </tbody>
</table>
<div class="row justify-content-center notes-pagination">{{ $notes->links() }}</div>

<script>
    $(document).on('change', '.custom-file-input', function(){
        console.log("Cambió");
        var filename = $(this).val().split('\\').pop();
        console.log(filename);

        $(this).closest(".input-group-wrapp").addClass("input-group-wrapp-selected");

        $(this).siblings('.custom-file-label').html("<span>"+filename+"</span>");
    });

    $(document).ready(function(){
        $('.prev-note-img-btn').each(function(i, obj) {
            console.log("-------MODAL NOTES--------");
            let img_src = $(this).attr("data-href");
            let note_id = $(this).attr("data-id");

            let elem_src = $("#tr-"+note_id+" img.note-prev").attr("src");
            if(elem_src){
                console.log("Ya tiene src precargado");
            }else{
                console.log("Se precargó el src");
                $("#tr-"+note_id+" img.note-prev").attr("src", img_src);
            }
        });
        console.log("cargó adentro: "+new Date());
    });
</script>
