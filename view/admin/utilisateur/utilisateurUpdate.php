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
$success = $_SESSION['success'] ?? '';
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['form_data']);

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();

    $stmt = $bdd->prepare('SELECT id, nom, prenom, email, adresse, téléphone, date_naissance, role 
                           FROM utilisateur WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRow) {
        $_SESSION['error'] = "Utilisateur introuvable.";
        header('Location: utilisateurListe.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors du chargement de l'utilisateur.";
    header('Location: utilisateurListe.php');
    exit();
}

// Pré-remplissage des champs (POST en priorité si erreur)
$nom = $formData['nom'] ?? $userRow['nom'];
$prenom = $formData['prenom'] ?? $userRow['prenom'];
$email = $formData['email'] ?? $userRow['email'];
$adresse = $formData['adresse'] ?? $userRow['adresse'];
$telephone = $formData['telephone'] ?? ($userRow['téléphone'] ?? '');
$dateNaissance = $formData['dateNaissance'] ?? ($userRow['date_naissance'] ?? '');
$roleValue = $formData['role'] ?? ($userRow['role'] ?? 'eleve');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur - Administration</title>
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
    <div class="card bg-black text-light border border-light">
        <div class="card-header fs-4 fw-bold text-uppercase">
            <i class="bi bi-pencil-square me-2"></i>Modifier l'utilisateur #<?= htmlspecialchars($id) ?>
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

            <form method="post" action="../../../src/Traitement/UtilisateurUpdateTrt.php" class="row g-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                <div class="col-md-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($prenom) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($nom) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($email) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($adresse) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($telephone) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="dateNaissance" class="form-control bg-transparent text-light"
                           required value="<?= htmlspecialchars($dateNaissance) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nouveau mot de passe (optionnel)</label>
                    <input type="password" name="motDePasse" class="form-control bg-transparent text-light">
                    <div class="form-text text-muted">
                        Laisser vide pour conserver le mot de passe actuel.
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmation du mot de passe</label>
                    <input type="password" name="confirmMotDePasse" class="form-control bg-transparent text-light">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Rôle</label>
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
                    <button type="submit" name="update" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
