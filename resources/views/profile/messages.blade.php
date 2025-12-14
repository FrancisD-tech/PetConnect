{{-- resources/views/messages.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Poppins', sans-serif; background:#f0f2f5; height:100vh; overflow:hidden; display:flex; }
        
        /* Sidebar - Chat List */
        .chat-list {
            width:100%; max-width:420px; background:white; display:flex; flex-direction:column;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .chat-list.hidden { transform:translateX(-100%); }

        .header {
            padding:16px; background:white; border-bottom:1px solid #ddd; display:flex; align-items:center; justify-content:space-between;
        }
        .header h1 { font-size:24px; font-weight:700; color:#1c1e21; }
        .search-bar {
            margin:12px 16px; background:#f0f2f5; border-radius:30px; padding:10px 16px; display:flex; align-items:center; gap:12px;
        }
        .search-bar input { border:none; background:none; outline:none; width:100%; font-size:15px; }

        .tabs {
            display:flex; padding:0 16px; margin-bottom:8px; overflow-x:auto; scrollbar-width:none;
        }
        .tab {
            padding:10px 20px; white-space:nowrap; font-weight:600; color:#65676b; position:relative;
        }
        .tab.active { color:#8B5CF6; }
        .tab.active::after { content:''; position:absolute; bottom:-8px; left:0; width:100%; height:3px; background:#8B5CF6; border-radius:2px; }

        .chat-item {
            display:flex; padding:12px 16px; cursor:pointer; align-items:center; gap:14px; transition:0.2s;
        }
        .chat-item:hover, .chat-item.active { background:#f5f6f8; }
        .avatar { width:60px; height:60px; border-radius:50%; object-fit:cover; }
        .chat-info { flex:1; min-width:0; }
        .chat-name { font-weight:600; font-size:15px; color:#1c1e21; }
        .chat-preview { font-size:13px; color:#65676b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .chat-time { font-size:12px; color:#65676b; }
        .unread { background:#E41E3F; color:white; min-width:20px; height:20px; border-radius:50%; font-size:11px; font-weight:bold; display:flex; align-items:center; justify-content:center; }

        /* Chat Area */
        .chat-area {
            flex:1; display:flex; flex-direction:column; background:#f0f2f5;
            transform:translateX(100%); transition:transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .chat-area.active { transform:translateX(0); }

        .chat-header {
            padding:16px; background:white; border-bottom:1px solid #ddd; display:flex; align-items:center; gap:14px; position:relative;
        }
        .back-btn { display:none; }
        .chat-header .avatar { width:40px; height:40px; border-radius:50%; }
        .chat-header h2 { font-weight:600; font-size:17px; color:#1c1e21; }
        .chat-header .status { font-size:13px; color:#65676b; }

        .messages {
            flex:1; padding:20px 16px; overflow-y:auto; display:flex; flex-direction:column; gap:12px;
        }
        .message {
            max-width:75%; padding:10px 16px; border-radius:18px; line-height:1.4; font-size:15px;
            word-wrap:break-word;
        }
        .message.sent {
            background:#8B5CF6; color:white; align-self:flex-end; border-bottom-right-radius:4px;
        }
        .message.received {
            background:#e4e6eb; color:#1c1e21; align-self:flex-start; border-bottom-left-radius:4px;
        }
        .message-time {
            font-size:11px; margin-top:4px; opacity:0.7; text-align:right;
        }

        .input-area {
            padding:12px 16px; background:white; display:flex; align-items:center; gap:12px;
        }
        .input-box {
            flex:1; padding:12px 20px; border-radius:30px; border:none; background:#f0f2f5; outline:none; font-size:15px;
        }
        .send-btn {
            width:44px; height:44px; background:#8B5CF6; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-size:20px; cursor:pointer; transition:0.2s;
        }
        .send-btn:hover { background:#7c4dff; }

        /* Mobile Optimizations */
        @media (max-width:768px) {
            .chat-list { position:fixed; top:0; left:0; height:100%; z-index:1000; }
            .chat-area { position:fixed; top:0; left:0; width:100%; height:100%; z-index:999; }
            .back-btn { display:block; }
            .chat-header .ml-auto { display:none; }
        }
    </style>
</head>
<body>

    <!-- Chat List Sidebar -->
    <div class="chat-list" id="chatList">
        <a href="homepage">
            <div class="header">
            <h1>Back</h1>
            <i class="fas fa-edit text-xl text-purple-600 cursor-pointer"></i>
        </div>
        </a>

        <div class="search-bar">
            <i class="fas fa-search text-gray-500"></i>
            <input type="text" placeholder="Search Messenger">
        </div>

        <div class="tabs">
            <div class="tab active">All</div>
            <div class="tab">Unread</div>
            <div class="tab">Communities</div>
        </div>

        <div class="chat-list-scroll">
            <div class="chat-item active" onclick="openChat('Maria Santos', 'https://randomuser.me/api/portraits/women/44.jpg')">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="avatar">
                <div class="chat-info">
                    <div class="chat-name">Maria Clara</div>
                    <div class="chat-preview">Hi! Is Bella still available?</div>
                </div>
                <div class="chat-time">2h</div>
                <div class="unread">3</div>
            </div>
            <div class="chat-item" onclick="openChat('John Reyes', 'https://randomuser.me/api/portraits/men/32.jpg')">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="avatar">
                <div class="chat-info">
                    <div class="chat-name">Frank Dave</div>
                    <div class="chat-preview">I think I saw your dog near the park</div>
                </div>
                <div class="chat-time">5h</div>
            </div>
            <div class="chat-item" onclick="openChat('PAWS Shelter', 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=100')">
                <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=100" class="avatar">
                <div class="chat-info">
                    <div class="chat-name">PAWS Shelter</div>
                    <div class="chat-preview">Your adoption application has been approved!</div>
                </div>
                <div class="chat-time">1d</div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="chat-area" id="chatArea">
        <div class="chat-header">
            <button class="back-btn" onclick="backToList()">
                <i class="fas fa-arrow-left text-2xl"></i>
            </button>
            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="avatar">
            <div>
                <h2>Maria Santos</h2>
                <div class="status">Active 2h ago</div>
            </div>
            <div class="ml-auto flex gap-6">
                <i class="fas fa-phone text-xl cursor-pointer text-gray-600"></i>
                <i class="fas fa-video text-xl cursor-pointer text-gray-600"></i>
                <i class="fas fa-info-circle text-xl cursor-pointer text-gray-600"></i>
            </div>
        </div>

        <div class="messages" id="messages">
            <div class="message received">
                Hi! I saw your post about Bella. She’s so cute! Is she still available for adoption?
                <div class="message-time">Thu 10:01 AM</div>
            </div>
            <div class="message sent">
                Atay
                <div class="message-time">11:43 AM</div>
            </div>
            <div class="message sent">
                Pangutana daw ni daniel
                <div class="message-time">11:43 AM</div>
            </div>
            <div class="message received">
                Gne
                <div class="message-time">11:44 AM</div>
            </div>
            <div class="message sent">
                Asa naman ka? Ali na mangadto nata
                <div class="message-time">11:45 AM</div>
            </div>
        </div>

        <div class="input-area">
            <i class="far fa-smile text-2xl text-gray-600 cursor-pointer"></i>
            <input type="text" class="input-box" placeholder="Aa">
            <i class="far fa-paperclip text-2xl text-gray-600 cursor-pointer"></i>
            <div class="send-btn">
                <i class="fas fa-paper-plane"></i>
            </div>
        </div>
    </div>

    <script>
        function openChat(name, avatar) {
            document.querySelector('.chat-header h2').textContent = name;
            document.querySelector('.chat-header .avatar').src = avatar;
            document.getElementById('chatArea').classList.add('active');
            document.getElementById('chatList').classList.add('hidden');
        }
        function backToList() {
            document.getElementById('chatArea').classList.remove('active');
            document.getElementById('chatList').classList.remove('hidden');
        }

        // Auto-scroll to bottom
        document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
    </script>
</body>
</html>