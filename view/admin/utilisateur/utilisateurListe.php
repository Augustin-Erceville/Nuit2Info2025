<?php
session_start();

require_once __DIR__ . '/../../../src/Bdd/config.php';
require_once __DIR__ . '/../../../src/repository/UtilisateurRepository.php';

use repository\UtilisateurRepository;

// Vérification d'accès (admin uniquement)
//if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
//    header('Location: ../../user/Connexion.php');
//    exit();
//}

// Messages flash
$flashError = $_SESSION['error'] ?? '';
$flashSuccess = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getPDO();

    $repo = new UtilisateurRepository($bdd);
    $utilisateurs = $repo->findAll(); // retourne un tableau associatif
} catch (PDOException $e) {
    $utilisateurs = [];
    $flashError = $flashError ?: "Erreur de connexion à la base de données.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Utilisateurs</title>
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
                <a href="../commentaire/commentaireListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Commentaires">
                    <i class="bi bi-chat"></i>
                </a>
                <a href="../quiz/quizListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Quiz">
                    <i class="bi bi-question-circle"></i>
                </a>
                <a href="../resource/ressourceListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ressources">
                    <i class="bi bi-folder"></i>
                </a>
                <a href="../defi/defiListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Défis">
                    <i class="bi bi-trophy"></i>
                </a>
                <a href="../etablissement/etablissementListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Etablissements">
                    <i class="bi bi-building"></i>
                </a>
                <a href="../idee/ideeListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Idées">
                    <i class="bi bi-lightbulb"></i>
                </a>
                <a href="../materiel/materielListe.php" class="btn btn-outline-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Matériels">
                    <i class="bi bi-pc-display"></i>
                </a>
                <a href="utilisateurListe.php" class="btn btn-danger btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Utilisateurs">
                    <i class="bi bi-people"></i>
                </a>
                <a href="../../user/moduleMateriel/Deconnexion.php" class="btn btn-outline-light btn-lg"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Déconnexion">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>

            <!-- Menu mobile -->
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../commentaire/commentaireListe.php">
                        <i class="bi bi-chat"></i> Commentaires
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../quiz/quizListe.php">
                        <i class="bi bi-question-circle"></i> Quiz
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../resource/ressourceListe.php">
                        <i class="bi bi-folder"></i> Ressources
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../defi/defiListe.php">
                        <i class="bi bi-trophy"></i> Défis
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../etablissement/etablissementListe.php">
                        <i class="bi bi-building"></i> Etablissements
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../idee/ideeListe.php">
                        <i class="bi bi-lightbulb"></i> Idées
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-danger w-100" href="../materiel/materielListe.php">
                        <i class="bi bi-pc-display"></i> Matériels
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-danger w-100" href="utilisateurListe.php">
                        <i class="bi bi-people"></i> Utilisateurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light w-100" href="../../user/moduleMateriel/Deconnexion.php">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<hr class="text-light">

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-light mb-0">
            <i class="bi bi-people me-2"></i>Gestion des utilisateurs
        </h1>
        <a href="utilisateurCreate.php" class="btn btn-success">
            <i class="bi bi-person-plus-fill me-1"></i> Nouvel utilisateur
        </a>
    </div>

    <?php if ($flashSuccess): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($flashSuccess) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($flashError): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($flashError) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card bg-black text-light border border-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold text-uppercase">Liste des utilisateurs</span>
            <span class="badge bg-secondary">
                Total : <?= isset($utilisateurs) ? count($utilisateurs) : 0 ?>
            </span>
        </div>
        <div class="card-body p-0">
            <?php if (empty($utilisateurs)): ?>
                <p class="p-3 mb-0">Aucun utilisateur trouvé.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Date de naissance</th>
                            <th>Rôle</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($utilisateurs as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['prenom']) ?></td>
                                <td><?= htmlspecialchars($user['nom']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['adresse']) ?></td>
                                <td><?= htmlspecialchars($user['téléphone'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['date_naissance'] ?? '') ?></td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= htmlspecialchars($user['role'] ?? 'eleve') ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="utilisateurRead.php?id=<?= urlencode($user['id']) ?>"
                                       class="btn btn-sm btn-outline-light me-1"
                                       data-bs-toggle="tooltip" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="utilisateurUpdate.php?id=<?= urlencode($user['id']) ?>"
                                       class="btn btn-sm btn-outline-warning me-1"
                                       data-bs-toggle="tooltip" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="utilisateurDelete.php?id=<?= urlencode($user['id']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       data-bs-toggle="tooltip" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
