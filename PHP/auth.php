<?php
session_start();

$db_host = 'localhost';
$db_nome = 'learn_in_emotion';
$db_usuario = 'root';
$db_senha = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['username'];
    $senha = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_nome;charset=utf8", $db_usuario, $db_senha);
        
        // Busca o usuário pelo e-mail
        $sql = "SELECT id_aluno, nome, senha FROM alunos WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica a senha
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login correto
            $_SESSION['id_aluno'] = $usuario['id_aluno'];
            $_SESSION['nome_aluno'] = $usuario['nome'];
            
            // Redireciona para a página inicial (sai da pasta PHP com ../)
            header("Location: ../index.php");
            exit;
        } else {
            // Senha errada
            echo "<script>
                    alert('E-mail ou senha incorretos!'); 
                    window.location.href='../login.html';
                  </script>";
        }

    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}
?>