@extends('layouts.app', ['page' => 'surveys'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.surveys.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Encuesta
                        <a
                            class="btn btn-third"
                            href="{{ route("surveys.create") }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ver</th>
                </tr>
                </thead>
                <tbody>
                @forelse($surveys as $survey)
                    <tr>
                        <td>
                            <a
                                href="{{ route('surveys.edit', $survey->id) }}"
                            >
                                {{ $survey->name }}
                            </a>
                            <a
                                class="btn btn-edit"
                                href="{{ route('surveys.addQuestions', $survey->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar preguntas"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>

                            @if($survey->state == \App\Survey::ACTIVE)
                                Activa
                            @elseif($survey->state == \App\Survey::INACTIVE)
                                Inactiva
                            @endif
                        </td>

                        <td>
                            <div class="btn-group mb-2">
                                <a
                                    class="btn btn-outline-info"
                                    href="{{ route('surveys.results', $survey->id) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Ver resultados"
                                >
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                <a
                                    class="btn btn-outline-info"
                                    href="{{ route('surveys.vote', (\App\Survey::encryptSurveyId($survey->id) ) ) }}"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    target="_blank"
                                    title="Link de voto"
                                >
                                    <i class="fa fa-link"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ __("No hay encuestas disponibles")}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Modal para las notas -->
        <!-- The Modal -->
        <div class="modal" id="modalNotes">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Notas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body modal-ajax-content"></div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            {{ $surveys->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
