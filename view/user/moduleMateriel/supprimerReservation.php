<?php
session_start();

// Vérifie que l'index est fourni
if (!isset($_GET['index']) || !is_numeric($_GET['index'])) {
    $_SESSION['error'] = 'Réservation invalide.';
    header('Location: moduleMaterielMain.php');
    exit();
}

$index = (int)$_GET['index'];

// Vérifie que le panier existe
if (!isset($_SESSION['reservations']) || !is_array($_SESSION['reservations'])) {
    $_SESSION['error'] = 'Aucune réservation à supprimer.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Vérifie que l'index existe
if (!isset($_SESSION['reservations'][$index])) {
    $_SESSION['error'] = 'Réservation non trouvée.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Récupère le nom pour le message
$nom = $_SESSION['reservations'][$index]['nom'];

// Supprime la réservation
array_splice($_SESSION['reservations'], $index, 1);

$_SESSION['success'] = 'La réservation "' . htmlspecialchars($nom) . '" a été supprimée.';
header('Location: moduleMaterielMain.php');
exit();
