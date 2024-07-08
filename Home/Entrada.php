<?php

//verifiaca a cessao
session_start();
if (isset($_SESSION['ID'])) {
    header("Location: ../Entrada/login.html");
    exit();
}



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ola </title>
</head>
<body>
    
</body>
</html>