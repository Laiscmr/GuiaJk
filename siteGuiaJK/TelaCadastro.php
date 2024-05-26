<?php
include_once("conexao.php");
if(isset($_POST["submit"])){
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $senha = $_POST["senha"];
  $aluno = isset($_POST['aluno']) ? 1 : 0;
  $data_nasc = $_POST["data_nascimento"];
  $confirma_senha = $_POST["confirmar_senha"];

  // Verifique se o e-mail já existe
  $checkEmail = mysqli_query($conexao, "SELECT * FROM usuario WHERE email='$email'");
  if(mysqli_num_rows($checkEmail) > 0){
    echo "<div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>×</span> 
            Este e-mail já está cadastrado.
          </div>";
  } else if ($senha != $confirma_senha){
    echo "<div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>×</span> 
            As senhas não conferem.
          </div>";
  } else {
    $result = mysqli_query($conexao, "INSERT INTO usuario (nome,email,aluno,data_nasc,senha) 
    VALUES ('$nome','$email','$aluno','$data_nasc','$senha')");
    header("Location: TelaLogin.php");
  }
}
?>





<!DOCTYPE html>
<html>
    <head>
        <title>Tela de Cadastro</title>
        <link rel="stylesheet" type="text/css" href="css\bonitocad.css">
        <link rel="stylesheet" type="text/css" href="css\erro.css">
    </head>-
    <body>
       
        <form action="TelaCadastro.php" method="post">

        <h1 id="cad">CADASTRO</h1>
        
            <label for="nome"></label><br>
            <input type="text"placeholder="Insira o seu nome" id="nome" name="nome" required><br>

            <label for="email"></label><br>
            <input type="email"placeholder="Insira o seu E-mail" id="email" name="email" required><br>

            <label for="senha"></label><br>
            <input type="password"placeholder="Insira o sua senha" id="senha" name="senha" required><br>

            <label for="confirmar_senha"></label><br>
            <input type="password"placeholder="Confirme a sua senha" id="confirmar_senha" name="confirmar_senha" required><br>

            <br><label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required><br>

            <br><label for="aluno">É aluno da rede Faetec?</label>
            <input type="checkbox" id="sim" name="aluno" value="sim">
            <label for="sim">Sim</label><br>


            <input type="submit" name="submit" value="Cadastrar">
        </form>
    </body>
</html>
