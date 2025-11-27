<?php
session_start();
include("conexao.php");

// FILTRO DE BUSCA
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : "";

// FILTRO DE ORDEM (padrão: data mais recente)
$ordemSQL = " ORDER BY l.data_login DESC";

if (isset($_GET['ordem'])) {
    if ($_GET['ordem'] === "asc") {
        $ordemSQL = " ORDER BY c.nome ASC";
    } elseif ($_GET['ordem'] === "desc") {
        $ordemSQL = " ORDER BY c.nome DESC";
    }
}

// CONSULTA
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

// APLICA A ORDEM ESCOLHIDA
$sql .= $ordemSQL;

$logs = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Logs de Autenticação</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { overflow-x: hidden; }

.search-box {
    background: #ffffff;
    border-radius: 40px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    max-width: 400px;
    border: 1px solid #ccc;
    margin: 20px auto;
}

.search-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 16px;
    background: transparent;
}

.historico-wrapper {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}
</style>
</head>

<body>

<div class="historico-wrapper">
    <div class="container mt-5">
        <h2 class="mb-4">🔐 Logs de Autenticação 2FA</h2>

        <!-- CAMPO DE BUSCA -->
        <form method="GET" class="search-box">
            <i class="bi bi-search"></i>
            <input 
                type="text"
                name="busca"
                placeholder="Pesquisar por nome ou CPF..."
                value="<?= $_GET['busca'] ?? '' ?>"
            >
        </form>

        <!-- FILTRO DE ORDENAÇÃO -->
        <form method="GET" class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <!-- mantém a busca ao mudar a ordem -->
            <input type="hidden" name="busca" value="<?= $_GET['busca'] ?? '' ?>">

            <div>
                <label class="fw-semibold me-2">Ordenar por nome:</label>
                <select 
                    name="ordem" 
                    class="form-select d-inline-block w-auto"
                    onchange="this.form.submit()"
                >
                    <option value="">Mais recentes</option>
                    <option value="asc"  <?= (($_GET['ordem'] ?? '') === 'asc')  ? 'selected' : '' ?>>A → Z</option>
                    <option value="desc" <?= (($_GET['ordem'] ?? '') === 'desc') ? 'selected' : '' ?>>Z → A</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Pergunta 2FA</th>
                        <th>Status</th>
                        <th>IP</th>
                        <th>Data/Hora</th>
                    </tr>
                </thead>
                <tbody>
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
</div>

</body>
</html>
