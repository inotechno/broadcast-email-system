<!--- Sidemenu -->
<div id="sidebar-menu">

    <ul class="metismenu list-unstyled" id="side-menu">

        @if (!empty($menus))
            @foreach ($menus as $menu)
                <li class="menu-title" key="t-{{ strtolower(str_replace(' ', '-', $menu['name'])) }}">
                    {{ strtoupper($menu['name']) }}</li>
                @foreach ($menu['child'] as $menuChild)
                    <li>
                        <a href="@if (empty($menuChild['child'])) {{ $menuChild['url'] }} @else # @endif"
                            class="@if (!empty($menuChild['child'])) has-arrow @endif waves-effect">
                            {{-- ICON --}}
                            {!! $menuChild['icon'] !!}

                            {{-- LABEL --}}
                            <span
                                key="t-{{ strtolower(str_replace(' ', '-', $menuChild['name'])) }}">{{ $menuChild['name'] }}</span>
                        </a>

                        @if (!empty($menuChild['child']))
                            <ul class="sub-menu" aria-expanded="false">
                                @foreach ($menuChild['child'] as $subMenu)
                                    <li>
                                        {{-- LABEL --}}
                                        <a href="{{ $subMenu['url'] }}"
                                            key="t-{{ strtolower(str_replace(' ', '-', $subMenu['name'])) }}">{{ $subMenu['name'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endforeach
        @endif
    </ul>
</div>
<!-- Sidebar -->
