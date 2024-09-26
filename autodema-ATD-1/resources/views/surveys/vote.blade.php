@extends('layouts.app', ['page' => 'surveys'])

@section('content')
    <div class="container container-form" style="min-width: 650px">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' =>  $survey->name,
                    'icon' => "file-text-o"
                ])
            </div>
        </div>
        <div class="questions-wrap">
            <form
                class="questions-inn"
                method="POST"
                action="{{ route('surveys.storeVote') }}"
            >
                @csrf


                <div class="form-group d-none">
                    <label for="survey_id">Survey id</label>
                    <input
                        type="number"
                        name="survey_id"
                        class="form-control"
                        value="{{ \App\Survey::encryptSurveyId($survey->id) }}"
                        required
                        autocomplete="off"
                    >
                </div>
                <table class="table  table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="col-order text-center">Preguntas</th>
                        @for($i = 1 ; $i<= \App\Survey::QUESTIONS; $i++)
                            <th class="text-center">{{ $i }}</th>
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
                                <td class="text-center">
                                    <label class="text-center" for="candidate_0_1">
                                        @php
                                            $option =$question->options->where('type', $i)->first();
                                            $option_id = 0;
                                            if($option){
                                                $option_id = $option->id;
                                            }
                                        @endphp
                                        <input
                                            type="radio"
                                            class=""
                                            name="question[{{ $question->id }}]"
                                            value="{{ $option_id }}"
                                            required
                                            autocomplete="off"
                                        >
                                    </label>
                                </td>
                            @endfor
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-danger" >
                        {{ __("Votar") }}
                    </button>
                </div>


            </form>

        </div>


    </div>


@endsection

@push('scripts')
    <script>


    </script>
@endpush
