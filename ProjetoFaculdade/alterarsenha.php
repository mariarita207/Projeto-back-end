<?php
session_start();
require("conexao.php");

// 1. CORREÇÃO: Verifica se o ID do usuário existe na sessão (novo padrão)
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php"); // Se não estiver logado, manda pro login
    exit();
}

$id_usuario = $_SESSION["id_usuario"]; // Pega o ID da sessão
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $senha_atual    = $_POST['senha_atual']    ?? '';
    $nova_senha     = $_POST['nova_senha']     ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    // 2. CORREÇÃO: Busca pela Primary Key (id_usuario) em vez do CPF
    $sql = "SELECT senha FROM cadastro WHERE id_usuario = '$id_usuario'";
    $resultado = $conexao->query($sql);

    if (!$resultado || $resultado->num_rows == 0) {
        $mensagem = "Usuário não encontrado.";
    } else {

        $usuario = $resultado->fetch_assoc();
        $senha_hash_atual = $usuario['senha'];

        // VERIFICA SENHA ATUAL
        if (!password_verify($senha_atual, $senha_hash_atual)) {
            $mensagem = "Senha atual incorreta.";
        }
        // CONFIRMAÇÃO
        elseif ($nova_senha !== $confirma_senha) {
            $mensagem = "A confirmação da senha não confere.";
        }
        // TAMANHO MÍNIMO (Regra do seu projeto: 8 caracteres)
        elseif (strlen($nova_senha) < 8) {
            $mensagem = "A nova senha deve ter no mínimo 8 caracteres.";
        }
        else {
            // GERA NOVO HASH
            $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            // 3. CORREÇÃO: Atualiza usando o ID
            $sql_update = "UPDATE cadastro SET senha = '$novo_hash' WHERE id_usuario = '$id_usuario'";

            if ($conexao->query($sql_update)) {
                echo "<script>
                    alert('Senha alterada com sucesso!');
                    window.location.href = 'home.php'; // Manda para home, não painel
                </script>";
                exit();
            } else {
                $mensagem = "Erro ao atualizar a senha.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Senha - Lootsy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="styles/alterarsenha.css">

    <link rel="shortcut icon" href="assets/images/imagem_da_logo.png" type="image/x-icon">
</head>
<body>

<header class="cabecalho">
    <div class="icone">
        <a href="home.php">
            <img src="assets/images/logo+nome.png" alt="Logo Lootsy" class="imagem-cabecalho"/>
        </a>
    </div>

    <div class="trilho" id="trilho">
          <div class="indicador"></div>
   </div>

</header>

<main>
<section class="container d-flex justify-content-center">
    <div class="alterar">

        <div class="lootsy-body text-center">
            <a href="home.php">
                <img src="assets/images/logo+nome.png" alt="Lootsy"/>
            </a>
        </div>

        <h3 class="text-center">ALTERAR SENHA</h3>

        <!--  Mensagem de erro -->
        <?php if (!empty($mensagem)) : ?>
            <div class="alert alert-danger text-center">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <!--  FORMULÁRIO CORRETO -->
        <form method="POST" action="alterarsenha.php">

            <label class="mt-2">SENHA ATUAL</label>
            <input type="password" name="senha_atual" id="senha-atual" class="form-control" required>

            <label class="mt-2">NOVA SENHA</label>
            <input type="password" name="nova_senha" id="nova-senha" class="form-control" required>

            <label class="mt-2">CONFIRMAR NOVA SENHA</label>
            <input type="password" name="confirma_senha" id="confirmar-nova-senha" class="form-control" required>

            <button class="btn btn-primary w-100 mt-4" id="botao" type="submit">
                ALTERAR
            </button>

        </form>

    </div>
</section>
</main>

<script src="js/darkmode.js"></script>

</body>
</html>
