<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDAM Chatbot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .chat-container {
            height: calc(100vh - 180px);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }
        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #3b82f6;
            border-radius: 50%;
            margin: 0 2px;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="max-w-2xl mx-auto mt-10">
        <!-- Chat Box -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden flex flex-col h-[85vh]">
            
            <!-- Header -->
            <div class="bg-blue-600 p-4 text-white flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold text-xl">
                        P
                    </div>
                    <div>
                        <h1 class="font-semibold text-lg">Asisten PDAM</h1>
                        <p class="text-xs text-blue-200">🟢 Online | Cek Tagihan Air</p>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="chat-messages" class="chat-container p-4 overflow-y-auto flex-1 space-y-4 bg-gray-50">
                <!-- Welcome Message -->
                <div class="flex">
                    <div class="bg-white border border-gray-200 text-gray-800 rounded-2xl rounded-tl-none py-2 px-4 max-w-[80%] shadow-sm">
                        <p class="text-sm">Halo! Saya adalah Asisten Virtual PDAM. Silakan ketikkan <b>nomor pelanggan</b> Anda atau tanyakan jumlah tagihan Anda bulan ini.</p>
                    </div>
                </div>
            </div>

            <!-- Typing Indicator (Hidden by default) -->
            <div id="typing-indicator" class="hidden px-4 pb-2 bg-gray-50">
                <div class="flex">
                    <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-none py-2 px-4 shadow-sm">
                        <div class="typing-indicator">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form id="chat-form" class="flex space-x-2">
                    <input 
                        type="text" 
                        id="message-input" 
                        class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        placeholder="Ketik pesan di sini..." 
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center transition-colors shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');

        // Ganti URL ini dengan URL FastAPI Backend Anda saat production
        const API_URL = 'http://localhost:8001/api/chat';

        function appendMessage(text, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isUser ? 'justify-end' : ''}`;
            
            const innerDiv = document.createElement('div');
            innerDiv.className = isUser 
                ? 'bg-blue-600 text-white rounded-2xl rounded-tr-none py-2 px-4 max-w-[80%] shadow-sm'
                : 'bg-white border border-gray-200 text-gray-800 rounded-2xl rounded-tl-none py-2 px-4 max-w-[80%] shadow-sm';
            
            // Render text. Convert linebreaks to <br> if needed
            innerDiv.innerHTML = `<p class="text-sm whitespace-pre-wrap">${text}</p>`;
            
            messageDiv.appendChild(innerDiv);
            chatMessages.appendChild(messageDiv);
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTyping() {
            typingIndicator.classList.remove('hidden');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTyping() {
            typingIndicator.classList.add('hidden');
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (!message) return;

            // 1. Tambahkan pesan user ke UI
            appendMessage(message, true);
            messageInput.value = '';
            
            // 2. Tampilkan typing indicator
            showTyping();

            try {
                // 3. Kirim ke API Python Backend
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                
                // 4. Sembunyikan typing indicator & tampilkan balasan bot
                hideTyping();
                
                if (data && data.reply) {
                    appendMessage(data.reply, false);
                } else {
                    appendMessage("Maaf, format respons dari server tidak dikenali.", false);
                }

            } catch (error) {
                console.error("Error connecting to backend:", error);
                hideTyping();
                appendMessage("Maaf, tidak dapat terhubung ke server. Pastikan Backend Python sudah menyala.", false);
            }
        });
    </script>
</body>
</html>
