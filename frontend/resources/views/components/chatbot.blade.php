    <style>
    /* Style explicitly for the Chatbot Widget */
    #chat-widget {
        position: fixed !important;
        bottom: 90px !important;
        right: 24px !important;
        width: 384px !important;
        height: 520px !important;
        background-color: #ffffff !important;
        border-radius: 16px !important;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
        transition: all 0.35s ease !important;
        transform: translateY(16px) !important;
        opacity: 0 !important;
        pointer-events: none !important;
        z-index: 99999 !important;
        border: 1px solid #f3f4f6 !important;
    }

    #chat-widget.active {
        opacity: 1 !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    /* Style for chatbot widget header */
    #chat-widget > div:first-child {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
    }

    /* Standard utility classes for chatbot widget in case of Tailwind purging */
    .bg-pdam-blue {
        background-color: #1e3a8a !important;
    }
    .text-pdam-blue {
        color: #1e3a8a !important;
    }
    .bg-pdam-bluelight {
        background-color: #3b82f6 !important;
    }
    .text-pdam-bluelight {
        color: #3b82f6 !important;
    }
    .bg-slate-50 {
        background-color: #f8fafc !important;
    }
    .bg-slate-100 {
        background-color: #f1f5f9 !important;
    }
    .bg-slate-300 {
        background-color: #cbd5e1 !important;
    }
    .text-slate-700 {
        color: #334155 !important;
    }
    .text-slate-800 {
        color: #1e293b !important;
    }
    .text-slate-400 {
        color: #94a3b8 !important;
    }
    .border-gray-100 {
        border-color: #f3f4f6 !important;
    }
    .border-slate-200 {
        border-color: #e2e8f0 !important;
    }
    .hover\:bg-slate-100:hover {
        background-color: #f1f5f9 !important;
    }

    /* Normal states for dashboard button icons */
    #chat-dashboard .bg-blue-50 i {
        color: #1e3a8a !important;
    }
    #chat-dashboard .bg-red-50 i {
        color: #ef4444 !important;
    }
    #chat-dashboard .bg-green-50 i {
        color: #16a34a !important;
    }
    #chat-dashboard .bg-purple-50 i {
        color: #9333ea !important;
    }

    /* Hover and focus states for dashboard buttons to prevent disappearing icons */
    #chat-dashboard button:hover .bg-blue-50,
    #chat-dashboard button:focus .bg-blue-50 {
        background-color: #1e3a8a !important;
    }
    #chat-dashboard button:hover .bg-blue-50 i,
    #chat-dashboard button:focus .bg-blue-50 i {
        color: #ffffff !important;
    }

    #chat-dashboard button:hover .bg-red-50,
    #chat-dashboard button:focus .bg-red-50 {
        background-color: #ef4444 !important;
    }
    #chat-dashboard button:hover .bg-red-50 i,
    #chat-dashboard button:focus .bg-red-50 i {
        color: #ffffff !important;
    }

    #chat-dashboard button:hover .bg-green-50,
    #chat-dashboard button:focus .bg-green-50 {
        background-color: #16a34a !important;
    }
    #chat-dashboard button:hover .bg-green-50 i,
    #chat-dashboard button:focus .bg-green-50 i {
        color: #ffffff !important;
    }

    #chat-dashboard button:hover .bg-purple-50,
    #chat-dashboard button:focus .bg-purple-50 {
        background-color: #9333ea !important;
    }
    #chat-dashboard button:hover .bg-purple-50 i,
    #chat-dashboard button:focus .bg-purple-50 i {
        color: #ffffff !important;
    }

    #chat-dashboard button:hover i.fa-chevron-right {
        color: #1e3a8a !important;
    }

    /* Chatbot Input Area Styles */
    #chat-input-area {
        padding: 12px 16px 16px 16px !important;
        background-color: #ffffff !important;
        border-top: 1px solid #f1f5f9 !important;
    }

    #chat-form {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        gap: 8px !important;
    }

    #message-input {
        flex: 1 !important;
        min-width: 0 !important;
        width: 100% !important;
        height: 38px !important;
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 9999px !important;
        padding: 0 16px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
    }

    #message-input:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    }

    #chat-form button {
        width: 38px !important;
        height: 38px !important;
        border-radius: 50% !important;
        background-color: #1e3a8a !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: none !important;
        cursor: pointer !important;
        transition: background-color 0.2s ease !important;
        flex-shrink: 0 !important;
        position: static !important; /* Prevent absolute positioning override */
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: 0 2px 8px rgba(30, 58, 138, 0.25) !important;
    }

    #chat-form button:hover {
        background-color: #3b82f6 !important;
    }

    #chat-form button:disabled {
        background-color: #cbd5e1 !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
        box-shadow: none !important;
    }

    /* Scrollbar for chat messages area */
    .chat-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .chat-scroll::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .chat-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 4px;
    }
    .chat-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
    
    /* Typing indicator styling */
    .typing-indicator span {
        display: inline-block;
        width: 6px;
        height: 6px;
        background-color: #3b82f6;
        border-radius: 50%;
        margin: 0 1px;
        animation: bounce 1.4s infinite ease-in-out both;
    }
    .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
    .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
    </style>

    <!-- Floating Action Button -->
    <!-- Floating Action Button -->
<div style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
    <!-- Main FAB Button (blue theme) -->
    <button id="fabButton" aria-label="Tanya Asisten Virtual"
            style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; position: relative;">
        <i class="fas fa-headset" id="fab-icon" style="color: white; font-size: 18px;"></i>
        
        <!-- Tooltip -->
        <div id="fabTooltip" 
             style="position: absolute; right: 60px; top: 50%; transform: translateY(-50%); background: rgba(0, 0, 0, 0.8); color: white; padding: 8px 12px; border-radius: 6px; font-size: 12px; white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease; pointer-events: none; z-index: 10001;">
            Tanya Asisten Virtual
            <!-- Tooltip arrow -->
            <div style="position: absolute; left: 100%; top: 50%; transform: translateY(-50%); width: 0; height: 0; border: 5px solid transparent; border-left-color: rgba(0, 0, 0, 0.8);"></div>
        </div>
    </button>
</div>

<!-- Popup Modal -->
<div id="chat-widget" class="fixed bottom-24 right-6 w-96 h-[520px] bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.15)] flex flex-col overflow-hidden transition-all duration-350 transform translate-y-4 opacity-0 pointer-events-none z-50 border border-gray-100">
        
        <!-- Widget Header -->
        <div class="bg-gradient-to-r from-pdam-blue to-pdam-bluelight px-4 py-3.5 text-white flex items-center justify-between shadow-md">
            <div class="flex items-center space-x-3">
                <!-- Tombol Kembali, disembunyikan di dashboard -->
                <button id="btn-back-to-menu" onclick="showDashboard()" class="hidden w-7 h-7 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors text-white focus:outline-none mr-0.5">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <div class="w-9 h-9 bg-white text-pdam-blue rounded-full flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                    P
                </div>
                <div>
                    <h3 class="font-extrabold text-sm tracking-tight leading-tight">Asisten Virtual PDAM</h3>
                    <p class="text-[10px] text-blue-100 font-semibold flex items-center">
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5 animate-pulse"></span> Online
                    </p>
                </div>
            </div>
            <button onclick="toggleChatWidget()" class="w-7 h-7 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors text-white focus:outline-none">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Menu / Dashboard Area -->
        <div id="chat-dashboard" class="flex-1 p-5 overflow-y-auto bg-slate-50 flex flex-col justify-between chat-scroll">
            <div class="space-y-4">
                <!-- Welcome text -->
                <div class="text-center py-2">
                    <h4 class="font-extrabold text-slate-800 text-sm">Selamat Datang di PDAM Purbalingga</h4>
                    <p class="text-slate-500 text-[11px] mt-1">Silakan pilih layanan yang Anda butuhkan di bawah ini:</p>
                </div>
                
                <!-- Quick Action Buttons -->
                <div class="space-y-2.5">
                    <button onclick="selectDashboardMenu('cek_tagihan')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-pdam-blue flex items-center justify-center group-hover:bg-pdam-blue group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Cek Tagihan Air</p>
                            <p class="text-[10px] text-slate-400 truncate">Lihat tunggakan tagihan rekening air Anda</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                    
                    <button onclick="selectDashboardMenu('lapor_keluhan')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-bullhorn text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Laporkan Keluhan Layanan</p>
                            <p class="text-[10px] text-slate-400 truncate">Adukan kendala air mati, pipa bocor, dll</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                    
                    <button onclick="selectDashboardMenu('cek_status')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Cek Status Laporan</p>
                            <p class="text-[10px] text-slate-400 truncate">Pantau perkembangan tindak lanjut keluhan Anda</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                    
                    <button onclick="selectDashboardMenu('chat_bebas')" class="w-full text-left bg-white hover:bg-slate-100 border border-slate-200 hover:border-pdam-blue text-slate-700 p-3 rounded-xl transition-all duration-200 flex items-center space-x-3 shadow-sm group focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fa-solid fa-comments text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800">Tanya Asisten PDAM</p>
                            <p class="text-[10px] text-slate-400 truncate">Mengobrol langsung dengan AI Agent kami</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-350 group-hover:text-pdam-blue transition-colors shrink-0"></i>
                    </button>
                </div>
            </div>
            <!-- Footer brand / small note inside widget -->
            <div class="text-center pt-3 border-t border-slate-150 shrink-0">
                <span class="text-[9px] text-slate-400 font-medium">Perumda Air Minum Tirta Perwira</span>
            </div>
        </div>
        
        <!-- Message Area -->
        <div id="chat-messages" class="hidden flex-1 p-4 overflow-y-auto bg-slate-50 space-y-4 chat-scroll">
            <!-- Bot Initial Message -->
            <div class="flex">
                <div class="bg-white border border-gray-150 text-slate-700 rounded-2xl rounded-tl-none py-2.5 px-4 max-w-[85%] shadow-sm text-xs leading-relaxed">
                    👋 Halo! Saya adalah Asisten Virtual PDAM Purbalingga.
                    <br><br>
                    Ada yang bisa saya bantu?
                    <br>
                    • Ketik *nomor pelanggan* untuk cek tagihan rekening air.
                    <br>
                    • Ketik *"cara bayar"* untuk petunjuk pembayaran.
                    <br>
                    • Ketik *"lapor keluhan"* jika ingin membuat laporan keluhan layanan PDAM.
                </div>
            </div>
        </div>
        
        <!-- Typing Indicator -->
        <div id="typing-indicator" class="hidden px-4 py-2 bg-slate-50">
            <div class="flex">
                <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-none py-2 px-3 shadow-sm">
                    <div class="typing-indicator">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Input Area -->
        <div id="chat-input-area" class="hidden p-3.5 bg-white border-t border-gray-100">
            <form id="chat-form" class="flex items-center space-x-2">
                <input 
                    type="text" 
                    id="message-input" 
                    class="flex-1 border border-gray-200 bg-slate-50 rounded-full px-4 py-2.5 text-xs focus:outline-none focus:bg-white focus:ring-2 focus:ring-pdam-blue focus:border-transparent transition-all" 
                    placeholder="Ketik pesan di sini..." 
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    class="bg-pdam-blue hover:bg-pdam-bluelight text-white rounded-full w-9 h-9 flex items-center justify-center transition-colors shadow-md shrink-0 focus:outline-none"
                >
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
        
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatWidget = document.getElementById('chat-widget');
        const chatFab = document.getElementById('fabButton');
        const fabIcon = document.getElementById('fab-icon');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');

        // Elemen UI Baru untuk Dashboard & Navigasi
        const chatDashboard = document.getElementById('chat-dashboard');
        const chatInputArea = document.getElementById('chat-input-area');
        const btnBackToMenu = document.getElementById('btn-back-to-menu');

        // URL API ke FastAPI Python Backend
        // Nilai diambil dari env variable CHATBOT_API_URL di file .env Laravel
        const API_URL = '{{ env("CHATBOT_API_URL", "http://localhost:8001") }}/api/chat';
        const COMPLAINT_API_URL = '{{ env("CHATBOT_API_URL", "http://localhost:8001") }}/api/complaints';
        const STATUS_API_URL = '{{ env("CHATBOT_API_URL", "http://localhost:8001") }}/api/complaints/status';

        let isOpen = false;
        let isSending = false;
        
        // State Machine untuk Pelaporan Keluhan Lokal
        let reportState = 'NORMAL'; // NORMAL, WAITING_NAME, WAITING_ADDRESS, WAITING_PHONE, WAITING_COMPLAINT, WAITING_TICKET_STATUS, WAITING_BILL_CHECK
        let reportData = {
            nama: '',
            alamat: '',
            hp: '',
            keluhan: ''
        };

        // Menampilkan Menu Utama (Dashboard)
        function showDashboard() {
            chatDashboard.classList.remove('hidden');
            chatMessages.classList.add('hidden');
            chatInputArea.classList.add('hidden');
            btnBackToMenu.classList.add('hidden');
            
            messageInput.value = '';
            reportState = 'NORMAL';
            enableChatInput();
        }

        // Menampilkan Area Percakapan Aktif
        function showChatArea(initialGreeting) {
            chatDashboard.classList.add('hidden');
            chatMessages.classList.remove('hidden');
            chatInputArea.classList.remove('hidden');
            btnBackToMenu.classList.remove('hidden');
            
            chatMessages.innerHTML = '';
            enableChatInput();
            
            if (initialGreeting) {
                appendMessage(initialGreeting, false);
            }
            
            setTimeout(() => messageInput.focus(), 100);
        }

        // Pemicu Klik Menu Dashboard
        function selectDashboardMenu(menuType) {
            if (menuType === 'cek_tagihan') {
                showChatArea("💳 **Cek Tagihan Air**\n\nSilakan masukkan **Nomor Pelanggan** Anda (8 digit) untuk mengecek tagihan rekening air:\n\nKetik **\"batal\"** untuk kembali ke menu utama.");
                reportState = 'WAITING_BILL_CHECK';
            } else if (menuType === 'lapor_keluhan') {
                showChatArea();
                startLocalLaporFlow();
            } else if (menuType === 'cek_status') {
                showChatArea("🔍 **Cek Status Laporan Keluhan**\n\nSilakan masukkan **Nomor Tiket Laporan** Anda (contoh: 19122021-1):\n Pastikan penulisan nomor tiket benar.\n\nKetik **\"batal\"** untuk kembali ke menu utama.");
                reportState = 'WAITING_TICKET_STATUS';
            } else if (menuType === 'chat_bebas') {
                showChatArea("💬 **Tanya Asisten Virtual**\n\nHalo! Saya adalah Asisten Virtual PDAM Purbalingga. Ada yang bisa saya bantu terkait layanan air atau tagihan? Silakan tanyakan di bawah ini.");
            }
        }

        // Toggle Chat Widget (Buka / Tutup)
        function toggleChatWidget() {
            isOpen = !isOpen;
            if (isOpen) {
                // Tampilkan Widget
                chatWidget.classList.add('active');
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                
                // Ganti Icon FAB menjadi Silang
                fabIcon.className = 'fas fa-times text-[18px]';
                
                // Selalu buka menu utama dashboard saat pertama dibuka
                showDashboard();
            } else {
                // Sembunyikan Widget
                chatWidget.classList.remove('active');
                chatWidget.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                chatWidget.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                
                // Ganti Icon FAB kembali ke Comments
                fabIcon.className = 'fas fa-headset text-[18px]';
            }
        }

        // Buka chat dan isi input dengan query tertentu
        function openChatWithQuery(query) {
            if (!isOpen) {
                isOpen = true;
                chatWidget.classList.add('active');
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                fabIcon.className = 'fas fa-times text-[18px]';
            }
            
            if (query === 'cek tagihan') {
                selectDashboardMenu('cek_tagihan');
            } else {
                showChatArea("💬 **Tanya Asisten Virtual (Chat Bebas)**");
                messageInput.value = query;
                messageInput.focus();
            }
        }

        function disableChatInput() {
            messageInput.disabled = true;
            messageInput.placeholder = "Silakan isi formulir keluhan di atas...";
            messageInput.classList.remove('bg-slate-50', 'focus:bg-white', 'focus:ring-2', 'focus:ring-pdam-blue');
            messageInput.classList.add('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
            
            const submitBtn = chatForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-pdam-blue', 'hover:bg-pdam-bluelight');
                submitBtn.classList.add('bg-slate-300', 'cursor-not-allowed', 'opacity-60');
            }
        }

        function disableChatInputLoading() {
            messageInput.disabled = true;
            messageInput.placeholder = "Asisten sedang mengetik...";
            messageInput.classList.remove('bg-slate-50', 'focus:bg-white', 'focus:ring-2', 'focus:ring-pdam-blue');
            messageInput.classList.add('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
            
            const submitBtn = chatForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-pdam-blue', 'hover:bg-pdam-bluelight');
                submitBtn.classList.add('bg-slate-300', 'cursor-not-allowed', 'opacity-60');
            }
        }

        // Hubungkan kembali form submissions
        function enableChatInput() {
            messageInput.disabled = false;
            messageInput.placeholder = "Ketik pesan di sini...";
            messageInput.classList.remove('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
            messageInput.classList.add('bg-slate-50', 'focus:bg-white');
            
            const submitBtn = chatForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-slate-300', 'cursor-not-allowed', 'opacity-60');
                submitBtn.classList.add('bg-pdam-blue', 'hover:bg-pdam-bluelight');
            }
        }

        // Mulai alur keluhan lokal dengan menampilkan formulir langsung
        function startLocalLaporFlow() {
            reportState = 'NORMAL';
            disableChatInput();
            
            const formId = 'lapor-form-' + Date.now();
            const formHtml = `
                <div class="p-1.5 text-slate-700 bg-white">
                    <h4 class="font-bold text-xs mb-1.5 text-pdam-blue flex items-center gap-1.5">
                        <i class="fa-solid fa-file-invoice"></i> Formulir Pengaduan Keluhan
                    </h4>
                    <p class="text-[10px] text-gray-500 mb-2.5 leading-snug">Silakan isi formulir resmi berikut untuk mengirimkan pengaduan ke database PDAM Purbalingga.</p>
                    <form id="${formId}" class="space-y-2" onsubmit="handleFormLaporSubmit(event, '${formId}')">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Nama Lengkap</label>
                            <input type="text" name="nama" required class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue" placeholder="Contoh: Budi Susanto">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Alamat Lengkap</label>
                            <input type="text" name="alamat" required class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue" placeholder="Contoh: RT 02/RW 04, Purbalingga Kidul">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Nomor HP / WhatsApp</label>
                            <input type="text" name="hp" required class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue" placeholder="Contoh: 08123456789">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Detail Keluhan</label>
                            <textarea name="keluhan" required rows="3" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-pdam-blue resize-none" placeholder="Contoh: Air mati sejak kemarin sore..."></textarea>
                        </div>
                        <div class="pt-1 flex gap-2">
                            <button type="submit" class="flex-1 bg-pdam-blue hover:bg-blue-600 text-white font-bold py-1.5 px-3 rounded-lg text-xs transition-colors flex items-center justify-center gap-1">
                                <i class="fa-solid fa-paper-plane"></i> Kirim Laporan
                            </button>
                            <button type="button" onclick="cancelFormLapor(this)" class="bg-gray-100 hover:bg-gray-200 text-gray-500 font-semibold py-1.5 px-3 rounded-lg text-xs transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            `;
            
            appendRawHtmlMessage(formHtml);
        }

        function appendRawHtmlMessage(html) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-start';
            
            const innerDiv = document.createElement('div');
            innerDiv.className = 'bg-white border border-gray-200 text-slate-700 rounded-2xl rounded-tl-none py-3 px-4 w-[90%] shadow-sm text-xs leading-relaxed';
            innerDiv.innerHTML = html;
            
            messageDiv.appendChild(innerDiv);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function cancelFormLapor(btn) {
            const container = btn.closest('form').parentNode;
            container.innerHTML = `
                <div class="text-slate-400 italic text-xs py-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-xmark"></i> Pengisian formulir laporan dibatalkan.
                </div>
            `;
            enableChatInput();
        }

        async function handleFormLaporSubmit(event, formId) {
            event.preventDefault();
            const form = document.getElementById(formId);
            const submitBtn = form.querySelector('button[type="submit"]');
            const cancelBtn = form.querySelector('button[type="button"]');
            
            // Ubah button state jadi loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
            if (cancelBtn) cancelBtn.style.display = 'none';
            
            const formData = new FormData(form);
            const payload = {
                "ComplianerName": formData.get('nama'),
                "ComplianerAddress": formData.get('alamat'),
                "PhoneNumber": formData.get('hp'),
                "CompliantContent": formData.get('keluhan'),
                "InputedBy": "web_chatbot"
            };
            
            showTyping();
            
            try {
                const response = await fetch(COMPLAINT_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                
                hideTyping();
                
                if (response.ok) {
                    const resData = await response.json();
                    const ticketNum = resData.ticket_number;
                    form.parentNode.innerHTML = `
                        <div class="text-center py-2 text-slate-700">
                            <div class="text-emerald-500 text-2xl mb-1"><i class="fa-solid fa-circle-check"></i></div>
                            <h5 class="font-bold text-xs text-emerald-600 mb-1">Laporan Keluhan Terkirim!</h5>
                            <p class="text-[10px] text-gray-500 mb-2 leading-relaxed">Keluhan Anda telah dicatat oleh sistem dengan nomor tiket:</p>
                            <div class="inline-block bg-emerald-50 text-emerald-700 font-bold px-3 py-1.5 rounded-lg border border-emerald-200 text-xs tracking-wider select-all mb-1">
                                ${ticketNum}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 leading-snug">Simpan nomor tiket ini untuk melacak status penanganan keluhan Anda. Terima kasih! 🙏</p>
                        </div>
                    `;
                    enableChatInput();
                } else {
                    throw new Error("Gagal menyimpan ke server");
                }
            } catch (error) {
                console.error("Error submitting complaint:", error);
                hideTyping();
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Laporan';
                if (cancelBtn) cancelBtn.style.display = 'inline-block';
                alert("Gagal mengirim laporan keluhan. Silakan cek koneksi server backend Anda.");
            }
        }

        // Jalankan alur keluhan otomatis jika user menekan tombol pengaduan
        function openLaporFlow() {
            if (!isOpen) {
                isOpen = true;
                chatWidget.classList.add('active');
                chatWidget.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                chatWidget.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                fabIcon.className = 'fas fa-times text-[18px]';
            }
            showChatArea();
            startLocalLaporFlow();
        }

        // Tambahkan pesan ke UI
        function appendMessage(text, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isUser ? 'justify-end' : ''}`;
            
            const innerDiv = document.createElement('div');
            innerDiv.className = isUser 
                ? 'bg-pdam-blue text-white rounded-2xl rounded-tr-none py-2.5 px-4 max-w-[85%] shadow-sm text-xs leading-relaxed'
                : 'bg-white border border-gray-150 text-slate-700 rounded-2xl rounded-tl-none py-2.5 px-4 max-w-[85%] shadow-sm text-xs leading-relaxed';
            
            // Konversi format Markdown tebal (*) atau (**) ke <b>
            let formattedText = text
                .replace(/\*\*(.*?)\*\*/g, '<b>$1</b>')
                .replace(/\*(.*?)\*/g, '<b>$1</b>')
                .replace(/\n/g, '<br>');
                
            // Konversi [text](url) ke <a href="url">
            formattedText = formattedText.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" class="text-pdam-blue hover:underline font-bold">$1</a>');
            
            innerDiv.innerHTML = formattedText;
            messageDiv.appendChild(innerDiv);
            chatMessages.appendChild(messageDiv);
            
            // Auto scroll ke bawah
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTyping() {
            typingIndicator.classList.remove('hidden');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTyping() {
            typingIndicator.classList.add('hidden');
        }

        // Handle Pengiriman Pesan Form
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (isSending || messageInput.disabled) return;
            const message = messageInput.value.trim();
            if (!message) return;

            isSending = true;
            disableChatInputLoading();

            // 1. Tampilkan pesan user di widget
            appendMessage(message, true);
            messageInput.value = '';
            
            // Cek jika user membatalkan alur pengaduan
            if (reportState !== 'NORMAL' && message.toLowerCase() === 'batal') {
                showDashboard();
                appendMessage("❌ Alur saat ini telah dibatalkan. Kembali ke menu utama.", false);
                isSending = false;
                return;
            }

            let shouldReenable = true;

            try {
                // 2. State Machine Pengaduan (Lokal)
                if (reportState !== 'NORMAL') {
                    if (reportState === 'WAITING_TICKET_STATUS') {
                        const ticketNumber = message;
                        showTyping();
                        
                        try {
                            const response = await fetch(STATUS_API_URL, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ ticket_number: ticketNumber })
                            });
                            
                            hideTyping();
                            
                            if (response.ok) {
                                let data = await response.json();
                                
                                // Jika respons dibungkus dalam array, ambil objek pertama
                                if (Array.isArray(data) && data.length > 0) {
                                    data = data[0];
                                }
                                
                                const statusId = data.status_id;
                                let statusText = "Sedang Diproses ⏳";
                                if (statusId == 1) {
                                    statusText = "Dilaporkan 📝";
                                } else if (statusId == 2) {
                                    statusText = "Pengecekan 🔍";
                                } else if (statusId == 3) {
                                    statusText = "Pengerjaan 🛠️";
                                } else if (statusId == 4) {
                                    statusText = "Selesai / Teratasi ✅";
                                } else if (statusId === null || statusId === undefined || statusId === '') {
                                    statusText = "Tidak Ditemukan ❌";
                                }
                                const msgText = data.message || "Laporan Anda sedang berada dalam penanganan oleh tim teknis kami.";
                                
                                appendMessage(
                                    `🔍 **Hasil Pelacakan Laporan Keluhan**\n\n` +
                                    `• Nomor Laporan: **${ticketNumber}**\n` +
                                    `• Status: **${statusText}**\n\n` +
                                    `${msgText}\n\n` +
                                    `---\n` +
                                    `Silakan masukkan **Nomor Tiket Laporan** lainnya untuk mengecek kembali, atau ketik **"batal"** untuk kembali ke menu utama.`,
                                    false
                                );
                            } else {
                                throw new Error("Gagal mengambil data dari backend");
                            }
                        } catch (error) {
                            console.error("Error fetching status from backend:", error);
                            hideTyping();
                            appendMessage(
                                `⚠️ **Sistem Pelacakan Sedang Gangguan**\n\n` +
                                `Maaf, sistem pelacakan status keluhan saat ini sedang offline atau mengalami gangguan. Mohon mencoba kembali beberapa saat lagi.`,
                                false
                            );
                        }
                        return;
                    } else if (reportState === 'WAITING_BILL_CHECK') {
                        // Cek format angka
                        const cleanMsg = message.replace(/\s+/g, '');
                        const numMatch = cleanMsg.match(/\b\d{8,}\b/);
                        
                        if (!numMatch) {
                            appendMessage(
                                `⚠️ **Format Salah**\n\n` +
                                `Nomor pelanggan harus berupa angka minimal 8 digit.\n` +
                                `Silakan masukkan **Nomor Pelanggan** Anda kembali, atau ketik **"batal"** untuk kembali ke menu utama.`,
                                false
                            );
                            return;
                        }
                        
                        const noPelanggan = numMatch[0];
                        showTyping();
                        
                        try {
                            const response = await fetch(API_URL, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ message: "cek tagihan " + noPelanggan })
                            });

                            const data = await response.json();
                            hideTyping();
                            
                            if (data && data.reply) {
                                appendMessage(
                                    `${data.reply}\n\n` +
                                    `---\n` +
                                    `Silakan masukkan **Nomor Pelanggan** lainnya untuk mengecek kembali, atau ketik **"batal"** untuk kembali ke menu utama.`,
                                    false
                                );
                            } else {
                                appendMessage("Maaf, format respons dari server tidak dikenali.", false);
                            }
                        } catch (error) {
                            console.error("Error checking bill from backend:", error);
                            hideTyping();
                            appendMessage(
                                `⚠️ **Koneksi Bermasalah**\n\n` +
                                `Gagal menghubungkan ke database tagihan. Silakan cek koneksi backend Anda.`,
                                false
                            );
                        }
                        return;
                    }
                }

                // 3. Jalankan alur normal (Ollama AI) jika state NORMAL
                showTyping();

                try {
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message: message })
                    });

                    const data = await response.json();
                    hideTyping();
                    
                    if (data && data.reply) {
                        appendMessage(data.reply, false);
                        
                        if (data.intent === 'LAPOR_KELUHAN') {
                            shouldReenable = false; // transisi ke lapor flow, biarkan tetap disabled
                            showTyping();
                            setTimeout(() => {
                                hideTyping();
                                startLocalLaporFlow();
                            }, 1000);
                        }
                    } else {
                        appendMessage("Maaf, format respons dari server tidak dikenali.", false);
                    }

                } catch (error) {
                    console.error("Error connecting to backend:", error);
                    hideTyping();
                    appendMessage("Maaf, tidak dapat terhubung ke server asisten virtual. Pastikan API backend python pada port 8001 sudah menyala.", false);
                }
            } finally {
                if (shouldReenable) {
                    isSending = false;
                    enableChatInput();
                    messageInput.focus();
                } else {
                    isSending = false;
                }
            }
        });
    
        
        // Connect the FAB Button hover, click and tooltip behavior
        const fabButton = document.getElementById('fabButton');
        const fabTooltip = document.getElementById('fabTooltip');

        if (fabButton) {
            fabButton.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.boxShadow = '0 6px 20px rgba(59, 130, 246, 0.4)';
                if (fabTooltip) {
                    fabTooltip.style.opacity = '1';
                    fabTooltip.style.visibility = 'visible';
                }
            });

            fabButton.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 4px 15px rgba(59, 130, 246, 0.3)';
                if (fabTooltip) {
                    fabTooltip.style.opacity = '0';
                    fabTooltip.style.visibility = 'hidden';
                }
            });

            fabButton.addEventListener('click', function() {
                toggleChatWidget();
            });
        }

        // Connect the "Bantuan AI" button click
        const btnBantuanAi = document.getElementById('btn-bantuan-ai');
        if (btnBantuanAi) {
            btnBantuanAi.addEventListener('click', function(e) {
                e.preventDefault();
                toggleChatWidget();
            });
        }

        // Expose functions to global window scope for inline HTML event handlers (onclick, onsubmit)
        window.toggleChatWidget = toggleChatWidget;
        window.showDashboard = showDashboard;
        window.selectDashboardMenu = selectDashboardMenu;
        window.cancelFormLapor = cancelFormLapor;
        window.handleFormLaporSubmit = handleFormLaporSubmit;
    });
</script>
