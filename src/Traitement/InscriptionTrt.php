<?php
session_start();
require_once '../../src/Bdd/config.php';
require_once '../../src/modele/Utilisateur.php';
require_once '../../src/repository/UtilisateurRepository.php';

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de connexion à la base de données.";
    header('Location: ../../view/user/Inscription.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ok'])) {
    // Récupération et nettoyage des données
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $dateNaissance = trim($_POST['dateNaissance'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $motDePasse = trim($_POST['motDePasse'] ?? '');
    $confirmMotDePasse = trim($_POST['confirmMotDePasse'] ?? '');

    // Validation des champs requis
    if (empty($nom) || empty($prenom) || empty($email) || empty($adresse) || empty($dateNaissance) || empty($telephone) || empty($motDePasse)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    // Validation de la correspondance des mots de passe
    if ($motDePasse !== $confirmMotDePasse) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    // Validation du mot de passe
    if (strlen($motDePasse) < 12) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins 12 caractères.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    if (!preg_match('/[A-Z]/', $motDePasse)) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins une majuscule.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    if (!preg_match('/[a-z]/', $motDePasse)) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins une minuscule.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    if (!preg_match('/[0-9]/', $motDePasse)) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins un chiffre.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    if (!preg_match('/[\W_]/', $motDePasse)) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins un caractère spécial.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'adresse email n'est pas valide.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }

    // Création de l'objet Utilisateur et inscription
    try {
        $utilisateurRepository = new UtilisateurRepository($bdd);

        // Passer directement un tableau au lieu d'un objet
        $resultat = $utilisateurRepository->Inscription([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'adresse' => $adresse,
            'dateNaissance' => $dateNaissance,
            'telephone' => $telephone,
            'motDePasse' => $motDePasse,
        ]);

        if ($resultat['success']) {
            $_SESSION['success_message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            unset($_SESSION['form_data']);
            header('Location: ../../view/user/Connexion.php');
            exit();
        } else {
            $_SESSION['error'] = $resultat['error'] ?? "Erreur lors de l'inscription.";
            $_SESSION['form_data'] = $_POST;
            header('Location: ../../view/user/Inscription.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../view/user/Inscription.php');
        exit();
    }
} else {
    // Si accès direct sans POST
    header('Location: ../../view/user/Inscription.php');
    exit();
}
?>