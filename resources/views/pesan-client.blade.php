@extends('layouts.app')

@section('content')
<div class="chat-wrapper" style="padding-bottom: 120px;">
    <div class="chat-container">
        <header class="chat-header">Layanan Chat Admin</header>

        <main class="chat-body" id="messages"></main>

        <form class="chat-footer" id="form" style="position: fixed; bottom: 60px; left: 0; width: 100%; padding: 10px; z-index: 1000;">
            <input id="input" type="text" placeholder="Ketik pesan…" required>
            <button type="submit" aria-label="Kirim">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ========== RESET & VARIABEL ========== */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --h-header: 60px;
        --h-footer: 64px;
        --bg-page: #e5ddd5;
        --bg-header: #075e54;
        --bg-footer: #f0f2f5;
        --bubble-me: #dcf8c6;
        --bubble-admin: #fff;
    }

    /* ========== BODY & HTML ========== */
    html,
    body {
        height: 100%;
        overflow: hidden;
        /* scrollbar hanya di chat-body */
        font-family: system-ui, Arial, sans-serif;
    }

    /* ========== WRAPPER UTAMA ========== */
    .chat-wrapper {
        width: 100%;
        height: calc(100vh - 60px);
        /* Sesuaikan dengan tinggi navbar */
        display: flex;
        flex-direction: column;
        background: var(--bg-page);
    }

    .chat-container {
        width: 100%;
        max-width: 900px;
        height: 100%;
        /* isi tinggi wrapper */
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* tidak boleh scroll di sini */
    }

    /* ========== HEADER ========== */
    .chat-header {
        height: var(--h-header);
        background: var(--bg-header);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 600;
        flex: 0 0 auto;
        /* tetap di atas */
        box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
    }

    /* ========== BODY / PESAN ========== */
    .chat-body {
        flex: 1 1 auto;
        /* sisa ruang tinggi */
        overflow-y: auto;
        /* hanya ini yang scroll */
        -webkit-overflow-scrolling: touch;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        background: #efeae2 url('https://web.whatsapp.com/img/bg-chat-tile-light_a4be512e7195b6b733d9110b408f075d.png');
    }

    .chat-body::-webkit-scrollbar {
        width: 7px
    }

    .chat-body::-webkit-scrollbar-thumb {
        background: #aaa;
        border-radius: 4px
    }

    /* ========== BUBBLE ========== */
    .message-wrapper {
        display: flex;
        margin-bottom: 15px;
        width: 100%;
        align-items: flex-start;
    }

    .message-wrapper.me {
        justify-content: flex-end;
    }

    .message-wrapper.admin {
        justify-content: flex-start;
    }

    .message-container {
        max-width: 50%;
        display: flex;
        flex-direction: column;
    }

    .bubble {
        padding: 10px 15px;
        border-radius: 18px;
        font-size: 16px;
        line-height: 1.4;
        word-wrap: break-word;
        white-space: pre-wrap;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    }

    .bubble.me {
        background: var(--bubble-me);
        border-bottom-right-radius: 4px;
    }

    .bubble.admin {
        background: var(--bubble-admin);
        border-bottom-left-radius: 4px;
    }

    .message-date {
        font-size: .75rem;
        color: #667781;
        margin-top: 5px;
        padding: 0 5px;
    }

    .message-wrapper.me .message-date {
        text-align: right;
    }

    .message-wrapper.admin .message-date {
        text-align: left;
    }

    /* pembatas tanggal */
    .date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }

    .date-divider span {
        background-color: #efeae2;
        padding: 5px 15px;
        color: #667781;
        font-size: .8rem;
        position: relative;
        z-index: 1;
        border-radius: 12px;
        font-weight: 500;
    }

    .date-divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #ccc;
        z-index: 0;
    }

    /* ========== FOOTER / INPUT ========== */
    .chat-footer {
        flex: 0 0 auto;
        /* tinggi tetap */
        height: var(--h-footer);
        max-height: var(--h-footer);
        background: var(--bg-footer);
        border-top: 1px solid #ddd;
        display: flex;
        align-items: center;
        padding: 0 15px;
        gap: 10px;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, .05);
    }

    .chat-footer input {
        flex: 1;
        border: 1px solid #ccc;
        border-radius: 24px;
        padding: 11px 16px;
        font-size: 16px;
        outline: none;
    }

    .chat-footer input:focus {
        border-color: #128c7e;
    }

    .chat-footer button {
        border: none;
        background: #128c7e;
        color: #fff;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        font-size: 15px;
        cursor: pointer;
    }

    .chat-footer button {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border: none;
        border-radius: 50%;
        background: #128c7e;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .2s;
    }

    .chat-footer button:hover {
        background: #075e54;
    }

    /* ========== RESPONSIVE ========== */
    @media(max-width:768px) {
        .chat-container {
            max-width: 100%;
            border-radius: 0;
        }

        .message-container {
            max-width: 70%;
        }

        .chat-body {
            padding: 10px;
        }

        .chat-footer {
            padding: 0 10px;
        }
    }

    @media(max-width:576px) {
        :root {
            --h-header: 50px;
            --h-footer: 56px;
        }

        .chat-header {
            font-size: 1rem;
        }

        .chat-footer input {
            padding: 10px 14px;
            font-size: 14px;
        }

        .chat-footer button {
            width: 40px;
            height: 40px;
        }

        .chat-footer button svg {
            width: 20px;
            height: 20px;
        }

        .message-container {
            max-width: 85%;
        }

        .bubble {
            font-size: 15px;
            padding: 8px 12px;
        }
    }

</style>
@endpush

@push('scripts')
<script>
    /* konversi env ke JS */
    const SERVER_URL = "{{ env('SOCKET_URL') }}";
    const ADMIN_ID = "{{ env('ADMIN_ID') }}";
    const USER_ID = "{{ auth()->user()->nik}}";

    // --- DEBUG: Pastikan variabel ini terisi dengan benar ---
    console.log('Server URL:', SERVER_URL);
    console.log('Admin ID:', ADMIN_ID);
    console.log('User ID:', USER_ID);

</script>
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    const socket = io(SERVER_URL, {
        transports: ["websocket", "polling"]
    });
    const form = document.getElementById('form');
    const input = document.getElementById('input');
    const box = document.getElementById('messages');

    let lastDisplayedDate = null; // Untuk melacak tanggal terakhir yang ditampilkan

    // Fungsi untuk memformat tanggal
    function formatDate(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        // Cek apakah tanggalnya hari ini
        if (date.toDateString() === today.toDateString()) {
            return 'Hari ini, ' + date.toLocaleTimeString('id-ID', {
                hour: '2-digit'
                , minute: '2-digit'
            });
        }

        // Cek apakah tanggalnya kemarin
        if (date.toDateString() === yesterday.toDateString()) {
            return 'Kemarin, ' + date.toLocaleTimeString('id-ID', {
                hour: '2-digit'
                , minute: '2-digit'
            });
        }

        // Jika bukan hari ini atau kemarin, tampilkan tanggal lengkap
        return date.toLocaleDateString('id-ID', {
            day: 'numeric'
            , month: 'long'
            , year: 'numeric'
            , hour: '2-digit'
            , minute: '2-digit'
        });
    }

    // Fungsi untuk menambahkan pembatas tanggal
    function addDateDivider(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        let dateText;
        if (date.toDateString() === today.toDateString()) {
            dateText = 'Hari ini';
        } else if (date.toDateString() === yesterday.toDateString()) {
            dateText = 'Kemarin';
        } else {
            dateText = date.toLocaleDateString('id-ID', {
                day: 'numeric'
                , month: 'long'
                , year: 'numeric'
            });
        }

        const divider = document.createElement('div');
        divider.classList.add('date-divider');
        const span = document.createElement('span');
        span.textContent = dateText;
        divider.appendChild(span);
        box.appendChild(divider);
    }

    // FUNGSI YANG SUDAH DIPERBAIKI
    function addBubble(text, siapa = 'me', createdAt) {
        // Format tanggal
        const messageDate = new Date(createdAt);
        const messageDateString = messageDate.toDateString();

        // Tambahkan pembatas tanggal jika ini adalah pesan pertama atau tanggal berbeda dari pesan sebelumnya
        if (lastDisplayedDate === null || messageDateString !== lastDisplayedDate) {
            addDateDivider(createdAt);
            lastDisplayedDate = messageDateString;
        }

        // 1. Buat wrapper untuk pesan
        const messageWrapper = document.createElement('div');
        messageWrapper.classList.add('message-wrapper');
        messageWrapper.classList.add(siapa);

        // 2. Buat container untuk gelembung pesan dan tanggal
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('message-container');

        // 3. Buat gelembung pesan
        const b = document.createElement('div');
        b.className = 'bubble ' + siapa;
        b.textContent = text;

        // 4. Buat elemen tanggal
        const messageDateElement = document.createElement('div');
        messageDateElement.classList.add('message-date');
        messageDateElement.textContent = formatDate(createdAt);

        // 5. Susun elemen
        messageContainer.appendChild(b);
        messageContainer.appendChild(messageDateElement);
        messageWrapper.appendChild(messageContainer);
        box.appendChild(messageWrapper);

        // 6. Auto-scroll ke pesan terbaru
        box.scrollTop = box.scrollHeight;
    }

    // FUNGSI YANG SUDAH DIPERBAIKI
    async function loadMessageHistory() {
        // Tampilkan indikator loading (opsional)
        box.innerHTML = '<div style="text-align:center; color:#888;">Memuat pesan...</div>';

        try {
            const response = await fetch(`${SERVER_URL}/api/messages/${ADMIN_ID}/${USER_ID}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const messages = await response.json();

            // --- DEBUG: Lihat struktur data yang diterima ---
            console.log('Messages from API:', messages);

            // Kosongkan kotak pesan sebelum menambahkan histori
            box.innerHTML = '';
            lastDisplayedDate = null; // Reset tanggal terakhir yang ditampilkan

            // Tampilkan setiap pesan
            messages.forEach(msg => {
                // PERBAIKAN: Akses ID pengirim dari objek 'sender' yang bersarang
                // Fallback ke msg.senderId jika 'sender' tidak ada
                const senderIdFromApi = msg.sender ? msg.sender.id : msg.senderId;

                // Bandingkan dengan ID user yang sedang login
                const sender = (senderIdFromApi == USER_ID) ? 'me' : 'admin';

                addBubble(msg.content, sender, msg.createdAt);
            });

        } catch (error) {
            console.error('Gagal memuat histori pesan:', error);
            box.innerHTML = '<div style="text-align:center; color:red;">Gagal memuat pesan lama.</div>';
        }
    }

    // Panggil fungsi untuk memuat histori saat halaman dibuka
    loadMessageHistory();

    socket.on('connect', () => {
        socket.emit('register', {
            id: `${USER_ID}`
            , username: '{{ auth()->user()->name }}'
            , role: 'user'
        });
    });
    socket.on('newMessageFromAdmin', m => addBubble(m.content, 'admin', m.createdAt));

    form.addEventListener('submit', e => {
        e.preventDefault();
        const pesan = input.value.trim();
        if (!pesan) return;

        // Tambahkan pesan ke UI dengan timestamp saat ini
        const now = new Date().toISOString();
        addBubble(pesan, 'me', now);

        // Kirim pesan ke server
        socket.emit('sendMessageToAdmin', pesan);
        input.value = '';
    });

    // Fokus otomatis ke input saat halaman dimuat
    window.addEventListener('load', () => {
        input.focus();
    });

    // Fokus kembali ke input setelah mengirim pesan
    input.addEventListener('blur', () => {
        setTimeout(() => input.focus(), 100);
    });

</script>
@endpush
