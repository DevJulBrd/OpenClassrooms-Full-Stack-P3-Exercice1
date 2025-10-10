<?php

require_once __DIR__ . '/Contact.php';
require_once __DIR__ . '/ContactManager.php';

class Command
{

    private $manager;

    public function __construct(ContactManager $manager)
    {
        $this->manager = $manager;
    }

    // Command 'list', diplays all contacts with Contact::toString()
    public function listCmd(): void
    {
        $contacts = $this->manager->findAll();

        if (empty($contacts)) {
            echo "Le carnet est vide.\n";
            return;
        }

        echo "Liste des contacts : " . PHP_EOL;
        echo "id, name, email, phone_number" . PHP_EOL;

        foreach ($contacts as $contact) {
            echo $contact . PHP_EOL;
        }
    }

    // Command 'detail <id>', displays details of a contact by id
    public function detailCmd(int $id): void
    {
        $contact = $this->manager->findById($id);

        if ($contact === null) {
            echo "Contact avec l'ID {$id} non trouvé." . PHP_EOL;
            return;
        }

        echo $contact . PHP_EOL;
    }

    // Command 'create <name> <email> <phone_number>', creates a new contact
    public function createCmd(string $name, string $email, string $phone_number): void
    {
        $name  = trim($name);
        $email = trim($email);
        $phone_number = trim($phone_number);

        if ($name === '') {
            echo "Erreur: le nom est requis." . PHP_EOL;
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Erreur: email invalide." . PHP_EOL;
            return;
        }

        try {
            $contact = $this->manager->create($name, $email, $phone_number);
            echo "Contact créé: " . $contact . PHP_EOL;
        } catch (Throwable $e) {
            echo "Erreur lors de la création: " . $e->getMessage() . PHP_EOL;
        }
    }

    // Command 'delete <id>', delete a contact by id
    public function deleteCmd(int $id): void
    {
        $before = $this->manager->findById($id);
        if ($before === null) {
            echo "Contact #{$id} introuvable." . PHP_EOL;
            return;
        }

        try {
            $ok = $this->manager->deleteById($id);
            if ($ok) {
                echo "Contact supprimé : " . $before . PHP_EOL;
            } else {
                echo "Aucune suppression effectuée (contact #{$id})." . PHP_EOL;
            }
        } catch (Throwable $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage() . PHP_EOL;
        }
    }

    // Command 'help', displays available commands
    public function helpCmd(): void
    {
        echo "Commandes disponibles:\n";
        echo "   help : Affiche cette aide\n";
        echo "   list : Liste tous les contacts\n";
        echo "   detail <id> : Détaille le contact avec l'ID spécifié\n";
        echo "   create <name>, <email>, <phone_number> : Crée un nouveau contact\n";
        echo "   delete <id> : Supprime le contact avec l'ID spécifié\n";
        echo "   quit : Quitte l'application\n";
    }

    // Command 'quit'
    public function quitCmd(): void
    {
        echo "Au revoir !\n";
        exit(0);
    }

}