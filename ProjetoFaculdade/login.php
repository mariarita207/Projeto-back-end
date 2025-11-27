<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); window.location.href='login.html';</script>";
        exit();
    }

    $sql = "SELECT id_usuario, nome, email, senha, tipo, cpf FROM cadastro WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $usuario = mysqli_fetch_assoc($resultado);

        // VERIFICA A SENHA
        if (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha']) {
            
            // --- ALTERAÇÃO PARA 2FA ---
            
            // 1. Não definimos $_SESSION['id_usuario'] ainda.
            // 2. Definimos apenas o CPF temporário para o 2FA saber quem é.
            $_SESSION['cpf_2fa'] = $usuario['cpf'];

            // 3. Redirecionamos para a tela de perguntas
            header("Location: autenticar.php");
            exit();

        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href='login.html';</script>";
        }

    } else {
        echo "<script>alert('Utilizador não encontrado!'); window.location.href='login.html';</script>";
    }

} else {
    header("Location: login.html");
    exit();
}
?>





            
            
