@extends('layouts.app', ['page' => 'help'])

@section('content')
    <div class="container container-form">
        <div class="row">
            <div class="head-page">
                @include('partials.title', [
                    'title' => __("Ayuda"),
                    'icon' => "user"
                ])
            </div>
        </div>
        <div class="row mt-3 mb-3 d-flex justify-content-center">
            @switch($user->role_id)
                @case(1)
                <iframe
                    width="600"
                    height="400"
                    src="https://www.youtube-nocookie.com/embed/sprrn-nfc7w"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                >
                </iframe>
                @break
                @case(2)
                <iframe
                    width="600"
                    height="400"
                    src="https://www.youtube-nocookie.com/embed/sprrn-nfc7w"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                >
                </iframe>
                @break
                @case(3)
                <iframe
                    width="600"
                    height="400"
                    src="https://www.youtube-nocookie.com/embed/s-t6Xn8e2HI"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                >
                </iframe>
                @break
                @case(4)
                <iframe
                    width="600"
                    height="400"
                    src="https://www.youtube-nocookie.com/embed/6ruZENIeM1o"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                >
                </iframe>
                @break
            @endswitch
        </div>
    </div>
@endsection
