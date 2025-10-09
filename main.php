<?php 
require __DIR__ . '/DBConnect.php';
require __DIR__ . '/Contact.php';
require __DIR__ . '/ContactManager.php';
require __DIR__ . '/Command.php';

// First connection to the database
$db  = new DBConnect('127.0.0.1', 3306, 'P3-exercice1-CLI', 'root', '', 'utf8mb4');
$pdo = $db->getPDO();

// Contact manager instance
$manager = new ContactManager($pdo);
$command = new Command($manager);

// Command loop
while (true) {
    $line = readline("Entrer votre commande : ");
    if ($line === false) { echo PHP_EOL; break; }
    $input = strtolower(trim($line));

    if ($input === 'list') {
        $command->listCmd();
        continue;
    }

    if ($input === 'quit') {
        echo "Au revoir\n";
        break;
    }

    echo "Commande inconnue: '$input'\n";
}
