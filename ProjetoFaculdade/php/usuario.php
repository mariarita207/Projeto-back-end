<?php
include_once("conexao.php");

// Verifica se há busca
$busca = "";
if (isset($_GET['busca'])) {
  $busca = trim($_GET['busca']);
}

// Se tiver texto de busca, filtra; senão, mostra tudo
if ($busca != "") {
  $sql = "SELECT * FROM cadastro 
          WHERE nome LIKE '%$busca%' 
          OR logins LIKE '%$busca%' 
          OR email LIKE '%$busca%' 
          ORDER BY nome ASC";
} else {
  $sql = "SELECT * FROM cadastro ORDER BY nome ASC";
}

$resultado = $conexao->query($sql);

// Excluir usuário
if (isset($_GET['excluir'])) {
  $id = intval($_GET['excluir']);
  $conexao->query("DELETE FROM cadastro WHERE id_usuario = $id");
  header("Location: usuario.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Usuário</title>
  <link rel="stylesheet" href="../styles/usuario.css">
</head>
<body>

  <!-- TOPO -->
  <header class="topo">
    <div class="logo">
        <img src="../assets/images/logo+nome.png" alt="Logo">
    </div>
    <div class="usuario">
        <img src="../assets/images/login-icone.png" alt="Icone usuario" class="icone-usuario">
        Olá, usuário!
    </div>
  </header>

  <!-- BUSCA -->
  <section class="segundo-retangulo">
    <h2>CONSULTAR USUÁRIO</h2>
    <form method="GET" action="usuario.php">
      <div class="input-container">
        <img src="../assets/images/icons8-pesquisar-50.png" alt="buscar" class="icone-lupa">
        <input type="text" name="busca" placeholder="Buscar..." value="<?php echo htmlspecialchars($busca); ?>">
      </div>
    </form>
  </section>

  <!-- LISTA -->
  <section class="terceiro-retangulo">
    <h4>Lista de usuários</h4>
  </section>
  <hr class="linha">

  <!-- TABELA -->
  <section class="quarto-retangulo">
  <div class="retangulo-menor">
    <table>
      <thead>
        <tr>
          <th class="col-nome">Nome</th>
          <th class="col-usuario">Nome de Usuário</th>
          <th class="col-cpf">CPF</th>
          <th class="col-email">E-mail</th>
          <th class="col-acoes">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($resultado->num_rows > 0) {
          while ($linha = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['logins']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['cpf']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
            echo "<td>
              <a href='usuario.php?excluir=" . $linha['id_usuario'] . "' onclick='return confirmarExclusao()'>
                <img src=\"../assets/images/icons8-delete-50.png\" alt=\"excluir\" class=\"icone-tabela\">
              </a>
            </td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5' style='text-align:center;'>Nenhum usuário encontrado.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="info-usuarios">
    <?php echo $resultado->num_rows; ?> usuários
  </div>

  <div class="info-paginacao">
    <div class="paginacao">
      <a href="#">Anterior</a>
      <a href="#" class="ativo">1</a>
      <a href="#">Próximo</a>
    </div>
  </div>

  <div class="linha-container">
    <div class="dropdown">
      Todos
      <div class="dropdown-content">
        <a href="#">Todos</a>
        <a href="#">Ordem alfabética</a>
      </div>
    </div>
  </div>
</section>

<script>
function confirmarExclusao() {
  return confirm("Tem certeza que deseja excluir este usuário?");
}
</script>

</body>
</html>
