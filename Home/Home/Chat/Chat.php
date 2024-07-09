<?php

if (!isset($_GET['Chat'])) {
    echo "<p>Chat não encontrado!</p>";
    return;
}
echo "<h2>Chat: " . htmlspecialchars($_GET['Chat']) . "</h2>";

?>