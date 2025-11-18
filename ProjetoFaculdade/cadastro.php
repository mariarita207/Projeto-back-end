<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    include('conexao.php');
    
    
    $nome = $_POST['nome'];
    print_r($nome);
    $cpf = $_POST['cpf'];
    print_r($cpf);
    $sexo = $_POST['sexo'];
    print_r($sexo);
    $endereco = $_POST['endereco'];
    print_r($endereco);
    $cep = $_POST['cep'];
    print_r($cep);
    $email = $_POST['email'];
    print_r($email);
    $celular = $_POST['telefoneCelular'];
    print_r($celular);
    $login = $_POST['login'];
    print_r($login);
    $senha = $_POST['senha'];
    print_r($senha);
    $data_nascimento = $_POST['data'];
    print_r($data_nascimento);
    $nome_materno = $_POST['mae'];
    print_r($nome_materno);

    $sql = mysqli_query($conexao ,
     "INSERT INTO cadastro(nome,cpf,sexo,endereco,cep,email,celular,logins,senha,data_nascimento,nome_materno)
      VALUES ('$nome','$cpf','$sexo','$endereco','$cep','$email','$celular','$login','$senha','$data_nascimento','$nome_materno')");
   
    
}



?>
