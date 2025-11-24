<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lootsy</title>
    <meta name="description" content="Faça login na plataforma Lootsy para acessar suas funcionalidades e lootear seus futuros jogos!">
    
    <!--- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />

    <!---  CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="shortcut icon" href="assets/images/imagem_da_logo.png" type="image/x-icon">

    <!---  JS boostrap e Jquerry  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

    <!--- Início do corpo da página -->
<body>
    <header class="cabecalho">
        <div class="icone">
       <a href="../index.html">
        <img src="assets/images/logo+nome.png" alt="Lootsy">
       </a>
    </div>
     
      <div class="trilho" id="trilho">
          <div class="indicador"></div>
   </div>

    </header>
    
    <!--- Início do corpo principal -->
    <main>
    <section class="container d-flex justify-content-center">
        <div class="login">
            <div class="lootsy-body">
                <a href="../index.html">
        <img src="assets/images/logo+nome.png" alt="Lootsy">
       </a>
            </div>

            <!--- Título do formulário de login -->
            <h3 class="text-center">LOGIN</h3>

<form action="login.php" method="POST" class="formulario">
    <label for="email" class="label-email">E-MAIL</label>
    <input type="email" class="form-control" name="email" id="email" required>

    <label for="senha" class="label-senha">SENHA</label>
    <input type="password" class="form-control" name="senha" id="senha" required>

    <div class="text-center my-2" id="mensagem-login"></div>

    <div class="button d-flex gap-2 px-3 mt-3">
        <button class="btn btn-primary w-50" id="botao" type="submit">ENTRAR</button>
        <button class="btn btn-primary w-50" id="limpar" type="reset">LIMPAR</button>
    </div>
</form>

            <p>NOVO POR AQUI? <a href="cadastro.php" class="cadastro">CADASTRE-SE</a></p>
            
    </section>
    </main>

    <!-- JS -->
    <script src="js/login.js"></script>
    <script src="js/darkmode.js"></script>


    
</body>
</html>
<!-- Final do código -->

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

    $sql = "SELECT id_usuario, nome, email, senha, tipo FROM cadastro WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $usuario = mysqli_fetch_assoc($resultado);

        // VERIFICA SE A SENHA ESTÁ HASH OU TEXTO PURO
        if (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha']) {

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            // REDIRECIONA CONFORME TIPO
            if ($usuario['tipo'] === 'master') {
                header("Location: index.php");
                exit();
            } else {
                header("Location: ../index.html");
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



            
            
