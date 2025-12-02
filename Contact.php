<?php

declare(strict_types=1);

class Contact
{

    public function __construct(
        private ?int $id,
        private ?string $name,
        private ?string $email,
        private ?string $phoneNumber
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function __toString(): string
    {
        return "{$this->id}, {$this->name}, {$this->email}, {$this->phoneNumber}";
    }
}
