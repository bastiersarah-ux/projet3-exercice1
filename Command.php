<?php

declare(strict_types=1);

require_once "ContactManager.php";

/**
 * Classe qui stocke toute la logique d’exécution de chaque commande. 
 * Elle contient toutes les commandes.
 * 
 */
class Command
{
    /**
     * Gestionnaire des contacts en BDD
     *
     * @var ContactManager
     */
    private ContactManager $cm;

    /**
     * Constructeur qui instancie la classe ContactManager pour récupérer l’ensemble des données des contacts;
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->cm = new ContactManager($pdo);
    }
    /**
     * Exécute la commande "list" pour afficher la listes des contacts en BDD.
     *
     * @return void
     */
    public function listContactsCommand(): void
    {
        $contacts = $this->cm->findAll();

        echo "\nListe des contacts : \n\n";
        echo "id, name, email, phone number \n\n";

        foreach ($contacts as $contact) {
            echo "$contact \n\n";
        }
    }
    /**
     * Exécute la commande "detail" pour afficher le détail d'un contact en BDD à partir d'un id.
     * Affiche un message d'erreur si le contact n'est pas
     *
     * @param integer $id
     * @return void
     */
    public function detailContactCommand(int $id): void
    {
        $contact = $this->cm->findById($id);

        if ($contact === null) {
            echo "Aucun contact trouvé avec l'id $id. \n";
            return;
        }
        echo "$contact \n";
    }
    /**
     * Exécute la commande "create" pour créer un nouveau contact à partir des paramètres requis.
     * 
     * Affiche un message pour confirmer la création du contact.
     * Affiche un message d'erreur en cas de problème lors de la création en BDD du contact.
     * Affiche un message d'erreur liées aux nombres de paramètres requis (name, email, phone_number = 3 paramètres )
     *
     * @param string $create
     * @return void
     */
    public function createContactCommand(string $create): void
    {
        // "[name], [email], [phoneNumber]" devient array([name], [email], [phoneNumber])
        $array = explode(',', $create);
        if (is_array($array) && count($array) === 3) {
            [$name, $email, $phoneNumber] = $array; // Déconstruction du tableau

            $idContact = $this->cm->insertContact(trim($name), trim($email), trim($phoneNumber));

            if ($idContact === false) {
                echo "Une erreur est survenue lors de la création du contact. \n";
            } else {
                echo "Contact n°$idContact crée avec succès. \n";
            }
        } else {
            echo "Nombre de paramètres incorrect \n";
        }
    }
    /**
     * Exécute la commande "delete" pour supprimer un contact existant à partir d'un id.
     * 
     * Affiche un message pour confirmer la supression du contact.
     * Affiche un message d'erreur si l'id est introuvable ou pour tout autre erreur (ex: requêtage BDD).
     *
     * @param integer $id
     * @return void
     */
    public function deleteContactCommand(int $id): void
    {
        $nbLigne = $this->cm->deleteContact($id);

        if ($nbLigne === 1) {
            echo "Contact supprimé !\n";
        } else if ($nbLigne === 0) {
            echo "Le contact n°$id est introuvable ou inexistant.\n";
        } else {
            echo "Une erreur est survenue lors de la suppression du contact.\n";
        }
    }

    /**
     * Exécute la commande "help" pour afficher les commandes disponibles et leur utilisation.
     *
     * @return void
     */
    public function helpCommand(): void
    {
        echo "\nhelp : affiche cette aide \n\n";
        echo "list : liste les contacts \n\n";
        echo "create [name], [email], [phone number] : crée un contact\n\n";
        echo "delete [id] : supprime un contact\n\n";
        echo "quit : quitte le programme\n\n\n\n";
        echo "Attention à la syntaxe des commandes : les espaces et les virgules sont importants.\n\n";
    }
}
