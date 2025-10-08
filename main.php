<?php 
require __DIR__ . '/DBConnect.php';
require __DIR__ . '/Contact.php';
require __DIR__ . '/ContactManager.php';

// First connection to the database
$db  = new DBConnect('127.0.0.1', 3306, 'P3-exercice1-CLI', 'root', '', 'utf8mb4');
$pdo = $db->getPDO();

// Contact manager instance
$manager = new ContactManager($pdo);

// Command loop
while (true) {
    $line = readline("Entrer votre commande : ");
    if ($line === false) { echo PHP_EOL; break; } // Ctrl+D
    $cmd = strtolower(trim($line));

    if ($cmd === 'list') {
        $contacts = $manager->findAll();

        if (empty($contacts)) {
            echo "Le carnet est vide.\n";
        } else {
            foreach ($contacts as $contact) {
                echo $contact->toString(), PHP_EOL;
            }
        }
        continue;
    }

    if ($cmd === 'quit') {
        echo "Au revoir\n";
        break;
    }

    echo "Commande inconnue: '$cmd'\n";
}
