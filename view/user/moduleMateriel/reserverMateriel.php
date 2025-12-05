<?php
session_start();

// Vérifie que la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requête invalide.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Validation des données requises
$required_fields = ['id_materiel', 'nom', 'type', 'quantite'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $_SESSION['error'] = 'Données de réservation incomplètes.';
        header('Location: moduleMaterielMain.php');
        exit();
    }
}

// Récupération et validation des données
$id_materiel = (int)$_POST['id_materiel'];
$nom = trim($_POST['nom']);
$type = trim($_POST['type']);
$quantite = (int)$_POST['quantite'];

// Validation de la quantité
if ($quantite < 1) {
    $_SESSION['error'] = 'La quantité doit être au moins 1.';
    header('Location: moduleMaterielMain.php?type=' . urlencode($type));
    exit();
}

// Initialise le panier de réservations s'il n'existe pas
if (!isset($_SESSION['reservations'])) {
    $_SESSION['reservations'] = [];
}

// Vérifie si le matériel est déjà dans le panier
$found = false;
foreach ($_SESSION['reservations'] as &$reservation) {
    if ($reservation['id_materiel'] == $id_materiel) {
        // Augmente la quantité
        $reservation['quantite'] += $quantite;
        $found = true;
        $_SESSION['success'] = 'Quantité mise à jour pour "' . htmlspecialchars($nom) . '" (×' . $reservation['quantite'] . ').';
        break;
    }
}

// Si le matériel n'est pas encore dans le panier, l'ajouter
if (!$found) {
    $_SESSION['reservations'][] = [
        'id_materiel' => $id_materiel,
        'nom' => $nom,
        'type' => $type,
        'quantite' => $quantite
    ];
    $_SESSION['success'] = '"' . htmlspecialchars($nom) . '" a été ajouté à vos réservations (×' . $quantite . ').';
}

// Redirige vers la page principale avec le type sélectionné
header('Location: moduleMaterielMain.php?type=' . urlencode($type));
exit();
