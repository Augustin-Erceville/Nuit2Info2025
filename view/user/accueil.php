<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Nuit 2 l'Info</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        <a class="navbar-brand d-flex align-items-center" href="accueil.php">
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
                <a href="chatBot/viewChatBot.php" class="btn btn-outline-light btn-lg me-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tchat">
                    <i class="bi bi-chat-text"></i>
                </a>
                <a href="moduleMateriel/moduleMaterielMain.php" class="btn btn-outline-light btn-lg me-2"
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
                            <a class="dropdown-item" href="Connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="Inscription.php">
                                <i class="bi bi-person-plus-fill me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
<!--          Mobile menu          -->
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="chatBot/viewChatBot.php">
                        <i class="bi bi-chat-text"></i>
                        Tchat
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="moduleMateriel/moduleMaterielMain.php">
                        <i class="bi bi-pc-display"></i>
                        Matériels
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn btn-outline-light w-100 dropdown-toggle" href="#"
                       id="compteDropdown" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-person me-1"></i>
                        Compte
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100" aria-labelledby="compteDropdown">
                        <li>
                            <a class="dropdown-item" href="Connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="Inscription.php">
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
