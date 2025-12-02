<?php

declare(strict_types=1);

/**
 * main.php
 *
 * Script principal d'exécution. Il instancie la connexion à la base de données,
 * crée le gestionnaire de contacts et affiche la liste des contacts.
 *
 * Usage: php main.php
 */
require_once "DBConnect.php";
require_once "ContactManager.php";
require_once "Command.php";

$cmd = new Command();
$isRunning = true;

while ($isRunning) {
    $line = readline("Entrez votre commande (help, list, detail, create, delete, quit) : ");
    if ($line == "list") {
        $cmd->listContactsCommand();
    } else if (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        $id = intval($matches[1]);
        $cmd->detailContactCommand($id);
    } else if (preg_match('/^create\s+(.+)$/', $line, $matches)) {
        $cmd->createContactCommand($matches[1]);
    } else if (preg_match('/^delete\s+(\d+)$/', $line, $matches)) {
        $id = intval($matches[1]);
        $cmd->deleteContactCommand($id);
    } else if ($line == "quit") {
        $isRunning = false;
        echo "Fermeture du programme...\n";
    } else {
        echo "Commande inconnue : $line\n";
    }
}
