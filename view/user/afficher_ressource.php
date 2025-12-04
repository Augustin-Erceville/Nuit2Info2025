<?php
session_start();
require "config.php";

// ID de la ressource
$ressource_id = $_GET['id'];

// Charger la ressource
$req_ress = $pdo->prepare("SELECT * FROM ressources_contenu WHERE id = ?");
$req_ress->execute([$ressource_id]);
$ressource = $req_ress->fetch();

if (!$ressource) {
    die("Ressource non trouvée.");
}
function afficherCommentaires($list, $parent = null, $niveau = 0) {
    $html = '';
    foreach ($list as $comment) {
        if ($comment['parent_id'] == $parent) {
            $html .= '<div class="card mb-3 ms-' . ($niveau * 3) . '">';
            $html .= '    <div class="card-body">';
            $html .= '        <h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($comment['auteur']) . '</h6>';
            $html .= '        <p class="card-text">' . nl2br(htmlspecialchars($comment['contenu'])) . '</p>';
            $html .= '        <a href="#" class="btn btn-sm btn-outline-secondary repondre" data-id="' . $comment['id'] . '">Répondre</a>';
            
            // Afficher les réponses
            $html .= afficherCommentaires($list, $comment['id'], $niveau + 1);
            
            $html .= '    </div>';
            $html .= '</div>';
        }
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ressource['titre']); ?> - Nuit de l'Info</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .comment-form {
            display: none;
            margin-top: 15px;
        }
        body {
            background-color: #f8f9fa;
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

<main class="container my-4">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <h1 class="card-title"><?php echo htmlspecialchars($ressource['titre']); ?></h1>
            <div class="card-text">
                <?php echo nl2br(htmlspecialchars($ressource['contenu'])); ?>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h3 class="text-light">Commentaires</h3>
        <div id="commentaires" class="mb-4">
            <?php
            $req_com = $pdo->query("SELECT * FROM commentaires WHERE ressource_id = $ressource_id ORDER BY date_creation");
            $commentaires = $req_com->fetchAll();
            echo afficherCommentaires($commentaires);
            ?>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary" id="ajouterCommentaire">
                <i class="bi bi-chat-left-text me-2"></i>Ajouter un commentaire
            </button>
            
            <form id="commentForm" class="comment-form mt-3 bg-dark p-3 rounded" action="poster_commentaire.php" method="post">
                <input type="hidden" name="ressource_id" value="<?php echo $ressource_id; ?>">
                <input type="hidden" name="parent_id" id="parent_id" value="0">
                
                <div class="mb-3">
                    <label for="auteur" class="form-label text-light">Votre nom</label>
                    <input type="text" class="form-control bg-dark text-light" id="auteur" name="auteur" required>
                </div>
                
                <div class="mb-3">
                    <label for="contenu" class="form-label text-light">Votre commentaire</label>
                    <textarea class="form-control bg-dark text-light" id="contenu" name="contenu" rows="3" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-2"></i>Envoyer
                </button>
                <button type="button" class="btn btn-outline-light" id="annulerCommentaire">
                    <i class="bi bi-x-lg me-2"></i>Annuler
                </button>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialiser les tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Gestion des commentaires
        document.getElementById('ajouterCommentaire').addEventListener('click', function() {
            document.getElementById('commentForm').style.display = 'block';
            document.getElementById('parent_id').value = '0';
            this.style.display = 'none';
            document.getElementById('contenu').focus();
        });

        document.getElementById('annulerCommentaire').addEventListener('click', function() {
            document.getElementById('commentForm').style.display = 'none';
            document.getElementById('ajouterCommentaire').style.display = 'block';
            document.getElementById('parent_id').value = '0';
        });

        // Gérer les boutons de réponse
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('repondre')) {
                e.preventDefault();
                document.getElementById('parent_id').value = e.target.getAttribute('data-id');
                document.getElementById('commentForm').style.display = 'block';
                document.getElementById('ajouterCommentaire').style.display = 'none';
                document.getElementById('commentForm').scrollIntoView({ behavior: 'smooth' });
                document.getElementById('contenu').focus();
            }
        });
    });
</script>
</body>
</html>
