<?php
class ContactManager
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Find all contacts
    public function findAll() : array
    {
        // SQL request
        $sql = 'SELECT * FROM contact';
        // Execute request
        $statment = $this->pdo->prepare($sql);
        $statment->execute();
        // Fetch all results
        $contactsList = $statment->fetchAll();
        
        // Convert to Contact objects
        $contacts = [];
        foreach ($contactsList as $row) {
            $contacts[] = Contact::fromArray($row);
        }
        
        return $contacts;
    }

    // Find a contact by ID
    public function findById(int $id): ?Contact
    {
        $sql = 'SELECT * FROM contact WHERE id = :id';
        $statment = $this->pdo->prepare($sql);
        $statment->bindValue(':id', $id, PDO::PARAM_INT);
        $statment->execute();
        $row = $statment->fetch();

        if ($row === false) {
            return null;
        }

        return Contact::fromArray($row);
    }
}