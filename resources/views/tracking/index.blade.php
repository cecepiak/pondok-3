@extends('layouts.app')
@section('content')

@php
    $kategoriMap = [
        '1' => 'Lansia', '2' => 'Sakit', '3' => 'Disabilitas', '4' => 'ODGJ', '5' => 'Lainnya'
    ];
@endphp

<div class="max-w-4xl mx-auto p-4 pb-20">
    <h1 class="text-xl md:text-2xl font-bold mb-6 text-center text-gray-800 uppercase tracking-wider">
        {{ $isPedes ? 'Daftar Permohonan PEDES' : 'Daftar Permohonan' }}
    </h1>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        @if ($orders->count() > 0)
            <ul class="divide-y divide-gray-100">
                @foreach ($orders as $order)
                    <li class="p-4 md:p-6 hover:bg-blue-50/50 transition-all duration-200">
                        
                        {{-- Sesuai Gambar: Kiri (ID) dan Kanan (Status) sejajar di semua ukuran layar --}}
                        <a href="{{ $isPedes ? route('tracking.pedes.show', $order->id_trx) : route('tracking.show', $order->id_trx) }}" 
                           class="flex flex-row items-start justify-between w-full gap-2">
                            
                            {{-- SISI KIRI: ID Transaksi & Nama --}}
                            <div class="flex flex-col min-w-0">
                                <p class="text-[10px] md:text-xs text-gray-400 font-medium uppercase tracking-wider">ID Transaksi</p>
                                <p class="text-sm md:text-lg font-bold text-blue-800 tracking-tight leading-tight truncate">
                                    {{ $order->id_trx }}
                                </p>
                                
                                <div class="mt-2 flex flex-wrap gap-1 md:gap-2 items-center">
                                    <span class="text-[9px] md:text-[11px] font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded uppercase">
                                        {{ $order->nama }}
                                    </span>
                                    
                                    @if($isPedes)
                                        <span class="text-[9px] md:text-[11px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded uppercase">
                                            {{ $kategoriMap[$order->kategori_pemohon] ?? $order->kategori_pemohon }}
                                        </span>
                                    @endif

                                    @php
                                        $rawLayanan = $order->id_dokumen;
                                        $docIds = is_array($rawLayanan) ? $rawLayanan : json_decode($rawLayanan, true);
                                        $layananMap = [
                                            '1' => 'Kartu Keluarga',
                                            '2' => 'KTP',
                                            '3' => 'KIA',
                                            '4' => 'Pindah',  
                                            '5' => 'Datang',
                                            '6' => 'Akta Kelahiran',                    
                                            '7' => 'Akta Kematian',
                                            '8' => 'Surat Pengantar KUA',   
                                            '9' => 'Lainnya'                                    
                                        ];
                                    @endphp

                                    @if(!empty($docIds) && is_array($docIds))
                                        @foreach($docIds as $docId)
                                            @php
                                                $cleanId = trim((string)$docId);
                                            @endphp
                                            @if(isset($layananMap[$cleanId]))
                                                <span class="text-[9px] md:text-[11px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded uppercase">
                                                    {{ $layananMap[$cleanId] }}
                                                </span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- SISI KANAN: Status Permohonan (Tetap di Kanan meski di Mobile) --}}
                            <div class="flex flex-col items-end flex-shrink-0">
                                <p class="text-[10px] md:text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Status</p>
                                
                                @if($isPedes)
                                    <span class="px-3 py-1 rounded-full text-[9px] md:text-[11px] font-black uppercase tracking-wider shadow-sm {{ $order->status_color }}">
                                        {{ $order->status_text }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[9px] md:text-[11px] font-black uppercase tracking-wider shadow-sm
                                        @if ($order->status == '4') text-green-600 bg-green-50
                                        @elseif ($order->status == '3') text-blue-600 bg-blue-50
                                        @elseif ($order->status == '2') text-gray-600 bg-gray-50
                                        @else text-orange-600 bg-orange-50
                                        @endif">
                                        {{-- Logika Label Status Umum --}}
                                        @php
                                            $labels = ['4'=>'Selesai','3'=>'Diproses','5'=>'Ditolak','2'=>'Verifikasi','8'=>'Batal','6'=>'Ulang','7'=>'Komplain'];
                                            echo $labels[$order->status] ?? 'Baru';
                                        @endphp
                                    </span>
                                @endif
                            </div>
                        </a>

                        {{-- Tombol Cetak & Aksi Dinamis --}}
                        <div class="mt-4 flex justify-end border-t border-gray-50 pt-3">
                            @if (!$isPedes && $order->status == '4')
                                <a href="{{ route('tracking.show', $order->id_trx) }}?cek_berkas=1" 
                                   class="inline-flex items-center px-3 py-1.5 text-[9px] md:text-[10px] font-black bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all shadow-sm uppercase mr-2">
                                    <svg class="w-3 h-3 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Cek Berkas
                                </a>
                                <button type="button" 
                                        onclick="bukaRatingModal('{{ $order->id_trx }}')"
                                        class="inline-flex items-center px-3 py-1.5 text-[9px] md:text-[10px] font-black bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-sm uppercase mr-2">
                                    <svg class="w-3 h-3 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z"/>
                                    </svg>
                                    Nilai Kami
                                </button>
                            @endif

                            @if (!$isPedes && $order->status == '5')
                                <button type="button" 
                                        onclick="bacaPesan('{{ addslashes($order->pesan ?? 'Tidak ada pesan khusus dari petugas.') }}', '{{ $order->id_trx }}')"
                                        class="inline-flex items-center px-3 py-1.5 text-[9px] md:text-[10px] font-black bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all shadow-sm uppercase mr-2">
                                    <svg class="w-3 h-3 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    Baca Pesan
                                </button>
                            @endif

                            <a href="{{ $isPedes ? route('bukti.pedes', $order->id_trx) : route('bukti', $order->id_trx) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-[9px] md:text-[10px] font-black bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all shadow-sm uppercase">
                                <svg class="w-3 h-3 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                CETAK BUKTI
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center py-16">
                <p class="text-gray-500 italic text-sm">Belum ada riwayat permohonan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Nilai Kami -->
<div id="nilai-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                <div class="flex flex-col items-center text-center">
                    <!-- Icon Header with Gradient -->
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-tr from-blue-50 to-indigo-50 text-blue-600 mb-4 shadow-inner transform transition-all duration-300 hover:rotate-12">
                        <svg class="h-8 w-8 text-blue-600 filter drop-shadow-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 tracking-tight" id="modal-title">
                        Nilai Layanan Kami
                    </h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-xs">
                        Kepuasan Anda adalah prioritas kami. Berikan penilaian Anda untuk layanan ini.
                    </p>
                    
                    <!-- Rating Stars Container -->
                    <div class="mt-6 w-full">
                        <div class="flex justify-center space-x-3 mb-2" id="star-rating-container">
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="1" class="sr-only">
                                <span class="star text-gray-300 text-4xl md:text-5xl transition-all duration-150 inline-block transform group-hover:scale-125 select-none">★</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="2" class="sr-only">
                                <span class="star text-gray-300 text-4xl md:text-5xl transition-all duration-150 inline-block transform group-hover:scale-125 select-none">★</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="3" class="sr-only">
                                <span class="star text-gray-300 text-4xl md:text-5xl transition-all duration-150 inline-block transform group-hover:scale-125 select-none">★</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="4" class="sr-only">
                                <span class="star text-gray-300 text-4xl md:text-5xl transition-all duration-150 inline-block transform group-hover:scale-125 select-none">★</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="5" class="sr-only">
                                <span class="star text-gray-300 text-4xl md:text-5xl transition-all duration-150 inline-block transform group-hover:scale-125 select-none">★</span>
                            </label>
                        </div>
                        <!-- Teks Deskripsi Dinamis -->
                        <div id="rating-label" class="inline-block px-3 py-1 bg-gray-50 text-gray-400 text-xs font-semibold rounded-full border border-gray-100 transition-all duration-200">
                            Pilih tingkat kepuasan Anda
                        </div>
                    </div>

                    <!-- Komentar Opsional -->
                    <div class="mt-6 w-full text-left">
                        <label for="comment" class="block text-sm font-semibold text-gray-700 mb-1">Komentar / Masukan (opsional)</label>
                        <textarea id="comment" rows="3" class="mt-1 block w-full border border-gray-200 rounded-2xl shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm transition-all duration-200" placeholder="Ceritakan pengalaman Anda atau berikan saran..."></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer Buttons -->
            <div class="bg-gray-50/50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row sm:justify-end gap-2 border-t border-gray-100/50 rounded-b-3xl">
                <button type="button" id="nilai-cancel" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-200">
                    Batal
                </button>
                <button type="button" id="nilai-submit" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:from-blue-700 hover:to-indigo-700 shadow-md hover:shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform active:scale-95">
                    Kirim Penilaian
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function bacaPesan(pesan, idTrx) {
        Swal.fire({
            icon: 'info',
            title: 'Pesan Petugas',
            text: pesan,
            showCancelButton: true,
            confirmButtonText: 'Ajukan Ulang',
            cancelButtonText: 'Tutup',
            confirmButtonColor: '#8b5cf6', // Warna ungu untuk Ajukan Ulang
            cancelButtonColor: '#3085d6',  // Warna biru untuk Tutup
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/pengajuan-ulang/` + idTrx;
            }
        });
    }

    // === FITUR: NILAI KAMI ===
    let currentRatingIdTrx = null;
    const nilaiModal = document.getElementById('nilai-modal');
    const nilaiSubmit = document.getElementById('nilai-submit');
    const nilaiCancel = document.getElementById('nilai-cancel');
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const commentInput = document.getElementById('comment');
    const ratingLabel = document.getElementById('rating-label');

    const stars = document.querySelectorAll('.star');

    function highlightStars(count) {
        stars.forEach((star, index) => {
            if (index < count) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400', 'scale-110');
            } else {
                star.classList.remove('text-yellow-400', 'scale-110');
                star.classList.add('text-gray-300');
            }
        });
    }

    function updateRatingDisplay() {
        const selected = document.querySelector('input[name="rating"]:checked');
        if (selected) {
            const ratingValue = parseInt(selected.value);
            highlightStars(ratingValue);
            
            let labelText = '';
            let labelClass = '';
            switch(ratingValue) {
                case 1: 
                    labelText = 'Sangat Kurang 😞'; 
                    labelClass = 'text-red-600 border-red-100 bg-red-50';
                    break;
                case 2: 
                    labelText = 'Kurang 😕'; 
                    labelClass = 'text-orange-500 border-orange-100 bg-orange-50';
                    break;
                case 3: 
                    labelText = 'Cukup 😐'; 
                    labelClass = 'text-yellow-600 border-yellow-100 bg-yellow-50';
                    break;
                case 4: 
                    labelText = 'Baik 🙂'; 
                    labelClass = 'text-blue-600 border-blue-100 bg-blue-50';
                    break;
                case 5: 
                    labelText = 'Sangat Baik! 😀'; 
                    labelClass = 'text-green-600 border-green-100 bg-green-50';
                    break;
            }
            ratingLabel.textContent = labelText;
            ratingLabel.className = `inline-block px-3 py-1 font-semibold rounded-full border transition-all duration-200 ${labelClass}`;
        } else {
            highlightStars(0);
            ratingLabel.textContent = 'Pilih tingkat kepuasan Anda';
            ratingLabel.className = 'inline-block px-3 py-1 bg-gray-50 text-gray-400 text-xs font-semibold rounded-full border border-gray-100 transition-all duration-200';
        }
    }

    ratingInputs.forEach(input => {
        input.addEventListener('change', updateRatingDisplay);
    });

    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', () => {
            highlightStars(index + 1);
        });
        star.addEventListener('mouseleave', () => {
            const selected = document.querySelector('input[name="rating"]:checked');
            if (selected) {
                highlightStars(parseInt(selected.value));
            } else {
                highlightStars(0);
            }
        });
    });

    window.bukaRatingModal = function(idTrx) {
        currentRatingIdTrx = idTrx;
        nilaiModal.classList.remove('hidden');
        ratingInputs.forEach(radio => radio.checked = false);
        updateRatingDisplay();
        if (commentInput) commentInput.value = '';
    };

    if (nilaiCancel && nilaiModal) {
        nilaiCancel.addEventListener('click', () => {
            nilaiModal.classList.add('hidden');
            ratingInputs.forEach(radio => radio.checked = false);
            updateRatingDisplay();
            if (commentInput) commentInput.value = '';
        });
    }

    if (nilaiSubmit) {
        nilaiSubmit.addEventListener('click', () => {
            const selectedRating = document.querySelector('input[name="rating"]:checked');
            const comment = commentInput ? commentInput.value.trim() : '';
            if (!selectedRating) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Belum Memilih Rating',
                    text: 'Silakan pilih salah satu tingkat kepuasan.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Mengirim Penilaian...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/api/nilai/${currentRatingIdTrx}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    rating: parseInt(selectedRating.value),
                    comment: comment
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terima Kasih!',
                        text: 'Penilaian Anda telah kami terima. Kami sangat menghargai masukan Anda!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat mengirim penilaian.',
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan teknis. Silakan coba lagi nanti.',
                    confirmButtonText: 'Tutup'
                });
            })
            .finally(() => {
                nilaiModal.classList.add('hidden');
                ratingInputs.forEach(radio => radio.checked = false);
                updateRatingDisplay();
                if (commentInput) commentInput.value = '';
            });
        });
    }

    // Tutup modal jika klik di luar
    window.addEventListener('click', (event) => {
        if (nilaiModal && event.target === nilaiModal) {
            nilaiModal.classList.add('hidden');
            if (commentInput) commentInput.value = '';
            ratingInputs.forEach(radio => radio.checked = false);
        }
    });
</script>
@endpush
@endsection