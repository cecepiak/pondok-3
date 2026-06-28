@extends('layouts.app')
@section('content')

<div class="max-w-6xl mx-auto px-4 py-8">
    @if(isset($slides) && $slides->count() > 0)
    <div class="swiper mySwiper rounded-lg">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
            <div class="swiper-slide flex justify-center">
                <a href="{{ asset('images/' . $slide->filename) }}" data-src="{{ asset('images/' . $slide->filename) }}" class="lightbox-link relative w-[950px] h-[498px] overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/' . $slide->filename) }}" class="w-full h-full object-cover" alt="{{ $slide->judul }}">
                </a>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    @endif

    <section class="mt-4 bg-white/50 backdrop-blur-sm rounded-lg shadow-xl p-4">
        <div class="grid grid-cols-5 gap-2">
            @auth
            {{-- Bagian ini ditampilkan jika pengguna sudah login --}}
            <a href="{{ route('logout') }}" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('icon/Logout1.png') }}" alt="Logout" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
            {{-- Bagian ini ditampilkan jika pengguna belum login --}}
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/login.png') }}" alt="Login" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Login</span>
            </a>
            @endauth
            <a href="/formulir" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/formulir.png') }}" alt="Formulir" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Formulir</span>
            </a>
            <a href="/persyaratan" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/syarat1.png') }}" alt="Persyaratan" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Persyaratan</span>
            </a>
            <a href="https://dukcapil.tapinkab.go.id/publikasi/sp-sop" target="_blank" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/syarat.png') }}" alt="Persyaratan" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">S.P</span>
            </a>
            <a href="https://files.dukcapil.tapinkab.go.id/tutorial-pondok.pdf" target="_blank" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/Tutorial1.png') }}" alt="Tutorial" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Tutorial</span>
            </a>
        </div>
    </section>

    <section class="mt-4">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            {{-- Layanan Online --}}
            <a href="/form_pengajuan" class="animate-bounce-up bg-white/70 rounded-lg shadow-xl overflow-hidden flex flex-col items-center justify-center p-4 transform transition duration-300 hover:scale-105 hover:bg-blue-50">
                <img src="{{ asset('icon/online2.png') }}" alt="Layanan Online" class="w-20 h-20 mb-2">
                <p class="font-bold text-black-500 mt-1 text-center">Layanan Online</p>
                    <p class="text-gray-500 text-sm mb-1 text-center">Pengajuan Dokumen Administrasi Kependudukan</p>
            </a>

            {{-- Agregat --}}
            <a href="https://petaku.dukcapil.tapinkab.go.id/agregat-kependudukan" target="_blank" class="animate-bounce-up bg-white/70 rounded-lg shadow-xl overflow-hidden flex flex-col items-center justify-center p-4 transform transition duration-300 hover:scale-105 hover:bg-blue-50">
                <img src="{{ asset('icon/formulir-1.png') }}" alt="SP" class="w-20 h-20 mb-2">
                <p class="font-bold text-black-500 mt-1 text-center">Agregat Kependudukan</p>
                <p class="text-gray-500 text-sm mb-1 text-center">Informasi Data Kependudukan Kabupaten Tapin</p>
            </a>
            

            {{-- SKM --}}
            <div class="col-span-2 lg:col-span-1 flex justify-center">
                <a href="https://survei.dukcapil.tapinkab.go.id/survei-kepuasan-masyarakat" target="_blank" class="w-full lg:w-full max-w-[calc(50%-0.5rem)] lg:max-w-none animate-bounce-up bg-white/70 rounded-lg shadow-xl overflow-hidden flex flex-col items-center justify-center p-4 transform transition duration-300 hover:scale-105 hover:bg-blue-50">
                    <img src="{{ asset('icon/konsultasi.png') }}" alt="SP" class="w-20 h-20 mb-2">
                    <p class="font-bold text-black-500 mt-1 text-center">SKM</p>
                    <p class="text-gray-500 text-sm mb-1 text-center">Survey kepuasan masyarakat guna meningkatkan kualitas pelayanan Disdukcapil Tapin</p>
                </a>
            </div>
        </div>
    </section>
    
    <section class="text-center py-10 relative z-10 animate-bounce-up-delay">
        <style>
            .merah {
                color: blue;
                font-weight: bold;
            }

            .biru {
                color: green;
                font-weight: bold;
            }

            .hijau {
                color: orange;
                font-weight: bold;
            }

            .kuning {
                color: red;
                font-weight: bold;
            }

        </style>
        <p class="mt-2 text-black/70">
            <span class="merah">P</span>elayanan <span class="biru">On</span>line
            <span class="hijau">Do</span>kumen <span class="kuning">K</span>ependudukan
        </p>
        <h2 style="font-size: 2.25rem; font-weight: bold;">
            <span class="merah">DIS</span><span class="biru">DUK</span><span class="hijau">CA</span><span class="kuning">PIL</span>
        </h2>
        <img src="{{ asset('icon/jargon2.png') }}" alt="Jargon Tapin" class="mt-4 mx-auto w-45 h-20">
    </section>
</div>

{{-- HTML MODAL LOGIN - ID: login-modal --}}
<div id="login-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-full px-4 py-6 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl 
                    transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6 
                    relative z-50">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.017 3.377 1.517 3.377h13.064c1.5 0 2.383-1.877 1.517-3.377L12.99 3.375c-.865-1.5-2.29-1-3.155 0L2.696 16.501z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Akses Ditolak
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Anda belum login. Silahkan login atau daftar terlebih dahulu untuk mengakses layanan ini.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 flex flex-col sm:flex-row-reverse gap-y-2 sm:gap-x-3">
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                    Login
                </a>
                <button type="button" id="close-modal-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Deklarasi variabel
        const loginModal = document.getElementById('login-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const pengajuanLink = document.getElementById('pengajuan-link');
        const riwayatLink = document.getElementById('riwayat-link');
        const akunLink = document.getElementById('akun-link');

        // Pastikan elemen penting (Modal dan Tombol Tutup) ditemukan
        if (loginModal && closeModalBtn) {
            function showModal() {
                loginModal.classList.remove('hidden');
            }

            function hideModal() {
                loginModal.classList.add('hidden');
            }

            // Memasang listener pada tombol tutup
            closeModalBtn.addEventListener('click', hideModal);

            @guest


            // 2. Link Lacak (pengajuan-link) - dari footer
            if (pengajuanLink) {
                pengajuanLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }

            // 3. Link Riwayat (riwayatLink) - dari footer
            if (riwayatLink) {
                riwayatLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }

            // 4. Link Akun (akunLink) - dari footer
            if (akunLink) {
                akunLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }

            @else
            // Logika ketika user SUDAH login: Redirect

            if (admindukLink) {
                admindukLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/layanan';
                });
            }

            if (pengajuanLink) {
                pengajuanLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/tracking';
                });
            }

            if (riwayatLink) {
                riwayatLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/transaksi';
                });
            }

            if (akunLink) {
                akunLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/account';
                });
            }
            @endguest
        }
    });

</script>

{{-- SCRIPT LIGHTBOX UNTUK GAMBAR SLIDER --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan semua link yang memiliki kelas lightbox-link
        const lightboxLinks = document.querySelectorAll('.lightbox-link');

        lightboxLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah browser membuka link

                // Mendapatkan URL gambar dari atribut href
                const imageUrl = this.getAttribute('href');

                // Membuat overlay untuk lightbox
                const overlay = document.createElement('div');
                overlay.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';

                // Membuat elemen gambar untuk ditampilkan di dalam overlay
                const imgElement = document.createElement('img');
                imgElement.src = imageUrl;
                imgElement.className = 'max-w-full max-h-full';

                overlay.appendChild(imgElement);
                document.body.appendChild(overlay);

                // Menutup lightbox saat overlay diklik
                overlay.addEventListener('click', function() {
                    document.body.removeChild(overlay);
                });
            });
        });
    });

</script>

    <style>
        .material-symbols-outlined {
            font-size: 72px;
            color: blue;
            font-variation-settings:
                'FILL'1,
                'wght'400,
                'GRAD'0,
                'opsz'48;
        }

        /* Kode CSS untuk animasi bounce yang lebih baik */
        @keyframes bounce-up {
            0% {
                opacity: 0;
                /* Dimulai dari bawah dengan jarak yang lebih jauh */
                transform: translateY(200px);
            }

            60% {
                /* Memantul ke atas dan sedikit overshoot */
                transform: translateY(-10px);
            }

            80% {
                /* Memantul ke bawah sedikit sebelum berhenti */
                transform: translateY(7px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-bounce-up {
            animation: bounce-up 0.7s ease-out;
            animation-fill-mode: backwards;
        }

        .animate-bounce-up-delay {
            animation: bounce-up 0.7s ease-out 0.7s;
            animation-fill-mode: backwards;
        }
    </style>

@endsection

@push('scripts')

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Berhasil!'
        , text: 'Silahkan akses menu layanan dan ajukan permohonan.'
        , showConfirmButton: false
        , timer: 1500
    });

</script>
@endif

{{-- Logic SweetAlert untuk menangkap pesan error dari Controller --}}
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Akses Ditolak!',
        text: "{{ session('error') }}",
        confirmButtonText: 'Saya Mengerti',
        confirmButtonColor: '#3085d6',
        // footer: '<span style="color: #d33">Khusus Petugas Desa & Admin</span>',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    });
</script>
@endif
@endpush

