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
}