<?php
session_start();
include("conexao.php");

// Se o usuário não passou pelo login:
if (!isset($_SESSION['cpf_2fa'])) {
    header("Location: login.php");
    exit();
}

$cpf = $_SESSION['cpf_2fa'];

// Carrega dados do usuário
$sql = $conexao->prepare("SELECT nome_materno, data_nascimento, cep FROM cadastro WHERE cpf = ?");
$sql->bind_param("s", $cpf);
$sql->execute();
$dados = $sql->get_result()->fetch_assoc();

// Lista de perguntas
$perguntas = [
    "nome_materno"    => "Qual o nome da sua mãe?",
    "data_nascimento" => "Qual sua data de nascimento?",
    "cep"             => "Qual seu CEP?"
];

// ======== INICIALIZA O 2FA ========

if (!isset($_SESSION["perguntas_restantes"])) {
    $_SESSION["perguntas_restantes"] = array_keys($perguntas);
    $_SESSION["tentativas"] = 0;
}

if (!isset($_SESSION["pergunta_atual"])) {
    $_SESSION["pergunta_atual"] = $_SESSION["perguntas_restantes"][array_rand($_SESSION["perguntas_restantes"])];
}

$campoPergunta = $_SESSION["pergunta_atual"];
$textoPergunta = $perguntas[$campoPergunta];
$erro = null;

// ======== FORMULÁRIO ENVIADO ========

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $campo = $_POST["campo"];
    $resposta = trim($_POST["resposta"]);
    $correta = $dados[$campo];

    // Normaliza CEP
    if ($campo === "cep") {
        $resposta = preg_replace('/\D/', '', $resposta);
        $correta = preg_replace('/\D/', '', $correta);
    }

    // Normaliza data dd/mm/aaaa → aaaa-mm-dd
    if ($campo === "data_nascimento") {
        $partes = explode("/", $resposta);
        if (count($partes) === 3) {
            $resposta = "{$partes[2]}-{$partes[1]}-{$partes[0]}";
        }
    }

    // Verifica resposta
    $is_correct = (strcasecmp($resposta, $correta) === 0);

    // Prepara dados para log
    $ip = $_SERVER['REMOTE_ADDR'];
    $perguntaTexto = $perguntas[$campo];
    $status = $is_correct ? "sucesso" : "falha";

    // --- SALVA LOG ---
$sqlLog = $conexao->prepare("
    INSERT INTO log (cpf, segunda_autenticacao, status, ip)
    VALUES (?, ?, ?, ?)
");
$sqlLog->bind_param("ssss", $cpf, $perguntaTexto, $status, $ip);
$sqlLog->execute();


    // ======== SUCESSO ========
    if ($is_correct) {

        unset($_SESSION["perguntas_restantes"], $_SESSION["tentativas"], $_SESSION["pergunta_atual"]);

        $_SESSION["usuario"] = $cpf; // sessão principal

        unset($_SESSION["cpf_2fa"]); // remove sessão temporária

        header("Location: painel.php");
        exit();
    }

    // ======== FALHA ========
    $_SESSION["tentativas"]++;

    // Remove pergunta atual da lista
    $key = array_search($campo, $_SESSION["perguntas_restantes"]);
    if ($key !== false) {
        unset($_SESSION["perguntas_restantes"][$key]);
    }

    unset($_SESSION["pergunta_atual"]);

    // Três erros → bloqueia
    if ($_SESSION["tentativas"] >= 3) {
        unset($_SESSION["perguntas_restantes"], $_SESSION["tentativas"], $_SESSION["pergunta_atual"]);
        header("Location: cadastro.php");
        exit();
    }

    $erro = "Resposta incorreta! Tente outra pergunta.";

    // Nova pergunta
    $_SESSION["pergunta_atual"] = $_SESSION["perguntas_restantes"][array_rand($_SESSION["perguntas_restantes"])];
    $campoPergunta = $_SESSION["pergunta_atual"];
    $textoPergunta = $perguntas[$campoPergunta];
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Autenticação de 2 Fatores</title>

    <link rel="stylesheet" href="styles/autenticar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script>
        // === Máscara de Data (DD/MM/AAAA) ===
        function mascaraData(input) {
            let v = input.value.replace(/\D/g, "");

            if (v.length >= 2) v = v.slice(0, 2) + "/" + v.slice(2);
            if (v.length >= 5) v = v.slice(0, 5) + "/" + v.slice(5, 10);

            input.value = v;
        }
    </script>
</head>

<body>

<header class="cabecalho">
    <div class="icone">
        <a href="../home.php">
            <img src="assets/images/logo+nome.png" class="imagem-cabecalho">
        </a>
    </div>
</header>

<main>
<section class="container d-flex justify-content-center">
    <div class="login">

        <div class="lootsy-body text-center">
            <img src="assets/images/segurança.png" alt="icone segurança"/>
        </div>

        <h3 class="text-center">AUTENTICAÇÃO DE 2 FATORES</h3>

        <p><strong>Pergunta:</strong> <?= $textoPergunta ?></p>

        <?php if ($erro): ?>
            <p style="color: red;"><?= $erro ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="campo" value="<?= $campoPergunta ?>">

            <input 
                type="text" 
                class="form-control" 
                name="resposta" 
                placeholder="Digite aqui sua resposta"
                required
                <?php if ($campoPergunta === "data_nascimento") echo 'oninput="mascaraData(this)" maxlength="10"'; ?>
            >

            <div class="button mt-3">
                <button class="btn btn-primary w-100" type="submit">ENVIAR</button>
            </div>
        </form>

    </div>
</section>
</main>

</body>
</html>
