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
    $line = readline("Entrez votre commande (help, list, detail, create, delete, quit) : ");
    if ($line === false) { echo PHP_EOL; break; }
    $input = strtolower(trim($line));

    // Command 'list'
    if ($input === 'list') {
        $command->listCmd();
        continue;
    }

    // Command 'detail <id>'
    if (preg_match('/^detail\s+(\d+)$/i', $input, $m)) {
        $id = (int)$m[1];
        $command->detailCmd($id);
        continue;
    }

    // Command 'create <name>, <email>, <phone_number>'
    if (preg_match(
    '/^create\s+(?:"([^"]+)"|([^,]+?))\s*,\s*([^,]+)\s*,\s*(.+)$/i',
    $input,
    $m
    )) {
        // Support both quoted and unquoted names (possibily to add , in the name))
        $name  = $m[1] !== '' ? trim($m[1]) : trim($m[2]);
        $email = trim($m[3]);
        $phone_number = trim($m[4]);

        $command->createCmd($name, $email, $phone_number);
        continue;
    }

    // Command 'delete <id>'
    if (preg_match('/^delete\s+(\d+)$/i', $input, $m)) {
        $command->deleteCmd((int)$m[1]);
        continue;
    }

    // Command 'help'
    if ($input === 'help') {
        $command->helpCmd();
        continue;
    }

    // Command 'quit'
    if ($input === 'quit') {
        $command->quitCmd();
        break;
    }

    echo "Commande inconnue: '$input'\n";
}
