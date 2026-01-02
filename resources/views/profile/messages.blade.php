<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Messages • PetConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#8B5CF6',
                        'primary-dark': '#7C3AED',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f3f4f6; }
        .message-time { font-size: 0.75rem; opacity: 0.8; margin-top: 4px; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="h-full flex flex-col md:flex-row">

    <!-- Sidebar: Conversations List -->
    <div class="w-full md:w-96 bg-white border-r border-gray-200 flex flex-col h-screen">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <a href="/homepage" class="inline-flex items-center gap-2  text-black/80 hover:text-solid-black transition mb-8">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            </div>

            <!-- Search Bar -->
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                <input 
                    type="text" 
                    id="userSearch" 
                    placeholder="Search people..." 
                    class="w-full pl-12 pr-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition"
                >
                <div id="searchResults" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg mt-1 max-h-80 overflow-y-auto hidden z-10"></div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto scrollbar-hide" id="conversationList">
            @if($conversations->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-center px-8">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-envelope-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No messages yet</h3>
                    <p class="text-gray-500">Search for someone above to start a conversation!</p>
                </div>
            @else
                @foreach($conversations as $conv)
                <div 
                    class="p-4 hover:bg-gray-50 cursor-pointer transition border-b border-gray-100 last:border-0"
                    onclick="openChat({{ $conv['id'] }}, '{{ addslashes($conv['name']) }}', '{{ $conv['profile_photo_path'] ? asset('storage/' . $conv['profile_photo_path']) : '' }}')"
                >
                    <div class="flex items-center gap-4">
                        <!-- Real Profile Picture -->
                        <div class="relative w-14 h-14 rounded-full overflow-hidden shadow-md flex-shrink-0">
                            @if($conv['profile_photo_path'])
                                <img src="{{ asset('storage/' . $conv['profile_photo_path']) }}" alt="{{ $conv['name'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-primary flex items-center justify-center text-white text-xl font-bold">
                                    {{ strtoupper(substr($conv['name'], 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-900 truncate">{{ $conv['name'] }}</div>
                            <div class="text-sm text-gray-600 truncate">
                                {{ $conv['last_message'] ?? 'Start chatting...' }}
                            </div>
                        </div>
                        @if($conv['last_time'])
                        <div class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($conv['last_time'])->format('g:i A') }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col bg-gray-50 h-screen hidden md:flex" id="chatArea">
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center gap-4 shadow-sm">
            <button onclick="closeChat()" class="md:hidden text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <div class="w-12 h-12 rounded-full overflow-hidden shadow flex-shrink-0">
                <img src="" alt="" id="chatAvatarImg" class="w-full h-full object-cover hidden">
                <div id="chatAvatarFallback" class="w-full h-full bg-primary flex items-center justify-center text-white text-lg font-bold">
                    A
                </div>
            </div>
            <div>
                <h2 class="font-semibold text-gray-900" id="chatName">Select a conversation</h2>
                <p class="text-sm text-gray-500">Click on a chat to start messaging</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-6 scrollbar-hide" id="messages">
            <div class="flex items-center justify-center h-full text-gray-500">
                <div class="text-center">
                    <i class="fas fa-comments text-6xl mb-4 opacity-30"></i>
                    <p class="text-lg">No conversation selected</p>
                    <p class="text-sm mt-2">Choose someone from the list to begin</p>
                </div>
            </div>
        </div>

        <form id="messageForm" class="bg-white border-t border-gray-200 p-4 hidden">
            <div class="flex items-center gap-3 max-w-4xl mx-auto">
                <input 
                    type="text" 
                    id="messageInput" 
                    placeholder="Type a message..." 
                    class="flex-1 px-6 py-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition"
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    class="w-12 h-12 bg-primary hover:bg-primary-dark rounded-full flex items-center justify-center text-white shadow-lg transition"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>

    <script>
        let currentReceiverId = null;

        // Search users
        document.getElementById('userSearch').addEventListener('input', debounce(function() {
            const query = this.value.trim();
            const results = document.getElementById('searchResults');
            
            if (query.length < 2) {
                results.classList.add('hidden');
                results.innerHTML = '';
                return;
            }

            fetch(`/search-users?q=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(users => {
                    results.innerHTML = '';
                    if (users.length === 0) {
                        results.innerHTML = `<div class="p-4 text-center text-gray-500">No users found</div>`;
                    } else {
                        users.forEach(user => {
                            const item = document.createElement('div');
                            item.className = 'p-4 hover:bg-gray-50 cursor-pointer flex items-center gap-4 border-b border-gray-100 last:border-0';
                            item.innerHTML = `
                                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                                    ${user.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="font-medium">${user.name}</div>
                            `;
                            item.onclick = () => openChat(user.id, user.name);
                            results.appendChild(item);
                        });
                    }
                    results.classList.remove('hidden');
                });
        }, 300));

        function debounce(func, delay) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, arguments), delay);
            };
        }

        function openChat(userId, name, profilePicture = null) {
            currentReceiverId = userId;
            document.getElementById('chatName').textContent = name;

            const avatarImg = document.getElementById('chatAvatarImg');
            const avatarFallback = document.getElementById('chatAvatarFallback');

            if (profilePicture) {
                avatarImg.src = profilePicture;
                avatarImg.classList.remove('hidden');
                avatarFallback.classList.add('hidden');
            } else {
                avatarImg.classList.add('hidden');
                avatarFallback.classList.remove('hidden');
                avatarFallback.textContent = name.charAt(0).toUpperCase();
            }

            document.getElementById('chatArea').classList.remove('hidden', 'md:flex');
            document.getElementById('chatArea').classList.add('flex');
            document.querySelector('.w-full.md\\:w-96').classList.add('hidden', 'md:flex');
            document.getElementById('messageForm').classList.remove('hidden');
            document.getElementById('searchResults').classList.add('hidden');
            document.getElementById('userSearch').value = '';
            loadMessages(userId);
        }

        function closeChat() {
            document.getElementById('chatArea').classList.add('hidden');
            document.getElementById('chatArea').classList.remove('flex');
            document.querySelector('.w-full.md\\:w-96').classList.remove('hidden');
            document.getElementById('messageForm').classList.add('hidden');
            currentReceiverId = null;
        }

        function loadMessages(userId) {
            fetch(`/messages/conversation/${userId}`)
                .then(r => r.json())
                .then(messages => {
                    const container = document.getElementById('messages');
                    container.innerHTML = '';
                    
                    if (messages.length === 0) {
                        container.innerHTML = `
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-comment-alt text-5xl mb-4 opacity-30"></i>
                                    <p class="text-lg font-medium">Start the conversation!</p>
                                    <p class="text-sm">Send a message below</p>
                                </div>
                            </div>
                        `;
                    } else {
                        messages.forEach(msg => {
                            const bubble = document.createElement('div');
                            bubble.className = `flex ${msg.sender_id == {{ auth()->id() }} ? 'justify-end' : 'justify-start'} mb-4`;
                            bubble.innerHTML = `
                                <div class="max-w-xs lg:max-w-md px-5 py-3 rounded-2xl shadow-sm ${
                                    msg.sender_id == {{ auth()->id() }} 
                                        ? 'bg-primary text-white rounded-br-sm' 
                                        : 'bg-white text-gray-800 rounded-bl-sm border border-gray-200'
                                }">
                                    <p class="break-words">${msg.message}</p>
                                    <div class="message-time text-right">
                                        ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    </div>
                                </div>
                            `;
                            container.appendChild(bubble);
                        });
                    }
                    container.scrollTop = container.scrollHeight;
                });
        }

        // Send message
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('messageInput');
            const text = input.value.trim();
            if (!text || !currentReceiverId) return;

            fetch('/messages/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    receiver_id: currentReceiverId,
                    message: text
                })
            }).then(() => {
                input.value = '';
                loadMessages(currentReceiverId);
            }).catch(err => console.error('Send error:', err));
        });

        // Close search on click outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#userSearch') && !e.target.closest('#searchResults')) {
                document.getElementById('searchResults').classList.add('hidden');
            }
        });

        // Mark messages as read
        fetch('/messages/mark-read/${userId}' , {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).catch(err => console.error('Mark read error:', err));

        // Auto-open chat if ?user=ID is in URL
        const urlParams = new URLSearchParams(window.location.search);
        const startUserId = urlParams.get('user');
        if (startUserId) {
            const userName = "Pet Owner"; // You can improve this later
            openChat(startUserId, userName);
        }
    </script>
</body>
</html>