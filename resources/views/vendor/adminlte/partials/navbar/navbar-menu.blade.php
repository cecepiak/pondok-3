@inject('sidebarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\SidebarItemHelper')

@foreach($menuItems as $item)
    @if ($sidebarItemHelper->isHeader($item))

        {{-- Header --}}
        @include('adminlte::partials.navbar.menu-item-header')

    @elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))

        {{-- Search form --}}
        @include('adminlte::partials.navbar.menu-item-search-form')

    @elseif ($sidebarItemHelper->isMenuSearch($item))

        {{-- Search menu --}}
        @include('adminlte::partials.navbar.menu-item-search-menu')

    @elseif ($sidebarItemHelper->isSubmenu($item))

        {{-- Treeview menu --}}
        @include('adminlte::partials.navbar.menu-item-treeview-menu')

    @elseif ($sidebarItemHelper->isLink($item))

        {{-- Link --}}
        @include('adminlte::partials.navbar.menu-item-link')

    @endif
@endforeach