<?php
session_start();
require_once '../../src/Bdd/config.php';
require_once '../../src/modele/Utilisateur.php';
require_once '../../src/repository/UtilisateurRepository.php';

use repository\UtilisateurRepository;

// Vérification d'accès
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Accès refusé.";
    header('Location: ../../view/user/Connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['create'])) {
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();
}

// Récupération des données
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$adresse = trim($_POST['adresse'] ?? '');
$dateNaissance = trim($_POST['dateNaissance'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$motDePasse = trim($_POST['motDePasse'] ?? '');
$confirmMotDePasse = trim($_POST['confirmMotDePasse'] ?? '');
$role = trim($_POST['role'] ?? 'eleve');

// Sauvegarde temporaire des données pour ré-affichage en cas d'erreur
$_SESSION['form_data'] = $_POST;

if ($nom === '' || $prenom === '' || $email === '' || $adresse === '' ||
    $dateNaissance === '' || $telephone === '' || $motDePasse === '' || $confirmMotDePasse === '') {
    $_SESSION['error'] = "Tous les champs sont requis.";
    header('Location: ../../view/admin/utilisateur/utilisateurCreate.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Adresse email invalide.";
    header('Location: ../../view/admin/utilisateur/utilisateurCreate.php');
    exit();
}

if ($motDePasse !== $confirmMotDePasse) {
    $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
    header('Location: ../../view/admin/utilisateur/utilisateurCreate.php');
    exit();
}

if (strlen($motDePasse) < 12) {
    $_SESSION['error'] = "Le mot de passe doit contenir au moins 12 caractères.";
    header('Location: ../../view/admin/utilisateur/utilisateurCreate.php');
    exit();
}

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();
    $repo = new UtilisateurRepository($bdd);

    // Utilisation du modèle
    $utilisateur = new Utilisateur([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'adresse' => $adresse,
        'telephone' => $telephone,
        'dateNaissance' => $dateNaissance,
        'motDePasse' => $motDePasse,
        'role' => $role
    ]);

    // Inscription via le repository (gère hash + contrôle d'unicité email)
    $result = $repo->Inscription($utilisateur);

    if (!$result['success']) {
        $_SESSION['error'] = $result['error'] ?: "Erreur lors de la création de l'utilisateur.";
        header('Location: ../../view/admin/utilisateur/utilisateurCreate.php');
        exit();
    }

    // Récupération de l'ID créé
    $id = $bdd->lastInsertId();

    // Mise à jour du rôle si différent du rôle par défaut "eleve"
    if ($role !== '' && $role !== 'eleve') {
        $stmt = $bdd->prepare('UPDATE utilisateur SET role = :role WHERE id = :id');
        $stmt->execute([
            ':role' => $role,
            ':id' => $id
        ]);
    }

    unset($_SESSION['form_data']);
    $_SESSION['success'] = "Utilisateur créé avec succès.";
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de base de données lors de la création.";
    header('Location: ../../view/admin/utilisateur/utilisateurCreate.php');
    exit();
}
