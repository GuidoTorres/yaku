<!--
Sidebar
Example of: https://bootstrapious.com/p/bootstrap-sidebar
-->
<nav id="sidebar" class="@isset($active) active @endisset">
    @auth
    <button type="button" id="sidebarCollapse" class="btn">
        <i class="fa fa-chevron-left"></i>
    </button>
    @endauth
    <a class="sidebar-header" href="{{ url('/') }}">
        <img src="{{ asset('image/Logos.png') }}" alt="Logo" class="logo-sidebar logo-complete">
        <img src="{{ asset('image/Logos.png') }}" alt="Logo" class="logo-sidebar logo-partial">

    </a>

    <ul class="list-unstyled components">
        @include('partials.sidebar.' . \App\User::navigation())
    </ul>
    <div style="position: absolute;left: 50%;transform: translateX(-50%);top: 92vh;">
        <div class="row justify-content-center text-center">

            <a href="https://redyaku.com" target="_blank" class="logo-yaku-sidebar">
                Desarrollado por <img src="{{ asset('image/Logo-red.png') }}" alt="Logo sidebar" style="width: 80px">
            </a>
        </div>
    </div>

</nav>
