<?php 
session_start();
if (!isset($_SESSION['ID'])) {
    echo "<script>alert('Você não está logado!');</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chat = htmlspecialchars(trim($_POST['Nome']));
    include_once '../../../Server/Server.php';
    $info = infor_usuario($_SESSION['ID']);
    $certificado = $info['Certificado'];

    if (empty($chat)) {
        header("Location: ../Home.php?error=Nome do chat não pode ser vazio!");
        exit;
    } elseif ($chat == "Geral") {
        header("Location: ../Home.php?error=Nome do chat não pode ser Geral!");
        exit;
    }

    $ID = $_SESSION['ID'];
    $dir = "../../User/$ID/Chats";
    $file = "$dir/$chat.json";

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    if (file_exists($file)) {
        header("Location: ../Home.php?error=Chat já existe!");
        exit;
    }

    // informaçoes do chat
    $chat_info = array(
        "Certificado" => $certificado,
        "Dono"        => $ID,
        "Nome"        => $chat,
        "Mensagens"   => array()
    );
    $chat_info = json_encode($chat_info, JSON_PRETTY_PRINT);
    file_put_contents($file, $chat_info);
    header('Location: ../Home.php?success=Chat criado com sucesso!');
    exit;
}
?>
