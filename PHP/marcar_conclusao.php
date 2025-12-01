<?php
session_start();

if (!isset($_SESSION['id_aluno']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso não autorizado");
}

$db_host = 'localhost';
$db_nome = 'learn_in_emotion';
$db_usuario = 'root';
$db_senha = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_nome;charset=utf8", $db_usuario, $db_senha);
    
    $id_aluno = $_SESSION['id_aluno'];
    $arquivo_licao = $_POST['arquivo_licao'];
    $instrumento = $_POST['instrumento'];

    // Verifica se já existe o registro desta lição para este aluno
    $stmt = $pdo->prepare("SELECT id_progresso FROM progresso_aulas WHERE id_aluno = ? AND codigo_licao = ?");
    $stmt->execute([$id_aluno, $arquivo_licao]);

    if ($stmt->rowCount() == 0) {
        // Se não existir, insere o novo progresso
        $insert = $pdo->prepare("INSERT INTO progresso_aulas (id_aluno, instrumento, codigo_licao) VALUES (?, ?, ?)");
        $insert->execute([$id_aluno, $instrumento, $arquivo_licao]);
    }

    // CORREÇÃO: Redireciona para fora da pasta PHP, voltando para a raiz
    header("Location: ../area_aluno.php"); 
    exit;

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>