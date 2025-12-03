<?php

declare(strict_types=1);

/**
 * Classe qui permet de de stocker en mémoire un contact qui est récupéré de la table 'Contact' en BDD. 
 */
class Contact
{

    /**
     * Constructeur
     *
     * @param integer|null $id Identifiant du contact
     * @param string|null $name Nom du contact
     * @param string|null $email E-mail
     * @param string|null $phoneNumber Numéro de téléphone
     */
    public function __construct(
        private ?int $id,
        private ?string $name,
        private ?string $email,
        private ?string $phoneNumber
    ) {}

    /**
     * Getter permettant d'accéder à l'ID d'un contact. 
     * Cette méthode va retourner l’id du contact (ou null si l’id n’est pas encore défini).
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter permettant d'accéder au nom d'un contact. 
     * Cette méthode retourne le nom du contact (ou null si le nom n’est pas défini).
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter permettant de modifier le nom d'un contact. 
     * Cette méthode permet de spécifier le nom et ne retourne rien. 
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter permettant d'accéder à l'e-mail d'un contact. 
     * Cette méthode retourne l'e-mail du contact (ou null si le nom n’est pas défini).
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     * Setter permettant de modifier l'e-mail d'un contact. 
     * Cette méthode permet de spécifier l'e-mail et ne retourne rien.
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    /**
     * Getter permettant d'accéder au numéro de téléphone d'un contact. 
     * Cette méthode retourne le numéro de télphone du contact (ou null si le nom n’est pas défini).
     *
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
    /**
     * Setter permettant de modifier le numéro de téléphone d'un contact. 
     * Cette méthode permet de spécifier le numéro de téléphone et ne retourne rien.
     *
     * @param string $phoneNumber
     * @return void
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
    /**
     * Méthode qui s'occupe de convertir ce contact en chaîne de caractères.
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->id}, {$this->name}, {$this->email}, {$this->phoneNumber}";
    }
}
