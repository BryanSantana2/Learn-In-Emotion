<?php
session_start();

// Lógica de Sessão para Navbar
$logado = isset($_SESSION['id_aluno']);
$primeiro_nome = 'Visitante';
$matricula = '---';

if ($logado) {
    $nome_completo = $_SESSION['nome_aluno'];
    $primeiro_nome = explode(' ', $nome_completo)[0];
    $matricula = str_pad($_SESSION['id_aluno'], 6, '0', STR_PAD_LEFT);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda - Learn In Emotion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }
        
        /* Estilos do Menu Offcanvas */
        #offcanvas-menu { transition: transform 0.3s ease-in-out; transform: translateX(-100%); z-index: 50; }
        #offcanvas-menu.open { transform: translateX(0); }
        .overlay { transition: opacity 0.3s; opacity: 0; pointer-events: none; z-index: 40; }
        .overlay.open { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-gray-800">

    <!-- OVERLAY ESCURO -->
    <div id="menu-overlay" class="overlay fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- MENU LATERAL (OFFCANVAS) -->
    <div id="offcanvas-menu" class="fixed top-0 left-0 h-full w-72 bg-white shadow-2xl p-6 flex flex-col">
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-amber-500 tracking-wide">LIE</h2>
            <button id="close-menu" class="text-gray-400 hover:text-red-500 transition p-2 rounded-full hover:bg-red-50">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <nav class="space-y-2 text-lg flex-1">
            <a href="index.php" class="block p-3 rounded-lg hover:bg-amber-50 hover:text-amber-600 transition flex items-center gap-3">
                <i class="fas fa-home w-6 text-center"></i> Início
            </a>
            <a href="area_aluno.php" class="block p-3 rounded-lg hover:bg-amber-50 hover:text-amber-600 transition flex items-center gap-3">
                <i class="fas fa-user-graduate w-6 text-center"></i> Área do Aluno
            </a>
            <a href="cifras_tabs.php" class="block p-3 rounded-lg hover:bg-amber-50 hover:text-amber-600 transition flex items-center gap-3">
                <i class="fas fa-music w-6 text-center"></i> Cifras, Tabs & Parts
            </a>
            <a href="comunidade.php" class="block p-3 rounded-lg hover:bg-amber-50 hover:text-amber-600 transition flex items-center gap-3">
                <i class="fas fa-users w-6 text-center"></i> Comunidade
            </a>
            <a href="ajuda.php" class="block p-3 rounded-lg bg-amber-50 text-amber-600 font-semibold transition flex items-center gap-3">
                <i class="fas fa-question-circle w-6 text-center"></i> Ajuda
            </a>
        </nav>

        <div class="border-t border-gray-100 pt-6">
            <?php if($logado): ?>
                <a href="PHP/logout.php" class="block w-full text-center py-3 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 font-bold transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Sair
                </a>
            <?php else: ?>
                <a href="login.html" class="block w-full text-center py-3 rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-100 font-bold transition">
                    <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- NAVBAR SUPERIOR -->
    <nav class="bg-white shadow-sm sticky top-0 z-30 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <button id="open-menu" class="text-slate-500 hover:text-amber-500 transition text-2xl">
                <i class="fas fa-bars"></i>
            </button>
            <div class="flex items-center gap-2 text-amber-500">
                <i class="fas fa-music text-2xl"></i>
                <span class="font-bold text-xl tracking-tight hidden md:inline">Learn In Emotion</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <?php if($logado): ?>
                <span class="text-sm font-medium text-slate-500 hidden sm:inline">Matrícula: <?php echo $matricula; ?></span>
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold border border-amber-200">
                    <?php echo strtoupper(substr($primeiro_nome, 0, 1)); ?>
                </div>
            <?php else: ?>
                <a href="login.html" class="text-sm font-bold text-amber-600 hover:underline">Fazer Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL: CHATBOT -->
    <main class="flex-1 container mx-auto px-4 py-8 max-w-4xl flex flex-col h-[calc(100vh-80px)]">
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 flex-1 flex flex-col overflow-hidden">
            <!-- Header do Chat -->
            <div class="bg-amber-50 p-4 border-b border-amber-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white shadow-sm">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Assistente Harmonia</h3>
                    <p class="text-xs text-gray-500">Tire suas dúvidas sobre música ou a plataforma.</p>
                </div>
            </div>

            <!-- Janela de Mensagens -->
            <div id="chat-window" class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50">
                <div class="bg-white p-4 rounded-xl rounded-tl-none shadow-sm border border-gray-100 max-w-[80%]">
                    <p class="text-gray-700">Olá, <strong><?php echo $primeiro_nome; ?></strong>! 👋 Como posso te ajudar hoje?</p>
                    <ul class="list-disc pl-5 mt-2 text-sm text-gray-500 space-y-1">
                        <li>Como acessar minhas aulas?</li>
                        <li>O que é uma escala pentatônica?</li>
                        <li>Minha senha não funciona.</li>
                    </ul>
                </div>
            </div>

            <!-- Input -->
            <div class="p-4 bg-white border-t border-gray-100">
                <div class="flex gap-2">
                    <input type="text" id="user-input" class="flex-1 bg-gray-50 border border-gray-200 rounded-full px-6 py-3 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition" placeholder="Digite sua dúvida...">
                    <button id="send-btn" class="bg-amber-500 hover:bg-amber-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-md transition transform active:scale-95">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Menu Logic
        const openMenuBtn = document.getElementById('open-menu');
        const closeMenuBtn = document.getElementById('close-menu');
        const offcanvasMenu = document.getElementById('offcanvas-menu');
        const overlay = document.getElementById('menu-overlay');

        function toggleMenu() {
            offcanvasMenu.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        openMenuBtn.addEventListener('click', toggleMenu);
        closeMenuBtn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Chat Logic
        const chatWindow = document.getElementById('chat-window');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        function addMessage(text, isUser = false) {
            const div = document.createElement('div');
            div.className = isUser 
                ? "bg-amber-500 text-white p-4 rounded-xl rounded-tr-none shadow-md max-w-[80%] ml-auto"
                : "bg-white p-4 rounded-xl rounded-tl-none shadow-sm border border-gray-100 max-w-[80%]";
            div.textContent = text;
            chatWindow.appendChild(div);
            chatWindow.scrollTop = chatWindow.scrollHeight;
        }

        function handleSend() {
            const text = userInput.value.trim();
            if(!text) return;
            
            addMessage(text, true);
            userInput.value = '';

            setTimeout(() => {
                addMessage("Esta é uma resposta automática. Em breve nossa IA estará conectada!");
            }, 1000);
        }

        sendBtn.addEventListener('click', handleSend);
        userInput.addEventListener('keypress', (e) => {
            if(e.key === 'Enter') handleSend();
        });
    </script>
</body>
</html>