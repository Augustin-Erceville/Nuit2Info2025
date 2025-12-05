<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - NIRD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #212529;
            color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #1a1d20 0%, #2d3339 100%);
            padding: 5rem 0;
            margin-bottom: 4rem;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .feature-card {
            background: linear-gradient(135deg, #2d3339 0%, #343a40 100%);
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            border-color: rgba(13, 110, 253, 0.5);
        }
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .action-btn {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .action-btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
        }
        .action-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
        }
        .action-btn-outline {
            border-color: #0d6efd;
            color: #0d6efd;
        }
        .action-btn-outline:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-3px);
        }
        .stats-card {
            background: rgba(13, 110, 253, 0.1);
            border-left: 4px solid #0d6efd;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        .module-showcase {
            background: linear-gradient(135deg, #2d3339 0%, #1a1d20 100%);
            border-radius: 15px;
            padding: 3rem;
            margin-bottom: 3rem;
            border: 2px solid rgba(13, 110, 253, 0.3);
        }
        .module-showcase:hover {
            border-color: rgba(13, 110, 253, 0.6);
            box-shadow: 0 15px 35px rgba(13, 110, 253, 0.2);
        }
        .advantage-item {
            display: flex;
            align-items-start;
            padding: 1rem;
            background: rgba(13, 110, 253, 0.05);
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .advantage-item:hover {
            background: rgba(13, 110, 253, 0.1);
            transform: translateX(10px);
        }
        .advantage-item i {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: #0d6efd;
            margin-top: 0.2rem;
        }
    </style>
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
            <ul class="navbar-nav ms-auto d-none d-lg-flex align-items-center">
                <li class="nav-item me-2">
                    <a href="APropos.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="À propos">
                        <i class="bi bi-info-circle"></i>
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="chatBot/viewChatBot.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="ChatBot">
                        <i class="bi bi-chat-dots"></i>
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="qcm.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="Quiz">
                        <i class="bi bi-question-circle"></i>
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="moduleMateriel/moduleMaterielMain.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="Matériels">
                        <i class="bi bi-pc-display"></i>
                    </a>
                </li>
                <li class="nav-item">
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
                </li>
            </ul>
            <!-- Mobile menu -->
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="APropos.php">
                        <i class="bi bi-info-circle"></i>
                        À propos
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="chatBot/viewChatBot.php">
                        <i class="bi bi-chat-dots"></i>
                        ChatBot
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="qcm.php">
                        <i class="bi bi-question-circle"></i>
                        Quiz
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

<div class="container my-5">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content text-center px-4">
            <h1 class="display-2 fw-bold mb-4">
                Bienvenue sur NIRD
            </h1>
            <p class="lead fs-3 mb-4">
                Numérique Inclusif, Responsable et Durable
            </p>
            <p class="fs-5 mb-5 text-muted">
                Une démarche pour libérer les établissements scolaires de la dépendance aux Big Tech
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="APropos.php" class="btn action-btn action-btn-primary">
                    <i class="bi bi-info-circle me-2"></i>Découvrir le projet
                </a>
                <a href="qcm.php" class="btn action-btn action-btn-outline">
                    <i class="bi bi-question-circle me-2"></i>Testez vos connaissances
                </a>
            </div>
        </div>
    </div>

    <!-- Module Showcase -->
    <div class="module-showcase">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="text-center">
                    <div class="feature-icon mx-auto" style="width: 120px; height: 120px;">
                        <i class="bi bi-pc-display-horizontal fs-1 text-white"></i>
                    </div>
                    <h2 class="fw-bold mt-4 mb-3 display-6">Gestion des Matériels</h2>
                    <p class="text-muted fs-5">Un exemple concret de notre démarche</p>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="fw-bold mb-4">
                    <i class="bi bi-lightbulb-fill text-warning me-2"></i>
                    Des applications web légères et libres
                </h3>
                <p class="fs-5 mb-4">
                    Avec des applications internet développées par des développeurs comme nous, il est possible de gérer
                    efficacement des fonctionnalités essentielles tout en respectant les principes du logiciel libre (open source)
                    et de la sobriété numérique.
                </p>

                <div class="advantage-item">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <div>
                        <strong>Faible consommation de ressources</strong>
                        <p class="mb-0 text-muted">Applications optimisées qui fonctionnent même sur du matériel ancien</p>
                    </div>
                </div>

                <div class="advantage-item">
                    <i class="bi bi-unlock-fill"></i>
                    <div>
                        <strong>Open Source et libre de droits</strong>
                        <p class="mb-0 text-muted">Code accessible, modifiable et partageable par tous</p>
                    </div>
                </div>

                <div class="advantage-item">
                    <i class="bi bi-people-fill"></i>
                    <div>
                        <strong>Développé par la communauté</strong>
                        <p class="mb-0 text-muted">Des solutions créées par et pour les établissements scolaires</p>
                    </div>
                </div>

                <div class="advantage-item">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <strong>Autonomie et indépendance</strong>
                        <p class="mb-0 text-muted">Plus de dépendance aux licences coûteuses des Big Tech</p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="moduleMateriel/moduleMaterielMain.php" class="btn action-btn action-btn-primary w-100">
                        <i class="bi bi-box-arrow-up-right me-2"></i>
                        Découvrir le module de gestion du parc informatique
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <h2 class="fw-bold mb-4 text-center">
                <i class="bi bi-graph-up text-success me-2"></i>
                Impact de la démarche NIRD
            </h2>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="bi bi-pc-display-horizontal fs-1 text-primary mb-2"></i>
                        <h3 class="fs-2 fw-bold mb-0 text-primary">24</h3>
                        <p class="mb-0">Matériels gérés</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="bi bi-recycle fs-1 text-success mb-2"></i>
                        <h3 class="fs-2 fw-bold mb-0 text-success">12</h3>
                        <p class="mb-0">Matériels reconditionnés</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="bi bi-lightning-charge fs-1 text-warning mb-2"></i>
                        <h3 class="fs-2 fw-bold mb-0 text-warning">-40%</h3>
                        <p class="mb-0">Consommation énergétique</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="bi bi-currency-euro fs-1 text-info mb-2"></i>
                        <h3 class="fs-2 fw-bold mb-0 text-info">-60%</h3>
                        <p class="mb-0">Coûts de licences</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <h2 class="fw-bold mb-4 text-center">
        <i class="bi bi-stars text-warning me-2"></i>
        Nos outils au service de votre établissement
    </h2>
    <div class="row g-4 mb-5">
        <?php
        $features = [
                [
                        'icon' => 'pc-display',
                        'title' => 'Gestion du matériel',
                        'description' => 'Module complet pour gérer votre parc informatique : inventaire, réservations, suivi de l\'état et reconditionnement.',
                        'link' => 'moduleMateriel/moduleMaterielMain.php',
                        'color' => 'primary'
                ],
                [
                        'icon' => 'chat-dots',
                        'title' => 'ChatBot interactif',
                        'description' => 'Assistant virtuel pour répondre à vos questions sur la démarche NIRD et vous guider dans vos choix.',
                        'link' => 'chatBot/viewChatBot.php',
                        'color' => 'success'
                ],
                [
                        'icon' => 'question-circle',
                        'title' => 'Quiz éducatif',
                        'description' => 'Testez vos connaissances sur le numérique responsable, l\'open source et la sobriété numérique.',
                        'link' => 'qcm.php',
                        'color' => 'info'
                ],
                [
                        'icon' => 'shield-check',
                        'title' => 'Sécurité et confidentialité',
                        'description' => 'Données hébergées en France, respect du RGPD et utilisation de logiciels libres et open source.',
                        'link' => 'APropos.php',
                        'color' => 'warning'
                ],
                [
                        'icon' => 'people',
                        'title' => 'Gestion des comptes',
                        'description' => 'Interface intuitive pour les enseignants, élèves et administrateurs avec des rôles personnalisés.',
                        'link' => 'Connexion.php',
                        'color' => 'danger'
                ],
                [
                        'icon' => 'book',
                        'title' => 'Documentation',
                        'description' => 'Ressources complètes pour comprendre et mettre en œuvre la démarche NIRD dans votre établissement.',
                        'link' => 'APropos.php',
                        'color' => 'secondary'
                ]
        ];

        foreach ($features as $feature) {
            echo '<div class="col-md-6 col-lg-4">';
            echo '<a href="' . $feature['link'] . '" class="text-decoration-none">';
            echo '<div class="feature-card">';
            echo '<div class="feature-icon">';
            echo '<i class="bi bi-' . $feature['icon'] . ' fs-1 text-white"></i>';
            echo '</div>';
            echo '<h3 class="fw-bold mb-3 text-white">' . $feature['title'] . '</h3>';
            echo '<p class="text-muted">' . $feature['description'] . '</p>';
            echo '<span class="text-' . $feature['color'] . ' fw-bold">';
            echo 'Découvrir <i class="bi bi-arrow-right ms-1"></i>';
            echo '</span>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- CTA Section -->
    <div class="text-center py-5">
        <div class="hero-section py-4">
            <h2 class="display-5 fw-bold mb-4">Prêt à commencer ?</h2>
            <p class="lead mb-4">Rejoignez la démarche NIRD et contribuez à un numérique plus responsable</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="Inscription.php" class="btn action-btn action-btn-primary">
                    <i class="bi bi-person-plus me-2"></i>S'inscrire
                </a>
                <a href="Connexion.php" class="btn action-btn action-btn-outline">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </a>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-light py-4 mt-5 border-top border-secondary">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-moon-stars me-2"></i>NIRD
                </h5>
                <p class="text-muted">
                    Numérique Inclusif, Responsable et Durable pour un système éducatif autonome et éthique.
                </p>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold mb-3">Liens rapides</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="APropos.php" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>À propos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="hatBot/viewChatBot.php" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>ChatBot
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="qcm.php" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Quiz
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="moduleMateriel/moduleMaterielMain.php" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Gestion Matériels
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold mb-3">Contact</h5>
                <p class="text-muted mb-2">
                    <i class="bi bi-envelope me-2"></i>contact@nird.fr
                </p>
                <p class="text-muted">
                    <i class="bi bi-geo-alt me-2"></i>France
                </p>
            </div>
        </div>
        <hr class="border-secondary my-3">
        <div class="text-center text-muted">
            <p class="mb-0">© <?php echo date('Y'); ?> Démarche NIRD - Tous droits réservés</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>
</html>