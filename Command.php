<?php

declare(strict_types=1);

require_once "ContactManager.php";
require_once "DBConnect.php";

class Command
{
    private ContactManager $cm;

    public function __construct()
    {
        $db = new DBConnect();
        $pdo = $db->getPDO();
        $this->cm = new ContactManager($pdo);
    }

    public function listContactsCommand(): void
    {
        $contacts = $this->cm->findAll();

        echo "\nListe des contacts : \n\n";
        echo "id, name, email, phone number \n\n";

        foreach ($contacts as $contact) {
            echo "$contact \n\n";
        }
    }

    public function detailContactCommand(int $id): void
    {
        $contact = $this->cm->findById($id);

        if ($contact === null) {
            echo "Aucun contact trouvé avec l'id $id. \n";
            return;
        }
        echo "$contact \n";
    }

    public function createContactCommand(string $create): void
    {
        // "[name], [email], [phoneNumber]" devient array([name], [email], [phoneNumber])
        $array = explode(',', $create);
        if (is_array($array) && count($array) === 3) {
            [$name, $email, $phoneNumber] = $array; // Déconstruction du tableau

            // On insère le contact et on récupère son id (ou -1)
            // Trim : on supprime les espaces inutiles liés à la fonction explode
            $idContact = $this->cm->insertContact(trim($name), trim($email), trim($phoneNumber));

            if ($idContact == -1) {
                echo "Une erreur est survenue lors de la création du contact. \n";
            } else {
                echo "Contact n°$idContact crée avec succès. \n";
            }
        } else {
            echo "Nombre de paramètres incorrect \n";
        }
    }

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
