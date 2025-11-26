<?php
session_start();
include("conexao.php");

// FILTRO DE BUSCA
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : "";

// CONSULTA USANDO A TABELA CORRETA: log
$sql = "
    SELECT 
        l.id_log,
        l.cpf,
        c.nome AS nome_usuario,
        l.segunda_autenticacao,
        l.status,
        l.ip,
        l.data_login
    FROM log l
    LEFT JOIN cadastro c ON c.cpf = l.cpf
";

if (!empty($busca)) {
    $sql .= " WHERE c.nome LIKE '%$busca%' OR l.cpf LIKE '%$busca%'";
}

$sql .= " ORDER BY l.data_login DESC";

$logs = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Logs de Autenticação</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="styles/historico-login.css">

<style>
/* impede barra horizontal */
body { overflow-x: hidden; }

/* === MENU LATERAL === */
.sidebar {
    width: 240px;
    height: calc(100vh - 70px);
    background-color: #392666;
    position: fixed;
    top: 55px;
    left: 0;
    overflow-y: auto;
    padding-top: 20px;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.main-content { margin-left: 260px; padding: 20px; }

/* CAMPO DE BUSCA */
.search-box {
    background: #ffffff;
    border-radius: 40px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    width: 350px;
    border: 1px solid #ccc;
    margin: 20px auto; /* CENTRALIZA */
}

.search-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 16px;
    background: transparent;
}
</style>
</head>

<body>

<?php include('navbar.php'); ?>

<!-- MENU LATERAL -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" id="adminFoto" class="sidebar-foto">
        <h3>Administrador</h3>
    </div>

    <ul class="sidebar-menu">
        <li><a href="crud.php">Consultar Usuários</a></li>
        <li><a href="historico-login.php">Histórico de Login</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>

    <div class="sidebar-footer">
        <input type="file" id="fotoInput" accept="image/*" style="display:none;">
        <button class="trocarFotoBtn" onclick="document.getElementById('fotoInput').click();">
            Trocar foto
        </button>
    </div>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main-content">

    <div class="container mt-5">
        <h2 class="mb-4">🔐 Logs de Autenticação 2FA</h2>

        <!-- CAMPO DE BUSCA-->
        <form method="GET" class="search-box" onsubmit="return false;">
            <i class="bi bi-search"></i>
            <input type="text" id="busca" name="busca" placeholder="Pesquisar por nome ou CPF..." value="<?php echo $_GET['busca'] ?? ''; ?>">
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Pergunta</th>
                    <th>Status</th>
                    <th>IP</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody id="tabelaLogs">
                <?php while ($row = $logs->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_log'] ?></td>
                    <td><?= $row['cpf'] ?></td>
                    <td><?= $row['nome_usuario'] ?? '<i>Não encontrado</i>' ?></td>
                    <td><?= $row['segunda_autenticacao'] ?></td>

                    <td>
                        <?php if ($row['status'] === "sucesso"): ?>
                            <span class="badge bg-success">Sucesso</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Falha</span>
                        <?php endif; ?>
                    </td>

                    <td><?= $row['ip'] ?></td>
                    <td><?= $row['data_login'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// === BUSCA AJAX SEM PERDER FOCO ===
document.getElementById("busca").addEventListener("input", function () {
    let termo = this.value;

    fetch("historico-login.php?busca=" + termo)
        .then(r => r.text())
        .then(html => {

            // pegar apenas a tabela atualizada
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, "text/html");

            let novasLinhas = doc.querySelector("#tabelaLogs").innerHTML;

            document.getElementById("tabelaLogs").innerHTML = novasLinhas;
        });
});
</script>

</body>
</html>


