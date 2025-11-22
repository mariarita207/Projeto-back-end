<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    include('conexao.php');
    
    
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $sexo = $_POST['sexo'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $email = $_POST['email'];
    $celular = $_POST['telefoneCelular'];
    $login = $_POST['login'];
    $senha = password_hash($_POST['senha'] , PASSWORD_DEFAULT);
    $data_nascimento = $_POST['data'];
    $nome_materno = $_POST['mae'];

    $sql = mysqli_query($conexao ,
     "INSERT INTO cadastro(nome,cpf,sexo,endereco,cep,email,celular,logins,senha,data_nascimento,nome_materno)
      VALUES ('$nome','$cpf','$sexo','$endereco','$cep','$email','$celular','$login','$senha','$data_nascimento','$nome_materno')");
   
    if($sql) {
        header("Location: login.html");
        exit();
    }
    else{
        echo "erro ao cadastrar!";
    }
}
?>


