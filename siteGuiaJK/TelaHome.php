<?php
include_once("conexao.php");
if(isset($_POST["submit"])){
    $email = $_POST['email'];
    $confirma_email = $_POST["confirmar_email"];

    if ($email != $confirma_email){
        echo "<div class='alert'>
                <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>×</span> 
                O email não confere.
            </div>";
    } else {



        // Prepare a consulta SQL para verificar se o e-mail existe
        if ($stmt = mysqli_prepare($ckdhvçiGVg