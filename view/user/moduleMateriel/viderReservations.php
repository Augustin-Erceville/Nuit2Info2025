<?php
session_start();

// Vérifie que le panier existe et n'est pas vide
if (!isset($_SESSION['reservations']) || empty($_SESSION['reservations'])) {
    $_SESSION['error'] = 'Aucune réservation à supprimer.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Compte le nombre de réservations avant de vider
$count = count($_SESSION['reservations']);

// Vide toutes les réservations
$_SESSION['reservations'] = [];

$_SESSION['success'] = 'Toutes les réservations ont été supprimées (' . $count . ' article' . ($count > 1 ? 's' : '') . ').';
header('Location: moduleMaterielMain.php');
exit();
