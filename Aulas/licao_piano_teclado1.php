<?php
session_start();
if (!isset($_SESSION['id_aluno'])) {
    header('Location: ../login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula de Piano 1 - Learn In Emotion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap'); body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <header class="bg-white border-b border-slate-200 p-4 sticky top-0 z-30 shadow-sm flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="../area_aluno.php" class="text-slate-500 hover:text-amber-600 transition p-2 rounded-full hover:bg-slate-100">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="font-bold text-lg leading-tight">Teclas Brancas</h1>
                <p class="text-xs text-slate-500">Módulo Básico • Aula 1</p>
            </div>
        </div>
    </header>

    <main class="container mx-auto max-w-4xl p-4 md:p-8">
        
        <div class="bg-black rounded-xl overflow-hidden shadow-2xl mb-8 aspect-w-16 aspect-h-9 relative" style="padding-top: 56.25%;">
            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-amber-900">Iniciando no Teclado</h2>
            <div class="prose max-w-none text-slate-600">
                <p class="mb-4">O piano é o instrumento mestre da harmonia. Vamos começar:</p>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>Identificando o Dó Central (C).</li>
                    <li>A escala natural (Teclas Brancas).</li>
                    <li>Numeração dos dedos e postura da mão.</li>
                </ul>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 text-center shadow-sm">
            <i class="fas fa-keyboard text-4xl text-amber-400 mb-4 block"></i>
            <h3 class="font-bold text-xl text-amber-900 mb-2">Encontrou o Dó Central?</h3>
            <p class="text-amber-600/80 mb-6 max-w-md mx-auto">Marque a conclusão para salvar seu progresso inicial.</p>
            
            <form action="../PHP/marcar_conclusao.php" method="POST">
                <input type="hidden" name="arquivo_licao" value="licao_piano_teclado1"> 
                <input type="hidden" name="instrumento" value="piano">
                
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-green-200 transform transition hover:scale-105 active:scale-95 flex items-center justify-center mx-auto gap-2 text-lg">
                    <i class="fas fa-check"></i> Concluir Aula
                </button>
            </form>
        </div>

    </main>
</body>
</html>