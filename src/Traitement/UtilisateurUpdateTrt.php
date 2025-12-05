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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update'])) {
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    $_SESSION['error'] = "Utilisateur invalide.";
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

// Sauvegarde temporaire
$_SESSION['form_data'] = $_POST;

if ($nom === '' || $prenom === '' || $email === '' || $adresse === '' ||
    $dateNaissance === '' || $telephone === '') {
    $_SESSION['error'] = "Tous les champs (hors mot de passe) sont requis.";
    header('Location: ../../view/admin/utilisateur/utilisateurUpdate.php?id=' . $id);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Adresse email invalide.";
    header('Location: ../../view/admin/utilisateur/utilisateurUpdate.php?id=' . $id);
    exit();
}

// Connexion DB
try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();
    $repo = new UtilisateurRepository($bdd);

    // Récupération de l'utilisateur pour le mot de passe actuel
    $stmt = $bdd->prepare('SELECT mot_de_passe FROM utilisateur WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $_SESSION['error'] = "Utilisateur introuvable.";
        header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
        exit();
    }

    $hashedPassword = $row['mot_de_passe'];

    // Gestion du nouveau mot de passe (optionnel)
    if ($motDePasse !== '' || $confirmMotDePasse !== '') {
        if ($motDePasse !== $confirmMotDePasse) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
            header('Location: ../../view/admin/utilisateur/utilisateurUpdate.php?id=' . $id);
            exit();
        }

        if (strlen($motDePasse) < 12) {
            $_SESSION['error'] = "Le mot de passe doit contenir au moins 12 caractères.";
            header('Location: ../../view/admin/utilisateur/utilisateurUpdate.php?id=' . $id);
            exit();
        }

        $hashedPassword = password_hash($motDePasse, PASSWORD_BCRYPT);
    }

    // Modèle
    $utilisateur = new Utilisateur([
        'id' => $id,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'adresse' => $adresse,
        'telephone' => $telephone,
        'dateNaissance' => $dateNaissance,
        'motDePasse' => $hashedPassword,
        'role' => $role
    ]);

    // Mise à jour des champs via le repository (sauf rôle)
    $ok = $repo->modifierUtilisateur($utilisateur);

    if (!$ok) {
        $_SESSION['error'] = "Erreur lors de la mise à jour de l'utilisateur.";
        header('Location: ../../view/admin/utilisateur/utilisateurUpdate.php?id=' . $id);
        exit();
    }

    // Mise à jour du rôle séparément
    $stmtRole = $bdd->prepare('UPDATE utilisateur SET role = :role WHERE id = :id');
    $stmtRole->execute([
        ':role' => $role,
        ':id' => $id
    ]);

    unset($_SESSION['form_data']);
    $_SESSION['success'] = "Utilisateur mis à jour avec succès.";
    header('Location: ../../view/admin/utilisateur/utilisateurListe.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de base de données lors de la mise à jour.";
    header('Location: ../../view/admin/utilisateur/utilisateurUpdate.php?id=' . $id);
    exit();
}
