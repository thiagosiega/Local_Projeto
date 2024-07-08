<?php
#file: Entrada/Porteiro.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $action = $_POST['action'];
   if ($action == 'cadastro'){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha2 = $_POST['confirmarSenha'];
        $sexo = $_POST['sexo'];
        $dataNascimento = $_POST['dataNascimento'];
        $Img = $_POST['imagem'];

        if ($senha != $senha2) {
            echo "<script>alert('As senhas não conferem!');</script>";
            exit;
        }

   }

} else {
    header('Location: login.html');
    exit;
}

?>