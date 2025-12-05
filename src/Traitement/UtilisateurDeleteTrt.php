<?php
session_start();
require_once '../../src/Bdd/config.php';
require_once '../../src/repository/UtilisateurRepository.php';

use repository\UtilisateurRepository;

// Vérification d'accès
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Accès refusé.";
    header('Location: ../../view/user/Connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['delete'])) {
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    $_SESSION['error'] = "Utilisateur invalide.";
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();
}

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();
    $repo = new UtilisateurRepository($bdd);

    $ok = $repo->supprimerUtilisateur($id);

    if ($ok) {
        $_SESSION['success'] = "Utilisateur supprimé avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur.";
    }

    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de base de données lors de la suppression.";
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();
}
