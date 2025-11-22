<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticar - Lootsy</title>

    
    <!--- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />

    <!---  CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/autenticar.css">
    <link rel="shortcut icon" href="assets/images/imagem_da_logo.png" type="image/x-icon">

    <!---  JS boostrap e Jquerry  -->

    <!--- Início do corpo da página -->
<body>
    <header class="cabecalho">
        <div class="icone">
        <a href="../index.php">
        <img src="assets/images/logo+nome.png" alt="Logo Lootsy" class="imagem-cabecalho"/>
        </a>
        </div>
    </header>
    
    <!--- Início do corpo principal -->
    <main>
    <section class="container d-flex justify-content-center">
        <div class="login">
            <div class="lootsy-body text-center">
                <img src="assets/images/segurança.png" alt="icone segurança"/>
            </div>

            <!--- Título do formulário de autenticação-->
            <h3 class="text-center">AUTENTICAÇÃO DE 2 FATORES</h3>

            <!--- Formulário de autenticação-->
            <div class="formulario">
            <form action="#" method="post">
            <label for="resposta" class="label-resposta">Qual o nome da sua mãe?</label>
            <input type="text" class="form-control" id="resposta" name="resposta" placeholder="Digite aqui sua resposta" required>
            </form>
            </div>
            
            <div class="button">
                <button class="btn btn-primary w-100" id="botao" type="button">ENVIAR</button>
            </div>
        </div>
    </section>
    </main>

    <!-- JS -->
    <script src="js/login.js"></script>
</body>
</html>

<!-- Final do código -->
