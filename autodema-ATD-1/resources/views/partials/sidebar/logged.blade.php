
<li class="nav-help d-none">
    <a href="{{ route('users.help') }}"><i class="fa fa-info"></i> Ayuda</a>
</li>
<li class="">
    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fa fa-user"></i>
        {{ explode(' ',trim(auth()->user()->name))[0] }}
    </a>
    <ul class="collapse list-unstyled" id="userSubmenu">
        <li>
            <a
                href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"

            >Cerrar sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</li>
