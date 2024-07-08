<?php

function conectar_server() {
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "projetos_local";
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    if ($conexao->connect_error) {
        $resposta_server = "Erro de conexão: " . $conexao->connect_error;
        return $resposta_server;
    }
    return $conexao;
}

// Verificação de imagens
function imgs($ID, $imagem) {
    // Verifica se o arquivo é uma imagem
    $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    
    // Verificação de extensão de arquivo
    if (!in_array($extensao, $extensoes_permitidas)) {
        return "Extensão de arquivo inválida!";
    }
    
    // Aleatoriza o nome da imagem 
    $novo_nome = md5(uniqid(rand(), true)) . ".$extensao";
    $diretorio = "../Home/User/$ID/imagens/$novo_nome";
    
    // Caso não exista a pasta, cria a pasta
    if (!file_exists("../Home/User/$ID/imagens/")) {
        mkdir("../Home/User/$ID/imagens/", 0777, true);
    }
    
    // Move a imagem para a pasta
    if (!move_uploaded_file($imagem['tmp_name'], $diretorio)) {
        return "Erro ao mover a imagem!";
    }
    
    return $novo_nome;
}

function Cadastrar_user($nome, $email, $senha, $sexo, $dataNascimento, $Img, $niki) {
    #Nome    Email    Senha    Sexo    ID    Img_Perfil    Data_naci    Certificado    Niki
    $conexao = conectar_server();
    
    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o email já está cadastrado
    $stmt = $conexao->prepare("SELECT * FROM user_local WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        return "Email já cadastrado!";
    }
    
    // Verifica se o niki já está cadastrado
    $stmt = $conexao->prepare("SELECT * FROM user_local WHERE Niki = ?");
    $stmt->bind_param("s", $niki);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        return "Niki já cadastrado!";
    }

    // Gera um ID aleatório de 4 dígitos
    do {
        $ID = rand(1000, 9999);
        $stmt = $conexao->prepare("SELECT * FROM user_local WHERE ID = ?");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $resultado = $stmt->get_result();
    } while ($resultado->num_rows > 0);

    // Verifica se a imagem foi enviada
    if ($Img != "") {
        $novo_nome = imgs($ID, $_FILES['imagem']);
        if (strpos($novo_nome, 'Erro') !== false) {
            return $novo_nome;
        }
        $Img = $novo_nome;
    } else {
        $Img = "Default.png";
    }

    // Gera um certificado aleatório de 10 dígitos
    do {
        $certificado = rand(100000, 999999);
        $stmt = $conexao->prepare("SELECT * FROM user_local WHERE Certificado = ?");
        $stmt->bind_param("i", $certificado);
        $stmt->execute();
        $resultado = $stmt->get_result();
    } while ($resultado->num_rows > 0);

    $stmt = $conexao->prepare("INSERT INTO user_local (Nome, Email, Senha, Sexo, ID, Img_Perfil, Data_naci, Certificado, Niki) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisiss", $nome, $email, $senha_hash, $sexo, $ID, $Img, $dataNascimento, $certificado, $niki);
    
    if ($stmt->execute()) {
        return "Usuário cadastrado com sucesso!";
    } else {
        return "Erro ao cadastrar o usuário: " . $stmt->error;
    }
}
?>
