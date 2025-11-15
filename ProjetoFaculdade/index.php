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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  </head>
  <body>
    <?php include('navbar.php'); ?>
    <div class="container mt-3">
    <div class="input-group" style="max-width: 450px; margin: auto;">

        <!-- Ícone de lupa vindo do GitHub -->
        <span class="input-group-text" style="background: white; border-radius: 20px 0 0 20px;">
            <img src="https://raw.githubusercontent.com/mariarita207/Projeto-back-end/main/ProjetoFaculdade/assets/images/icons8-pesquisar-50.png" 
                 alt="lupa" 
                 style="width: 18px;">
        </span>

        <!-- Campo de pesquisa -->
        <input 
            type="text" 
            id="campoBusca" 
            class="form-control" 
            placeholder="Pesquisar usuário..."
            style="border-radius: 0 20px 20px 0; height: 45px;"
        >
    </div>
</div>


    <div class="container mt-4">
        <?php include('mensagem.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Usuários
                        <a href="usuario-create.php" class="btn btn-primary float-end">Adicionar usuário</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-strioed">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">NOME</th>
                                    <th class="text-center">EMAIL</th>
                                    <th class="text-center">DATA DE NASCIMENTO</th>
                                    <th class="text-center">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody id="resultado">
                                <?php 
                                $ordem = "";
                                if (isset($_GET['ordem']) && $_GET['ordem'] == "asc") {
                                $ordem = "ORDER BY nome ASC";
                                }

                                $sql = "SELECT * FROM cadastro $ordem";


                                $usuario = mysqli_query($conexao, $sql);
                                if (mysqli_num_rows($usuario) > 0) {
                                    foreach($usuario as $usuario) {
                                ?>
                                <tr>
                                    <td class="text-center"><?=$usuario['id_usuario']?></td>
                                    <td class="text-center"><?=$usuario['nome']?></td>
                                    <td class="text-center"><?=$usuario['email']?></td>
                                    <td class="text-center"><?=date('d/m/Y', strtotime($usuario['data_nascimento']))?></td>
                                    <td class="text-center">
                                        <a href="usuario-view.php?id_usuario=<?= $usuario['id_usuario'] ?>" class="btn btn-secondary btn-sm"><spam class="bi-eye-fill"></spam>&nbsp;Visualizar</a>
                                        <a href="usuario-edit.php?id_usuario=<?= $usuario['id_usuario'] ?>" class="btn btn-success btn-sm"><spam class="bi-pencil-fill"></spam>&nbsp;Editar</a>
                                        <form action="acoes.php" method="POST" class="d-inline">
                                            <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_usuario" value="<?= $usuario['id_usuario'] ?>" class="btn btn-danger btn-sm">
                                                <spam class="bi-trash3-fill"></spam>&nbsp;Excluir
                                            </button>
                                       </form>
                                    </td>
                                </tr>
                                <?php 
                                }
                            } else {
                                echo '<h5>Nenhum usuário encontrado</h5>';
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <script>
document.getElementById("campoBusca").addEventListener("keyup", function () {
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
</script>

  </body>
</html>
