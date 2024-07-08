<?php

session_start();
if (isset($_SESSION['ID'])) {
    header('Location: Home/Entrada.php');
    exit;
}else{
    header('Location: Entrada/login.html');
    exit;
}

?>

