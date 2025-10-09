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

        foreach ($contacts as $contact) {
            if (method_exists($contact, 'toString')) {
                echo $contact->toString() . PHP_EOL;
            } else {
                echo (string)$contact . PHP_EOL;
            }
        }
    }

    // Command 'detail <id>', displays details of a contact by ID
    public function detailCmd(int $id): void
    {
        $contact = $this->manager->findById($id);

        if ($contact === null) {
            echo "Contact avec l'ID {$id} non trouvé." . PHP_EOL;
            return;
        }

        echo $contact->toString() . PHP_EOL;
    }
}