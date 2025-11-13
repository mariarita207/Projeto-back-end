<?php 
session_start();
include('conexao.php');
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <?php include("navbar.php"); ?>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Usuários
                        <a href="usuario-create.php" class="btn btn-primary float-end">Adicionar usuário</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOME</th>
                                    <th>EMAIL</th>
                                    <th>DATA NASCIMENTO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                           <tbody>
<?php
$query = "SELECT * FROM cadastro";
$result = mysqli_query($conexao, $query);

if (mysqli_num_rows($result) > 0) {
    while ($usuario = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?= $usuario['id_usuario']; ?></td>
            <td><?= $usuario['nome']; ?></td>
            <td><?= $usuario['email']; ?></td>
            <td><?= date('d/m/Y', strtotime($usuario['data_nascimento'])); ?></td>
            <td>
                <a href="usuario-view.php?id_usuario<?=$usuario['id_usuario'] ?>" class="btn btn-secondary btn-sm">Visualizar</a>
                <a href="#" class="btn btn-success btn-sm">Editar</a>
                <form action="" method="POST" class="d-inline">
                    <button type="submit" name="delete_usuario" value="<?= $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm">
                        Excluir
                    </button>
                </form>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='5'>Nenhum usuário encontrado</td></tr>";
}
?>
</tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
