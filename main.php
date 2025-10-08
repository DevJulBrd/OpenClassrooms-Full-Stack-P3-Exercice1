<?php 
while (true) {
    $line = readline("Entrer votre commande : ");
    echo "Vous avez saisi : $line\n";
    
    // Listening commands
    $command = strtolower(trim($line));

    // Unsers commands
    if ($command === "list") {
        echo "Affichage de la liste des contactes\n";
        continue;
    }
}
