<?php


// Função de conexão com o servidor
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

// Função de cadastro de usuário
function Cadastrar_user($nome, $email, $senha, $sexo, $dataNascimento, $Img, $niki) {
    $conexao = conectar_server();

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

    // Verifica se o campo de imagem não está vazio
    if ($Img && $Img['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = $Img['name'];
        //aleatoriza o nome do arquivo
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
        $nomeArquivo = md5(uniqid()) . ".$extensao";
        $caminho = "../Home/User/$ID/Imgs/";
        if (!file_exists($caminho)) {
            mkdir($caminho, 0777, true);
        }
        // Move a imagem para a pasta
        move_uploaded_file($Img['tmp_name'], $caminho . $nomeArquivo);
        $Img_Perfil = $nomeArquivo;
    } else {
        $Img_Perfil = "Default.png"; // Imagem padrão caso não seja enviada nenhuma imagem
    }

    // Gera um certificado aleatório de 10 dígitos
    do {
        $certificado = rand(100000, 999999);
        $stmt = $conexao->prepare("SELECT * FROM user_local WHERE Certificado = ?");
        $stmt->bind_param("i", $certificado);
        $stmt->execute();
        $resultado = $stmt->get_result();
    } while ($resultado->num_rows > 0);

    // Insere os dados no banco de dados
    $stmt = $conexao->prepare("INSERT INTO user_local (Nome, Email, Senha, Sexo, ID, Img_Perfil, Data_naci, Certificado, Niki) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisiss", $nome, $email, $senha, $sexo, $ID, $Img_Perfil, $dataNascimento, $certificado, $niki);
    
    if ($stmt->execute()) {
        return true; // Retorna verdadeiro se o cadastro for bem-sucedido
    } else {
        return "Erro ao cadastrar o usuário: " . $stmt->error; // Retorna mensagem de erro se ocorrer algum problema
    }
}

// Função de login
function Login($email, $senha) {
    $conexao = conectar_server();
    
    $stmt = $conexao->prepare("SELECT * FROM user_local WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 0) {
        return "Email não cadastrado!";
    }
    
    $usuario = $resultado->fetch_assoc();
    
    if (!password_verify($senha, $usuario['Senha'])) {
        return "Senha incorreta!";
    }
    
    session_start();
    $_SESSION['ID'] = $usuario['ID'];    
    return true;
}

function infor_funcionario ($ID){
    $conexao = conectar_server();
    $stmt = $conexao->prepare("SELECT * FROM user_local WHERE ID = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        return "Usuário não encontrado!";
    }else{
        return $resultado->fetch_assoc();
    }

}

?>
