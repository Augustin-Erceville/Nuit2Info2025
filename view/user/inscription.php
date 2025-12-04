<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Portfolio</title>
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
                            <a class="dropdown-item" href="connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="inscription.php">
                                <i class="bi bi-person-plus-fill me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--          Mobile menu          -->
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
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
                            <a class="dropdown-item" href="connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="inscription.php">
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

<section class="container">
    <div class="card text-center text-light border-light bg-transparent">
        <div class="card-header fs-3 fw-bold border-light text-uppercase bg-black">
            Inscription
        </div>
        <div class="card-body">
            <form action="treatmentRegister.php" method="post">
                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control text-light bg-transparent"
                                   id="floatingPrenom" placeholder="Prénom" required
                                   autocomplete="given-name">
                            <label for="floatingPrenom">Prénom</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control text-light bg-transparent"
                                   id="floatingNom" placeholder="Nom de famille" required
                                   autocomplete="family-name">
                            <label for="floatingNom">Nom de famille</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="date" class="form-control text-light bg-transparent"
                                   id="floatingNaissance" placeholder="Date de naissance" required
                                   autocomplete="bday">
                            <label for="floatingNaissance">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="tel" class="form-control text-light bg-transparent"
                                   id="floatingTel" placeholder="Numéro de téléphone" required
                                   autocomplete="tel">
                            <label for="floatingTel">Numéro de téléphone</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control text-light bg-transparent"
                                   id="floatingDiscord" placeholder="Pseudo discord" required
                                   autocomplete="username">
                            <label for="floatingDiscord">Pseudo discord</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select text-light bg-transparent"
                                    id="floatingGenre" required autocomplete="sex">
                                <option value="" selected disabled>Choisir...</option>
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                                <option value="Autre">Autre</option>
                            </select>
                            <label for="floatingGenre">Genre</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="password" class="form-control text-light bg-transparent"
                                   id="floatingMotDePasse" placeholder="Mot de passe" required
                                   autocomplete="new-password">
                            <label for="floatingMotDePasse">Mot de passe</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="password" class="form-control text-light bg-transparent"
                                   id="floatingConfirmMDP" placeholder="Confirmation de mot de passe" required
                                   autocomplete="new-password">
                            <label for="floatingConfirmMDP">Confirmation de mot de passe</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2 my-1">
                    <div class="col text-end">
                        <button type="button" class="btn btn-sm btn-outline-light" id="togglePasswords">
                            Afficher les mots de passe
                        </button>
                    </div>
                </div>

                <div class="row g-2 my-3">
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            S'inscrire
                        </button>
                    </div>
                </div>
            </form>
            <a href="login.php" class="btn btn-secondary btn-sm w-100">
                Se connecter
            </a>
        </div>
        <div class="card-footer text-light fw-lighter border-light">
            Aucune informations fournis dans le formulaire ne doivent pas contenir d'informations personnelles réel.
        </div>
    </div>
</section>

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
