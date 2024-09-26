<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CRM') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    @stack('styles')
</head>

<body class="page-@php echo isset($page) ? $page : 'default'; @endphp">


    <div class="wrapp d-flex">
        @auth
        @include('partials.sidebar')
        <!-- Page Content  -->
        <div class="role-fixed-name">
            Rol:<br>
            {{ auth()->user()->role->name }}
        </div>
        @endauth
        @yield('jumbotron')
        <div id="modern">
            <main class="main-content">
                <div class="row justify-content-center text-center site-title-body">
                    <div class="col-md-10 pb-3">
                        <h2 class="titulo-plat">Plataforma de Vigilancia de la Calidad del Agua</h2>
                        <h4 class="titulo-plat">Red de monitoreo</h4>
                    </div>
                </div>
                @if(session('message'))
                <div class="row justify-content-center text-center">
                    <div class="col-md-10">
                        <div class="alert alert-{{ session('message')[0] }} alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <h4 class="alert-heading">{{ __("Mensaje informativo") }}</h4>
                            <p>{{ session('message')[1] }}</p>
                        </div>
                    </div>
                </div>
                @endif
                @yield('title')

                @yield('content')
            </main>
        </div>
        @include('partials.modals.modalMessage')

        @include('partials.footer')
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover({
                html: true
            }).on('shown.bs.popover', function(eventShown) {
                var $popup = $('#' + $(eventShown.target).attr('aria-describedby'));
                $popup.find('.close-popover').click(function(e) {
                    $popup.popover('hide');
                });
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });


        });
    </script>
</body>

</html>
