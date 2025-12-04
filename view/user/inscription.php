<?php
require_once __DIR__ . '/../includes/header.php';

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: accueil.php');
    exit();
}

$errors = [];
$formData = [
    'prenom' => '',
    'nom' => '',
    'email' => '',
    'telephone' => ''
];

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $formData['prenom'] = trim($_POST['prenom'] ?? '');
    $formData['nom'] = trim($_POST['nom'] ?? '');
    $formData['email'] = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $formData['telephone'] = trim($_POST['telephone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $acceptTerms = isset($_POST['accept_terms']);

    // Validation des champs
    if (empty($formData['prenom'])) {
        $errors['prenom'] = 'Le prénom est obligatoire';
    } elseif (strlen($formData['prenom']) < 2) {
        $errors['prenom'] = 'Le prénom doit contenir au moins 2 caractères';
    }

    if (empty($formData['nom'])) {
        $errors['nom'] = 'Le nom est obligatoire';
    } elseif (strlen($formData['nom']) < 2) {
        $errors['nom'] = 'Le nom doit contenir au moins 2 caractères';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'L\'adresse email est obligatoire';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'L\'adresse email n\'est pas valide';
    }
    // Ici, vous devriez vérifier si l'email existe déjà dans la base de données

    if (!empty($formData['telephone']) && !preg_match('/^[0-9+\s-]{10,20}$/', $formData['telephone'])) {
        $errors['telephone'] = 'Le numéro de téléphone n\'est pas valide';
    }

    if (empty($password)) {
        $errors['password'] = 'Le mot de passe est obligatoire';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères';
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors['password'] = 'Le mot de passe doit contenir au moins une majuscule et un chiffre';
    }

    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
    }

    if (!$acceptTerms) {
        $errors['terms'] = 'Vous devez accepter les conditions d\'utilisation';
    }

    // Si pas d'erreurs, procéder à l'inscription
    if (empty($errors)) {
        // Ici, vous devrez ajouter la logique d'inscription dans votre base de données
        // Exemple: $user = $userService->register($formData, $password);
        
        // Simulation de succès (à remplacer par votre logique d'inscription)
        $_SESSION['user_id'] = 1;
        $_SESSION['user_email'] = $formData['email'];
        $_SESSION['success_message'] = 'Votre compte a été créé avec succès !';
        
        header('Location: accueil.php');
        exit();
    }
}
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 mb-4 text-center">Créer un compte</h1>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <p class="mb-0">Veuillez corriger les erreurs ci-dessous :</p>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="inscription.php" method="post" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo isset($errors['prenom']) ? 'is-invalid' : ''; ?>" 
                                       id="prenom" name="prenom" value="<?php echo htmlspecialchars($formData['prenom']); ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['prenom'] ?? 'Veuillez entrer votre prénom';
                                    ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo isset($errors['nom']) ? 'is-invalid' : ''; ?>" 
                                       id="nom" name="nom" value="<?php echo htmlspecialchars($formData['nom']); ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['nom'] ?? 'Veuillez entrer votre nom'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                   id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?php echo $errors['email'] ?? 'Veuillez entrer une adresse email valide'; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone (optionnel)</label>
                            <input type="tel" class="form-control <?php echo isset($errors['telephone']) ? 'is-invalid' : ''; ?>" 
                                   id="telephone" name="telephone" value="<?php echo htmlspecialchars($formData['telephone']); ?>">
                            <div class="invalid-feedback">
                                <?php echo $errors['telephone'] ?? 'Veuillez entrer un numéro de téléphone valide'; ?>
                            </div>
                            <div class="form-text">Format : 0612345678 ou +33612345678</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                           id="password" name="password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['password'] ?? 'Veuillez entrer un mot de passe valide'; ?>
                                    </div>
                                </div>
                                <div class="form-text">8 caractères minimum, avec au moins une majuscule et un chiffre</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                           id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['confirm_password'] ?? 'Les mots de passe ne correspondent pas'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input <?php echo isset($errors['terms']) ? 'is-invalid' : ''; ?>" 
                                       type="checkbox" id="accept_terms" name="accept_terms" 
                                       <?php echo !empty($_POST['accept_terms']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="accept_terms">
                                    J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">conditions d'utilisation</a> <span class="text-danger">*</span>
                                </label>
                                <div class="invalid-feedback">
                                    <?php echo $errors['terms'] ?? 'Vous devez accepter les conditions d\'utilisation'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">S'inscrire</button>
                        </div>
                        
                        <div class="text-center">
                            <p class="mb-0">Déjà inscrit ? 
                                <a href="connexion.php" class="text-decoration-none">Se connecter</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Conditions d'utilisation -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Conditions d'utilisation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <h6>1. Acceptation des conditions</h6>
                <p>En vous inscrivant sur notre plateforme, vous acceptez les présentes conditions d'utilisation dans leur intégralité.</p>
                
                <h6>2. Compte utilisateur</h6>
                <p>Vous êtes responsable de la confidentialité de votre compte et de votre mot de passe. Vous vous engagez à ne pas partager ces informations avec des tiers.</p>
                
                <h6>3. Données personnelles</h6>
                <p>Vos données personnelles sont collectées et traitées conformément à notre politique de confidentialité. En vous inscrivant, vous acceptez notre politique de protection des données.</p>
                
                <h6>4. Responsabilité</h6>
                <p>Nous nous efforçons de fournir un service de qualité mais ne pouvons garantir un fonctionnement ininterrompu ou exempt d'erreurs.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
// Afficher/masquer le mot de passe
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const passwordInput = this.previousElementSibling;
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
});

// Validation du formulaire côté client
(function () {
    'use strict';
    
    const forms = document.querySelectorAll('.needs-validation');
    
    // Validation personnalisée pour le mot de passe
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    if (password) {
        password.addEventListener('input', function() {
            if (this.validity.tooShort) {
                this.setCustomValidity('Le mot de passe doit contenir au moins 8 caractères');
            } else if (!/[A-Z]/.test(this.value) || !/[0-9]/.test(this.value)) {
                this.setCustomValidity('Le mot de passe doit contenir au moins une majuscule et un chiffre');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Validation du formulaire
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Vérification supplémentaire pour la confirmation du mot de passe
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
                confirmPassword.reportValidity();
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
