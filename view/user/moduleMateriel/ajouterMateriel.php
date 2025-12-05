<?php
session_start();

require_once '../../../src/bdd/config.php';
require_once '../../../src/repository/MaterielRepository.php';
require_once '../../../src/modele/Materiel.php';

use repository\MaterielRepository;

// Vérifie que la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requête invalide.';
    header('Location: moduleMaterielMain.php');
    exit();
}

// Validation des données requises
$required_fields = ['nom', 'type', 'quantite_disponible', 'quantite_totale', 'etat', 'id_etablissement'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $_SESSION['error'] = 'Veuillez remplir tous les champs requis.';
        header('Location: moduleMaterielMain.php');
        exit();
    }
}

// Récupération et nettoyage des données
$nom = trim($_POST['nom']);
$type = trim($_POST['type']);
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$quantite_disponible = (int)$_POST['quantite_disponible'];
$quantite_totale = (int)$_POST['quantite_totale'];
$etat = trim($_POST['etat']);
$id_etablissement = (int)$_POST['id_etablissement'];

// Validation des valeurs
if ($quantite_disponible < 0 || $quantite_totale < 1) {
    $_SESSION['error'] = 'Les quantités doivent être valides (disponible >= 0, totale >= 1).';
    header('Location: moduleMaterielMain.php');
    exit();
}

if (!in_array($etat, ['bon', 'correct', 'mauvais'])) {
    $_SESSION['error'] = 'État du matériel invalide.';
    header('Location: moduleMaterielMain.php');
    exit();
}

$valid_types = ['Tour', 'Clavier', 'Souris', 'Ecran', 'Webcam', 'Câble', 'PCPortable', 'Enceinte'];
if (!in_array($type, $valid_types)) {
    $_SESSION['error'] = 'Type de matériel invalide.';
    header('Location: moduleMaterielMain.php');
    exit();
}

try {
    // Récupère la connexion PDO
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->get1();

    // Crée une instance du repository
    $materielRepo = new MaterielRepository($bdd);

    // Crée un nouvel objet Materiel
    $materiel = new Materiel(
        null,                   // id_materiel (sera généré par la BDD)
        $nom,                   // nom
        $description,           // description
        $quantite_disponible,   // quantite_disponible
        $quantite_totale,       // quantite_totale
        $etat,                  // etat
        $type,                  // type
        null,                   // date_ajout (sera générée automatiquement)
        $id_etablissement       // id_etablissement
    );

    // Enregistre le matériel dans la base de données
    $result = $materielRepo->create($materiel);

    if ($result !== null) {
        // Succès - redirige vers la page principale avec le type sélectionné
        $_SESSION['success'] = 'Le matériel "' . htmlspecialchars($nom) . '" a été ajouté avec succès.';
        header('Location: moduleMaterielMain.php?type=' . urlencode($type));
        exit();
    } else {
        // Erreur lors de la création
        $_SESSION['error'] = 'Une erreur est survenue lors de la création du matériel.';
        header('Location: moduleMaterielMain.php');
        exit();
    }

} catch (Exception $e) {
    // Log l'erreur (pour le débogage)
    error_log('Erreur lors de l\'ajout du matériel : ' . $e->getMessage());

    // Redirige avec un message d'erreur
    $_SESSION['error'] = 'Une erreur technique est survenue. Veuillez réessayer.';
    header('Location: moduleMaterielMain.php');
    exit();
}
