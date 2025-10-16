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

    /**
     * Commande 'list', liste tous les contacts
     * @return void
     */
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

    /**
     * Commande 'detail <id>', affiche les détails d'un contact par son ID
     * @param int $id
     * @return void
     */
    public function detailCmd(int $id): void
    {
        $contact = $this->manager->findById($id);

        if ($contact === null) {
            echo "Contact avec l'ID {$id} non trouvé." . PHP_EOL;
            return;
        }

        echo $contact . PHP_EOL;
    }

    /**
     * Commande 'create <name>, <email>, <phone_number>', crée un nouveau contact
     * @param string $name
     * @param string $email
     * @param string $phone_number
     * @return void
     */
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

    /**
     * Commande 'delete <id>', supprime un contact par son ID
     * @param int $id
     * @return void
     */
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

    /**
     * Commande 'help', affiche l'aide
     * @return void
     */
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

    /**
     * Commande 'quit', quitte l'application
     * @return void
     */
    public function quitCmd(): void
    {
        echo "Au revoir !\n";
        exit(0);
    }

}