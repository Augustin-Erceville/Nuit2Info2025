<?php
session_start();

// Vérification d'accès (admin uniquement)
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../user/Connexion.php');
    exit();
}

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur - Administration</title>
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
                <a href="../../user/moduleMateriel/Deconnexion.php" class="btn btn-outline-light btn-lg"
                   data-bs-toggle="tooltip" title="Déconnexion">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<hr class="text-light">

<div class="container my-4">
    <div class="card bg-black text-light border border-light">
        <div class="card-header fs-4 fw-bold text-uppercase">
            <i class="bi bi-person-plus-fill me-2"></i>Créer un utilisateur
        </div>
        <div class="card-body">

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="../../../src/Traitement/UtilisateurCreateTrt.php" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($formData['prenom'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($formData['nom'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($formData['adresse'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($formData['telephone'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="dateNaissance" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($formData['dateNaissance'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="motDePasse" class="form-control bg-transparent text-light" required>
                    <div class="form-text text-muted">
                        Minimum 12 caractères, recommandé : majuscule, minuscule, chiffre, caractère spécial.
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmation du mot de passe</label>
                    <input type="password" name="confirmMotDePasse" class="form-control bg-transparent text-light" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Rôle</label>
                    <?php $roleValue = $formData['role'] ?? 'eleve'; ?>
                    <select name="role" class="form-select bg-transparent text-light">
                        <option value="eleve" <?= $roleValue === 'eleve' ? 'selected' : '' ?>>Élève</option>
                        <option value="enseignant" <?= $roleValue === 'enseignant' ? 'selected' : '' ?>>Enseignant</option>
                        <option value="technicien" <?= $roleValue === 'technicien' ? 'selected' : '' ?>>Technicien</option>
                        <option value="collectivite" <?= $roleValue === 'collectivite' ? 'selected' : '' ?>>Collectivité</option>
                        <option value="admin" <?= $roleValue === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-between mt-3">
                    <a href="utilisateurListe.php" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button type="submit" name="create" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
