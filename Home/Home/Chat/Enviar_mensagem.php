<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION['ID'])) {
        echo "<script>alert('Você não está logado!');</script>";
        exit;
    }

    $ID = $_SESSION['ID'];
    $ChatNome = $_POST['Chat']; // Nome do chat
    $Mensagem = $_POST['Mensagem']; // Mensagem a ser enviada

    include_once '../../../Server/Server.php';
    
    // Certificado do chat para encontrar o dono do chat
    $Certificado = $_POST['Certificado'];
    $Infor_dono = Achar_certificado($Certificado);
    $ID_dono = $Infor_dono['ID'];
    
    if ($ChatNome == "Global_chat") {
        $ID_dono = "Global_chat";
    } 

    if ($ID_dono === "Certificado não encontrado!") {
        echo "<script>alert('Certificado não encontrado!')</script>";
        exit;
    }

    if ($ID_dono == "Global_chat") {
        $CaminhoChat = "../../User/Global_chat/Global_chat.json";
    } else {
        $CaminhoChat = "../../User/$ID_dono/Chats/$ChatNome.json";
    }

    if (!file_exists($CaminhoChat)) {
        echo "<script>alert('Chat não encontrado!')</script>";
        exit;
    }

    // Estrutura da mensagem a ser enviada
    $mensagem_enviada = array(
        "Autor" => $ID, // Aqui pode ser o ID ou nome do autor da mensagem
        "Texto" => $Mensagem
    );

    // Carrega o conteúdo atual do chat
    $ChatContent = file_get_contents($CaminhoChat);
    $Chat = json_decode($ChatContent, true);

    if ($Chat === null) {
        echo "<script>alert('Erro ao carregar o chat!')</script>";
        exit;
    }

    // Adiciona a nova mensagem ao array de mensagens do chat
    $Chat['Mensagens'][] = $mensagem_enviada;

    // Converte de volta para JSON
    $ChatJson = json_encode($Chat);

    // Salva o conteúdo atualizado de volta no arquivo JSON do chat
    file_put_contents($CaminhoChat, $ChatJson);

    // Redireciona de volta para a página do chat
    header("Location: Chat.php?Chat=" . urlencode($ChatNome));
    exit;
} else {
    echo "<script>alert('Erro ao enviar a mensagem!')</script>";
    exit;
}

?>
