<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../src/bdd/config.php';
session_start();

$pdo = getPDO();

$idUtilisateur = $_SESSION['id_utilisateur'] ?? null;
if (!$idUtilisateur) {
    die("Vous devez être connecté pour poster un sujet.");
}

if (!isset($_POST['titre'], $_POST['contenu'])) {
    die("Formulaire invalide.");
}

$titre   = trim($_POST['titre']);
$contenu = trim($_POST['contenu']);

if ($titre === '' || $contenu === '') {
    die("Tous les champs sont obligatoires.");
}

$sql = "
    INSERT INTO ressources_contenu (titre, contenu, auteur_id, date_publication, categorie)
    VALUES (?, ?, ?, NOW(), 'autre')
";
$req = $pdo->prepare($sql);
$req->execute([
    $titre,
    $contenu,
    $idUtilisateur
]);

header("Location: liste_ressources.php");
exit;
