<?php

session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: Entrada/login.html');
    exit;
}

include_once '../Server/Server.php';
$ID = $_SESSION['ID'];
$infor = infor_funcionario($ID);
if ($infor == "Usuário não encontrado!") {
    echo "<script>alert('Usuário não encontrado!');</script>";
    echo "<a href='Entrada/login.html'>Voltar</a>";
    exit;
}

$Img_perfil = htmlspecialchars($infor['Img_Perfil']);
if ($Img_perfil == "Default.png") {
    $Img_perfil = "User/Defaut/Defalt.png";
}else {
    $Img_perfil = "User/". $ID ."/Imgs/". $Img_perfil;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olá <?php echo htmlspecialchars($infor['Nome']); ?></title>
    <link rel="stylesheet" href="Home.css">
</head>
<body>
    <div class="container">
        <div class="box">
            <h1>Confirme se é você!</h1>
            <div class="img">
                <img src="<?php echo $Img_perfil; ?>" alt="Imagem de perfil">
            </div>
            <div class="info">
                <p>Nome: <?php echo htmlspecialchars($infor['Nome']); ?></p>
                <p>Email: <?php echo htmlspecialchars($infor['Email']); ?></p>
                <p>Sexo: <?php echo htmlspecialchars($infor['Sexo']); ?></p>
                <p>Data de nascimento: <?php echo htmlspecialchars($infor['Data_naci']); ?></p>
                <p>Nickname: <?php echo htmlspecialchars($infor['Niki']); ?></p>
                <a href="Home/Home.php">Continuar</a>
                <a href="../Server/Sair.php">Nao!</a>
            </div>
        </div>
    </div>
</body>
</html>
