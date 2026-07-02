@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">

        <!-- Chat Notification Icon -->
        <li class="nav-item">
            <a class="nav-link" id="navbar-chat-link" href="{{ url('admin/pesan') }}" title="Pesan Chat Masuk">
                <i class="far fa-comments"></i>
            </a>
        </li>

        {{-- Panggil partial notification bell yang berisi logic dan HTML --}}
        @include('vendor.adminlte.partials.notification-bell') 

        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    (function() {
        const SOCKET_SERVER_URL = "{{ env('SOCKET_URL') }}";
        const CURRENT_ADMIN_ID = "{{ env('ADMIN_ID') }}";

        // Initialize socket if not already initialized
        if (!window.globalAdminSocket) {
            window.globalAdminSocket = io(SOCKET_SERVER_URL);
            window.globalAdminSocket.on('connect', () => {
                window.globalAdminSocket.emit('register', {
                    id: CURRENT_ADMIN_ID,
                    role: 'admin'
                });
            });
        }

        // Function to fetch and update unread badges
        async function updateGlobalUnreadBadges() {
            try {
                const response = await fetch(`${SOCKET_SERVER_URL}/chat/messages/unread/admin/${CURRENT_ADMIN_ID}`);
                const unreadList = await response.json(); // Array of {senderId, count}
                const totalUnreadCount = unreadList.reduce((sum, item) => sum + parseInt(item.count || 0), 0);

                // 1. Update Left Sidebar "Pesan" badge
                const pesanLink = document.querySelector('a[href$="admin/pesan"] p');
                if (pesanLink) {
                    const oldBadge = pesanLink.querySelector('.badge');
                    if (oldBadge) oldBadge.remove();

                    if (totalUnreadCount > 0) {
                        const badge = document.createElement('span');
                        badge.className = 'right badge badge-danger ml-2';
                        badge.id = 'sidebar-pesan-badge';
                        badge.textContent = totalUnreadCount;
                        pesanLink.appendChild(badge);
                    }
                }

                // 2. Update Top Navbar Chat Icon/Badge
                const navbarChatLink = document.getElementById('navbar-chat-link');
                if (navbarChatLink) {
                    const oldBadge = navbarChatLink.querySelector('.badge');
                    if (oldBadge) oldBadge.remove();

                    if (totalUnreadCount > 0) {
                        const badge = document.createElement('span');
                        badge.className = 'badge badge-success navbar-badge';
                        badge.textContent = totalUnreadCount;
                        navbarChatLink.appendChild(badge);
                    }
                }
            } catch (error) {
                console.error('Error updating unread badges:', error);
            }
        }

        // Update badges on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateGlobalUnreadBadges();
        });

        // Listen for real-time messages
        window.globalAdminSocket.on('newMessageFromUser', () => {
            updateGlobalUnreadBadges();
        });
        window.globalAdminSocket.on('messagesRead', () => {
            updateGlobalUnreadBadges();
        });
    })();
</script>
