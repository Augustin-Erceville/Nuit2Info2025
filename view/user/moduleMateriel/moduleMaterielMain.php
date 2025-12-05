<?php
session_start();

require_once '../../../src/bdd/config.php';
require_once '../../../src/repository/MaterielRepository.php';

use repository\MaterielRepository;

// Récupère la connexion PDO
$database = new Bdd('localhost', 'nird_village', 'root', '');
$bdd = $database->getPDO();

$materielRepo = new MaterielRepository($bdd);
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

<!-- Messages de succès/erreur -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Section Résumé des Réservations -->
<?php if (isset($_SESSION['reservations']) && !empty($_SESSION['reservations'])): ?>
    <section class="container my-4">
        <div class="card bg-dark text-light border-primary">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-cart-check me-2"></i>Mes Réservations
                    <span class="badge bg-light text-dark ms-2"><?php echo count($_SESSION['reservations']); ?></span>
                </h5>
                <a href="viderReservations.php" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-trash me-1"></i>Tout vider
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                        <tr>
                            <th>Matériel</th>
                            <th>Type</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($_SESSION['reservations'] as $index => $reservation): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservation['nom']); ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($reservation['type']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">×<?php echo $reservation['quantite']; ?></span>
                                </td>
                                <td class="text-end">
                                    <a href="supprimerReservation.php?index=<?php echo $index; ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Supprimer cette réservation ?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0 text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Total: <strong><?php
                            $total = array_sum(array_column($_SESSION['reservations'], 'quantite'));
                            echo $total;
                            ?></strong> article<?php echo $total > 1 ? 's' : ''; ?>
                    </p>

                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Section des catégories -->
<section class="container my-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-light mb-0">Matériels</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterMaterielModal">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un matériel
        </button>
    </div>
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
                                <form method="POST" action="reserverMateriel.php" class="d-flex gap-2 align-items-center">
                                    <input type="hidden" name="id_materiel" value="<?php echo $materiel['id']; ?>">
                                    <input type="hidden" name="nom" value="<?php echo htmlspecialchars($materiel['nom']); ?>">
                                    <input type="hidden" name="type" value="<?php echo htmlspecialchars($materiel['type']); ?>">

                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<!-- Modal Ajouter Matériel -->
<div class="modal fade" id="ajouterMaterielModal" tabindex="-1" aria-labelledby="ajouterMaterielModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="ajouterMaterielModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter un nouveau matériel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="ajouterMateriel.php">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom du matériel *</label>
                            <input type="text" class="form-control bg-secondary text-light border-secondary"
                                   id="nom" name="nom" required>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label">Type *</label>
                            <select class="form-select bg-secondary text-light border-secondary"
                                    id="type" name="type" required>
                                <option value="">-- Choisir un type --</option>
                                <option value="Tour">Tour</option>
                                <option value="Clavier">Clavier</option>
                                <option value="Souris">Souris</option>
                                <option value="Ecran">Écran</option>
                                <option value="Webcam">Webcam</option>
                                <option value="Câble">Câble</option>
                                <option value="PCPortable">PC Portable</option>
                                <option value="Enceinte">Enceinte</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control bg-secondary text-light border-secondary"
                                      id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="quantite_disponible" class="form-label">Quantité disponible *</label>
                            <input type="number" class="form-control bg-secondary text-light border-secondary"
                                   id="quantite_disponible" name="quantite_disponible" min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label for="quantite_totale" class="form-label">Quantité totale *</label>
                            <input type="number" class="form-control bg-secondary text-light border-secondary"
                                   id="quantite_totale" name="quantite_totale" min="1" required>
                        </div>

                        <div class="col-md-4">
                            <label for="etat" class="form-label">État *</label>
                            <select class="form-select bg-secondary text-light border-secondary"
                                    id="etat" name="etat" required>
                                <option value="bon">Bon</option>
                                <option value="correct">Correct</option>
                                <option value="mauvais">Mauvais</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <input type="hidden" name="id_etablissement" value="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmer les Réservations -->
<div class="modal fade" id="confirmerReservationsModal" tabindex="-1" aria-labelledby="confirmerReservationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="confirmerReservationsModalLabel">
                    <i class="bi bi-check-circle me-2"></i>Confirmer vos réservations
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($_SESSION['reservations']) && !empty($_SESSION['reservations'])): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Vous êtes sur le point de confirmer la réservation de <strong><?php echo count($_SESSION['reservations']); ?></strong> matériel(s).
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                            <tr>
                                <th>Matériel</th>
                                <th>Type</th>
                                <th class="text-center">Quantité</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['reservations'] as $reservation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservation['nom']); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($reservation['type']); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">×<?php echo $reservation['quantite']; ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <form method="POST" action="confirmerReservations.php">
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début *</label>
                            <input type="date" class="form-control bg-secondary text-light border-secondary"
                                   id="date_debut" name="date_debut" required
                                   min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de fin *</label>
                            <input type="date" class="form-control bg-secondary text-light border-secondary"
                                   id="date_fin" name="date_fin" required
                                   min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                            <textarea class="form-control bg-secondary text-light border-secondary"
                                      id="commentaire" name="commentaire" rows="3"
                                      placeholder="Motif de la réservation, remarques..."></textarea>
                        </div>
                        <div class="modal-footer border-secondary px-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>Confirmer la réservation
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Réinitialise le formulaire quand le modal est fermé
        var ajouterMaterielModal = document.getElementById('ajouterMaterielModal');
        if (ajouterMaterielModal) {
            ajouterMaterielModal.addEventListener('hidden.bs.modal', function () {
                var form = ajouterMaterielModal.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>