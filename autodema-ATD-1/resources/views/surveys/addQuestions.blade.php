@extends('layouts.app', ['page' => 'surveys'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => "Añadir preguntas en ". $survey->name,
                    'icon' => "file-text-o"
                ])
            </div>
        </div>
        <div class="questions-wrap">
            <div class="questions-inn">
                <table class="table  table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="col-order text-center">Preguntas</th>

                        @for($i = 1 ; $i<= \App\Survey::QUESTIONS; $i++)
                            <th class="">{{ $i }}</th>
                        @endfor
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($survey->questions as $question)
                        <tr class="candidate">
                            <td class="list- text-center">
                                {{ $question->name }}
                            </td>
                            @for($i = 1 ; $i<= \App\Survey::QUESTIONS; $i++)
                                <td class="col-order list_0_1">
                                    <label class="form-check-label label-vote" for="candidate_0_1">
                                        <input
                                            type="radio"
                                            class=""
                                            required
                                            autocomplete="off"
                                            disabled
                                        >
                                    </label>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                    <tr class="candidate">
                        <td class="list text-center">
                            <form
                                method="POST"
                                action="{{ route('questions.store') }}"
                                novalidate
                                class="form-inline">
                                @if( $errors->any())
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                @endif
                                @csrf
                                <div class="input-group w-100 d-none">
                                    <input type="number" class="form-control" value="{{ $survey->id }}" name="survey_id" required>
                                </div>
                                <div class="input-group w-100">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese la pregunta" aria-describedby="inputGroupPrepend" required>
                                    <div class="input-group-apend">
                                        <input class="btn btn-outline-secondary" type="submit" value="Agregar">
                                    </div>
                                </div>
                            </form>
                        </td>
                        @for($i = 1 ; $i<= \App\Survey::QUESTIONS; $i++)
                        <td class="col-order list_0_1">
                            <label class="form-check-label label-vote" for="candidate_0_1">
                                <input
                                    type="radio"
                                    class=""
                                    required
                                    autocomplete="off"
                                    disabled
                                >
                            </label>
                        </td>
                        @endfor


                    </tr>

                    </tbody>
                </table>

                <div class="form-group text-center">
                    <a type="submit" class="btn btn-danger" href="{{ route("surveys.listAll") }}">
                        {{ __("Siguiente") }}
                    </a>
                </div>


            </div>

        </div>


    </div>


@endsection

@push('scripts')
    <script>


    </script>
@endpush
