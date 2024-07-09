<?php

if (!isset($_GET['Chat'])) {
    echo "<p>Chat não encontrado!</p>";
    exit;
}

session_start();

$ChatNome = htmlspecialchars($_GET['Chat']); // Nome do chat
$ID = $_SESSION['ID'];
//verifica se o chat e o global
if ($ChatNome == "Global_chat") {
    $CaminhoChat = "../../User/Global_chat/Global_chat.json";
} else {
    $CaminhoChat = "../../User/$ID/Chats/$ChatNome.json";
}

if (!file_exists($CaminhoChat)) {
    echo "<p>Chat não encontrado!</p>";
    echo "<p>Caminho do chat: $CaminhoChat</p>";
    exit;
}

$ChatContent = file_get_contents($CaminhoChat);
$Chat = json_decode($ChatContent, true);

if ($Chat === null) {
    echo "<p>Erro ao carregar o chat!</p>";
    exit;
}

$ChatNome = htmlspecialchars($Chat['Nome']);
$ChatMensagens = $Chat['Mensagens'];
$chatCertificado = $Chat['Certificado'];

include_once "../../../Server/Server.php";
$infor = infor_usuario($ID);
$certificado = $infor['Certificado'];

if ($ChatNome != "Global") {
    $dono = Achar_certificado($chatCertificado);
} else {
    $dono = 0;
}

$Img_perfil = $infor['Img_Perfil'];
if ($Img_perfil == "Default.png") {
    $Img_perfil = "../../User/Default/imagens/Default.png"; // Imagem padrão caso não seja enviada nenhuma imagem
} else {
    $Img_perfil = "../../User/$ID/Imgs/$Img_perfil";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat: <?php echo $ChatNome ?></title>
    <link rel="stylesheet" href="../../Sidebar/Sidebar.css">
    <style>
        .container {
            margin-left: 250px;
            padding: 20px;
        }

        .chat {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
        }

        .chat h2 {
            text-align: center;
        }

        .mensagens {
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            max-height: 400px;
            overflow-y: auto;
        }

        .mensagem {
            display: flex;
            margin-bottom: 10px;
        }

        .mensagem p {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
        }

        .chat form {
            margin-top: 20px;
            display: flex;
        }

        .chat form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .chat form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .mensagem-autor {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
        }

        .mensagem-autor p {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 10px;
            max-width: 70%; /* Ajuste o tamanho máximo conforme necessário */
            word-wrap: break-word; /* Quebra de palavras */
        }

        .mensagem-autor img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .mensagem-outro {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 10px;
        }

        .mensagem-outro p {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            max-width: 70%; /* Ajuste o tamanho máximo conforme necessário */
            word-wrap: break-word; /* Quebra de palavras */
        }

        .mensagem-outro img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

    </style>
</head>
<body>
    <div class="Sidebar" id="sidebar">
        <div class="Img_perfil">
            <img src="<?php echo $Img_perfil; ?>" alt="Imagem de perfil">
        </div>
        <div class="Menu">
            <ul>
                <h1>Olá <?php echo htmlspecialchars($infor['Nome']); ?></h1>
                <li><a href="../Home.php">Home</a></li>
                <li><a href="../Perfil/Perfil.php">Perfil</a></li>
                <li><a href="../Perfil/Configurações.php">Configurações</a></li>
                <li><a href="../../../Server/Sair.php">Sair</a></li>
            </ul>
        </div>
    </div> 
    <script src="../../Sidebar/Siedebar.js"></script>
    <div class="container">
        <div class="chat">
            <h2><?php echo $ChatNome; ?></h2>
            <div class="mensagens">
            <?php
            // Exibe as mensagens do chat
            foreach ($ChatMensagens as $mensagem) {
                //define a imagem de cada mensagem
                $autor = $mensagem['Autor'];
                echo "<script>console.log('$autor')</script>";
                $infor = infor_usuario($autor);
                $Img_perfil = $infor['Img_Perfil'];
                if ($Img_perfil == "Default.png") {
                    $Img_perfil = "../../User/Default/imagens/Default.png"; // Imagem padrão caso não seja enviada nenhuma imagem
                } else {
                    $Img_perfil = "../../User/$autor/Imgs/$Img_perfil";
                }
                echo "<script>console.log('$Img_perfil')</script>";
                $mensagem_texto = $mensagem['Texto'];
                if ($autor == $ID) {
                    echo "<div class='mensagem-autor'>";
                    echo "<img src='$Img_perfil' alt='Imagem de perfil'>";
                    echo "<p>$mensagem_texto</p>";
                    echo "</div>";
                } else {
                    echo "<div class='mensagem-outro'>";
                    echo "<img src='$Img_perfil' alt='Imagem de perfil'>";
                    echo "<p>$mensagem_texto</p>";
                    echo "</div>";
                }

            }
            ?>

            </div>
            <form action="Enviar_mensagem.php" method="post">
                <input type="hidden" name="Chat" value="<?php echo $ChatNome; ?>">
                <input type="hidden" name="Certificado" value="<?php echo $certificado; ?>">
                <input type="text" name="Mensagem" placeholder="Digite sua mensagem">
                <button type="submit">Enviar</button>
            </form>
            
        </div>
    </div>
</body>
</html>
