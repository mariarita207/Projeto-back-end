<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - Lootsy</title>

    
    <!--- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />

    <!---  CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/alterarsenha.css">
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
        <div class="alterar">
            <div class="lootsy-body text-center">
                <a href="../index.php">
                <img src="assets/images/logo+nome.png" alt="ícone da plataforma Lootsy"/>
                </a>
            </div>

            <!--- Título do formulário de alterar senha-->
            <h3 class="text-center">ALTERAR SENHA</h3>

            <!--- Formulário de alterar senha -->
            <div class="formulario">
                <label for="senha-atual" class="label-senha-atual">SENHA ATUAL</label>
                <input type="password" class="form-control" name="senha-atual" id="senha-atual" required>
                <label for="nova-senha" class="label-nova-senha">NOVA SENHA</label>
                <input type="password" class="form-control" name="nova-senha" id="nova-senha" required>
                <label for="confirmar-nova-senha" class="label-confirmar-nova-senha">CONFIRMAR NOVA SENHA</label>
                <input type="password" class="form-control" name="confirmar-nova-senha" id="confirmar-nova-senha" required>
            </div>
            <div class="button">
                <button class="btn btn-primary w-100" id="botao" type="button">ALTERAR</button>
            </div>
        </div>
    </section>
    </main>

    <!-- JS -->
    <script src="js/login.js"></script>
</body>
</html>
<!-- Final do código -->

