<?php
# file: Entrada/Porteiro.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action == 'cadastro') {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $senha2 = $_POST['confirmarSenha'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $dataNascimento = $_POST['dataNascimento'] ?? '';
        // Para o campo de imagem, use $_FILES ao invés de $_POST
        $Img = $_FILES['imagem'] ?? '';
        $niki = $_POST['niki'] ?? '';

        // Inclua o arquivo de funções apenas se todos os campos necessários estiverem presentes
        if ($nome && $email && $senha && $senha2 && $sexo && $dataNascimento && $Img && $niki) {
            include '../Server/Server.php';
            $resposta = Cadastrar_user($nome, $email, $senha, $senha2, $sexo, $dataNascimento, $Img, $niki);

            // Verifique se a resposta não é verdadeira (ou seja, houve um erro)
            if ($resposta !== true) {
                echo "<script>alert('$resposta');</script>";
            } else {
                echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'login.html';</script>";
            }
        } else {
            echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href = 'cadastro.html';</script>";
        }
    } else if ($action == 'login'){
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if ($email && $senha) {
            include '../Server/Server.php';
            $resposta = Login($email, $senha);

            if ($resposta !== true) {
                echo "<script>alert('$resposta');</script>";
            } else {
                echo "<script>alert('Login realizado com sucesso!'); window.location.href = 'home.html';</script>";
            }
        } else {
            echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href = 'login.html';</script>";
        }        
    }
} else {
    header('Location: login.html');
    exit;
}
?>
