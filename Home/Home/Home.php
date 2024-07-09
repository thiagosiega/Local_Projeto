<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: ../../Entrada/login.html');
    exit;
}

$ID = $_SESSION['ID'];
require_once '../../Server/Server.php';
$infor = infor_usuario($ID);
$Img_perfil = $infor['Img_Perfil'];
if ($Img_perfil == "Default.png") {
    $Img_perfil = "../User/Default/Default.png"; // Imagem padrão caso não seja enviada nenhuma imagem
} else {
    $Img_perfil = "../User/" . $ID . "/Imgs/" . $Img_perfil;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olá <?php echo htmlspecialchars($infor['Nome']); ?></title>
    <link rel="stylesheet" href="../Sidebar/Sidebar.css">
    <link rel="stylesheet" href="Home.css">
</head>
<body>
    <div class="Sidebar" id="sidebar">
        <div class="Img_perfil">
            <img src="<?php echo $Img_perfil; ?>" alt="Imagem de perfil">
        </div>
        <div class="Menu">
            <ul>
                <h1>Olá <?php echo htmlspecialchars($infor['Nome']); ?></h1>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Perfil/Perfil.php">Perfil</a></li>
                <li><a href="Perfil/Configurações.php">Configurações</a></li>
                <li><a href="../../Server/Sair.php">Sair</a></li>
            </ul>
        </div>
    </div> 
    <script src="../Sidebar/Siedebar.js"></script>
    <div class="container">
        <div class="box">
            <h2>Seus Chats!</h2>
            <div class="Chats_local">
                <div class= "Add_chat">
                    <form action="Chat/Add_chat.php" method="post">
                        <input type="text" name="Nome" placeholder="Nome do chat">
                        <button type="submit">Adicionar</button>
                    </form>
                </div>
                <h3>Seus chats</h3>
                <a href="Chat/Chat.php?Chat=Global">Chat Global</a>
                <?php
                include "Chat/Ver_chat_user.php";
                ver_chat($ID)                
                ?>
            </div>
           
                
        </div>
    </div>
</body>
</html>
