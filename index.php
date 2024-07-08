<?php

session_start();
if (isset($_SESSION['ID'])) {
    header('Location: home.php');
    exit;
}else{
    header('Location: Entrada/login.html');
    exit;
}

?>

