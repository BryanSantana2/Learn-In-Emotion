<?php
session_start();
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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Professor - Learn In Emotion</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="CSS/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50">

  <!-- HEADER -->
  <header class="bg-white shadow-md sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
      <div></div>
      <div class="text-center">
        <h1 class="text-2xl font-extrabold text-amber-500">Learn In Emotion</h1>
        <p class="text-xs text-gray-500">Escola & Plataforma de Cifras</p>
      </div>
            <?php if($logado): ?>
          <div class="flex items-center gap-3">
              <div class="text-right hidden md:block">
                  <p class="text-xs text-gray-400 font-medium">Matrícula</p>
                  <p class="text-sm font-bold text-gray-700">#<?php echo $matricula; ?></p>
              </div>
              <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold border border-amber-200 shadow-sm" title="<?php echo $_SESSION['nome_aluno']; ?>">
                  <?php echo strtoupper(substr($primeiro_nome, 0, 1)); ?>
              </div>
          </div>
      <?php endif; ?>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- voltar -->
    <div class="mb-6">
      <a href="/Projeto/index.php" class="inline-flex items-center text-sm text-gray-600 hover:text-amber-500">
        <i class="fas fa-chevron-left mr-2"></i> Voltar para professores
      </a>
    </div>

    <!-- CARD DO PROFESSOR -->
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 grid grid-cols-1 md:grid-cols-3 gap-8">

      <!-- foto + contato -->
      <aside class="flex flex-col items-center md:items-start">

        <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-amber-400 shadow-md mb-4">
          <img src="../Imagens/Professor4.png" 
               alt="Foto do professor" 
               class="w-full h-full object-cover">
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-1">Júlia Toledo</h2>

        <div class="w-full space-y-3">
          <div>
            <h4 class="font-semibold text-sm text-gray-700 mb-1">Contato</h4>
            <p class="text-sm text-gray-500">juliatoledo@exemplo.com</p>
          </div>
          <button onclick="openContactModal()" class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
            <i class="fab fa-solid fa-paper-plane mr-2"></i> Contato
          </button>
        </div>
      </aside>

      <!-- bio + instrumentos -->
      <section class="md:col-span-2">

        <div class="mb-6">
          <h3 class="text-xl font-extrabold text-gray-800 mb-2">Sobre o Professor</h3>
          <p class="text-gray-600 leading-relaxed">
            Biografia do professor — formação, experiência, métodos de ensino e enfoque profissionalizante.
          </p>
        </div>

        <div class="mb-6">
          <h3 class="text-lg font-bold text-gray-800 mb-3">Instrumentos & Áreas Profissionalizantes</h3>
          <div class="flex flex-wrap gap-3">
            <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-sm">
              Baixo
            </span>

            <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-sm">
              Técnica Avançada
            </span>

            <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-sm">
              Leitura Musical
            </span>
          </div>

          <p class="text-sm text-gray-500 mt-3">
            Estes são os instrumentos e áreas que o professor leciona e que possuem conteúdo profissionalizante.
          </p>
        </div>

        <!-- cursos -->
        <div class="mb-6">
          <h3 class="text-lg font-bold text-gray-800 mb-3">Cursos Profissionalizantes</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="p-4 border rounded-lg">
              <h4 class="font-semibold text-gray-800">Curso </h4>
              <p class="text-sm text-gray-500">Baixista</p>
            </div>

            <div class="p-4 border rounded-lg">
              <h4 class="font-semibold text-gray-800">Curso </h4>
              <p class="text-sm text-gray-500">Teoria</p>
            </div>

          </div>
        </div>

        <!-- avaliações -->
        <div>
          <h3 class="text-lg font-bold text-gray-800 mb-3">Avaliações & Experiências</h3>

          <div class="space-y-3">

            <div class="p-3 border rounded">
              <p class="text-sm text-gray-700">“Melhor professor que já tive!”</p>
              <p class="text-xs text-gray-500 mt-1">— Aluno A.</p>
            </div>

            <div class="p-3 border rounded">
              <p class="text-sm text-gray-700">“Muito paciente e didático.”</p>
              <p class="text-xs text-gray-500 mt-1">— Aluno B.</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <footer class="bg-gray-800 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div>
        <h3 class="text-amber-400 font-bold">Learn In Emotion</h3>
        <p class="text-gray-400 text-sm mt-1">A sua escola de música online.</p>
      </div>

      <div class="text-sm text-gray-400">
        <p>© 2025 Learn In Emotion. Todos os direitos reservados.</p>
      </div>

      <div class="text-right text-sm text-gray-400">
        <a href="https://wa.me/5511987654321" class="hover:text-green-300">
          <i class="fab fa-whatsapp mr-2"></i> Chamar no WhatsApp
        </a>
      </div>
    </div>
  </footer>
    <div id="contact-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 px-4 backdrop-blur-sm transition-opacity duration-300">
      <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full text-center relative transform transition-all scale-95 opacity-0" id="modal-content">
          <div class="mb-4 text-amber-500">
              <i class="fas fa-exclamation-circle text-5xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-2">Contato Indisponível</h3>
          <p class="text-gray-500 text-sm mb-6">No momento, o contato direto com este professor não está disponível pela plataforma.</p>
          <button onclick="closeContactModal()" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg transition shadow-md">
              Fechar
          </button>
      </div>

  </div>
    <script>
      const modal = document.getElementById('contact-modal');
      const modalContent = document.getElementById('modal-content');

      function openContactModal() {
          modal.classList.remove('hidden');
          modal.classList.add('flex');
          // Animação de entrada
          setTimeout(() => {
              modalContent.classList.remove('scale-95', 'opacity-0');
              modalContent.classList.add('scale-100', 'opacity-100');
          }, 10);
      }

      function closeContactModal() {
          // Animação de saída
          modalContent.classList.remove('scale-100', 'opacity-100');
          modalContent.classList.add('scale-95', 'opacity-0');
          setTimeout(() => {
              modal.classList.remove('flex');
              modal.classList.add('hidden');
          }, 300);
      }

      // Fechar ao clicar fora do modal
      modal.addEventListener('click', (e) => {
          if (e.target === modal) {
              closeContactModal();
          }
      });
  </script>
</body>
</html>
