<?php
session_start();
include("conexao.php");

// Se não veio do login.php com o CPF temporário, manda voltar
if (!isset($_SESSION['cpf_2fa'])) {
    header("Location: login.html");
    exit();
}

$cpf = preg_replace('/\D/', '', $_SESSION['cpf_2fa']);

// --- AQUI ESTÁ A CORREÇÃO ---
// Buscamos as respostas para o 2FA (nome_materno, data, cep)
// MAS TAMBÉM buscamos (id_usuario, nome, tipo) para criar a sessão depois.
$sql = $conexao->prepare("SELECT id_usuario, nome, tipo, nome_materno, data_nascimento, cep FROM cadastro WHERE cpf = ? LIMIT 1");
$sql->bind_param("s", $cpf);
$sql->execute();
$result = $sql->get_result();
$dados = $result ? $result->fetch_assoc() : null;
$sql->close();

if (!$dados) {
    header("Location: login.html");
    exit();
}

// Lista de perguntas (Conforme PDF: Mãe, Data, CEP)
$perguntas = [
    "nome_materno"    => "Qual o nome da sua mãe?",
    "data_nascimento" => "Qual sua data de nascimento?",
    "cep"             => "Qual seu CEP?"
];

// Inicializa o 2FA
if (!isset($_SESSION["perguntas_restantes"]) || !is_array($_SESSION["perguntas_restantes"]) || count($_SESSION["perguntas_restantes"]) === 0) {
    $_SESSION["perguntas_restantes"] = array_keys($perguntas);
    $_SESSION["tentativas"] = 0;
}

if (!isset($_SESSION["pergunta_atual"]) || !in_array($_SESSION["pergunta_atual"], $_SESSION["perguntas_restantes"])) {
    $keys = array_values($_SESSION["perguntas_restantes"]);
    $_SESSION["pergunta_atual"] = $keys[array_rand($keys)];
}

$campoPergunta = $_SESSION["pergunta_atual"];
$textoPergunta = $perguntas[$campoPergunta];
$erro = null;

// Processa a resposta
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $campo = $_POST["campo"] ?? '';
    $resposta = trim($_POST["resposta"] ?? '');
    $correta = $dados[$campo] ?? '';

    // Normalizações (CEP e Data)
    if ($campo === "cep") {
        $resposta = preg_replace('/\D/', '', $resposta);
        $correta = preg_replace('/\D/', '', $correta);
    }
    if ($campo === "data_nascimento") {
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $resposta)) {
            $partes = explode("/", $resposta);
            $resposta = "{$partes[2]}-{$partes[1]}-{$partes[0]}";
        }
    }

    $is_correct = (strcasecmp(trim((string)$resposta), trim((string)$correta)) === 0);

    // LOG (Requisito: Logar a pergunta feita e o status) [cite: 32]
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $perguntaTexto = $perguntas[$campo] ?? 'Pergunta 2FA';
    $status = $is_correct ? "sucesso" : "falha";

    $sqlLog = $conexao->prepare("INSERT INTO log (cpf, segunda_autenticacao, status, ip) VALUES (?, ?, ?, ?)");
    if ($sqlLog) {
        $sqlLog->bind_param("ssss", $cpf, $perguntaTexto, $status, $ip);
        $sqlLog->execute();
        $sqlLog->close();
    }

    // ======== SUCESSO ========
    if ($is_correct) {
        // Limpa variáveis de controle do 2FA
        unset($_SESSION["perguntas_restantes"], $_SESSION["tentativas"], $_SESSION["pergunta_atual"]);
        
        // Salva os dados que a Home precisa
        $_SESSION['id_usuario'] = $dados['id_usuario'];
        $_SESSION['nome']       = $dados['nome'];
        $_SESSION['tipo']       = $dados['tipo'];
        
        // Remove o CPF temporário
        unset($_SESSION["cpf_2fa"]); 

        // --- AQUI ENTRA O SEU CÓDIGO DE REDIRECIONAMENTO ---
        // Note que usamos $dados['tipo'] porque é assim que buscamos no banco neste arquivo
        if ($dados['tipo'] === 'master') {
            header("Location: crud.php");
            exit();
        } else {
            header("Location: home.php");
            exit();
        }
        // ----------------------------------------------------
    }

    // ======== FALHA ========
    $_SESSION["tentativas"]++;

    // Se errar 3 vezes (Requisito: mensagem e voltar ao login) 
    if ($_SESSION["tentativas"] >= 3) {
        unset($_SESSION["perguntas_restantes"], $_SESSION["tentativas"], $_SESSION["pergunta_atual"], $_SESSION["cpf_2fa"]);
        echo "<script>alert('3 tentativas sem sucesso! Favor realizar Login novamente.'); window.location.href='login.html';</script>";
        exit();
    }

    // Remove a pergunta atual para não repetir e sorteia outra
    if (($key = array_search($campo, $_SESSION["perguntas_restantes"])) !== false) {
        unset($_SESSION["perguntas_restantes"][$key]);
        $_SESSION["perguntas_restantes"] = array_values($_SESSION["perguntas_restantes"]);
    }
    unset($_SESSION["pergunta_atual"]);
    $erro = "Resposta incorreta! Tente outra pergunta.";
    
    // Sorteia nova pergunta
    if (!empty($_SESSION["perguntas_restantes"])) {
        $keys = array_values($_SESSION["perguntas_restantes"]);
        $_SESSION["pergunta_atual"] = $keys[array_rand($keys)];
        $campoPergunta = $_SESSION["pergunta_atual"];
        $textoPergunta = $perguntas[$campoPergunta];
    } else {
        header("Location: login.html");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Autenticação de 2 Fatores</title>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/autenticar.css">

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
        <a href="home.php">
            <img src="assets/images/logo+nome.png" class="imagem-cabecalho">
        </a>
    </div>

<div class="trilho" id="trilho">
          <div class="indicador"></div>
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

<script src="js/darkmode.js"></script>

</body>
</html>


