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
        // Use $_FILES para o campo de imagem
        $Img = $_FILES['imagem'] ?? '';
        $niki = $_POST['niki'] ?? '';

        if ($senha != $senha2) {
            echo "<script>alert('As senhas não coincidem!'); window.location.href = 'cadastro.html';</script>";
            exit;
        }
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        include '../Server/Server.php';
        $resposta = Cadastrar_user($nome, $email, $senha, $sexo, $dataNascimento, $Img, $niki);
        // Verifique se a resposta não é verdadeira (houve um erro)
        if ($resposta !== true) {
            echo "<script>alert('$resposta');</script>";
            header('Location: cadastro.html');
            exit;

        } else {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'login.html';</script>";
        }
    } else if ($action == 'login') {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if ($email && $senha) {
            include '../Server/Server.php';
            $resposta = Login($email, $senha);

            if ($resposta !== true) {
                if ($resposta == "Email não cadastrado!") {
                    echo "<script>alert('$resposta'); window.location.href = 'login.html';</script>";
                    // Deixa a entrada do email em branco e com uma borda vermelha
                    echo "<script>document.getElementById('email').style.border = '1px solid red';</script>";
                } else if ($resposta == "Senha incorreta!") {
                    echo "<script>alert('$resposta'); window.location.href = 'login.html';</script>";
                    // Deixa a entrada da senha em branco e com uma borda vermelha
                    echo "<script>document.getElementById('senha').style.border = '1px solid red';</script>";
                } else {
                    echo "<script>alert('$resposta');</script>";
                }
            } else {
                echo "<script>alert('Login realizado com sucesso!'); window.location.href = 'Home/Entada.php';</script>";
            }
        } else {
            echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('Ação desconhecida.'); window.location.href = 'login.html';</script>";
    }
} else {
    header('Location: login.html');
    exit;
}
?>
