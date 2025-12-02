<?php

declare(strict_types=1);

/**
 * DBConnect
 *
 * Classe responsable de la connexion à la base de données MySQL via PDO.
 * Utilise hôte localhost et la base de données `projet3`.
 */
class DBConnect
{
    /**
     * Instance de PDO utilisée pour interagir avec la base de données.
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Initialise la connexion PDO.
     *
     * Le constructeur configure l'objet PDO avec le DSN et les informations
     * d'authentification. En cas d'erreur de connexion, une
     * exception PDOException sera levée.
     *
     * @throws PDOException si la connexion à la base de données échoue.
     */
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=projet3", "root", "");
    }

    /**
     * Retourne l'instance PDO connectée à la base de données.
     *
     * @return PDO L'objet PDO initialisé dans le constructeur.
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
