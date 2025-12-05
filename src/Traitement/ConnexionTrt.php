<?php
session_start();
require_once '../../src/Bdd/config.php';
require_once '../../src/repository/UtilisateurRepository.php';

use repository\UtilisateurRepository;

// Redirection si accès direct sans POST
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['connexion'])) {
    header('Location: ../../view/user/Connexion.php');
    exit();
}

try {
    // Connexion à la base de données
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de connexion à la base de données.";
    header('Location: ../../view/user/Connexion.php');
    exit();
}

// Récupération et nettoyage des données
$email = trim($_POST['email'] ?? '');
$motDePasse = trim($_POST['motDePasse'] ?? '');

// Sauvegarder l'email pour le réafficher en cas d'erreur
$_SESSION['last_email'] = $email;

// Validation des champs
if (empty($email) || empty($motDePasse)) {
    $_SESSION['error'] = "Veuillez remplir tous les champs.";
    header('Location: ../../view/user/Connexion.php');
    exit();
}

// Validation du format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "L'adresse email n'est pas valide.";
    header('Location: ../../view/user/Connexion.php');
    exit();
}

try {
    // Tentative de connexion
    $utilisateurRepository = new UtilisateurRepository($bdd);
    $resultat = $utilisateurRepository->connexion($email, $motDePasse);

    if ($resultat) {
        // Connexion réussie
        // Stocker les informations de l'utilisateur en session
        $_SESSION['user_id'] = $resultat->getIdUtilisateur();
        $_SESSION['user_email'] = $resultat->getEmail();
        $_SESSION['user_nom'] = $resultat->getNom();
        $_SESSION['user_prenom'] = $resultat->getPrenom();
        $_SESSION['user_role'] = $resultat->getRole() ?? 'eleve';
        $_SESSION['logged_in'] = true;

        // Nettoyer l'email sauvegardé
        unset($_SESSION['last_email']);

        // Message de succès
        $_SESSION['success_message'] = "Bienvenue " . htmlspecialchars($resultat->getPrenom()) . " !";

        // Redirection selon le rôle (à adapter selon vos besoins)
        switch ($_SESSION['user_role']) {
            case 'admin':
                header('Location: ../../view/admin/dashboard.php');
                break;
            case 'enseignant':
                header('Location: ../../view/enseignant/dashboard.php');
                break;
            case 'technicien':
                header('Location: ../../view/technicien/dashboard.php');
                break;
            case 'collectivite':
                header('Location: ../../view/collectivite/dashboard.php');
                break;
            case 'eleve':
            default:
                header('Location: ../../view/user/accueil.php');
                break;
        }
        exit();

    } else {
        // Échec de la connexion
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header('Location: ../../view/user/Connexion.php');
        exit();
    }

} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de la connexion : " . $e->getMessage();
    header('Location: ../../view/user/Connexion.php');
    exit();
}
?>