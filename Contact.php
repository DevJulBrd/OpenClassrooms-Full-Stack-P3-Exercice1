<?php
class Contact
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $phone_number = null;

    public function _construct(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $phone_number = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    // Create Contact from array
    public static function fromArray(array $row): self
    {
        return new self(
            isset($row['id']) ? (int)$row['id'] : null,
            $row['name']  ?? null,
            $row['email'] ?? null,
            $row['phone_number'] ?? null
        );
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function getEmail(): ?string{ return $this->email; }
    public function getPhone(): ?string{ return $this->phone_number; }

    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setName(?string $name): void  { $this->name = $name; }
    public function setEmail(?string $email): void{ $this->email = $email; }
    public function setPhone(?string $phone_number): void{ $this->phone_number = $phone_number; }

    // String representation
    public function _toString(): string
    {
        $id = $this->id !== null ? "#{$this->id}" : "#?";
        $name = $this->name ?? "(sans nom)";
        $email = $this->email ?? "-";
        $phone_number = $this->phone_number ?? "-";
        return sprintf("%s | %s | %s | %s", $id, $name, $email, $phone_number);
    }

    // Alias for toString
    public function toString(): string
    {
        return $this->_toString();
    }
}