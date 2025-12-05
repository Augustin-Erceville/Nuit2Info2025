<?php
session_start();

require_once '../../../src/bdd/config.php';
require_once '../../../src/repository/MaterielRepository.php';

use repository\MaterielRepository;

// Récupère la connexion PDO
$bdd = getPDO();

$materielRepo = new MaterielRepository($bdd);
$selectedType = isset($_GET['type']) ? $_GET['type'] : null;
$materiels = [];

if ($selectedType) {
    $materiels = $materielRepo->getByType($selectedType);
}
$selectedType = isset($_GET['type']) ? $_GET['type'] : null;
$materiels = [];

if ($selectedType) {
    $materiels = $materielRepo->getByType($selectedType);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>N2I</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        <a class="navbar-brand d-flex align-items-center" href="../accueil.php">
            <i class="bi bi-moon-stars fs-1 me-2"></i>
            <span class="fs-3 fw-bold text-light">NUIT DE L'INFO</span>
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="ms-auto d-none d-lg-flex align-items-center">
                <a href="moduleMaterielMain.php" class="btn btn-outline-light btn-lg active me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Matériels">
                    <i class="bi bi-pc-display"></i>
                </a>
                <div class="btn-group dropstart">
                    <button class="btn btn-outline-light btn-lg dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-toggle-second="tooltip" data-bs-placement="bottom" title="Compte">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item" href="../Connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../Inscription.php">
                                <i class="bi bi-person-plus-fill me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light active w-100" href="moduleMaterielMain.php">
                        <i class="bi bi-pc-display"></i>
                        Matériels
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn btn-outline-light w-100 dropdown-toggle" href=""
                       id="compteDropdown" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-person me-1"></i>
                        Compte
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100" aria-labelledby="compteDropdown">
                        <li>
                            <a class="dropdown-item" href="../Connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../Inscription.php">
                                <i class="bi bi-person-plus-fill me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<hr class="text-light">

<!-- Section des catégories -->
<section class="container my-3">
    <h2 class="text-center text-light my-3">Matériels</h2>
    <div class="row g-3">
        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Tour"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/tour.png" class="img-fluid" alt="Tour">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Tour</h3>
                </div>
            </a>
        </article>

        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Clavier"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/clavier.png" class="img-fluid" alt="Clavier">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Clavier</h3>
                </div>
            </a>
        </article>

        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Souris"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/souris.png" class="img-fluid" alt="Souris">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Souris</h3>
                </div>
            </a>
        </article>

        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Ecran"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/ecran.png" class="img-fluid" alt="Écran">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Ecran</h3>
                </div>
            </a>
        </article>
    </div>
</section>

<section class="container my-3">
    <div class="row g-3">
        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Webcam"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/webcam.png" class="img-fluid" alt="Webcam">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Webcam</h3>
                </div>
            </a>
        </article>

        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Câble"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/cable.png" class="img-fluid" alt="Câble">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Câble</h3>
                </div>
            </a>
        </article>

        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=PCPortable"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/portable.png" class="img-fluid" alt="PC Portable">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">PC Portable</h3>
                </div>
            </a>
        </article>

        <article class="col-12 col-sm-6 col-md-3">
            <a href="?type=Enceinte"
               class="card bg-transparent text-light border-light text-decoration-none h-100 d-flex flex-column"
               style="min-height: 320px;">
                <div class="card-body d-flex align-items-center justify-content-center flex-grow-1">
                    <img src="../../../src/img/enceinte.png" class="img-fluid" alt="Enceinte">
                </div>
                <div class="card-footer bg-transparent border-0 text-center mt-auto">
                    <h3 class="mb-0">Enceinte</h3>
                </div>
            </a>
        </article>
    </div>
</section>

<!-- Section d'affichage des matériels filtrés -->
<?php if ($selectedType): ?>
    <section class="container my-5">
        <hr class="text-light mb-4">
        <h3 class="text-center text-light mb-4">Matériels disponibles : <?php echo htmlspecialchars($selectedType); ?></h3>

        <?php if (empty($materiels)): ?>
            <div class="alert alert-info text-center" role="alert">
                Aucun matériel trouvé pour cette catégorie.
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($materiels as $materiel): ?>
                    <article class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card bg-dark text-light border-light h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($materiel['nom']); ?></h5>
                                <p class="card-text">
                                    <small class="text-muted">Type: <?php echo htmlspecialchars($materiel['type']); ?></small>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars($materiel['description']); ?></p>
                                <p class="card-text">
                                    <span class="badge bg-success">Disponible: <?php echo $materiel['quantite_disponible']; ?></span>
                                    <span class="badge bg-secondary">Total: <?php echo $materiel['quantite_totale']; ?></span>
                                </p>
                                <p class="card-text">
                                    <span class="badge bg-info">État: <?php echo htmlspecialchars($materiel['etat']); ?></span>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top border-light">
                                <button class="btn btn-outline-light btn-sm w-100">
                                    <i class="bi bi-info-circle me-1"></i>Détails
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

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