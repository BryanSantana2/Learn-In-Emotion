<?php
// Inicia sessão para poder usar mensagens se necessário
session_start();

// --- Configurações do Banco de Dados ---
$db_host = 'localhost';
$db_nome = 'learn_in_emotion'; // Nome correto do banco
$db_usuario = 'root';
$db_senha = ''; // Verifique se sua senha é vazia
// ----------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Receber Dados (nomes iguais aos 'name' do HTML)
    $nome = $_POST['usuario_nome'];
    $email = $_POST['usuario_email'];
    $senha = $_POST['usuario_senha'];
    $data_nasc = $_POST['data_nasc']; // O HTML envia como 'data_nasc'

    // 2. Validação Básica
    if (empty($nome) || empty($email) || empty($senha)) {
        die("Erro: Preencha todos os campos obrigatórios.");
    }

    // 3. Criptografar Senha
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // 4. Conexão e Inserção
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_nome;charset=utf8", $db_usuario, $db_senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insere na tabela 'alunos'
        $sql = "INSERT INTO alunos (nome, email, senha, data_nasc) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha_hash, $data_nasc]);

        // Sucesso: volta para a tela de login (sai da pasta PHP com ../)
        echo "<script>
                alert('Cadastro realizado com sucesso!'); 
                window.location.href='../login.html';
              </script>";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Código de erro para duplicidade
            echo "<script>alert('Erro: Este e-mail já está cadastrado.'); window.history.back();</script>";
        } else {
            die("Erro ao cadastrar: " . $e->getMessage());
        }
    }
}
?>