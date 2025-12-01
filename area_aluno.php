<?php
session_start();

// --- 1. SEGURANÇA E CONFIGURAÇÃO ---
if (!isset($_SESSION['id_aluno']) && !isset($_SESSION['nome_aluno'])) {
    header('Location: login.html');
    exit;
}

$db_host = 'localhost';
$db_nome = 'learn_in_emotion';
$db_usuario = 'root';
$db_senha = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_nome;charset=utf8", $db_usuario, $db_senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Dados do Usuário
$id_aluno = $_SESSION['id_aluno'];
$nome_completo = $_SESSION['nome_aluno'];
$primeiro_nome = explode(' ', $nome_completo)[0];
$matricula = str_pad($id_aluno, 6, '0', STR_PAD_LEFT);

// --- 2. LÓGICA DE AÇÕES (POST) ---
if (isset($_POST['escolher_instrumento'])) {
    $novo_inst = $_POST['instrumento'];
    $stmt = $pdo->prepare("UPDATE alunos SET instrumento_foco = ? WHERE id_aluno = ?");
    $stmt->execute([$novo_inst, $id_aluno]);
    header("Refresh:0");
    exit;
}

if (isset($_POST['avancar_nivel'])) {
    $stmt = $pdo->prepare("UPDATE alunos SET nivel_atual = 'intermediario' WHERE id_aluno = ?");
    $stmt->execute([$id_aluno]);
    header("Refresh:0");
    exit;
}

// --- 3. BUSCAR DADOS DO BANCO ---
$stmt = $pdo->prepare("SELECT instrumento_foco, nivel_atual, email, created_at FROM alunos WHERE id_aluno = ?");
$stmt->execute([$id_aluno]);
$dados_aluno = $stmt->fetch(PDO::FETCH_ASSOC);

$instrumento_atual = $dados_aluno['instrumento_foco'];
$nivel_atual = $dados_aluno['nivel_atual'] ?? 'basico';
$data_entrada = date('d/m/Y', strtotime($dados_aluno['created_at']));

// --- 4. CONFIGURAÇÃO DO CURRÍCULO ---
$curriculo = [
    'bateria' => ['nome' => 'Bateria', 'icone' => 'fa-drum', 'cor' => 'cyan', 'basico' => [['arquivo' => 'licao_bateria1', 'titulo' => 'Introdução à Bateria'], ['arquivo' => 'licao_bateria2', 'titulo' => 'Ritmos Básicos']], 'intermediario' => [['arquivo' => 'licao_bateria3', 'titulo' => 'Viradas Simples'], ['arquivo' => 'licao_bateria4', 'titulo' => 'Pedal Duplo']]],
    'violao' => ['nome' => 'Violão', 'icone' => 'fa-guitar', 'cor' => 'orange', 'basico' => [['arquivo' => 'licao_violao1', 'titulo' => 'Acordes Maiores'], ['arquivo' => 'licao_violao2', 'titulo' => 'Batidas Pop']], 'intermediario' => [['arquivo' => 'licao_violao3', 'titulo' => 'Pestana'], ['arquivo' => 'licao_violao4', 'titulo' => 'Dedilhado']]],
    'contrabaixo' => ['nome' => 'Contrabaixo', 'icone' => 'fa-music', 'cor' => 'blue', 'basico' => [['arquivo'=>'licao_contrabaixo1', 'titulo'=>'Notas no Braço'], ['arquivo'=>'licao_contrabaixo2', 'titulo'=>'Slap Básico']], 'intermediario' => [['arquivo'=>'licao_contrabaixo3', 'titulo'=>'Grooves de Funk'], ['arquivo'=>'licao_contrabaixo4', 'titulo'=>'Walking Bass']]],
    'piano' => ['nome' => 'Piano', 'icone' => 'fa-keyboard', 'cor' => 'purple', 'basico' => [['arquivo'=>'licao_piano_teclado1', 'titulo'=>'Teclas Brancas'], ['arquivo'=>'licao_piano_teclado2', 'titulo'=>'Acordes Tríades']], 'intermediario' => [['arquivo'=>'licao_piano_teclado3', 'titulo'=>'Inversões'], ['arquivo'=>'licao_piano_teclado4', 'titulo'=>'Arpejos']]],
];

// Progresso
$aulas_concluidas = [];
if ($instrumento_atual) {
    $stmt = $pdo->prepare("SELECT codigo_licao FROM progresso_aulas WHERE id_aluno = ? AND instrumento = ?");
    $stmt->execute([$id_aluno, $instrumento_atual]);
    $aulas_concluidas = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$pode_avancar = false;
$porcentagem = 0;
$total_concluidas_count = count($aulas_concluidas);

if ($instrumento_atual && isset($curriculo[$instrumento_atual])) {
    $total_basico = count($curriculo[$instrumento_atual]['basico']);
    $concluidas_basico = 0;
    foreach ($curriculo[$instrumento_atual]['basico'] as $aula) {
        if (in_array($aula['arquivo'], $aulas_concluidas)) $concluidas_basico++;
    }
    if ($total_basico > 0) $porcentagem = round(($concluidas_basico / $total_basico) * 100);
    if ($concluidas_basico == $total_basico && $nivel_atual == 'basico') $pode_avancar = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Aluno - Learn In Emotion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }
        #offcanvas-menu { transition: transform 0.3s ease-in-out; transform: translateX(-100%); z-index: 50; }
        #offcanvas-menu.open { transform: translateX(0); }
        .overlay { transition: opacity 0.3s; opacity: 0; pointer-events: none; z-index: 40; }
        .overlay.open { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body class="text-slate-700">

    <!-- OVERLAY -->
    <div id="menu-overlay" class="overlay fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- MENU LATERAL -->
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
            <a href="area_aluno.php" class="block p-3 rounded-lg bg-amber-50 text-amber-600 font-semibold transition flex items-center gap-3">
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
            <a href="PHP/logout.php" class="block w-full text-center py-3 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 font-bold transition">
                <i class="fas fa-sign-out-alt mr-2"></i> Sair
            </a>
        </div>
    </div>

    <!-- NAVBAR -->
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
            <span class="text-sm font-medium text-slate-500 hidden sm:inline">Matrícula: <?php echo $matricula; ?></span>
            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold border border-amber-200">
                <?php echo strtoupper(substr($primeiro_nome, 0, 1)); ?>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO -->
    <main class="container mx-auto px-4 py-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- COLUNA ESQUERDA: PERFIL -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Card Perfil -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-amber-400 to-orange-500 opacity-90"></div>
                    <div class="relative z-10 mt-12">
                        <div class="w-24 h-24 bg-white p-1 rounded-full mx-auto shadow-lg">
                            <div class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center text-4xl text-slate-400">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800 mt-4"><?php echo $nome_completo; ?></h2>
                        <p class="text-slate-500 text-sm mb-4"><?php echo $dados_aluno['email']; ?></p>
                        <div class="bg-slate-50 rounded-lg p-3 border border-slate-100 text-left text-sm space-y-2">
                            <div class="flex justify-between"><span class="text-slate-500">Matrícula:</span><span class="font-mono font-bold text-slate-700">#<?php echo $matricula; ?></span></div>
                            <div class="flex justify-between"><span class="text-slate-500">Membro desde:</span><span class="font-medium text-slate-700"><?php echo $data_entrada; ?></span></div>
                        </div>
                    </div>
                </div>

                <!-- Card Favoritos (Carregado via JS) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-heart text-red-500"></i> Meus Favoritos
                    </h3>
                    
                    <div id="favorites-list" class="space-y-3">
                        <!-- Itens serão injetados aqui pelo JS -->
                        <div class="text-center py-4 text-gray-400 text-sm">
                            Carregando...
                        </div>
                    </div>
                    
                    <a href="cifras_tabs.php" class="block text-center text-xs text-amber-600 hover:underline mt-4">Ver biblioteca completa</a>
                </div>
            </div>

            <!-- COLUNA DIREITA: DASHBOARD -->
            <div class="lg:col-span-3">
                
                <?php if (!$instrumento_atual): ?>
                    <!-- SELETOR DE INSTRUMENTO -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Bem-vindo, <?php echo $primeiro_nome; ?>!</h2>
                        <p class="text-slate-500 mb-8">Para personalizar seu perfil, escolha seu instrumento principal.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <?php 
                            $opcoes = ['bateria' => ['nome' => 'Bateria', 'icone' => 'fa-drum'], 'violao' => ['nome' => 'Violão', 'icone' => 'fa-guitar'], 'contrabaixo' => ['nome' => 'Baixo', 'icone' => 'fa-music'], 'piano' => ['nome' => 'Piano', 'icone' => 'fa-keyboard']];
                            foreach($opcoes as $key => $opt): ?>
                                <form method="POST" class="h-full">
                                    <input type="hidden" name="instrumento" value="<?php echo $key; ?>">
                                    <button type="submit" name="escolher_instrumento" class="w-full p-6 rounded-xl border border-slate-100 hover:border-amber-400 bg-slate-50 hover:bg-white transition-all duration-300 group">
                                        <i class="fas <?php echo $opt['icone']; ?> text-3xl text-slate-400 group-hover:text-amber-500 mb-3 block"></i>
                                        <span class="font-bold text-slate-700"><?php echo $opt['nome']; ?></span>
                                    </button>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    
                    <!-- STATS -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg"><i class="fas fa-check-circle"></i></div>
                            <div><p class="text-xs text-slate-500 uppercase font-bold">Concluídas</p><p class="text-xl font-bold text-slate-800"><?php echo $total_concluidas_count; ?> Aulas</p></div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
                            <div class="p-3 bg-green-50 text-green-600 rounded-lg"><i class="fas fa-layer-group"></i></div>
                            <div><p class="text-xs text-slate-500 uppercase font-bold">Nível</p><p class="text-xl font-bold text-slate-800"><?php echo ucfirst($nivel_atual); ?></p></div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
                            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg"><i class="fas <?php echo $curriculo[$instrumento_atual]['icone']; ?>"></i></div>
                            <div><p class="text-xs text-slate-500 uppercase font-bold">Instrumento</p><p class="text-lg font-bold text-slate-800"><?php echo $curriculo[$instrumento_atual]['nome']; ?></p></div>
                        </div>
                    </div>

                    <!-- AULAS -->
                    <div class="space-y-6">
                        <!-- Básico -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="p-5 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                                <h3 class="font-bold text-slate-800">Nível Básico</h3>
                                <div class="w-32 bg-slate-200 rounded-full h-2"><div class="bg-amber-500 h-2 rounded-full transition-all" style="width: <?php echo $porcentagem; ?>%"></div></div>
                            </div>
                            <div class="divide-y divide-slate-100">
                                <?php foreach ($curriculo[$instrumento_atual]['basico'] as $idx => $aula): 
                                    $feita = in_array($aula['arquivo'], $aulas_concluidas);
                                ?>
                                    <a href="Aulas/<?php echo $aula['arquivo']; ?>.php" class="flex items-center p-4 hover:bg-slate-50 transition group">
                                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4 <?php echo $feita ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-500'; ?>"><?php echo $idx + 1; ?></span>
                                        <div class="flex-1"><h4 class="font-medium text-slate-700 group-hover:text-amber-600 transition"><?php echo $aula['titulo']; ?></h4></div>
                                        <i class="fas <?php echo $feita ? 'fa-check text-green-500' : 'fa-play text-slate-300 group-hover:text-amber-500'; ?>"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Intermediário -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                            <div class="p-5 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                                <h3 class="font-bold text-slate-800">Nível Intermediário</h3>
                                <?php if($nivel_atual == 'basico'): ?><i class="fas fa-lock text-slate-400"></i><?php else: ?><span class="text-xs font-bold text-amber-600 bg-amber-100 px-2 py-1 rounded">ABERTO</span><?php endif; ?>
                            </div>
                            <?php if ($nivel_atual == 'basico'): ?>
                                <div class="p-8 text-center text-slate-500"><i class="fas fa-lock text-3xl mb-2 text-slate-300"></i><p>Conclua o nível básico para desbloquear.</p></div>
                            <?php else: ?>
                                <div class="divide-y divide-slate-100">
                                    <?php foreach ($curriculo[$instrumento_atual]['intermediario'] as $idx => $aula): ?>
                                        <a href="Aulas/<?php echo $aula['arquivo']; ?>.php" class="flex items-center p-4 hover:bg-slate-50 transition group">
                                            <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4 bg-orange-100 text-orange-600"><?php echo $idx + 1; ?></span>
                                            <div class="flex-1"><h4 class="font-medium text-slate-700 group-hover:text-orange-600 transition"><?php echo $aula['titulo']; ?></h4></div>
                                            <i class="fas fa-play text-slate-300 group-hover:text-orange-500"></i>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <form method="POST" class="inline"><input type="hidden" name="instrumento" value=""><button type="submit" name="escolher_instrumento" class="mt-4 bg-amber-500 text-white font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-100 transition">Trocar de Instrumento</button></form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Modal Level Up -->
    <?php if ($pode_avancar): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center relative">
                <i class="fas fa-trophy text-6xl text-yellow-400 mb-4 animate-bounce inline-block"></i>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Nível Concluído!</h2>
                <form method="POST"><button type="submit" name="avancar_nivel" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold py-3 rounded-xl shadow-lg hover:scale-105 transition">Ir para Intermediário</button></form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Menu
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

        // --- CARREGAR FAVORITOS DO LOCALSTORAGE ---
        const STORAGE_KEY = 'harmonia_favorites';
        const favoritesList = document.getElementById('favorites-list');

        function loadFavorites() {
            const favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
            
            if (favorites.length === 0) {
                favoritesList.innerHTML = `
                    <div class="text-center py-6">
                        <div class="text-slate-300 text-3xl mb-2"><i class="far fa-heart"></i></div>
                        <p class="text-sm text-slate-500">Você ainda não favoritou nenhuma cifra.</p>
                    </div>`;
                return;
            }

            favoritesList.innerHTML = favorites.map(fav => `
                <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 border border-transparent hover:border-slate-100 transition group cursor-pointer relative">
                    <div class="w-8 h-8 rounded bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-music text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">${fav.title}</p>
                        <p class="text-xs text-slate-400 truncate">${fav.artist}</p>
                    </div>
                    <button onclick="removeFav('${fav.id}')" class="text-gray-300 hover:text-red-500 p-1" title="Remover">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');
        }

        // Função global para remover favorito direto do card
        window.removeFav = function(id) {
            let favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
            favorites = favorites.filter(f => f.id !== id);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(favorites));
            loadFavorites();
        };

        document.addEventListener('DOMContentLoaded', loadFavorites);
    </script>
</body>
</html>