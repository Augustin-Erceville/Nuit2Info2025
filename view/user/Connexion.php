<?php
session_start();

// Récupération des messages
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success_message'] ?? '';

// Nettoyage des variables de session après affichage
unset($_SESSION['error'], $_SESSION['success_message']);
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Connexion - Nuit de l'Info</title>
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

    <section class="container">
        <div class="card text-center text-light border-light bg-transparent">
            <div class="card-header fs-3 fw-bold border-light text-uppercase bg-black">
                Connexion
            </div>
            <div class="card-body">
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="../../src/Traitement/ConnexionTrt.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control text-light bg-transparent"
                               id="floatingInput" name="email" placeholder="name@example.com"
                               required autocomplete="email"
                               value="<?= htmlspecialchars($_SESSION['last_email'] ?? '') ?>">
                        <label for="floatingInput">Adresse email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control text-light bg-transparent"
                               id="floatingPassword" name="motDePasse" placeholder="Mot de passe"
                               required autocomplete="current-password">
                        <label for="floatingPassword">Mot de passe</label>
                    </div>
                    <div class="row g-2 my-1 mb-3">
                        <div class="col text-end">
                            <button type="button" class="btn btn-sm btn-outline-light" id="togglePassword">
                                <i class="bi bi-eye"></i> Afficher le mot de passe
                            </button>
                        </div>
                    </div>
                    <div class="row g-2 my-3">
                        <div class="col">
                            <button type="submit" name="connexion" class="btn btn-lg w-100 btn-primary text-light">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </button>
                        </div>
                    </div>
                </form>
                <a href="Inscription.php" class="btn btn-secondary btn-sm w-100">
                    <i class="bi bi-person-plus-fill me-2"></i>S'inscrire
                </a>
            </div>
            <div class="card-footer text-light fw-lighter border-light">
                Vous n'avez pas encore de compte ? Inscrivez-vous gratuitement.
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Toggle password visibility
            const toggleBtn = document.getElementById('togglePassword');
            const pwdInput = document.getElementById('floatingPassword');

            if (toggleBtn && pwdInput) {
                toggleBtn.addEventListener('click', function () {
                    const type = pwdInput.type === 'password' ? 'text' : 'password';
                    pwdInput.type = type;

                    const icon = this.querySelector('i');
                    if (type === 'text') {
                        icon.className = 'bi bi-eye-slash';
                        this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer le mot de passe';
                    } else {
                        icon.className = 'bi bi-eye';
                        this.innerHTML = '<i class="bi bi-eye"></i> Afficher le mot de passe';
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php
// Nettoyer l'email sauvegardé après affichage
unset($_SESSION['last_email']);
?>