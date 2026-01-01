<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan - KIP Kuliah Polinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: #f0f2f5; font-family: 'Segoe UI', sans-serif; height: 100vh;
        }
        
        .main-wrapper {
            margin-left: 250px; /* Sidebar width */
            padding: 20px;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Container Chat Besar */
        .chat-container {
            width: 100%;
            max-width: 800px;
            height: 85vh;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        /* Header */
        .chat-header {
            background: linear-gradient(135deg, #6f42c1, #4a148c);
            padding: 20px;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .header-icon {
            width: 50px; height: 50px; background: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            padding: 3px;
        }
        
        /* Body */
        .chat-body {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        /* Messages */
        .message {
            max-width: 70%;
            padding: 15px 20px;
            border-radius: 18px;
            font-size: 15px;
            line-height: 1.5;
            position: relative;
            word-wrap: break-word;
            animation: fadeIn 0.3s ease;
        }
        .message.bot {
            align-self: flex-start;
            background: white;
            color: #333;
            border: 1px solid #e9ecef;
            border-top-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .message.user {
            align-self: flex-end;
            background: #6f42c1;
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 10px rgba(111, 66, 193, 0.2);
        }
        
        /* Chips */
        .chat-chip {
            display: block; width: 100%; text-align: left; padding: 10px 15px; margin: 5px 0;
            background: white; border: 1px solid #6f42c1; color: #6f42c1;
            border-radius: 25px; cursor: pointer; font-size: 14px; transition: 0.2s;
            font-weight: 500;
        }
        .chat-chip:hover { background: #f3e5f5; padding-left: 20px; }
        .chat-chip i { margin-right: 8px; width: 20px; text-align: center; }

        .chat-chip-small {
            display: inline-block; padding: 6px 12px; margin-top: 8px;
            background: #e9ecef; border: none; color: #555;
            border-radius: 15px; cursor: pointer; font-size: 12px; font-weight: 600;
        }
        .chat-chip-small:hover { background: #dee2e6; }

        /* Footer */
        .chat-footer {
            padding: 20px;
            background: white;
            border-top: 1px solid #eee;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        #chat-input {
            flex: 1; padding: 15px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 30px;
            outline: none;
            font-size: 15px;
            transition: 0.2s;
            background: #f8f9fa;
        }
        #chat-input:focus { border-color: #6f42c1; background: white; box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1); }
        
        #chat-send-btn { 
            background: #6f42c1; color: white; border: none; 
            width: 50px; height: 50px; border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center; 
            transition: 0.2s; font-size: 18px;
        }
        #chat-send-btn:hover { background: #512da8; transform: scale(1.05); }

        .typing-indicator { 
            font-size: 13px; color: #888; 
            margin-left: 30px; margin-bottom: 10px; display: none; font-style: italic; 
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Mobile */
        @media (max-width: 768px) {
            .main-wrapper { margin-left: 0; padding: 0; height: 100vh; }
            .chat-container { width: 100%; height: 100%; max-width: none; border-radius: 0; padding-top: 60px; /* space for mobile navbar */ }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-wrapper">
        <div class="chat-container">
            
            <!-- Header -->
            <div class="chat-header">
                <div class="header-icon">
                    <img src="assets/logo-polinela.png" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">Asisten KIP Polinela</h4>
                    <small class="opacity-75"><i class="fas fa-circle text-success" style="font-size: 8px;"></i> Online • Siap Membantu 24 Jam</small>
                </div>
            </div>

            <!-- Body Chat -->
            <div class="chat-body" id="chat-body">
                <div class="message bot">
                    Hai! 👋 Selamat datang di <b>Pusat Bantuan KIP-Kuliah Polinela</b>.<br><br>
                    Saya adalah asisten virtual yang siap membantumu. Silakan pilih topik permasalahan di bawah ini:
                    <br><br>
                    <button class="chat-chip" onclick="sendChip('Informasi KIP-Kuliah')"><i class="fas fa-info-circle"></i> Informasi KIP-Kuliah</button>
                    <button class="chat-chip" onclick="sendChip('Syarat & Alur')"><i class="fas fa-file-alt"></i> Syarat & Alur Pendaftaran</button>
                    <button class="chat-chip" onclick="sendChip('Jadwal Seleksi')"><i class="fas fa-calendar-alt"></i> Jadwal Seleksi</button>
                    <button class="chat-chip" onclick="sendChip('Kendala Evaluasi')"><i class="fas fa-desktop"></i> Kendala Form Evaluasi</button>
                    <button class="chat-chip" onclick="sendChip('Pertanyaan Umum')"><i class="fas fa-question-circle"></i> Pertanyaan Umum (FAQ)</button>
                </div>
            </div>
            
            <div class="typing-indicator" id="typing-indicator">
                <i class="fas fa-circle-notch fa-spin"></i> Asisten sedang mengetik...
            </div>

            <!-- Footer Input -->
            <div class="chat-footer">
                <input type="text" id="chat-input" placeholder="Ketik pertanyaanmu disini..." autocomplete="off">
                <button id="chat-send-btn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
            
        </div>
    </div>

    <script>
        const chatBody = document.getElementById('chat-body');
        const chatInput = document.getElementById('chat-input');
        const typingIndicator = document.getElementById('typing-indicator');

        // Initial Focus
        chatInput.focus();

        // Handle Enter
        chatInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendMessage();
        });

        // Function Chip Button
        function sendChip(text) {
            // Hilangkan icon dari text saat dikirim ke chat bubble user (opsional, tapi biar rapi)
            // Tapi untuk input value, kita pakai raw text saja
            chatInput.value = text;
            sendMessage();
        }

        function sendMessage() {
            const msg = chatInput.value.trim();
            if (msg === '') return;

            // 1. Add User Message
            appendMessage(msg, 'user');
            chatInput.value = '';

            // 2. Show Loading
            typingIndicator.style.display = 'block';
            scrollToBottom();

            // 3. API Call
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
                appendMessage("Maaf, terjadi gangguan koneksi. Coba lagi nanti.", 'bot');
            });
        }

        function appendMessage(htmlText, sender) {
            const div = document.createElement('div');
            div.classList.add('message', sender);
            div.innerHTML = htmlText;
            chatBody.appendChild(div);
            scrollToBottom();
        }

        function scrollToBottom() {
            chatBody.scrollTo({
                top: chatBody.scrollHeight,
                behavior: 'smooth'
            });
        }
    </script>

</body>
</html>
