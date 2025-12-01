<?php
session_start();

// Lógica de Sessão para a Navbar
$logado = isset($_SESSION['id_aluno']);
$primeiro_nome = 'Visitante';
$matricula = '---';

if ($logado) {
    $nome_completo = $_SESSION['nome_aluno'];
    $primeiro_nome = explode(' ', $nome_completo)[0];
    $matricula = str_pad($_SESSION['id_aluno'], 6, '0', STR_PAD_LEFT);
}

// Dados dos Professores com os Links Específicos
$professores = [
    [
        'nome' => 'Alice Garcia', 
        'inst' => 'Guitarra', 
        'desc' => 'Guitarra: Especialista em técnica de mão direita.', 
        'img' => 'Imagens/Professor5.png',
        'link' => 'Professores/professor1.php'
    ],
    [
        'nome' => 'Marcos Silva', 
        'inst' => 'Bateria', 
        'desc' => 'Bateria & Percussão: Foco em ritmos brasileiros.', 
        'img' => 'Imagens/Professor1.png',
        'link' => 'Professores/professor2.php'
    ],
    [
        'nome' => 'Júlia Toledo', 
        'inst' => 'Contrabaixo', 
        'desc' => 'Contrabaixo: Técnica de sopro e repertório.', 
        'img' => 'Imagens/Professor4.png',
        'link' => 'Professores/professor3.php'
    ],
    [
        'nome' => 'Ricardo Neto', 
        'inst' => 'Teclado', 
        'desc' => 'Teclado & Jazz: Improvisação e teoria avançada.', 
        'img' => 'Imagens/Professor3.png',
        'link' => 'Professores/professor4.php'
    ],
    [
        'nome' => 'Lucas Souza', 
        'inst' => 'Violão', 
        'desc' => 'Violão & Produção: Síntese sonora.', 
        'img' => 'Imagens/Professor2.png',
        'link' => 'Professores/professor5.php'
    ],
    [
        'nome' => 'Patrícia Lima', 
        'inst' => 'Bateria', 
        'desc' => 'Bateria: Postura e afinação.', 
        'img' => 'Imagens/Professor6.png',
        'link' => 'Professores/professor6.php'
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn In Emotion - Escola e Cifras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="CSS/home.css">
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
<body id="home">

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
            <a href="index.php" class="block p-3 rounded-lg bg-amber-50 text-amber-600 font-semibold transition flex items-center gap-3">
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
    <nav class="bg-white shadow-sm sticky top-0 z-30 px-4 sm:px-6 py-4 flex justify-between items-center gap-4">
        
        <div class="flex items-center gap-4 flex-shrink-0">
            <button id="open-menu" class="text-slate-500 hover:text-amber-500 transition text-2xl">
                <i class="fas fa-bars"></i>
            </button>
            <div class="flex items-center gap-2 text-amber-500">
                <i class="fas fa-music text-2xl"></i>
                <span class="font-bold text-xl tracking-tight hidden md:inline">Learn In Emotion</span>
            </div>
        </div>
        
        <div class="flex-grow max-w-md mx-auto hidden sm:flex items-center border border-gray-200 rounded-full bg-gray-50 overflow-hidden focus-within:border-amber-400 focus-within:ring-2 focus-within:ring-amber-100 transition">
            <input 
                id="search-input" 
                type="text" 
                placeholder="Buscar músicas, aulas ou cifras..." 
                class="w-full py-2 pl-4 text-sm bg-transparent focus:outline-none text-gray-700"
            >
            <button 
                id="search-button" 
                type="submit" 
                class="bg-amber-500 hover:bg-amber-600 text-white p-2 px-4 h-full transition">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <div class="flex items-center gap-4 flex-shrink-0">
            <?php if($logado): ?>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="text-xs text-slate-400 font-medium">Matrícula</p>
                        <p class="text-sm font-bold text-slate-700">#<?php echo $matricula; ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold border border-amber-200 shadow-sm" title="<?php echo $_SESSION['nome_aluno']; ?>">
                        <?php echo strtoupper(substr($primeiro_nome, 0, 1)); ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.html" class="text-sm font-bold text-amber-600 hover:text-amber-700 hover:underline transition">
                    Fazer Login
                </a>
                <a href="login.html" class="hidden md:inline-block bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold py-2 px-4 rounded-full transition shadow-md">
                    Criar Conta
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto">
        
        <!-- Banner Section -->
        <section id="banners" class="mt-8 px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Learn In Emotion</h2>
            <div class="relative overflow-hidden rounded-xl shadow-lg bg-gray-100 h-[350px] sm:h-[400px]">
                <div id="carousel-inner" class="flex transition-transform duration-700 ease-in-out h-full">
                    <div class="min-w-full flex items-center justify-center p-8 bg-gradient-to-r from-amber-500 to-yellow-400 text-white relative">
                        <div class="max-w-md z-10">
                            <h3 class="text-4xl font-black mb-2">Seu Plano de Estudos</h3>
                            <p class="text-lg">Veja suas próximas aulas agendadas e seu progresso no curso.</p>
                            <a href="area_aluno.php"><button class="mt-4 bg-white text-amber-500 font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-100 transition">Acessar Meu Painel</button></a>
                        </div>
                        <i class="fas fa-guitar text-9xl absolute right-10 opacity-20 hidden md:block rotate-12"></i>
                    </div>
                    <div class="min-w-full flex items-center justify-center p-8 bg-gradient-to-r from-teal-500 to-green-400 text-white relative">
                        <div class="max-w-md z-10">
                            <h3 class="text-4xl font-black mb-2">Tire suas Dúvidas</h3>
                            <p class="text-lg">Nossa IA e comunidade estão prontas para te ajudar.</p>
                            <a href="ajuda.php"><button class="mt-4 bg-white text-teal-500 font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-100 transition">Perguntar Agora</button></a>
                        </div>
                        <i class="fas fa-comments text-9xl absolute right-10 opacity-20 hidden md:block"></i>
                    </div>
                    <div class="min-w-full flex items-center justify-center p-8 bg-gradient-to-r from-red-500 to-pink-400 text-white relative">
                        <div class="max-w-md z-10">
                            <h3 class="text-4xl font-black mb-2">Teoria Musical</h3>
                            <p class="text-lg">Entenda harmonia, ritmo e melodia para tocar com confiança.</p>
                            <a href="#cursos"><button class="mt-4 bg-white text-red-500 font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-100 transition">Ver Módulos</button></a>
                        </div>
                        <i class="fas fa-music text-9xl absolute right-10 opacity-20 hidden md:block rotate-[-10deg]"></i>
                    </div>
                </div>
                
                <button id="carousel-prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white/30 hover:bg-white/50 p-3 rounded-full text-white transition backdrop-blur-sm">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="carousel-next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white/30 hover:bg-white/50 p-3 rounded-full text-white transition backdrop-blur-sm">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <div id="carousel-indicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <div class="w-3 h-3 bg-white rounded-full cursor-pointer transition-all active-indicator"></div>
                    <div class="w-3 h-3 bg-white/50 rounded-full cursor-pointer transition-all"></div>
                    <div class="w-3 h-3 bg-white/50 rounded-full cursor-pointer transition-all"></div>
                </div>
            </div>
        </section>

        <!-- Professores Section (DINÂMICA) -->
        <section id="professores" class="py-16 px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-extrabold text-center text-amber-500 mb-12">Nossos Maestros</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php foreach($professores as $prof): ?>
                    <?php if($logado): ?>
                        <!-- VERSÃO LOGADO: LINK PARA A PÁGINA ESPECÍFICA -->
                        <a href="<?php echo $prof['link']; ?>" class="teacher-card block bg-white p-4 rounded-xl shadow-lg hover:-translate-y-2 transition duration-300 cursor-pointer border-2 border-transparent hover:border-amber-400 group h-full flex flex-col">
                            <img src="<?php echo $prof['img']; ?>" alt="<?php echo $prof['nome']; ?>" class="w-full h-auto rounded-full object-cover aspect-square mb-3 border-4 border-amber-100 group-hover:border-amber-400 transition">
                            <h4 class="font-bold text-lg text-gray-800 mb-1"><?php echo $prof['nome']; ?></h4>
                            <p class="text-sm text-gray-500 mb-3 flex-grow"><?php echo $prof['inst']; ?></p>
                        </a>
                    <?php else: ?>
                        <!-- VERSÃO VISITANTE: MODAL -->
                        <div class="teacher-card text-center bg-white p-4 rounded-xl shadow-lg hover:-translate-y-2 transition duration-300 cursor-pointer h-full flex flex-col" onclick="showTeacherInfo('<?php echo $prof['nome']; ?>', '<?php echo $prof['desc']; ?>')">
                            <img src="<?php echo $prof['img']; ?>" alt="<?php echo $prof['nome']; ?>" class="w-full h-auto rounded-full object-cover aspect-square mb-3 border-4 border-amber-400">
                            <h4 class="font-bold text-lg text-gray-800 mb-1"><?php echo $prof['nome']; ?></h4>
                            <p class="text-sm text-gray-500 flex-grow"><?php echo $prof['inst']; ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Instrumentos Section -->
        <section id="instrumentos" class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 rounded-3xl my-8">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-10">Descubra seu Instrumento</h2>
            
            <div class="relative">
                <button id="slider-prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-amber-500 text-white p-3 rounded-full shadow-xl hover:bg-amber-600 transition z-10 hidden md:block -ml-5">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div id="instrument-slider" class="instrument-slider flex overflow-x-scroll space-x-6 p-4 -mx-4 md:mx-0 scroll-smooth hide-scrollbar" style="scrollbar-width: none;">
                    
                    <div class="instrument-card min-w-[280px] bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition duration-300 border-t-4 border-amber-400">
                        <i class="fas fa-guitar text-6xl text-amber-500 mb-4"></i>
                        <h4 class="font-bold text-xl mb-2">Violão</h4>
                        <p class="text-gray-600 mb-4">O ponto de partida perfeito para qualquer músico.</p>
                        <a href="area_aluno.php" class="text-amber-500 hover:text-amber-600 font-semibold text-sm">Ver Curso &rarr;</a>
                    </div>
                    
                    <div class="instrument-card min-w-[280px] bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition duration-300 border-t-4 border-amber-400">
                        <i class="fas fa-keyboard text-6xl text-amber-500 mb-4"></i>
                        <h4 class="font-bold text-xl mb-2">Piano / Teclado</h4>
                        <p class="text-gray-600 mb-4">Harmonia e melodia em um único instrumento versátil.</p>
                        <a href="area_aluno.php" class="text-amber-500 hover:text-amber-600 font-semibold text-sm">Ver Curso &rarr;</a>
                    </div>
                    
                    <div class="instrument-card min-w-[280px] bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition duration-300 border-t-4 border-amber-400">
                        <i class="fas fa-drum text-6xl text-amber-500 mb-4"></i>
                        <h4 class="font-bold text-xl mb-2">Bateria</h4>
                        <p class="text-gray-600 mb-4">A base rítmica de qualquer banda. Liberte sua energia!</p>
                        <a href="area_aluno.php" class="text-amber-500 hover:text-amber-600 font-semibold text-sm">Ver Curso &rarr;</a>
                    </div>

                    <div class="instrument-card min-w-[280px] bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition duration-300 border-t-4 border-amber-400">
                        <i class="fas fa-music text-6xl text-amber-500 mb-4"></i>
                        <h4 class="font-bold text-xl mb-2">Baixo Elétrico</h4>
                        <p class="text-gray-600 mb-4">O groove e a sustentação rítmica da harmonia.</p>
                        <a href="area_aluno.php" class="text-amber-500 hover:text-amber-600 font-semibold text-sm">Ver Curso &rarr;</a>
                    </div>
                </div>

                <button id="slider-next" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-amber-500 text-white p-3 rounded-full shadow-xl hover:bg-amber-600 transition z-10 hidden md:block -mr-5">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </section>
        
        <section id="diferenciais" class="py-16 px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Nossos Diferenciais</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-white rounded-xl shadow-lg border-b-4 border-blue-500 hover:-translate-y-2 transition duration-300">
                    <i class="fas fa-laptop-code text-5xl text-blue-500 mb-4"></i>
                    <h3 class="font-bold text-xl mb-2">Aulas Dinâmicas</h3>
                    <p class="text-gray-600">Plataforma interativa com vídeos, cifras e acompanhamento de progresso.</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-lg border-b-4 border-purple-500 hover:-translate-y-2 transition duration-300">
                    <i class="fas fa-globe text-5xl text-purple-500 mb-4"></i>
                    <h3 class="font-bold text-xl mb-2">Comunidade Global</h3>
                    <p class="text-gray-600">Conecte-se com músicos de todo o mundo em nossos fóruns.</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-lg border-b-4 border-green-500 hover:-translate-y-2 transition duration-300">
                    <i class="fas fa-medal text-5xl text-green-500 mb-4"></i>
                    <h3 class="font-bold text-xl mb-2">Resultados Reais</h3>
                    <p class="text-gray-600">Metodologia focada na prática para você tocar suas primeiras músicas rápido.</p>
                </div>
            </div>
        </section>

    </main>
    
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-2 md:grid-cols-4 gap-8">
            
            <div class="col-span-2 md:col-span-1">
                <h3 class="text-2xl font-extrabold text-amber-400 mb-4">Harmonia Total</h3>
                <p class="text-gray-400 text-sm">A sua escola de música online, dedicada a transformar paixão em habilidade.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="font-semibold text-lg mb-4 border-b border-gray-700 pb-1">Navegação</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="index.php" class="text-gray-400 hover:text-white transition">Home</a></li>
                    <li><a href="area_aluno.php" class="text-gray-400 hover:text-white transition">Cursos</a></li>
                    <li><a href="#professores" class="text-gray-400 hover:text-white transition">Corpo Docente</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-lg mb-4 border-b border-gray-700 pb-1">Suporte</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="ajuda.php" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Termos de Uso</a></li>
                    <li><a href="area_aluno.php" class="text-gray-400 hover:text-white transition">Área do Aluno</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-lg mb-4 border-b border-gray-700 pb-1">Fale Conosco</h4>
                <p class="text-sm text-gray-400 mb-2">
                    <i class="fas fa-envelope mr-2 text-amber-400"></i> contato@harmoniatotal.com
                </p>
                <p class="text-sm text-gray-400 mb-2">
                    <i class="fas fa-phone-alt mr-2 text-amber-400"></i> (11) 98765-4321
                </p>
            </div>
        </div>
        
        <div class="border-t border-gray-700 py-4 text-center">
            <p class="text-xs text-gray-500">&copy; 2025 Harmonia Total. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Modal do Professor (Apenas para Visitantes) -->
    <div id="teacher-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0" id="modal-content-box">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold text-amber-500">Detalhes do Professor</h3>
                <button id="close-modal" class="text-gray-500 hover:text-red-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <p id="modal-teacher-name" class="text-2xl font-semibold text-gray-800 mb-2"></p>
            <p id="modal-teacher-instrument" class="text-lg text-gray-600 mb-4"></p>
            <div class="text-sm text-gray-500 border-t pt-3">
                <p>Este professor está disponível para aulas particulares. Use o link "Acessar / Matricular" para iniciar sua jornada!</p>
            </div>
        </div>
    </div>

    <script>
        // --- Modal Logic ---
        const teacherModal = document.getElementById('teacher-modal');
        const modalContentBox = document.getElementById('modal-content-box');
        const closeModalButton = document.getElementById('close-modal');
        const modalTeacherName = document.getElementById('modal-teacher-name');
        const modalTeacherInstrument = document.getElementById('modal-teacher-instrument');

        window.showTeacherInfo = (name, instrument) => {
            modalTeacherName.textContent = name;
            modalTeacherInstrument.textContent = instrument;
            
            teacherModal.classList.remove('hidden');
            setTimeout(() => {
                teacherModal.classList.add('flex');
                modalContentBox.classList.remove('opacity-0', 'scale-95');
                modalContentBox.classList.add('opacity-100', 'scale-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        };

        const closeModal = () => {
            modalContentBox.classList.remove('opacity-100', 'scale-100');
            modalContentBox.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => {
                teacherModal.classList.remove('flex');
                teacherModal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        };

        closeModalButton.addEventListener('click', closeModal);
        teacherModal.addEventListener('click', (e) => {
            if (e.target === teacherModal) closeModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            
            // --- Menu Logic ---
            const openMenu = document.getElementById('open-menu');
            const closeMenu = document.getElementById('close-menu');
            const offcanvasMenu = document.getElementById('offcanvas-menu');
            const offcanvasBackdrop = document.getElementById('menu-overlay');
            const navLinks = offcanvasMenu.querySelectorAll('a');

            function toggleMenu(isOpen) {
                if (isOpen) {
                    offcanvasMenu.classList.add('open');
                    offcanvasBackdrop.classList.add('open');
                    document.body.style.overflow = 'hidden'; 
                } else {
                    offcanvasMenu.classList.remove('open');
                    offcanvasBackdrop.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }

            openMenu.addEventListener('click', () => toggleMenu(true));
            closeMenu.addEventListener('click', () => toggleMenu(false));
            offcanvasBackdrop.addEventListener('click', () => toggleMenu(false));
            
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    setTimeout(() => toggleMenu(false), 300);
                });
            });

            // --- Search Logic (Links to cifras_tabs.php) ---
            const searchButton = document.getElementById('search-button');
            const searchInput = document.getElementById('search-input');

            const performSearch = () => {
                const query = searchInput.value.trim();
                if (query) {
                    // REDIRECIONA COM O PARÂMETRO 'search'
                    window.location.href = `cifras_tabs.php?search=${encodeURIComponent(query)}`;
                }
            };

            searchButton.addEventListener('click', (e) => {
                e.preventDefault();
                performSearch();
            });

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });

            // --- Carousel Logic ---
            const carouselInner = document.getElementById('carousel-inner');
            const prevButton = document.getElementById('carousel-prev');
            const nextButton = document.getElementById('carousel-next');
            const indicatorsContainer = document.getElementById('carousel-indicators');
            const slides = carouselInner.children;
            let currentIndex = 0;
            const slideWidth = 100;

            function updateCarousel() {
                carouselInner.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
                
                Array.from(indicatorsContainer.children).forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.remove('bg-white/50');
                        indicator.classList.add('bg-white', 'scale-125');
                    } else {
                        indicator.classList.add('bg-white/50');
                        indicator.classList.remove('bg-white', 'scale-125');
                    }
                });
            }

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateCarousel();
            });

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateCarousel();
            });
            
            Array.from(indicatorsContainer.children).forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                });
            });

            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateCarousel();
            }, 5000);
            
            updateCarousel();

            // --- Instrument Slider Logic ---
            const slider = document.getElementById('instrument-slider');
            const sliderPrev = document.getElementById('slider-prev');
            const sliderNext = document.getElementById('slider-next');
            const scrollAmount = 300;

            if(slider && sliderPrev && sliderNext) {
                sliderNext.addEventListener('click', () => {
                    slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });

                sliderPrev.addEventListener('click', () => {
                    slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });
            }
        });
    </script>
</body>
</html>