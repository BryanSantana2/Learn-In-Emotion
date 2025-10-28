<?php

// --- Configurações do Banco de Dados ---
$db_host = 'localhost';
$db_nome = 'meu_banco';
$db_usuario = 'root';
$db_senha = ''; // Sua senha
// ----------------------------------------

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- 1. Receber Dados do Formulário ---
    $nome = $_POST['usuario_nome'];
    $email = $_POST['usuario_email'];
    $senha = $_POST['usuario_senha'];
    $data_nascimento = $_POST['data_nascimento']; // Ex: "1995-10-27"

    // --- 2. Validação dos Dados ---
    
    // Verifica campos vazios
    if (empty($nome) || empty($email) || empty($senha) || empty($data_nascimento)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Valida o formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erro: Formato de e-mail inválido.");
    }

    // Validação simples da data (formato AAAA-MM-DD e se é uma data real)
    try {
        $dateObj = new DateTime($data_nascimento);
        $hoje = new DateTime();
        if ($dateObj > $hoje) {
             die("Erro: A data de nascimento não pode ser no futuro.");
        }
    } catch (Exception $e) {
        die("Erro: Formato de data de nascimento inválido.");
    }

    // --- 3. Hash da Senha (Segurança) ---
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // --- 4. Conexão e Inserção no Banco (PDO) ---
    try {
        // Conexão
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_nome;charset=utf8", $db_usuario, $db_senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL Preparado (Prepared Statement) para evitar SQL Injection
        // ATUALIZADO: com a coluna 'data_nascimento' e um '?' a mais
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, data_nascimento) VALUES (?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Executa a consulta, passando os dados de forma segura
        // ATUALIZADO: com a variável $data_nascimento
        // (O formato YYYY-MM-DD do input type="date" é perfeito para a coluna DATE do MySQL)
        $stmt->execute([$nome, $email, $senha_hash, $data_nascimento]);

        echo "Cadastro realizado com sucesso!";

    } catch (PDOException $e) {
        // Verifica se é um erro de e-mail duplicado
        if ($e->getCode() == 23000) { 
            die("Erro: Este e-mail já está cadastrado.");
        } else {
            // Outro erro de banco
            die("Erro ao cadastrar no banco de dados: " . $e->getMessage());
        }
    }
} else {
    // Se alguém tentar acessar o script diretamente sem enviar o formulário
    echo "Acesso inválido. Por favor, preencha o formulário de cadastro.";
}

?>