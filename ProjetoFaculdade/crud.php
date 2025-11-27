<?php 
session_start();
include 'conexao.php';
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuários</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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
    padding-top: 50px;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
}
@media (max-width: 992px) { .sidebar { width: 200px; } .main-content { margin-left: 210px; } }
@media (max-width: 768px) { .sidebar { width: 180px; } .main-content { margin-left: 190px; } }

.sidebar-header { text-align: center; margin-bottom: 20px; }
.sidebar-foto {
    width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid white; margin-bottom: 10px;
}
.sidebar-menu { list-style: none; padding: 0; width: 100%; }
.sidebar-menu li a {
    display: block; padding: 12px 25px; color: white; text-decoration: none;
}
.sidebar-menu li a:hover { background-color: rgba(255, 255, 255, 0.2); }
.sidebar-footer { margin-top: auto; padding: 20px; }
.trocarFotoBtn {
    background: white; border: none; padding: 8px 15px; border-radius: 6px;
    color: #000000ff; cursor: pointer; font-weight: bold;
}

/* === CONTEÚDO PRINCIPAL === */
.main-content { margin-left: 260px; padding: 20px; }
.table-responsive { overflow-x: auto !important; white-space: nowrap; }
.card { max-width: 1000px; margin: auto; }
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
        <li><a href="#" data-target="conteudo-lista">Consultar Usuários</a></li>
        <li><a href="#" data-target="historico-login.php">Histórico de Login</a></li>
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
<div class="main-content" id="conteudo-principal">

    <!-- DIV ORIGINAL DA LISTA DE USUÁRIOS -->
    <div id="conteudo-lista">
        <!-- Campo de busca -->
        <div class="container mt-3">
            <div class="input-group" style="max-width: 450px; margin: auto;">
                <span class="input-group-text" style="background: white; border-radius: 20px 0 0 20px;">
                    <img src="https://raw.githubusercontent.com/mariarita207/Projeto-back-end/main/ProjetoFaculdade/assets/images/icons8-pesquisar-50.png" 
                         alt="lupa" style="width: 18px;">
                </span>
                <input type="text" id="campoBusca" class="form-control" placeholder="Pesquisar usuário..."
                       style="border-radius: 0 20px 20px 0; height: 45px;">
            </div>
        </div>

        <!-- Lista de usuários -->
        <div class="container mt-4">
            <?php include('mensagem.php'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Lista de Usuários
                                <a href="usuario-create.php" class="btn btn-primary float-end">Adicionar usuário</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">NOME</th>
                                            <th class="text-center">E-MAIL</th>
                                            <th class="text-center">DATA DE NASCIMENTO</th>
                                            <th class="text-center">AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="resultado">
                                    <?php 
                                        $ordem = "";
                                        if (isset($_GET['ordem']) && $_GET['ordem'] == "asc") $ordem = "ORDER BY nome ASC";
                                        $sql = "SELECT * FROM cadastro $ordem";
                                        $usuario = mysqli_query($conexao, $sql);
                                        if (mysqli_num_rows($usuario) > 0) {
                                            foreach($usuario as $usuario) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $usuario['id_usuario'] ?></td>
                                            <td class="text-center"><?= $usuario['nome'] ?></td>
                                            <td class="text-center"><?= $usuario['email'] ?></td>
                                            <td class="text-center"><?= date('d/m/Y', strtotime($usuario['data_nascimento'])) ?></td>
                                            <td class="text-center">
                                                <a href="usuario-view.php?id_usuario=<?= $usuario['id_usuario'] ?>" class="btn btn-secondary btn-sm">
                                                    <span class="bi-eye-fill"></span>&nbsp;Visualizar
                                                </a>
                                                <a href="usuario-edit.php?id_usuario=<?= $usuario['id_usuario'] ?>" class="btn btn-success btn-sm">
                                                    <span class="bi-pencil-fill"></span>&nbsp;Editar
                                                </a>
                                                <form action="acoes.php" method="POST" class="d-inline">
                                                    <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_usuario" value="<?= $usuario['id_usuario'] ?>" class="btn btn-danger btn-sm">
                                                        <span class="bi-trash3-fill"></span>&nbsp;Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>Nenhum usuário encontrado</td></tr>";
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- fim conteudo-lista -->

</div> <!-- fim main-content -->

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
// FOTO DO ADMIN SALVA NO LOCALSTORAGE
const fotoInput = document.getElementById('fotoInput');
const fotoPerfil = document.getElementById('adminFoto');
document.addEventListener('DOMContentLoaded', () => {
  const imgSalva = localStorage.getItem('fotoAdmin');
  if (imgSalva) fotoPerfil.src = imgSalva;
});
fotoInput.addEventListener('change', (e) => {
  const arquivo = e.target.files[0];
  if (arquivo) {
    const leitor = new FileReader();
    leitor.onload = () => {
      fotoPerfil.src = leitor.result;
      localStorage.setItem('fotoAdmin', leitor.result);
    };
    leitor.readAsDataURL(arquivo);
  }
});

// BARRA DE PESQUISA
document.getElementById("campoBusca")?.addEventListener("keyup", function () {
    let termo = this.value;
    fetch("buscar.php?termo=" + termo)
        .then(response => response.json())
        .then(dados => {
            let html = "";
            if (dados.length === 0) {
                html = "<tr><td colspan='5' class='text-center'>Nenhum usuário encontrado</td></tr>";
            } else {
                dados.forEach(u => {
                    html += `
                        <tr>
                            <td class="text-center">${u.id_usuario}</td>
                            <td class="text-center">${u.nome}</td>
                            <td class="text-center">${u.email}</td>
                            <td class="text-center">${new Date(u.data_nascimento).toLocaleDateString("pt-BR")}</td>
                            <td class="text-center">
                                <a href="usuario-view.php?id_usuario=${u.id_usuario}" class="btn btn-secondary btn-sm">
                                    <span class="bi-eye-fill"></span>&nbsp;Visualizar
                                </a>
                                <a href="usuario-edit.php?id_usuario=${u.id_usuario}" class="btn btn-success btn-sm">
                                    <span class="bi-pencil-fill"></span>&nbsp;Editar
                                </a>
                                <form action="acoes.php" method="POST" class="d-inline">
                                    <button onclick="return confirm('Tem certeza que deseja excluir?')" 
                                        type="submit" name="delete_usuario" value="${u.id_usuario}" 
                                        class="btn btn-danger btn-sm">
                                        <span class="bi-trash3-fill"></span>&nbsp;Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `;
                });
            }
            document.getElementById("resultado").innerHTML = html;
        });
});

// SIDEBAR - CONTEÚDO DINÂMICO
const linksSidebar = document.querySelectorAll('.sidebar-menu li a');
const conteudoPrincipal = document.getElementById('conteudo-principal');
const conteudoListaOriginal = document.getElementById('conteudo-lista').innerHTML;

linksSidebar.forEach(link => {
    link.addEventListener('click', function(e) {
        
        // Se for o botão de sair, deixa o navegador seguir o link normalmente
        if (this.getAttribute('href') === "logout.php") {
            return;
        }

        e.preventDefault();


        const target = this.getAttribute('data-target');

        if (target === 'conteudo-lista') {
            conteudoPrincipal.innerHTML = conteudoListaOriginal;
        } else {
            fetch(target)
                .then(res => res.text())
                .then(html => {
                    conteudoPrincipal.innerHTML = html;
                })
                .catch(err => {
                    conteudoPrincipal.innerHTML = '<p>Erro ao carregar o conteúdo.</p>';
                    console.error(err);
                });
        }
    });
});
</script>

<script>
/*
  Delegation: escuta INPUTs com id="busca" mesmo que o elemento
  seja inserido dinamicamente via innerHTML (fetch).
*/
document.addEventListener('input', function (e) {
  if (!e.target) return;
  if (e.target.id !== 'busca') return; // só responde ao campo #busca

  const termo = e.target.value || '';

  // Busca o HTML do histórico (mesmo endpoint que você já usa para incluir a página)
  fetch('historico-login.php?busca=' + encodeURIComponent(termo))
    .then(resp => {
      if (!resp.ok) throw new Error('Erro na requisição');
      return resp.text();
    })
    .then(html => {
      // Pega só a parte #tabelaLogs do HTML retornado
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const novasTbody = doc.querySelector('#tabelaLogs');

      if (novasTbody) {
        const tbodyAtual = document.querySelector('#tabelaLogs');
        if (tbodyAtual) {
          tbodyAtual.innerHTML = novasTbody.innerHTML;
        } else {
          // caso a tabela ainda não exista (por algum motivo), tenta recarregar o conteúdo completo
          const conteudoPrincipal = document.getElementById('conteudo-principal');
          if (conteudoPrincipal) conteudoPrincipal.innerHTML = html;
        }
      } else {
        console.warn('Resposta veio sem #tabelaLogs. Conteúdo retornado:', html);
      }
    })
    .catch(err => {
      console.error('Erro no fetch da busca:', err);
    });
});
</script>

</body>
</html>

