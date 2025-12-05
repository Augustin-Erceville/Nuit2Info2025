<?php
session_start();
require_once __DIR__ . '/../../../src/Bdd/config.php';

// Vérification d'accès
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../user/Connexion.php');
    exit();
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    $_SESSION['error'] = "Utilisateur invalide.";
    header('Location: utilisateurListe.php');
    exit();
}

$id = (int)$_GET['id'];

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();

    $stmt = $bdd->prepare('SELECT id, nom, prenom, email, role 
                           FROM utilisateur WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$utilisateur) {
        $_SESSION['error'] = "Utilisateur introuvable.";
        header('Location: utilisateurListe.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors du chargement de l'utilisateur.";
    header('Location: utilisateurListe.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur - Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        <a class="navbar-brand d-flex align-items-center text-danger" href="../../user/accueil.php">
            <i class="bi bi-moon-stars fs-1 me-2"></i>
            <span class="fs-3 fw-bold">NUIT DE L'INFO - ADMINISTRATION</span>
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="ms-auto d-none d-lg-flex align-items-center">
                <a href="utilisateurListe.php" class="btn btn-outline-light btn-lg me-2">
                    <i class="bi bi-people"></i> Retour à la liste
                </a>
                <a href="../../user/moduleMateriel/Deconnexion.php" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<hr class="text-light">

<div class="container my-4">
    <div class="card bg-black text-light border border-danger">
        <div class="card-header bg-danger text-light fw-bold text-uppercase">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmer la suppression
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <p>Vous êtes sur le point de supprimer l'utilisateur suivant :</p>
            <ul>
                <li><strong>ID :</strong> <?= htmlspecialchars($utilisateur['id']) ?></li>
                <li><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']) ?></li>
                <li><strong>Email :</strong> <?= htmlspecialchars($utilisateur['email']) ?></li>
                <li><strong>Rôle :</strong> <?= htmlspecialchars($utilisateur['role'] ?? 'eleve') ?></li>
            </ul>
            <p class="text-danger fw-bold">Cette action est irréversible.</p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="utilisateurListe.php" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i> Annuler
            </a>
            <form method="post" action="../../../src/Traitement/UtilisateurDeleteTrt.php" class="d-inline">
                <input type="hidden" name="id" value="<?= htmlspecialchars($utilisateur['id']) ?>">
                <button type="submit" name="delete" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Confirmer la suppression
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
