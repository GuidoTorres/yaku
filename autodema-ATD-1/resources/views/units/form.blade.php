@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Parámetro"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <form
            method="POST"
            action="{{ ! $unit->id ? route('units.store'): route('units.update', $unit->id) }}"
            novalidate
        >
            @if($unit->id)
                @method('PUT')
            @endif

            @csrf

            <div class="form-group">
                <label for="magnitude">Magnitud</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('magnitude') ? 'is-invalid': '' }}"
                    name="magnitude"
                    id="magnitude"
                    placeholder=""
                    value="{{ old('magnitude') ?: $unit->magnitude }}"
                    required
                >
                @if($errors->has('magnitude'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('magnitude') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="unit">Unidad</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('unit') ? 'is-invalid': '' }}"
                    name="unit"
                    id="unit"
                    placeholder=""
                    value="{{ old('unit') ?: $unit->unit }}"
                    required
                >
                @if($errors->has('unit'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('unit') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="symbol">Símbolo</label>
                <span class="btn btn-outline-info" onclick="getSelectionHtml()">sup</span><span class="btn btn-outline-danger" onclick="removeSuper()">rem</span>
                <div class="form-control" id="simbolo-helper" contenteditable="true">{!! old('symbol') ?: $unit->symbol !!}</div>
                <input
                    type="text"
                    class="form-control {{ $errors->has('symbol') ? 'is-invalid': '' }} d-none"
                    name="symbol"
                    id="symbol"
                    placeholder=""
                    value="{{ old('symbol') ?: $unit->symbol }}"
                    required
                >

                @if($errors->has('symbol'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('symbol') }}</strong>
                </span>
                @endif
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-secondary">
                    {{ __($btnText) }}
                </button>
            </div>

        </form>

    </div>
@endsection
@push('styles')

@endpush
@push('scripts')
<script>
    function getSelectionHtml() {

        var helperText = $("#simbolo-helper").html();
        var selection = window.getSelection();
        var start = selection.anchorOffset;
        var end = selection.focusOffset;

        if(start > end){
            var tempStart =start
            start = end;
            end = tempStart;
        }

        var hasSup = helperText.indexOf('<sup>');

        if(hasSup >= 0){

            var endSup = helperText.indexOf('</sup>');

            if(start < hasSup){
                helperText = [helperText.slice(0, end), '</sup>', helperText.slice(end)].join('');
                helperText = [helperText.slice(0, start), '<sup>', helperText.slice(start)].join('');
            }else{
                var firstText = helperText.slice(0, endSup+6);
                var lastText = helperText.slice(endSup+6);
                lastText = replaceAndAdd(lastText, start, end);
                helperText = [firstText,lastText].join('');
            }
        }else{
            helperText = [helperText.slice(0, end), '</sup>', helperText.slice(end)].join('');
            helperText = [helperText.slice(0, start), '<sup>', helperText.slice(start)].join('');
        }


        $("#simbolo-helper").html(helperText);
        $("#symbol").val(helperText);
    }
    function replaceAndAdd(helperText, start, end){
        var hasSup = helperText.indexOf('<sup>');

        if(hasSup >= 0){

            var endSup = helperText.indexOf('</sup>');

            if(start < hasSup){
                helperText = [helperText.slice(0, end), '</sup>', helperText.slice(end)].join('');
                helperText = [helperText.slice(0, start), '<sup>', helperText.slice(start)].join('');
            }else{
                var firstText = helperText.slice(0, endSup+6);
                var lastText = helperText.slice(endSup+6);
                lastText = replaceAndAdd(lastText, start, end );
                helperText = [firstText,lastText].join('');
            }
        }else{
            helperText = [helperText.slice(0, end), '</sup>', helperText.slice(end)].join('');
            helperText = [helperText.slice(0, start), '<sup>', helperText.slice(start)].join('');
        }

        return helperText;

    }
    function removeSuper() {
        var helperText = $("#simbolo-helper").html();
        helperText = helperText.replace(/\<sup\>/g, '').replace(/\<\/sup\>/g, '');
        $("#simbolo-helper").html(helperText);
        $("#symbol").val(helperText);
    }
    function replaceInOrder(text,end,start){
        if(end>start){
            text = [helperText.slice(0, end), '</sup>', helperText.slice(end)].join('');
            text = [text.slice(0, start), '<sup>', text.slice(start)].join('');
        }else if(end<start){
            text = [text.slice(0, start), '</sup>', text.slice(start)].join('');
            text = [text.slice(0, end), '<sup>', text.slice(end)].join('');
        }

        return text;
    }
</script>
@endpush
