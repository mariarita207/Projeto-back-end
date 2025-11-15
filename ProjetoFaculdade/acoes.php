<?php 
session_start();
require 'conexao.php';
//Para a página de adicionar usuário//
if (isset($_POST['create_usuario'])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, trim($_POST['senha'])) : '';

    //se algum campo estiver vazio//
    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($senha)) {
        $_SESSION['mensagem'] = "Usuário não foi cadastrado. Preencha todos os dados!";
        header("Location: index.php");
        exit;
    }

    //se todos forem preenchidos//
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';

    $sql ="INSERT INTO cadastro (nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$data_nascimento', '$senha')";

    mysqli_query($conexao, $sql);

        $_SESSION['mensagem'] = 'Usuário criando com sucesso!';
        header('Location: index.php');
        exit;
    }

//Para a página de editar usuário//
if (isset($_POST['update_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));

    $sql = "UPDATE cadastro SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";

    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql .= ", senha = '$senha_hash'";
    }

    $sql .=" WHERE id_usuario = '$usuario_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário atualizado com sucesso!';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi atualizado';
        header('Location: index.php');
        exit;
    }
}

//Para a página de excluir usuário//
if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);
    
    $sql ="DELETE  FROM cadastro WHERE id_usuario = '$usuario_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário deletado com sucesso!';
        header('Location: index.php');
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi deletado';
        header('Location: index.php');
        exit;
    }
}
?>
