<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire le cookie de session si présent
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Détruire la session
session_destroy();

// Créer une nouvelle session pour le message
session_start();
$_SESSION['success_message'] = "Vous avez été déconnecté avec succès.";

// Rediriger vers la page de connexion
header('Location: ../../view/user/Connexion.php');
exit();
?>