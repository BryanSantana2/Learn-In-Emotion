<?php
session_start();

// Lógica de Sessão
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
    <title>Cifras, Tabs & Parts - Learn In Emotion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }
        
        /* Menu Offcanvas */
        #offcanvas-menu { transition: transform 0.3s ease-in-out; transform: translateX(-100%); z-index: 50; }
        #offcanvas-menu.open { transform: translateX(0); }
        .overlay { transition: opacity 0.3s; opacity: 0; pointer-events: none; z-index: 40; }
        .overlay.open { opacity: 1; pointer-events: auto; }
        
        .cifra-card:hover { transform: translateY(-4px); }
        
        /* Custom Checkbox */
        .custom-checkbox:checked + div { background-color: #f59e0b; border-color: #f59e0b; }
        .custom-checkbox:checked + div:after { content: '\2714'; color: white; display: block; text-align: center; line-height: 14px; font-size: 10px; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-gray-800">

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
            <a href="cifras_tabs.php" class="block p-3 rounded-lg bg-amber-50 text-amber-600 font-semibold transition flex items-center gap-3">
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

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm sticky top-0 z-30 px-6 py-4 flex justify-between items-center gap-4">
        <div class="flex items-center gap-4 flex-shrink-0">
            <button id="open-menu" class="text-slate-500 hover:text-amber-500 transition text-2xl">
                <i class="fas fa-bars"></i>
            </button>
            <div class="flex items-center gap-2 text-amber-500">
                <i class="fas fa-music text-2xl"></i>
                <span class="font-bold text-xl tracking-tight hidden md:inline">Learn In Emotion</span>
            </div>
        </div>
        
        <!-- Barra de Pesquisa -->
        <div class="flex-grow max-w-md mx-auto hidden sm:flex items-center border border-gray-200 rounded-full bg-gray-50 overflow-hidden focus-within:border-amber-400 focus-within:ring-2 focus-within:ring-amber-100 transition">
            <input 
                id="search-input" 
                type="text" 
                placeholder="Pesquisar por música ou artista..." 
                class="w-full py-2 pl-4 text-sm bg-transparent focus:outline-none text-gray-700"
            >
            <button class="bg-amber-500 hover:bg-amber-600 text-white p-2 px-4 h-full transition">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <div class="flex items-center gap-4 flex-shrink-0">
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

    <!-- CONTEÚDO COM SIDEBAR -->
    <div class="container mx-auto px-4 py-8 max-w-7xl flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar de Filtros -->
        <aside class="lg:w-64 flex-shrink-0 space-y-8">
            
            <!-- Meus Favoritos -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-bookmark text-amber-500"></i> Biblioteca
                </h3>
                <div class="space-y-2">
                    <button onclick="filterByFavorite()" id="btn-favorites" class="w-full text-left px-3 py-2 rounded-lg hover:bg-red-50 text-gray-600 hover:text-red-500 transition flex items-center gap-2">
                        <i class="fas fa-heart"></i> Meus Favoritos
                    </button>
                    <button onclick="resetFilters()" class="w-full text-left px-3 py-2 rounded-lg hover:bg-amber-50 text-gray-600 hover:text-amber-600 transition flex items-center gap-2">
                        <i class="fas fa-layer-group"></i> Ver Todos
                    </button>
                </div>
            </div>

            <!-- Filtro Instrumento -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3">Instrumento</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-instrument" value="Violão"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Violão</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-instrument" value="Baixo"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Baixo</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-instrument" value="Piano"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Piano/Teclado</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-instrument" value="Bateria"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Bateria</span></label>
                </div>
            </div>

            <!-- Filtro Gênero -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3">Gênero</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-genre" value="Rock"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Rock</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-genre" value="Pop"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Pop</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-genre" value="MPB"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">MPB</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-genre" value="Gospel"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Gospel</span></label>
                </div>
            </div>

            <!-- Filtro Tipo -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3">Formato</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-type" value="Cifra"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Cifra</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-type" value="Tablatura"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Tablatura</span></label>
                    <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" class="hidden custom-checkbox filter-type" value="Partitura"><div class="w-4 h-4 border-2 border-gray-300 rounded bg-white group-hover:border-amber-400 transition"></div><span class="text-sm text-gray-600">Partitura</span></label>
                </div>
            </div>
        </aside>

        <!-- Grid de Cards -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Biblioteca</h1>
                <span id="result-count" class="text-sm text-gray-500">Mostrando todas</span>
            </div>

            <div id="cifras-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Card 1 -->
                <div class="cifra-card bg-white p-5 rounded-xl shadow-sm border border-gray-100 cursor-pointer hover:border-amber-200 transition relative group" 
                     data-id="1" data-genre="Rock" data-instrument="Violão" data-type="Cifra" data-title="Tempo Perdido" data-artist="Legião Urbana">
                    <div class="flex justify-between items-start mb-3">
                        <span class="bg-orange-100 text-orange-600 text-xs font-bold px-2 py-1 rounded">Violão</span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Cifra</span>
                    </div>
                    <a href="ver_cifras_tabs.html">
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1">Epitáfio</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-1">Titãs</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-400">Rock • Fácil</span>
            </a>
                        <button onclick="toggleFavorite(this, 1)" class="fav-btn text-gray-300 hover:text-red-500 transition text-xl focus:outline-none" title="Favoritar">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="cifra-card bg-white p-5 rounded-xl shadow-sm border border-gray-100 cursor-pointer hover:border-amber-200 transition relative group" 
                     data-id="2" data-genre="Rock" data-instrument="Baixo" data-type="Tablatura" data-title="Another One Bites The Dust" data-artist="Queen">
                    <div class="flex justify-between items-start mb-3">
                        <span class="bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded">Baixo</span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Tablatura</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1">Another One Bites The Dust</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-1">Queen</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-400">Rock • Médio</span>
                        <button onclick="toggleFavorite(this, 2)" class="fav-btn text-gray-300 hover:text-red-500 transition text-xl focus:outline-none">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="cifra-card bg-white p-5 rounded-xl shadow-sm border border-gray-100 cursor-pointer hover:border-amber-200 transition relative group" 
                     data-id="3" data-genre="Pop" data-instrument="Piano" data-type="Partitura" data-title="Imagine" data-artist="John Lennon">
                    <div class="flex justify-between items-start mb-3">
                        <span class="bg-purple-100 text-purple-600 text-xs font-bold px-2 py-1 rounded">Piano</span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Partitura</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1">Imagine</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-1">John Lennon</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-400">Pop • Fácil</span>
                        <button onclick="toggleFavorite(this, 3)" class="fav-btn text-gray-300 hover:text-red-500 transition text-xl focus:outline-none">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="cifra-card bg-white p-5 rounded-xl shadow-sm border border-gray-100 cursor-pointer hover:border-amber-200 transition relative group" 
                     data-id="4" data-genre="Gospel" data-instrument="Violão" data-type="Cifra" data-title="Porque Ele Vive" data-artist="Harpa Cristã">
                    <div class="flex justify-between items-start mb-3">
                        <span class="bg-orange-100 text-orange-600 text-xs font-bold px-2 py-1 rounded">Violão</span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Cifra</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1">Porque Ele Vive</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-1">Harpa Cristã</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-400">Gospel • Fácil</span>
                        <button onclick="toggleFavorite(this, 4)" class="fav-btn text-gray-300 hover:text-red-500 transition text-xl focus:outline-none">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="cifra-card bg-white p-5 rounded-xl shadow-sm border border-gray-100 cursor-pointer hover:border-amber-200 transition relative group" 
                     data-id="5" data-genre="MPB" data-instrument="Violão" data-type="Cifra" data-title="Aquarela" data-artist="Toquinho">
                    <div class="flex justify-between items-start mb-3">
                        <span class="bg-orange-100 text-orange-600 text-xs font-bold px-2 py-1 rounded">Violão</span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Cifra</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1">Aquarela</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-1">Toquinho</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-400">MPB • Médio</span>
                        <button onclick="toggleFavorite(this, 5)" class="fav-btn text-gray-300 hover:text-red-500 transition text-xl focus:outline-none">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

            </div>
            
            <div id="no-results" class="hidden text-center py-10 text-gray-500">
                <i class="fas fa-search text-4xl mb-3 text-gray-300"></i>
                <p>Nenhum resultado encontrado para sua busca.</p>
            </div>
        </div>
    </div>

    <script>
        // --- Menu Offcanvas ---
        const openMenuBtn = document.getElementById('open-menu');
        const closeMenuBtn = document.getElementById('close-menu');
        const offcanvasMenu = document.getElementById('offcanvas-menu');
        const backdrop = document.getElementById('menu-overlay');

        function toggleMenu(open) {
            if (open) {
                offcanvasMenu.classList.add('open');
                backdrop.classList.add('open');
            } else {
                offcanvasMenu.classList.remove('open');
                backdrop.classList.remove('open');
            }
        }

        openMenuBtn.addEventListener('click', () => toggleMenu(true));
        closeMenuBtn.addEventListener('click', () => toggleMenu(false));
        backdrop.addEventListener('click', () => toggleMenu(false));

        // --- Favoritos (Linkado com area_aluno.php) ---
        const STORAGE_KEY = 'harmonia_favorites'; // Mesma chave que usaremos no area_aluno.php
        let favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

        function initFavorites() {
            document.querySelectorAll('.fav-btn').forEach(btn => {
                const card = btn.closest('.cifra-card');
                const id = card.getAttribute('data-id');
                const icon = btn.querySelector('i');
                
                // Se o ID estiver no localStorage, pinta de vermelho
                const isFav = favorites.some(f => f.id === id);
                
                if (isFav) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-red-500');
                    card.setAttribute('data-favorite', 'true');
                } else {
                    card.setAttribute('data-favorite', 'false');
                }
            });
        }

        window.toggleFavorite = function(btn, id) {
            id = String(id); 
            const icon = btn.querySelector('i');
            const card = btn.closest('.cifra-card');
            
            const existingIndex = favorites.findIndex(f => f.id === id);
            
            if (existingIndex > -1) {
                // REMOVER
                favorites.splice(existingIndex, 1);
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far');
                card.setAttribute('data-favorite', 'false');
            } else {
                // ADICIONAR (Salva os dados completos para exibir no card da outra página)
                const favObj = {
                    id: id,
                    title: card.getAttribute('data-title'),
                    artist: card.getAttribute('data-artist'),
                    instrument: card.getAttribute('data-instrument'),
                    type: card.getAttribute('data-type')
                };
                favorites.push(favObj);
                
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500');
                card.setAttribute('data-favorite', 'true');
            }
            
            // Salva no LocalStorage
            localStorage.setItem(STORAGE_KEY, JSON.stringify(favorites));
            
            // Se estiver filtrando por favoritos, atualiza a tela
            if (showingFavorites) {
                applyFilters();
            }
        };

        // --- Filtros e Pesquisa ---
        const searchInput = document.getElementById('search-input');
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        const cards = document.querySelectorAll('.cifra-card');
        const noResults = document.getElementById('no-results');
        let showingFavorites = false;

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const checkedInstruments = Array.from(document.querySelectorAll('.filter-instrument:checked')).map(cb => cb.value);
            const checkedGenres = Array.from(document.querySelectorAll('.filter-genre:checked')).map(cb => cb.value);
            const checkedTypes = Array.from(document.querySelectorAll('.filter-type:checked')).map(cb => cb.value);
            
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                const artist = card.getAttribute('data-artist').toLowerCase();
                const instrument = card.getAttribute('data-instrument');
                const genre = card.getAttribute('data-genre');
                const type = card.getAttribute('data-type');
                const isFavorite = card.getAttribute('data-favorite') === 'true';

                const matchesSearch = title.includes(searchTerm) || artist.includes(searchTerm);
                const matchesInstrument = checkedInstruments.length === 0 || checkedInstruments.includes(instrument);
                const matchesGenre = checkedGenres.length === 0 || checkedGenres.includes(genre);
                const matchesType = checkedTypes.length === 0 || checkedTypes.includes(type);
                const matchesFavorite = !showingFavorites || isFavorite;

                if (matchesSearch && matchesInstrument && matchesGenre && matchesType && matchesFavorite) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            document.getElementById('result-count').innerText = showingFavorites 
                ? `Meus Favoritos (${visibleCount})` 
                : `Mostrando ${visibleCount} resultados`;
        }

        searchInput.addEventListener('input', applyFilters);
        checkboxes.forEach(cb => cb.addEventListener('change', applyFilters));

        window.filterByFavorite = function() {
            showingFavorites = true;
            document.getElementById('btn-favorites').classList.add('bg-red-50', 'text-red-500');
            applyFilters();
        };

        window.resetFilters = function() {
            showingFavorites = false;
            document.getElementById('btn-favorites').classList.remove('bg-red-50', 'text-red-500');
            searchInput.value = '';
            checkboxes.forEach(cb => cb.checked = false);
            applyFilters();
        };

        initFavorites();
        applyFilters();

    </script>
</body>
</html>