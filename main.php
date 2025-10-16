<?php 
require __DIR__ . '/config.php';
require __DIR__ . '/DBConnect.php';
require __DIR__ . '/Contact.php';
require __DIR__ . '/ContactManager.php';
require __DIR__ . '/Command.php';

// Connexion base de données
$db  = new DBConnect(
    DB_HOST,
    DB_PORT,
    DB_NAME,
    DB_USER,
    DB_PASSWORD,
    DB_CHARSET
);
$pdo = $db->getPDO();

$manager = new ContactManager($pdo);
$command = new Command($manager);

// Boucle principale
while (true) {
    $line = readline("Entrez votre commande (help, list, detail, create, delete, quit) : ");
    if ($line === false) { echo PHP_EOL; break; }
    $input = strtolower(trim($line));

    // Commande 'list'
    if ($input === 'list') {
        $command->listCmd();
        continue;
    }

    // Commande 'detail <id>'
    if (preg_match('/^detail\s+(\d+)$/i', $input, $m)) {
        $id = (int)$m[1];
        $command->detailCmd($id);
        continue;
    }

    // Commande 'create <name>, <email>, <phone_number>'
    if (preg_match(
    '/^create\s+(?:"([^"]+)"|([^,]+?))\s*,\s*([^,]+)\s*,\s*(.+)$/i',
    $input,
    $m
    )) {
        $name  = $m[1] !== '' ? trim($m[1]) : trim($m[2]);
        $email = trim($m[3]);
        $phone_number = trim($m[4]);

        $command->createCmd($name, $email, $phone_number);
        continue;
    }

    // Commande 'delete <id>'
    if (preg_match('/^delete\s+(\d+)$/i', $input, $m)) {
        $command->deleteCmd((int)$m[1]);
        continue;
    }

    // Commande 'help'
    if ($input === 'help') {
        $command->helpCmd();
        continue;
    }

    // Commande 'quit'
    if ($input === 'quit') {
        $command->quitCmd();
        break;
    }

    echo "Commande inconnue: '$input'\n";
}
