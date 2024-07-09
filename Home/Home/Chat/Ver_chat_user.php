<?php

function ver_chat($ID) {
    $file = "../User/$ID/Chats/";
    if (!is_dir($file)) {
        echo "<p>Você não tem chats!</p>";
        return;
    }

    // Lendo todos os arquivos do diretório
    $files = scandir($file);
    
    foreach ($files as $value) {
        if ($value == "." || $value == ".." || pathinfo($value, PATHINFO_EXTENSION) != 'json') {
            continue;
        }

        $filePath = $file . $value;
        $fileContents = file_get_contents($filePath);
        $chat = json_decode($fileContents, true);

        if ($chat === null) {
            continue;  // Skip files that are not valid JSON
        }

        $chatNome = htmlspecialchars($chat['Nome']);
        echo "<div class='Chat_php'>";
        echo "<from action='Chat/Chat.php' method='get'>";
        echo "<button type='submit' name='Chat' value='$chatNome'>$chatNome</button>";
        echo "</from>";
        echo "</div>";}
}
?>
