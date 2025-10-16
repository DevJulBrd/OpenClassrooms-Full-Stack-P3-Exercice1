<?php
class ContactManager
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Tous les contacts
     * @return Contact[]
     */
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

    /**
     * Contact par ID
     * @param int $id
     * @return Contact|null
     */
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

    /**
     * Créer un contact
     * @param string $name
     * @param string $email
     * @param string $phone_number
     * @return Contact
     */
    public function create(string $name, string $email, string $phone_number): Contact
    {
        $sql = 'INSERT INTO contact (name, email, phone_number)VALUES (:name, :email, :phone_number)';
        $statment = $this->pdo->prepare($sql);
        $statment->bindValue(':name', $name, PDO::PARAM_STR);
        $statment->bindValue(':email', $email, PDO::PARAM_STR);
        $statment->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);
        $statment->execute();

        // Display the created contact
        $id = (int)$this->pdo->lastInsertId();
        return new Contact($id, $name, $email, $phone_number);
    }

    /**
     * Supprimer un contact par ID
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $sql = 'DELETE FROM contact WHERE id = :id';
        $statment = $this->pdo->prepare($sql);
        $statment->bindValue(':id', $id, PDO::PARAM_INT);
        $statment->execute();

        return $statment->rowCount() === 1;
    }
}