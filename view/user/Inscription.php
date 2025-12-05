<?php
require_once __DIR__ . '/../../src/Bdd/config.php';
require_once __DIR__ . '/../../src/repository/UtilisateurRepository.php';
use repository\UtilisateurRepository;

session_start();

try {
    $database = new Bdd('localhost', 'nird_village', 'root', '');
    $bdd = $database->getBdd();
    $repo = new UtilisateurRepository($bdd);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
            'nom' => trim($_POST["nom"] ?? ''),
            'prenom' => trim($_POST["prenom"] ?? ''),
            'email' => trim($_POST["email"] ?? ''),
            'adresse' => trim($_POST["adresse"] ?? ''),
            'telephone' => trim($_POST["telephone"] ?? ''),
            'dateNaissance' => trim($_POST["dateNaissance"] ?? ''),
            'motDePasse' => trim($_POST["motDePasse"] ?? '')
    ];

    $confirmPassword = trim($_POST["confirmMotDePasse"] ?? '');

    // Validation des champs
    if (!$data['nom'] || !$data['prenom'] || !$data['email'] || !$data['adresse'] || !$data['telephone'] || !$data['dateNaissance'] || !$data['motDePasse']) {
        $error = "Tous les champs sont requis.";
    } elseif ($data['motDePasse'] !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($data['motDePasse']) < 12) {
        $error = "Le mot de passe doit contenir au moins 12 caractères.";
    } elseif (!preg_match('/[A-Z]/', $data['motDePasse'])) {
        $error = "Le mot de passe doit contenir au moins une majuscule.";
    } elseif (!preg_match('/[a-z]/', $data['motDePasse'])) {
        $error = "Le mot de passe doit contenir au moins une minuscule.";
    } elseif (!preg_match('/[0-9]/', $data['motDePasse'])) {
        $error = "Le mot de passe doit contenir au moins un chiffre.";
    } elseif (!preg_match('/[\W_]/', $data['motDePasse'])) {
        $error = "Le mot de passe doit contenir au moins un caractère spécial.";
    } else {
        $result = $repo->Inscription($data);
        $success = $result['success'];
        $error = $result['error'];

        // Redirection en cas de succès
        if ($success) {
            $_SESSION['success_message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header('Location: Connexion.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Nuit 2 l'Info</title>
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
            Inscription
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control text-light bg-transparent"
                                   id="floatingPrenom" name="prenom" placeholder="Prénom" required
                                   autocomplete="given-name" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
                            <label for="floatingPrenom">Prénom</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control text-light bg-transparent"
                                   id="floatingNom" name="nom" placeholder="Nom de famille" required
                                   autocomplete="family-name" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                            <label for="floatingNom">Nom de famille</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="date" class="form-control text-light bg-transparent"
                                   id="floatingNaissance" name="dateNaissance" placeholder="Date de naissance" required
                                   autocomplete="bday" value="<?= htmlspecialchars($_POST['dateNaissance'] ?? '') ?>">
                            <label for="floatingNaissance">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="tel" class="form-control text-light bg-transparent"
                                   id="floatingTel" name="telephone" placeholder="Numéro de téléphone" required
                                   autocomplete="tel" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
                            <label for="floatingTel">Numéro de téléphone</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="email" class="form-control text-light bg-transparent"
                                   id="floatingEmail" name="email" placeholder="Adresse email" required
                                   autocomplete="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            <label for="floatingEmail">Adresse email</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control text-light bg-transparent"
                                   id="floatingAdresse" name="adresse" placeholder="Adresse" required
                                   autocomplete="street-address" value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>">
                            <label for="floatingAdresse">Adresse</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="password" class="form-control text-light bg-transparent"
                                   id="floatingMotDePasse" name="motDePasse" placeholder="Mot de passe" required
                                   autocomplete="new-password">
                            <label for="floatingMotDePasse">Mot de passe</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="password" class="form-control text-light bg-transparent"
                                   id="floatingConfirmMDP" name="confirmMotDePasse" placeholder="Confirmation de mot de passe" required
                                   autocomplete="new-password">
                            <label for="floatingConfirmMDP">Confirmation de mot de passe</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 my-1">
                    <div class="col">
                        <div id="msg" class="text-start text-warning small"></div>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-sm btn-outline-light" id="togglePasswords">
                            <i class="bi bi-eye"></i> Afficher les mots de passe
                        </button>
                    </div>
                </div>

                <div class="row g-2 my-3">
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-person-plus-fill me-2"></i>S'inscrire
                        </button>
                    </div>
                </div>
            </form>
            <a href="Connexion.php" class="btn btn-secondary btn-sm w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </a>
        </div>
        <div class="card-footer text-light fw-lighter border-light">
            Aucune information fournie dans le formulaire ne doit contenir d'informations personnelles réelles.
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

        // Validation du mot de passe en temps réel
        const pwdInput = document.getElementById('floatingMotDePasse');
        const msg = document.getElementById('msg');

        pwdInput.addEventListener('input', function () {
            const pwd = this.value;
            let text = "";
            let valid = true;

            if (pwd.length < 12) {
                text += "❌ 12 caractères minimum<br>";
                valid = false;
            }
            if (!/[A-Z]/.test(pwd)) {
                text += "❌ 1 majuscule<br>";
                valid = false;
            }
            if (!/[a-z]/.test(pwd)) {
                text += "❌ 1 minuscule<br>";
                valid = false;
            }
            if (!/[0-9]/.test(pwd)) {
                text += "❌ 1 chiffre<br>";
                valid = false;
            }
            if (!/[\W_]/.test(pwd)) {
                text += "❌ 1 caractère spécial<br>";
                valid = false;
            }

            msg.innerHTML = text || "✅ Mot de passe sécurisé";
            msg.className = valid && pwd.length > 0 ? 'text-start text-success small' : 'text-start text-warning small';
        });

        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePasswords');
        const pwd1 = document.getElementById('floatingMotDePasse');
        const pwd2 = document.getElementById('floatingConfirmMDP');

        toggleBtn.addEventListener('click', function () {
            const type = pwd1.type === 'password' ? 'text' : 'password';
            pwd1.type = type;
            pwd2.type = type;

            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.className = 'bi bi-eye-slash';
                this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer les mots de passe';
            } else {
                icon.className = 'bi bi-eye';
                this.innerHTML = '<i class="bi bi-eye"></i> Afficher les mots de passe';
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>