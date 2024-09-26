@if(session('modalMessage'))
    <div class="modal" id="modalMensaje">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{!! session('modalMessage')[0] !!}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body modal-ajax-content">

                    <div class="modal-body-msg-wrapp">
                        {!! session('modalMessage')[1] !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(window).on('load',function(){
            $('#modalMensaje').modal('show');
        });
    </script>
    @php(\Session::forget('modalMessage'))
@endif
