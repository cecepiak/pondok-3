@extends('adminlte::page')
@section('title', 'Pesan Admin')
@section('content')
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <!-- Tambahkan CSS kustom di sini -->
   <style>
    /* Style untuk daftar user */
    #user-list li {
        cursor: pointer;
        transition: background-color 0.2s;
        /* --- BARU: Gunakan flexbox untuk menata username dan badge --- */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    #user-list li:hover {
        background-color: #f8f9fa;
    }
    #user-list li.active {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }
    /* --- BARU: Style untuk badge --- */
    #user-list li .badge {
        font-size: 0.7rem;
    }
    #user-list li.active .badge {
        background-color: white !important; /* Badge lebih terlihat saat item aktif */
        color: #007bff;
    }

    /* Style untuk area chat */
    #chat-messages {
        display: flex;
        flex-direction: column; /* Menyusun pesan dari atas ke bawah */
        padding: 10px;
    }

    /* Style untuk gelembung pesan (chat bubble) */
    .message-wrapper {
        display: flex;
        margin-bottom: 15px;
        width: 100%;
        align-items: flex-start;
    }
    
    .message-container {
        max-width: 50%; /* Ubah ke 50% dari lebar area chat */
        display: flex;
        flex-direction: column;
    }
    
    .message-bubble {
        padding: 10px 15px;
        border-radius: 18px;
        word-wrap: break-word; /* Memecah kata yang terlalu panjang */
        overflow-wrap: break-word; /* Alternatif untuk word-wrap */
        hyphens: auto; /* Menambahkan tanda hubung jika diperlukan */
        white-space: pre-wrap; /* Mempertahankan spasi dan line break */
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        line-height: 1.4;
    }
    
    /* Pesan dari admin (kanan) */
    .message-wrapper.admin {
        justify-content: flex-end;
    }
    .message-wrapper.admin .message-container {
        align-items: flex-end;
    }
    .message-wrapper.admin .message-bubble {
        background-color: #007bff; /* Warna tema AdminLTE */
        color: white;
        border-bottom-right-radius: 4px; /* Sudut yang menunjuk ke pengirim */
    }
    
    /* Pesan dari user (kiri) */
    .message-wrapper.user {
        justify-content: flex-start;
    }
    .message-wrapper.user .message-container {
        align-items: flex-start;
    }
    .message-wrapper.user .message-bubble {
        background-color: #e9ecef; /* Abu-abu terang */
        color: #212529;
        border-bottom-left-radius: 4px; /* Sudut yang menunjuk ke pengirim */
    }
    
    /* Style untuk tanggal pesan */
    .message-date {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 5px;
        padding: 0 5px;
    }
    .message-wrapper.admin .message-date {
        text-align: right;
    }
    .message-wrapper.user .message-date {
        text-align: left;
    }
    
    /* Style untuk pembatas tanggal */
    .date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    .date-divider span {
        background-color: #f4f4f4;
        padding: 5px 15px;
        color: #6c757d;
        font-size: 0.8rem;
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
        background-color: #dee2e6;
        z-index: 0;
    }
    
    /* Responsif untuk layar kecil */
    @media (max-width: 768px) {
        .message-container {
            max-width: 70%; /* Lebih lebar di layar kecil */
        }
    }
    
    @media (max-width: 576px) {
        .message-container {
            max-width: 85%; /* Lebih lebar lagi di layar sangat kecil */
        }
        .message-bubble {
            padding: 8px 12px;
        }
    }
    </style>

    <div class="row">
        <div class="col-3">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Pesan dari Pengguna</h3>
                </div>
                <!-- .list-group-flush untuk menghilangkan border di samping -->
                <div class="card-body p-0">
                    <ul id="user-list" class="list-group list-group-flush">
                        <!-- Daftar user akan dimuat di sini -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card mt-4">
                <!-- Tambahkan header untuk chat yang sedang aktif -->
                <div class="card-header">
                    <h3 id="chat-header" class="card-title">Pilih percakapan untuk memulai</h3>
                </div>
                <div class="card-body p-0">
                    <div id="chat-messages" style="height: 650px; overflow-y: scroll; background-color: #f4f4f4;">
                        <!-- Pesan-pesan akan muncul di sini -->
                    </div>
                    <!-- Gunakan .input-group untuk menggabungkan input dan tombol -->
                    <div id="chat-input-area" class="input-group m-3">
                        <input type="text" id="chat-input" placeholder="Ketik balasan..." class="form-control" />
                        <button id="send-button" class="btn btn-primary">➤</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
        // --- KONFIGURASI ---
        const SERVER_URL = "{{ env('SOCKET_URL') }}";
        const ADMIN_ID = 'admin-main';

        // --- INISIALISASI SOCKET.IO ---
        const socket = io(SERVER_URL);

        // --- REFERENSI ELEMEN DOM ---
        const userList = document.getElementById('user-list');
        const chatHeader = document.getElementById('chat-header');
        const messagesDiv = document.getElementById('chat-messages');
        const input = document.getElementById('chat-input');
        const sendButton = document.getElementById('send-button');

        // --- STATE ---
        let currentChatUserId = null;
        let lastDisplayedDate = null;

        // --- FUNGSI-FUNGSI UTAMA ---

        // Fungsi untuk memformat tanggal
        function formatDate(dateString) {
            const date = new Date(dateString);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            
            if (date.toDateString() === today.toDateString()) {
                return 'Hari ini, ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }
            if (date.toDateString() === yesterday.toDateString()) {
                return 'Kemarin, ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }
            return date.toLocaleDateString('id-ID', { 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
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
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric'
                });
            }
            
            const divider = document.createElement('div');
            divider.classList.add('date-divider');
            const span = document.createElement('span');
            span.textContent = dateText;
            divider.appendChild(span);
            messagesDiv.appendChild(divider);
        }

        function displayMessage(content, sender, createdAt) {
            const messageDate = new Date(createdAt);
            const messageDateString = messageDate.toDateString();
            
            if (lastDisplayedDate === null || messageDateString !== lastDisplayedDate) {
                addDateDivider(createdAt);
                lastDisplayedDate = messageDateString;
            }
            
            const messageWrapper = document.createElement('div');
            messageWrapper.classList.add('message-wrapper');
            
            const messageContainer = document.createElement('div');
            messageContainer.classList.add('message-container');
            
            const messageBubble = document.createElement('div');
            messageBubble.classList.add('message-bubble');
            messageBubble.textContent = content;

            const messageDateElement = document.createElement('div');
            messageDateElement.classList.add('message-date');
            messageDateElement.textContent = formatDate(createdAt);

            if (sender === 'me') {
                messageWrapper.classList.add('admin');
            } else {
                messageWrapper.classList.add('user');
            }
            
            messageContainer.appendChild(messageBubble);
            messageContainer.appendChild(messageDateElement);
            messageWrapper.appendChild(messageContainer);
            messagesDiv.appendChild(messageWrapper);
            
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // --- FUNGSI YANG SUDAH DIPERBAIKI ---
        async function loadAllConversations() {
            try {
                // --- BARU: Ambil data percakapan dan jumlah pesan belum dibaca secara bersamaan ---
                const [conversationsResponse, unreadCountsResponse] = await Promise.all([
                    fetch(`${SERVER_URL}/api/messages/admin/${ADMIN_ID}`),
                    fetch(`${SERVER_URL}/api/messages/unread/admin/${ADMIN_ID}`)
                ]);

                const conversations = await conversationsResponse.json();
                const unreadCounts = await unreadCountsResponse.json();

                // --- BARU: Buat object map untuk pencarian cepat { userId: count } ---
                const unreadMap = unreadCounts.reduce((map, item) => {
                    map[item.senderId] = item.count;
                    return map;
                }, {});
                
                userList.innerHTML = '';
                
                conversations.forEach(conv => {
                    const userItem = document.createElement('li');
                    userItem.classList.add('list-group-item', 'list-group-item-action');
                    userItem.dataset.userId = conv.user.id;
                    userItem.onclick = () => selectUser(conv.user.id, conv.user.username);

                    // --- BARU: Buat elemen untuk username ---
                    const usernameSpan = document.createElement('span');
                    usernameSpan.textContent = conv.user.username;
                    userItem.appendChild(usernameSpan);

                    // --- BARU: Tambahkan badge jika ada pesan belum dibaca ---
                    const unreadCount = unreadMap[conv.user.id];
                    if (unreadCount > 0) {
                        const badge = document.createElement('span');
                        badge.classList.add('badge', 'bg-danger', 'ms-auto');
                        badge.textContent = unreadCount;
                        userItem.appendChild(badge);
                    }

                    userList.appendChild(userItem);
                });
            } catch (error) {
                console.error('Gagal memuat daftar percakapan:', error);
                userList.innerHTML = '<li class="list-group-item text-danger">Gagal memuat data.</li>';
            }
        }

        async function selectUser(userId, username) {
            // Hapus class 'active' dari semua item
            document.querySelectorAll('#user-list li').forEach(item => {
                item.classList.remove('active');
            });

            // Tandai item yang dipilih sebagai 'active'
            const selectedItem = document.querySelector(`#user-list li[data-user-id="${userId}"]`);
            if (selectedItem) {
                selectedItem.classList.add('active');
                // --- BARU: Hapus badge dari user yang dipilih untuk feedback instan ---
                const badge = selectedItem.querySelector('.badge');
                if (badge) {
                    badge.remove();
                }
            }

            currentChatUserId = userId;
            chatHeader.textContent = `Chat dengan: ${username}`;
            messagesDiv.innerHTML = '';
            lastDisplayedDate = null;

            // --- BARU: Kirim event ke server untuk menandai pesan sebagai sudah dibaca ---
            socket.emit('markMessagesAsRead', { otherUserId: userId });

            try {
                const response = await fetch(`${SERVER_URL}/api/messages/${ADMIN_ID}/${userId}`);
                const messages = await response.json();
                
                messages.forEach(msg => {
                    const sender = (msg.sender.id === ADMIN_ID) ? 'me' : 'user';
                    displayMessage(msg.content, sender, msg.createdAt);
                });
            } catch (error) {
                console.error('Gagal memuat percakapan:', error);
            }
        }

        function sendMessage() {
            const content = input.value.trim();
            if (content && currentChatUserId) {
                socket.emit('replyToUser', { userId: currentChatUserId, messageContent: content });
                input.value = '';
            } else {
                console.warn('Pilih user terlebih dahulu untuk membalas pesan.');
            }
        }

        // --- EVENT LISTENER ---
        socket.on('connect', () => {
            console.log('Admin terhubung ke server!');
            socket.emit('register', { id: ADMIN_ID, role: 'admin' });
            loadAllConversations();
        });

        socket.on('newMessageFromUser', (message) => {
            console.log('Pesan baru dari user:', message);
            if (message.sender.id === currentChatUserId) {
                displayMessage(message.content, 'user', message.createdAt);
            } else {
                // --- BARU: Update badge secara real-time tanpa reload semua ---
                const userItem = document.querySelector(`#user-list li[data-user-id="${message.sender.id}"]`);
                if (userItem) {
                    let badge = userItem.querySelector('.badge');
                    if (badge) {
                        badge.textContent = parseInt(badge.textContent) + 1;
                    } else {
                        badge = document.createElement('span');
                        badge.classList.add('badge', 'bg-danger', 'ms-auto');
                        badge.textContent = 1;
                        userItem.appendChild(badge);
                    }
                } else {
                    // Jika user benar-benar baru, reload semua
                    loadAllConversations();
                }
            }
        });

        socket.on('newMessageFromAdmin', (message) => {
            if (message.receiver.id === currentChatUserId) {
                displayMessage(message.content, 'me', message.createdAt);
            }
        });

        // --- BARU: Listener untuk sinkronisasi 'mark as read' antar tab admin ---
        socket.on('messagesRead', (data) => {
            const { userId } = data;
            const userItem = document.querySelector(`#user-list li[data-user-id="${userId}"]`);
            if (userItem && !userItem.classList.contains('active')) { // Hapus jika bukan item yang sedang aktif
                const badge = userItem.querySelector('.badge');
                if (badge) {
                    badge.remove();
                }
            }
        });

        sendButton.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

</script>
@endsection