<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ route('admin_dashboard') }}" class="brand-link">
        <img src="{{ PUBLIC_DIR }}admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminPanel</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                @foreach ($sidebar_menu as $menu_group)

                    @if(!empty($menu_group['title']))
                        <li class="nav-header text-uppercase">{{$menu_group['title']}}</li>
                    @endif

                    @foreach($menu_group['items'] as $menuItem)
                        @if (!empty($menuItem['submenu']))
                            <li class="nav-item has-treeview {!! $menuItem['is_active'] ? 'menu-open' : '' !!}">
                                <a href="{{ $menuItem['link'] }}" class="nav-link {!! $menuItem['is_active'] ? 'active' : '' !!}" role="menuitem">
                                    <i class="nav-icon {{ $menuItem['icon'] }}"></i>
                                    <p>
                                        {{ $menuItem['title'] }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach ($menuItem['submenu'] as $subMenuItem)
                                        <li class="nav-item">
                                            <a href="{{ $subMenuItem['link'] }}" class="nav-link {!! $subMenuItem['is_active'] ? 'active' : '' !!}" role="menuitem">
                                                <i class="far fa-circle nav-icon {!! !empty($subMenuItem['custom_css']) ? $subMenuItem['custom_css'] : '' !!}"></i>
                                                <p>{!! $subMenuItem['title'] !!}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ $menuItem['link'] }}" class="nav-link {!! $menuItem['is_active'] ? 'active' : '' !!}" role="menuitem">
                                    <i class="nav-icon {{ $menuItem['icon'] }} {!! !empty($menuItem['custom_css']) ? $menuItem['custom_css'] : '' !!}"></i>
                                    <p>
                                        {{ $menuItem['title'] }}
                                    </p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </nav>

    </div>
</aside>
