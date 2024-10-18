@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(Auth::user()->getFirstMediaUrl("departmentGallery"))
            <img src="{{ Auth::user()->getFirstMediaUrl('departmentGallery') }}"
            alt="Foto de{{ Auth::user()->department->name }}" width="25px" height="20px" style="border-radius: 50%">
        @else
            <img src="{{ asset('img/logo.png') }}" width="25px" height="20px" style="border-radius: 50%">
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            @if(Auth::user()->hasRole('admin'))
                {{ Auth::user()->name }} {{-- Muestra el nombre del admin --}}
            @elseif(Auth::user()->hasRole('supervisor') && Auth::user()->department)
                {{ Auth::user()->department->name }} {{-- Muestra el nombre del departamento --}}
            @else
                {{ Auth::user()->name }} {{-- Fallback por si no tiene ninguno de los roles --}}
            @endif
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif">
                @if(Auth::user()->getFirstMediaUrl("departmentGallery"))
                    <img src="{{ Auth::user()->getFirstMediaUrl('departmentGallery') }}"
                    alt="Foto de {{ Auth::user()->department->name }}" width="100px" height="100px" style="border-radius: 50%; margin-top: 18px;">
                @else
                    <img src="{{ asset('img/logo.png') }}" width="100px" height="100px" style="border-radius: 50%; margin-top: 18px;">
                @endif
                <p class="@if(!config('adminlte.usermenu_image')) mt-0 @endif" style="margin-top: 18px;">
                    @if(Auth::user()->hasRole('admin'))
                        {{ Auth::user()->name }} {{-- Muestra el nombre del admin --}}
                    @elseif(Auth::user()->hasRole('supervisor') && Auth::user()->department)
                        {{ Auth::user()->department->name }} {{-- Muestra el nombre del departamento --}}
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')

        {{-- User menu body --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- User menu footer --}}
        <li class="user-footer">
            @if($profile_url)
                <a href="{{ $profile_url }}" class="nav-link btn btn-default btn-flat d-inline-block">
                    <i class="fa fa-fw fa-user text-lightblue"></i>
                    {{ __('adminlte::menu.profile') }}
                </a>
            @endif
            <a class="btn btn-default btn-flat float-right @if(!$profile_url) btn-block @endif"
               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>
