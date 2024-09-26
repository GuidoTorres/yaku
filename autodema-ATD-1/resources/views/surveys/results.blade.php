@extends('layouts.app', ['page' => 'surveys'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => "Resultados de ". $survey->name,
                    'icon' => "file-text-o"
                ])
            </div>
        </div>
        <div class="questions-wrap">
            <div class="question-title pb-4">
                <div><b>Votaron:</b> {{ $survey->questions->first()->options->first()->question_count }}</div>
            </div>
            <div class="questions-inn">
                <table class="table  table-bordered">
                    <thead>
                    <tr>
                        <th class="col-order text-center">Pregunta</th>
                        <th class="col-order text-center">Promedio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($survey->questions as $question)
                        <tr class="candidate">
                            <td class="list- text-center">
                                {{ $question->name }}
                            </td>
                            <td class="list- text-center">
                                @if($question->options->first())
                                    {{ number_format($question->options->first()->question_sum/$question->options->first()->question_count, 2) }}
                                @else
                                    0
                                @endif
                            </td>
                    @endforeach


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
