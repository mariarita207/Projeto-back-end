<?php
session_start();
include("conexao.php");

// debug temporário (remova em produção se quiser)
// ini_set('display_errors', 1); error_reporting(E_ALL);

// Se o usuário não passou pelo login:
if (!isset($_SESSION['cpf_2fa'])) {
    header("Location: login.php");
    exit();
}

// normaliza cpf: só números
$cpf = preg_replace('/\D/', '', $_SESSION['cpf_2fa']);

// Carrega dados do usuário (prepared)
$sql = $conexao->prepare("SELECT nome_materno, data_nascimento, cep FROM cadastro WHERE cpf = ? LIMIT 1");
if (!$sql) {
    error_log("ERRO prepare SELECT cadastro: " . mysqli_error($conexao));
    // redireciona por segurança
    header("Location: login.php");
    exit();
}
$sql->bind_param("s", $cpf);
$sql->execute();
$result = $sql->get_result();
$dados = $result ? $result->fetch_assoc() : null;
$sql->close();

if (!$dados) {
    // usuário não encontrado — volta ao login
    error_log("2FA: cadastro não encontrado para cpf={$cpf}");
    header("Location: login.php");
    exit();
}

// Lista de perguntas
$perguntas = [
    "nome_materno"    => "Qual o nome da sua mãe?",
    "data_nascimento" => "Qual sua data de nascimento?",
    "cep"             => "Qual seu CEP?"
];

// ======== INICIALIZA O 2FA ========
if (!isset($_SESSION["perguntas_restantes"]) || !is_array($_SESSION["perguntas_restantes"]) || count($_SESSION["perguntas_restantes"]) === 0) {
    $_SESSION["perguntas_restantes"] = array_keys($perguntas);
    $_SESSION["tentativas"] = 0;
}

if (!isset($_SESSION["pergunta_atual"]) || !in_array($_SESSION["pergunta_atual"], $_SESSION["perguntas_restantes"])) {
    // sorteia de forma segura
    $keys = array_values($_SESSION["perguntas_restantes"]);
    $_SESSION["pergunta_atual"] = $keys[array_rand($keys)];
}

$campoPergunta = $_SESSION["pergunta_atual"];
$textoPergunta = $perguntas[$campoPergunta];
$erro = null;

// ======== FORMULÁRIO ENVIADO ========
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $campo = $_POST["campo"] ?? '';
    $resposta = trim($_POST["resposta"] ?? '');
    $correta = $dados[$campo] ?? '';

    // Normaliza CEP
    if ($campo === "cep") {
        $resposta = preg_replace('/\D/', '', $resposta);
        $correta = preg_replace('/\D/', '', $correta);
    }

    // Normaliza data dd/mm/aaaa → aaaa-mm-dd (aceita tanto 01/01/1990 quanto 1990-01-01)
    if ($campo === "data_nascimento") {
        // se respondeu no formato d/m/a converte
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $resposta)) {
            $partes = explode("/", $resposta);
            $resposta = "{$partes[2]}-{$partes[1]}-{$partes[0]}";
        }
        // normaliza a correta também (caso venha com /)
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $correta)) {
            $p = explode("/", $correta);
            $correta = "{$p[2]}-{$p[1]}-{$p[0]}";
        }
    }

    // Verifica resposta (comparação segura)
    $is_correct = (strcasecmp(trim((string)$resposta), trim((string)$correta)) === 0);

    // Prepara dados para log
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $perguntaTexto = $perguntas[$campo] ?? 'Pergunta 2FA';
    $status = $is_correct ? "sucesso" : "falha";

    // --- SALVA LOG (com checagem) ---
    $sqlLog = $conexao->prepare("INSERT INTO log (cpf, segunda_autenticacao, status, ip) VALUES (?, ?, ?, ?)");
    if ($sqlLog) {
        $sqlLog->bind_param("ssss", $cpf, $perguntaTexto, $status, $ip);
        $executou = $sqlLog->execute();
        if (!$executou) {
            error_log("ERRO ao inserir log: " . $sqlLog->error);
        } else {
            // opcional: debug
            // error_log("LOG inserido: cpf={$cpf} status={$status}");
        }
        $sqlLog->close();
    } else {
        error_log("ERRO prepare INSERT log: " . mysqli_error($conexao));
    }

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

    // Remove pergunta atual da lista (se existir)
    if (($key = array_search($campo, $_SESSION["perguntas_restantes"])) !== false) {
        unset($_SESSION["perguntas_restantes"][$key]);
        $_SESSION["perguntas_restantes"] = array_values($_SESSION["perguntas_restantes"]); // reindex
    }

    unset($_SESSION["pergunta_atual"]);

    // Três erros → bloqueia (ou redireciona)
    if ($_SESSION["tentativas"] >= 3) {
        unset($_SESSION["perguntas_restantes"], $_SESSION["tentativas"], $_SESSION["pergunta_atual"]);
        header("Location: cadastro.php");
        exit();
    }

    $erro = "Resposta incorreta! Tente outra pergunta.";

    // Nova pergunta - se houver perguntas restantes
    if (!empty($_SESSION["perguntas_restantes"])) {
        $keys = array_values($_SESSION["perguntas_restantes"]);
        $_SESSION["pergunta_atual"] = $keys[array_rand($keys)];
        $campoPergunta = $_SESSION["pergunta_atual"];
        $textoPergunta = $perguntas[$campoPergunta];
    } else {
        // sem perguntas restantes — força bloqueio
        header("Location: cadastro.php");
        exit();
    }
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

        <p><strong>Pergunta:</strong> <?= htmlspecialchars($textoPergunta) ?></p>

        <?php if ($erro): ?>
            <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="campo" value="<?= htmlspecialchars($campoPergunta) ?>">

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


