
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

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            // SALVAR LOG DE LOGIN NORMAL
            $cpf = $usuario['cpf'];                       // vem do cadastro
            $pergunta = "Login normal (sem 2FA)";
            $status = "sucesso";
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

            $sqlLog = $conexao->prepare(
                "INSERT INTO log (cpf, segunda_autenticacao, status, ip)
                 VALUES (?, ?, ?, ?)"
            );

            if ($sqlLog) {
                $sqlLog->bind_param("ssss", $cpf, $pergunta, $status, $ip);
                $sqlLog->execute();
                $sqlLog->close();
            }
            // ================================

            // REDIRECIONA
            if ($usuario['tipo'] === 'master') {
                header("Location: index.php");
                exit();
            } else {
                header("Location: home.php");
                exit();
            }

        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href='login.html';</script>";
        }

    } else {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='login.html';</script>";
    }

} else {
    header("Location: login.html");
    exit();
}
?>





            
            
