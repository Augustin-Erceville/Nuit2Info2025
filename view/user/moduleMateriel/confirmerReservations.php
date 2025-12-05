<?php
session_start();

// Vérifie que la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requête invalide.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Vérifie qu'il y a des réservations
if (!isset($_SESSION['reservations']) || empty($_SESSION['reservations'])) {
    $_SESSION['error'] = 'Aucune réservation à confirmer.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Validation des données requises
$required_fields = ['date_debut', 'date_fin'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $_SESSION['error'] = 'Veuillez renseigner les dates de début et de fin.';
        header('Location: moduleMaterielMain.php');
        exit();
    }
}

// Récupération des données
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];
$commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';

// Validation des dates
$debut = strtotime($date_debut);
$fin = strtotime($date_fin);
$aujourdhui = strtotime(date('Y-m-d'));

if ($debut < $aujourdhui) {
    $_SESSION['error'] = 'La date de début ne peut pas être dans le passé.';
    header('Location: moduleMaterielMain.php');
    exit();
}

if ($fin < $debut) {
    $_SESSION['error'] = 'La date de fin doit être après la date de début.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// TODO: Ici, vous pourrez ajouter l'enregistrement en base de données
// Pour l'instant, on stocke les informations dans un fichier log ou on affiche un message

// Compte le nombre total d'articles
$total_articles = array_sum(array_column($_SESSION['reservations'], 'quantite'));

// Crée un résumé pour le message
$materiels = [];
foreach ($_SESSION['reservations'] as $reservation) {
    $materiels[] = $reservation['nom'] . ' (×' . $reservation['quantite'] . ')';
}
$resume_materiels = implode(', ', $materiels);

// Message de succès
$_SESSION['success'] = 'Votre réservation a été confirmée ! ' .
                       $total_articles . ' article' . ($total_articles > 1 ? 's' : '') . ' réservé' . ($total_articles > 1 ? 's' : '') .
                       ' du ' . date('d/m/Y', $debut) . ' au ' . date('d/m/Y', $fin) . '. ' .
                       'Matériels : ' . $resume_materiels . '.';

// Optionnel : Log de la réservation dans un fichier
$log_entry = date('Y-m-d H:i:s') . " - Réservation confirmée\n";
$log_entry .= "  Dates : " . $date_debut . " au " . $date_fin . "\n";
$log_entry .= "  Matériels :\n";
foreach ($_SESSION['reservations'] as $reservation) {
    $log_entry .= "    - " . $reservation['nom'] . " (ID: " . $reservation['id_materiel'] . ", Quantité: " . $reservation['quantite'] . ")\n";
}
if ($commentaire) {
    $log_entry .= "  Commentaire : " . $commentaire . "\n";
}
$log_entry .= "\n";

// Crée le dossier logs s'il n'existe pas
$log_dir = __DIR__ . '/logs';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0755, true);
}

// Enregistre dans le fichier log
file_put_contents($log_dir . '/reservations.log', $log_entry, FILE_APPEND);

// Vide le panier de réservations
$_SESSION['reservations'] = [];

// Redirige vers la page principale
header('Location: moduleMaterielMain.php');
exit();
