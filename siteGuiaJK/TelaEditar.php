<?php
session_start();
include_once("conexao.php");

// Recupere o ID do usuário a ser editado
$id_usuario = $_SESSION['id'];

$id = $id_usuario; // Defina $id com o valor de $id_usuario

if (isset($_POST["submit"])) {
    if (isset($_POST["id"])) {
        $id = $_POST["id"]; // Atribua o valor de $_POST["id"] à variável $id
    }
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $aluno = isset($_POST['aluno']) ? 1 : 0;
    $data_nasc = $_POST["data_nascimento"];
    $confirma_senha = $_POST["confirmar_senha"];

    // Verifique se o e-mail já existe
    $checkEmail = mysqli_query($conexao, "SELECT * FROM usuario WHERE email='$email'");
    if ($checkEmail->num_rows > 0 && $checkEmail->fetch_assoc()['id'] != $id) {
        echo "<div class='alert'>
                <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>×</span>
                O e-mail já está em uso.
              </div>";
    } elseif ($senha != $confirma_senha) {
        echo "<div class='alert'>
                <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>×</span>
              As senhas não conferem.
              </div>";
    } else {
        // Prepare a consulta SQL com parâmetros
        $sql = "UPDATE usuario SET nome=?, email=?, aluno=?, data_nasc=?, senha=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssissi", $nome, $email, $aluno, $data_nasc, $senha, $id);
        $result = $stmt->execute();

        if ($result) {
            header("Location: TelaLogin.php"); // Redirecione após a atualização
        } else {
            echo "Erro ao atualizar os dados.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tela de Editar Conta</title>
        <link rel="stylesheet" type="text/css" href="css\TelaEditar.css">
        <link rel="stylesheet" type="text/css" href="css\erro.css">
    </head>
    <body>
       
        <form action="TelaEditar.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id_usuario; ?>"> 
            <h1 id="cad">EDITAR CONTA</h1>

            <p>Insira seus novos dados desejados!</p>
            
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
