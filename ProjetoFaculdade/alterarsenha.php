<?php
session_start();
require("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$cpf = $_SESSION["usuario"]; // CPF

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $senha_atual    = $_POST['senha_atual']    ?? '';
    $nova_senha     = $_POST['nova_senha']     ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    // Busca SENHA HASH atual
    $sql = "SELECT senha FROM cadastro WHERE cpf = '$cpf'";
    $resultado = $conexao->query($sql);

    if (!$resultado || $resultado->num_rows == 0) {
        $mensagem = "Usuário não encontrado.";
    } else {

        $usuario = $resultado->fetch_assoc();
        $senha_hash_atual = $usuario['senha'];

        // VERIFICA SENHA CRIPTOGRAFADA
        if (!password_verify($senha_atual, $senha_hash_atual)) {
            $mensagem = "Senha atual incorreta.";
        
        }
        // CONFIRMAÇÃO
        elseif ($nova_senha !== $confirma_senha) {
            $mensagem = "A confirmação da senha não confere.";
        }
        else {
            // GERA NOVO HASH
            $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            //  ATUALIZA NO BANCO
            $sql_update = "UPDATE cadastro SET senha = '$novo_hash' WHERE cpf = '$cpf'";

            if ($conexao->query($sql_update)) {
                echo "<script>
                    alert('Senha alterada com sucesso!');
                    window.location.href = 'painel.php';
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
</header>

<main>
<section class="container d-flex justify-content-center">
    <div class="alterar">

        <div class="lootsy-body text-center">
            <a href="../home.php">
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
            <input type="password" name="senha_atual" class="form-control" required>

            <label class="mt-2">NOVA SENHA</label>
            <input type="password" name="nova_senha" class="form-control" required>

            <label class="mt-2">CONFIRMAR NOVA SENHA</label>
            <input type="password" name="confirma_senha" class="form-control" required>

            <button class="btn btn-primary w-100 mt-4" type="submit">
                ALTERAR
            </button>

        </form>

    </div>
</section>
</main>

</body>
</html>
