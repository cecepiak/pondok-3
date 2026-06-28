<?php
    // Pastikan Anda sudah mengimpor model User di namespace yang benar atau gunakan FQCN
    $newUsers = \App\Models\User::where('active', 0)
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
    
    $notificationCount = \App\Models\User::where('active', 0)->count();
?>

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($notificationCount > 0)
            <span class="badge badge-danger navbar-badge">{{ $notificationCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $notificationCount }} Notifikasi Baru</span>
        <div class="dropdown-divider"></div>

        @forelse ($newUsers as $user)
            {{-- MENGARAHKAN KE ROUTE INDEX USER BARU (user_baru.index) --}}
            {{-- Meneruskan user_id agar halaman index bisa menyorot user ini. --}}
            <a href="{{ route('user_baru.index', ['highlight_id' => $user->id]) }}" class="dropdown-item">
                <i class="fas fa-user-plus mr-2"></i> User baru: **{{ $user->name }}**
                <span class="float-right text-muted text-sm">{{ $user->created_at?->diffForHumans() }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <a href="#" class="dropdown-item">Tidak ada notifikasi baru.</a>
        @endforelse
        
        {{-- Menggunakan route index dari UserBaruController --}}
        <a href="{{ route('user_baru.index', ['active' => 0]) }}" class="dropdown-item dropdown-footer">Lihat Semua User Baru</a>
    </div>
</li>