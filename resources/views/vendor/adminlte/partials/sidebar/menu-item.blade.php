@inject('sidebarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\SidebarItemHelper')

@if ($sidebarItemHelper->isHeader($item))

    {{-- Header --}}
    @include('adminlte::partials.sidebar.menu-item-header')

@elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))

    {{-- Search form --}}
    @include('adminlte::partials.sidebar.menu-item-search-form')

@elseif ($sidebarItemHelper->isMenuSearch($item))

    {{-- Search menu --}}
    @include('adminlte::partials.sidebar.menu-item-search-menu')

@elseif ($sidebarItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    @include('adminlte::partials.sidebar.menu-item-treeview-menu')

@elseif ($sidebarItemHelper->isLink($item))

    {{-- Link --}}
    @include('adminlte::partials.sidebar.menu-item-link')

@endif

@if (isset($item['badge']))
    @if($item['badge'] === 'user_baru_count')
        @if(isset($userBaruCount) && $userBaruCount > 0)
            <span 
                class="right badge badge-{{ $item['badge_color'] ?? 'danger' }} ml-2"
                title="Ada {{ $userBaruCount }} user baru menunggu aktivasi"
                data-toggle="tooltip"
                data-placement="right"
            >
                <i class="fas fa-bell mr-1"></i> {{ $userBaruCount }}
            </span>
        @endif
    @else
        <span class="right badge badge-{{ $item['badge_color'] ?? 'primary' }} ml-2">
            {{ $item['badge'] }}
        </span>
    @endif
@endif
