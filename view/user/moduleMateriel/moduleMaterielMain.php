<?php
session_start();
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
                            <a class="dropdown-item" href="../connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../inscription.php">
                                <i class="bi bi-person-plus-fill me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--          Mobile menu          -->
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
                            <a class="dropdown-item" href="../connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../inscription.php">
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

<?php
$img = [
        "https://wallpaper.dog/large/20516113.png",
        "https://wallpaperswide.com/download/flat_design_illustration-wallpaper-3000x2000.jpg",
        "https://image.civitai.com/xG1nkqKTMzGDvpLrqFT7WA/3f811964-bed4-4072-b204-1c37e575fefb/width=1200/3f811964-bed4-4072-b204-1c37e575fefb.jpeg"
];
?>

<?php if (!empty($allEvenement)): ?>
    <section class="container my-3">
    <article class="row my-3">
    <div class="justify-content-center card-group">
    <?php
    $count = 0;
    foreach ($allEvenement as $evenement):
        if ($count > 0 && $count % 3 === 0):
            ?>
            </div>
            </article>
            </section>
            <section class="container my-3">
            <article class="row my-3">
            <div class="justify-content-center card-group">
        <?php
        endif;
        ?>
        <div class="card shadow-sm">
            <img src="<?= htmlspecialchars($img[$count % count($img)], ENT_QUOTES, 'UTF-8') ?>"
                 class="card-img-top"
                 style="height: 230px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold">
                    <?= htmlspecialchars($evenement->titre_eve, ENT_QUOTES, 'UTF-8') ?>
                </h5>
                <p class="card-text flex-grow-1 text-muted">
                    <?= htmlspecialchars(substr($evenement->desc_eve, 0, 100), ENT_QUOTES, 'UTF-8') ?>...
                </p>
                <a href="crudEvenement/evenementRead.php?id=<?= htmlspecialchars($evenement->id_evenement, ENT_QUOTES, 'UTF-8') ?>"
                   class="btn btn-primary mt-auto">
                    En savoir plus
                </a>
            </div>
            <div class="card-footer text-muted small">
                Dernière mise à jour : <?= date("d/m/Y H:i") ?>
            </div>
        </div>
        <?php
        $count++;
    endforeach;
    ?>
    </div>
    </article>
    </section>
<?php else: ?>
    <section class="container my-3">
        <article class="row my-3">
            <p class="text-light">Aucun événement trouvé.</p>
        </article>
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
