<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>À propos - NIRD</title>
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
            padding: 4rem 0;
            margin-bottom: 3rem;
            border-radius: 15px;
        }
        .section-card {
            background-color: #2d3339;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .pillar-card {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            border-radius: 10px;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
        }
        .pillar-card:hover {
            transform: scale(1.05);
        }
        .actor-badge {
            background-color: #495057;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            margin: 0.3rem;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .actor-badge:hover {
            background-color: #0d6efd;
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
            <!-- Mobile menu -->
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

<div class="container my-5">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="text-center px-4">
            <h1 class="display-3 fw-bold mb-4">
                <i class="bi bi-info-circle-fill text-primary me-3"></i>
                À propos de NIRD
            </h1>
            <p class="lead fs-4">Numérique Inclusif, Responsable et Durable</p>
        </div>
    </div>

    <!-- Présentation du sujet -->
    <div class="section-card">
        <div class="icon-box">
            <i class="bi bi-lightbulb-fill fs-2 text-white"></i>
        </div>
        <h2 class="fw-bold mb-4">Présentation du sujet</h2>
        <p class="fs-5 mb-3">
            À l'heure où la fin du support de Windows 10 met en évidence la dépendance structurelle aux Big Tech,
            les établissements scolaires se retrouvent confrontés à un empire numérique puissant : matériel rendu
            obsolète alors qu'il fonctionne encore, licences coûteuses, stockage de données hors UE, écosystèmes
            fermés, abonnements indispensables...
        </p>
        <p class="fs-5 mb-3">
            Face à ce Goliath numérique, l'École peut devenir un <strong>village résistant, ingénieux, autonome
                et créatif</strong>, à l'image du célèbre village d'Astérix.
        </p>
        <p class="fs-5">
            C'est précisément l'ambition de la démarche NIRD : permettre aux établissements scolaires d'adopter
            progressivement un Numérique Inclusif, Responsable et Durable, en redonnant du pouvoir d'agir aux
            équipes éducatives et en renforçant leur autonomie technologique.
        </p>
    </div>

    <!-- Les acteurs -->
    <div class="section-card">
        <div class="icon-box">
            <i class="bi bi-people-fill fs-2 text-white"></i>
        </div>
        <h2 class="fw-bold mb-4">Les acteurs du projet NIRD</h2>
        <p class="fs-5 mb-4">
            La démarche NIRD est portée par un collectif enseignant de la <strong>Forge des communs numériques
                éducatifs</strong>, projet soutenu par la Direction du numérique pour l'éducation. C'est une initiative
            d'en bas qui cherche à montrer en haut qu'il y a urgence à agir pour changer la situation.
        </p>
        <p class="fs-5 mb-4">Elle associe un ensemble d'acteurs du système éducatif et des territoires :</p>
        <div class="text-center">
            <?php
            $acteurs = [
                ['icon' => 'person-check', 'text' => 'Élèves et éco-délégués'],
                ['icon' => 'mortarboard', 'text' => 'Enseignants et enseignantes'],
                ['icon' => 'building', 'text' => 'Directions d\'établissements'],
                ['icon' => 'tools', 'text' => 'Techniciens et administrateurs réseaux'],
                ['icon' => 'heart', 'text' => 'Associations partenaires et clubs informatiques'],
                ['icon' => 'geo-alt', 'text' => 'Collectivités territoriales'],
                ['icon' => 'bank', 'text' => 'Services académiques et ministère']
            ];

            foreach ($acteurs as $acteur) {
                echo '<span class="actor-badge">';
                echo '<i class="bi bi-' . $acteur['icon'] . ' me-2"></i>';
                echo $acteur['text'];
                echo '</span>';
            }
            ?>
        </div>
        <p class="fs-5 mt-4 text-center fst-italic">
            Ensemble, ces acteurs expérimentent, partagent et transforment les pratiques pour construire un
            numérique éducatif plus autonome, plus durable, plus éthique.
        </p>
    </div>

    <!-- Activités -->
    <div class="section-card">
        <div class="icon-box">
            <i class="bi bi-gear-fill fs-2 text-white"></i>
        </div>
        <h2 class="fw-bold mb-4">Ses activités</h2>
        <p class="fs-5 mb-4">
            La démarche NIRD vise à promouvoir un numérique libre, responsable et écocitoyen au sein des
            établissements scolaires. Ses principales activités sont :
        </p>
        <div class="row g-3">
            <?php
            $activites = [
                'Sensibiliser les équipes éducatives et les élèves à la sobriété numérique',
                'Encourager le réemploi et le reconditionnement du matériel',
                'Promouvoir l\'usage de Linux afin de lutter contre l\'obsolescence programmée',
                'Mutualiser les ressources et outils libres via la Forge des communs numériques éducatifs',
                'Accompagner les établissements et collectivités dans une transition numérique écoresponsable',
                'Favoriser la co-construction de solutions numériques locales, ouvertes et autonomes'
            ];

            foreach ($activites as $activite) {
                echo '<div class="col-md-6">';
                echo '<div class="d-flex align-items-start">';
                echo '<i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>';
                echo '<p class="fs-5 mb-0">' . $activite . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Les trois piliers -->
    <div class="text-center mb-4">
        <h2 class="display-5 fw-bold">Les trois piliers de NIRD</h2>
        <p class="lead">Qui guident l'ensemble des actions menées</p>
    </div>
    <div class="row g-4 mb-5">
        <?php
        $piliers = [
            [
                'icon' => 'universal-access',
                'color' => 'primary',
                'titre' => 'Inclusion',
                'description' => 'Garantir l\'accès à tous, sans discrimination, pour un numérique éducatif équitable et ouvert.'
            ],
            [
                'icon' => 'shield-check',
                'color' => 'success',
                'titre' => 'Responsabilité',
                'description' => 'Adopter des pratiques éthiques et respectueuses des données personnelles et de la vie privée.'
            ],
            [
                'icon' => 'recycle',
                'color' => 'info',
                'titre' => 'Durabilité',
                'description' => 'Promouvoir la sobriété numérique et lutter contre l\'obsolescence programmée.'
            ]
        ];

        foreach ($piliers as $pilier) {
            echo '<div class="col-md-4">';
            echo '<div class="pillar-card text-center">';
            echo '<i class="bi bi-' . $pilier['icon'] . ' fs-1 text-' . $pilier['color'] . ' mb-3"></i>';
            echo '<h3 class="fw-bold mb-3">' . $pilier['titre'] . '</h3>';
            echo '<p class="fs-5">' . $pilier['description'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>
</html>