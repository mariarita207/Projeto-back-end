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
                id="busca"
                name="busca"
                placeholder="Pesquisar por nome ou CPF..."
                value="<?= $_GET['busca'] ?? '' ?>"
            >
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
</div>

<script>
function updateQueryParam(key, value) {
  const url = new URL(window.location.href);
  if (value === '' || value === null) {
    url.searchParams.delete(key);
  } else {
    url.searchParams.set(key, value);
  }
  return url.toString();
}

document.addEventListener('click', function (e) {
  const el = e.target.closest && e.target.closest('[data-ordem]');
  if (!el) return;

  e.preventDefault();
  const ordem = el.getAttribute('data-ordem') || '';

  if (document.getElementById('conteudo-lista')) {
    const novaUrl = updateQueryParam('ordem', ordem);
    window.location.href = novaUrl;
    return;
  }

  const conteudoPrincipal = document.getElementById('conteudo-principal');
  const conteudoVisivel = conteudoPrincipal && conteudoPrincipal.innerHTML.trim();

  if (conteudoVisivel && conteudoVisivel.includes('Logs de Autenticação')) {
    const endpoint = 'historico-login.php';
    const params = new URLSearchParams();
    if (ordem) params.set('ordem', ordem);

    fetch(endpoint + '?' + params.toString())
      .then(r => r.text())
      .then(html => {
        conteudoPrincipal.innerHTML = html;
      })
      .catch(err => {
        console.error(err);
        alert('Erro ao atualizar o histórico.');
      });
    return;
  }

  window.location.href = updateQueryParam('ordem', ordem);
});
</script>


</body>
</html>
