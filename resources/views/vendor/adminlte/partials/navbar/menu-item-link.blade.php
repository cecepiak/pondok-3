<li class="nav-item">
    <a href="{{ $item['url'] }}" class="nav-link {{ $item['active'] ? 'active' : '' }}">
        @if(isset($item['icon']))
            <i class="{{ $item['icon'] }} nav-icon"></i>
        @endif
        {{ $item['text'] }}

        @if(isset($item['badge']))
            @if($item['badge'] === 'user_baru_count')
                @if(isset($userBaruCount) && $userBaruCount > 0)
                    <span 
                        class="badge badge-{{ $item['badge_color'] ?? 'danger' }} navbar-badge"
                        title="Ada {{ $userBaruCount }} user baru menunggu aktivasi"
                        data-toggle="tooltip"
                        data-placement="right"
                    >
                        {{ $userBaruCount }}
                    </span>
                @endif
            @else
                <span class="badge badge-{{ $item['badge_color'] ?? 'primary' }} navbar-badge">
                    {{ $item['badge'] }}
                </span>
            @endif
        @endif
    </a>
</li>