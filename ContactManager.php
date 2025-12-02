<?php

declare(strict_types=1);

/**
 * ContactManager
 *
 * Gère les opérations sur la table `contact` de la base de données.
 * La classe attend une instance de PDO injectée via le constructeur.
 *
 * @package Projet3
 */

require_once "DBConnect.php";
require_once "Contact.php";
require_once "Command.php";

class ContactManager
{
    /**
     * Constructeur.
     *
     * @param PDO $pdo Instance PDO injectée (connexion active).
     */
    public function __construct(private PDO $pdo) {}

    /**
     * Récupère tous les contacts de la table `contact`.
     *
     * @return array<int, Contact> Tableau associatif contenant les contacts.
     */
    public function findAll(): array
    {
        $requete = $this->pdo->prepare("SELECT id, name, email, phone_number FROM contact");
        $requete->execute();
        $contacts = $requete->fetchAll();

        $resultat = array();

        foreach ($contacts as $contact) {
            array_push($resultat, new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number']));
        }

        return $resultat;
    }

    public function findById(int $id): ?Contact
    {
        $requete = $this->pdo->prepare("SELECT id, name, email, phone_number FROM contact WHERE id = ?");
        $requete->execute([$id]);
        $contact = $requete->fetch();
        return !empty($contact)
            ? new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number'])
            : null;
    }

    /**
     * Insère un contact en BDD.
     * 
     * Retourne l'id du contact crée ou -1 si l'insertion de données ne s'effectue pas correctement en BDD.
     *
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phoneNumber Numéro de téléphone du contact
     * @return integer identifiant (en BDD) du contact
     */
    public function insertContact(string $name, string $email, string $phoneNumber): int
    {
        try {
            $requete = $this->pdo->prepare("INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?)");
            $requete->execute([$name, $email, $phoneNumber]);
            return intval($this->pdo->lastInsertId());
        } catch (Exception $e) {
            return -1; // On retourne -1 dans le cas où l'insertion de données ne s'effectue pas correctement.
        }
    }

    public function deleteContact(int $id): int | false
    {
        try {
            $requete = $this->pdo->prepare("DELETE FROM contact WHERE id = ?");
            $requete->execute([$id]);
            return $requete->rowCount();
        } catch (Exception $e) {
            return false;
        }
    }
}
