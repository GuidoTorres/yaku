@extends('layouts.app', ['page' => 'parameters'])

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.units.search')
        </div>
        <div class="row justify-content-center">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th scope="col">Magnitud
                        <a
                            class="btn btn-plus"
                            href="{{ route("units.create") }}"
                        >
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Símbolo</th>
                </tr>
                </thead>
                <tbody>
                @forelse($units as $unit)
                    <tr>
                        <td>
                            <a href="{{ route('units.admin', $unit->id) }}">{{ $unit->magnitude }}</a>

                            <a
                                class="btn btn-edit"
                                href="{{ route('units.edit', $unit->id) }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Editar información de punto de muestreo"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>

                        </td>
                        <td>{{ $unit->unit }}</td>
                        <td>{!! $unit->symbol !!}</td>
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
            {{ $units->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
