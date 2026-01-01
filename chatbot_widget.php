<!-- Chatbot Widget Code -->
<style>
    /* Chatbot Floating Button - Updated Style */
    #chat-trigger-btn {
        position: fixed; bottom: 30px; right: 30px; width: 65px; height: 65px; z-index: 9999;
        background: #6f42c1; /* Ungu Solid */
        color: white; border-radius: 50%;
        box-shadow: 0 5px 20px rgba(111, 66, 193, 0.4); 
        cursor: pointer; border: none; outline: none;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    #chat-trigger-btn:hover { 
        transform: scale(1.1); 
        box-shadow: 0 8px 25px rgba(111, 66, 193, 0.6);
    }

    /* Icon Chat */
    #chat-trigger-btn i {
        font-size: 32px; /* Ukuran icon disesuaikan */
        margin-top: 2px; /* Center optical adj */
    }

    /* Notification Dot (Merah dengan Border Putih tebal) */
    #chat-trigger-btn .notification-dot {
        position: absolute; top: 0; right: 0; 
        width: 18px; height: 18px;
        background: #ff3b30; border-radius: 50%; 
        border: 3px solid #fff; /* Border putih tebal sesuai gambar */
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Chat Window - CENTERED MODAL */
    #chat-window {
        position: fixed; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%) scale(0.95);
        width: 400px; 
        height: 550px;
        background: white; 
        border-radius: 20px; 
        box-shadow: 0 15px 50px rgba(0,0,0,0.25);
        z-index: 10000; 
        display: flex; 
        flex-direction: column; 
        overflow: hidden;
        opacity: 0; 
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    #chat-window.active { 
        opacity: 1; 
        transform: translate(-50%, -50%) scale(1); 
        pointer-events: all; 
    }
    
    /* Backdrop Overlay */
    #chat-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
    }
    #chat-overlay.active {
        opacity: 1;
        pointer-events: all;
    }

    /* Header */
    .chat-header {
        background: linear-gradient(135deg, #6f42c1, #4a148c); padding: 15px 20px;
        color: white; display: flex; align-items: center; justify-content: space-between;
    }
    .chat-header h4 { margin: 0; font-size: 16px; font-weight: 600; }
    .chat-header span { font-size: 11px; opacity: 0.8; display: block; }
    .btn-close-chat { background: none; border: none; color: white; font-size: 18px; cursor: pointer; opacity: 0.7; }
    .btn-close-chat:hover { opacity: 1; }

    /* Body */
    .chat-body { flex: 1; padding: 15px; overflow-y: auto; background: #f8f9fa; display: flex; flex-direction: column; gap: 10px; }
    .chat-body::-webkit-scrollbar { width: 5px; }
    .chat-body::-webkit-scrollbar-thumb { background: #ccc; border-radius: 5px; }

    /* Messages */
    .message { max-width: 80%; padding: 10px 14px; border-radius: 12px; font-size: 13px; line-height: 1.4; position: relative; word-wrap: break-word; }
    .message.bot { align-self: flex-start; background: white; color: #333; border: 1px solid #e9ecef; border-top-left-radius: 2px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .message.user { align-self: flex-end; background: #6f42c1; color: white; border-bottom-right-radius: 2px; box-shadow: 0 2px 5px rgba(111, 66, 193, 0.3); }
    
    .typing-indicator { font-size: 11px; color: #888; margin-left: 10px; display: none; font-style: italic; }

    /* Footer */
    .chat-footer { padding: 10px; background: white; border-top: 1px solid #eee; display: flex; gap: 5px; }
    #chat-input {
        flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none; font-size: 13px; transition: 0.2s;
    }
    #chat-input:focus { border-color: #6f42c1; }
    #chat-send-btn { 
        background: #6f42c1; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer;
        display: flex; align-items: center; justify-content: center; transition: 0.2s;
    }
    #chat-send-btn:hover { background: #512da8; transform: scale(1.05); }

    /* Chip Buttons */
    .chat-chip {
        display: block; width: 100%; text-align: left; padding: 8px 12px; margin: 4px 0;
        background: white; border: 1px solid #6f42c1; color: #6f42c1;
        border-radius: 20px; cursor: pointer; font-size: 13px; transition: 0.2s;
    }
    .chat-chip:hover { background: #f3e5f5; }
    
    .chat-chip-small {
        display: inline-block; padding: 5px 10px; margin-top: 5px;
        background: #eee; border: none; color: #555;
        border-radius: 15px; cursor: pointer; font-size: 11px;
    }
    .chat-chip-small:hover { background: #ddd; }

    /* Mobile Responsive */
    @media (max-width: 480px) {
        #chat-window { bottom: 0; right: 0; width: 100%; height: 100%; border-radius: 0; }
        #chat-trigger-btn { bottom: 20px; right: 20px; }
    }
</style>

<!-- Floating Button -->
<button id="chat-trigger-btn" onclick="toggleChat()">
    <i class="fas fa-comment-dots"></i>
    <div class="notification-dot" id="chat-notif"></div>
</button>

<!-- Backdrop Overlay -->
<div id="chat-overlay" onclick="toggleChat()"></div>

<!-- Chat Window -->
<div id="chat-window">
    <div class="chat-header">
        <div class="d-flex align-items-center" style="display: flex; align-items: center;">
            <div style="width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; overflow: hidden; padding: 2px;">
                <img src="assets/logo-polinela.png" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div>
                <h4>Asisten KIP</h4>
                <span>Online • Polinela</span>
            </div>
        </div>
        <button class="btn-close-chat" onclick="toggleChat()"><i class="fas fa-times"></i></button>
    </div>
    
    <div class="chat-body" id="chat-body">
        <div class="message bot">
            Halo! Saya Asisten Virtual Polinela.<br>Silakan pilih topik bantuan:<br><br>
            <button class="chat-chip" onclick="sendChip('Informasi KIP-Kuliah')"><i class="fas fa-info-circle"></i> Informasi KIP-Kuliah</button>
            <button class="chat-chip" onclick="sendChip('Syarat & Alur')"><i class="fas fa-file-alt"></i> Syarat & Alur</button>
            <button class="chat-chip" onclick="sendChip('Jadwal Seleksi')"><i class="fas fa-calendar-alt"></i> Jadwal Seleksi</button>
            <button class="chat-chip" onclick="sendChip('Kendala Evaluasi')"><i class="fas fa-desktop"></i> Kendala Evaluasi</button>
            <button class="chat-chip" onclick="sendChip('Pertanyaan Umum')"><i class="fas fa-question-circle"></i> Pertanyaan Umum</button>
        </div>
    </div>
    <div class="typing-indicator" id="typing-indicator">Bot sedang mengetik...</div>

    <div class="chat-footer">
        <input type="text" id="chat-input" placeholder="Tulis pesanmu..." onkeypress="handleEnter(event)">
        <button id="chat-send-btn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script>
    const chatWindow = document.getElementById('chat-window');
    const chatOverlay = document.getElementById('chat-overlay');
    const chatBody = document.getElementById('chat-body');
    const chatInput = document.getElementById('chat-input');
    const typingIndicator = document.getElementById('typing-indicator');

    function toggleChat() {
        chatWindow.classList.toggle('active');
        chatOverlay.classList.toggle('active');
        if(chatWindow.classList.contains('active')) {
            document.getElementById('chat-input').focus();
            document.getElementById('chat-notif').style.display = 'none';
        }
    }

    // Function untuk tombol chip
    function sendChip(text) {
        chatInput.value = text;
        sendMessage();
    }

    function handleEnter(e) {
        if (e.key === 'Enter') sendMessage();
    }

    function sendMessage() {
        const msg = chatInput.value.trim();
        if (msg === '') return;

        // Add User Message
        appendMessage(msg, 'user');
        chatInput.value = '';

        // Show Typing
        typingIndicator.style.display = 'block';
        chatBody.scrollTop = chatBody.scrollHeight;

        // Call API
        fetch('api_chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: msg })
        })
        .then(response => response.json())
        .then(data => {
            setTimeout(() => {
                typingIndicator.style.display = 'none';
                appendMessage(data.reply, 'bot');
            }, 600); 
        })
        .catch(error => {
            typingIndicator.style.display = 'none';
            appendMessage("Maaf, terjadi kesalahan koneksi.", 'bot');
        });
    }

    function appendMessage(text, sender) {
        const div = document.createElement('div');
        div.classList.add('message', sender);
        div.innerHTML = text; 
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }
</script>
