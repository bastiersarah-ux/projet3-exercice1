<?php

declare(strict_types=1);

/**
 * main.php
 *
 * Instancie la connexion à la base de données (en particulier la table 'contact') et instancie la classe Command.
 * Crée le gestionnaire de contacts en ligne de commandes (CLI : Command Line Interface).
 * Lit toutes les commandes suivantes :
 * - afficher la liste des contacts issus de la table 'contact' en BDD;
 * - consulter le détail d'un contact individuellement;
 * - créer / supprimer un contact
 * - quitter le programme
 * - afficher une aide avec les commandes existantes avec les modalités de syntaxe à respecter.
 */
require_once "DBConnect.php";
require_once "ContactManager.php";
require_once "Command.php";

try {
    $db = new DBConnect();
} catch (PDOException $e) {
    echo "Une erreur est survenue lors de la connexion à la BDD. Fin du programme.";
    exit(1);
}

$cmd = new Command($db->getPDO());
$isRunning = true;

/**
 * Boucle qui permet de vérifier la commande entrée par l'utilisateur.
 * Utilisation des regex avec la fonction preg_match pour réglementer la syntaxe attendue.
 * La commande quit affiche un message "Fermeture du Programme..." pour prévenir de l'arrêt de la boucle et donc du programme.
 * Si une commande inexistante est entrée, un message s'affiche "Commande inconnue".
 */
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
    } else if ($line == "help") {
        $cmd->helpCommand();
    } else {
        echo "Commande inconnue : $line\n";
    }
}
