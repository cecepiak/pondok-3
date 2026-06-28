<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />
    <title>Pondok Dukcapil Tapin</title>
    <link rel="icon" type="image/png" href="{{ asset('icon/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.min.css" integrity="sha512-xtV3HfYNbQXS/1R1jP53KbFcU9WXiSA1RFKzl5hRlJgdOJm4OxHCWYpskm6lN0xp0XtKGpAfVShpbvlFH3MDAA==" crossorigin="anonymous" referrerpolicy="no-refer rer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12.0.3/swiper-bundle.min.css" />
    <style>
        /* Pastikan container swiper tidak overflow */
        .swiper {
            width: 100%;
            height: auto;
        }

        /* Batasi ukuran slide */
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 16 / 9;
            /* Opsional: jaga rasio gambar */
            max-height: 300px;
            /* Sesuaikan sesuai kebutuhan */
        }

        /* Jika slide berisi gambar */
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Penting: agar gambar tidak stretch */
            display: block;
        }

        /* Pagination styling (opsional) */
        .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background-color: #9ca3af;
            /* Warna abu-abu muda */
            opacity: 0.8;
            /* Transparansi */
            border-radius: 50%;
            /* Bulat sempurna */
            margin: 0 4px;
            /* Jarak antar titik */
        }

        /* Pagination Aktif */
        .swiper-pagination-bullet-active {
            background-color: #3b82f6;
            /* Biru (warna primary) */
            opacity: 1;
            transform: scale(1.2);
            /* Sedikit lebih besar saat aktif */
        }

    </style>

    @stack('styles')
</head>

<body class="bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/bg.jpg') }}');">
    <div class="min-h-screen">
        @yield('content')
    </div>

    @include('layouts.partials.footer-nav')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12.0.3/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true
            , slidesPerView: 2
            , centeredSlides: false
            , spaceBetween: 30
            , autoplay: {
                delay: 3000
                , disableOnInteraction: false
            , }
            , pagination: {
                el: ".swiper-pagination"
                , clickable: true
            , }
        , });

    </script>
    @stack('scripts')
</body>
</html>
