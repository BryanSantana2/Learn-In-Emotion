<?php
session_start();

// Lógica de Sessão para Navbar
$logado = isset($_SESSION['id_aluno']);
$primeiro_nome = 'Visitante';
$matricula = '---';
$nome_completo_js = 'Visitante'; // Variável para passar ao JS

if ($logado) {
    $nome_completo = $_SESSION['nome_aluno'];
    $nome_completo_js = $nome_completo;
    $primeiro_nome = explode(' ', $nome_completo)[0];
    $matricula = str_pad($_SESSION['id_aluno'], 6, '0', STR_PAD_LEFT);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidade - Learn In Emotion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'accent': '#F59E0B',
                        'accent-dark': '#D97706',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }
        
        #offcanvas-menu { transition: transform 0.3s ease-in-out; transform: translateX(-100%); z-index: 50; }
        #offcanvas-menu.open { transform: translateX(0); }
        .overlay { transition: opacity 0.3s; opacity: 0; pointer-events: none; z-index: 40; }
        .overlay.open { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body class="text-gray-800">

    <!-- OVERLAY & MENU -->
    <div id="menu-overlay" class="overlay fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

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
            <a href="comunidade.php" class="block p-3 rounded-lg bg-amber-50 text-amber-600 font-semibold transition flex items-center gap-3">
                <i class="fas fa-users w-6 text-center"></i> Comunidade
            </a>
            <a href="ajuda.php" class="block p-3 rounded-lg hover:bg-amber-50 hover:text-amber-600 transition flex items-center gap-3">
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

    <!-- CONTEÚDO COMUNIDADE -->
    <main class="container mx-auto px-4 py-8 max-w-5xl">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Comunidade Musical</h1>
            <p class="text-gray-500">Compartilhe sua evolução, tire dúvidas e conecte-se.</p>
        </header>

        <!-- Novo Post Box -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold border border-amber-200">
                    <?php echo $logado ? strtoupper(substr($primeiro_nome, 0, 1)) : '<i class="fas fa-user"></i>'; ?>
                </div>
                <div class="flex-1">
                    <textarea id="post-input" class="w-full bg-gray-50 rounded-lg p-3 border border-gray-200 focus:outline-none focus:border-accent resize-none transition" rows="3" placeholder="O que você está tocando hoje?"></textarea>
                    <div class="flex justify-between items-center mt-3">
                        <div class="flex gap-2 text-gray-400">
                            <button class="hover:text-accent p-2 rounded-full hover:bg-gray-100"><i class="fas fa-image"></i></button>
                            <button class="hover:text-accent p-2 rounded-full hover:bg-gray-100"><i class="fab fa-youtube"></i></button>
                        </div>
                        <button id="post-button" class="bg-accent hover:bg-accent-dark text-white font-bold py-2 px-6 rounded-full transition shadow-md">
                            Publicar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feed (Container identificado para o JS) -->
        <div class="space-y-6" id="feed-container">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-amber-200 transition">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">C</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Carlos Silva</h4>
                        <p class="text-xs text-gray-400">Há 2 horas • Violão</p>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">Finalmente consegui fazer a pestana de Fá Maior soar limpa! 🎉 A dica da aula 3 foi essencial.</p>
                <div class="flex items-center gap-6 text-gray-400 border-t border-gray-100 pt-3">
                    <button class="flex items-center gap-2 hover:text-red-500 transition"><i class="far fa-heart"></i> 24</button>
                    <button class="flex items-center gap-2 hover:text-blue-500 transition"><i class="far fa-comment"></i> 5</button>
                </div>
            </div>
        </div>
    </main>

    <script>
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

        // --- Lógica de Publicação de Post ---
        const postButton = document.getElementById('post-button');
        const postInput = document.getElementById('post-input');
        const feedContainer = document.getElementById('feed-container');

        // Dados do usuário logado vindos do PHP
        const userName = "<?php echo $nome_completo_js; ?>";
        const userInitial = "<?php echo $logado ? strtoupper(substr($primeiro_nome, 0, 1)) : 'V'; ?>";
        
        postButton.addEventListener('click', () => {
            const text = postInput.value.trim();
            
            if (!text) {
                alert("Por favor, escreva algo para publicar.");
                return;
            }

            // Cria o elemento do novo card
            const newCard = document.createElement('div');
            newCard.className = 'bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-amber-200 transition transform origin-top';
            
            // Estrutura HTML do card
            newCard.innerHTML = `
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold border border-amber-200">
                        ${userInitial}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">${userName}</h4>
                        <p class="text-xs text-gray-400">Agora mesmo • Geral</p>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">${text.replace(/\n/g, '<br>')}</p>
                <div class="flex items-center gap-6 text-gray-400 border-t border-gray-100 pt-3">
                    <button class="flex items-center gap-2 hover:text-red-500 transition" onclick="this.classList.toggle('text-red-500')">
                        <i class="far fa-heart"></i> <span class="text-xs">0</span>
                    </button>
                    <button class="flex items-center gap-2 hover:text-blue-500 transition">
                        <i class="far fa-comment"></i> <span class="text-xs">0</span>
                    </button>
                </div>
            `;

            // Adiciona ao topo do feed (prepend)
            feedContainer.prepend(newCard);

            // Limpa o input
            postInput.value = '';

            // Animação simples de entrada
            newCard.animate([
                { opacity: 0, transform: 'translateY(-20px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], {
                duration: 400,
                easing: 'ease-out'
            });
        });
    </script>
</body>
</html>