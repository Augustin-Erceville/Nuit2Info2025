<?php
require_once __DIR__ . '/../includes/header.php';

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: accueil.php');
    exit();
}

$error = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Ici, vous devrez ajouter la logique de vérification des identifiants
        // avec votre système d'authentification
        // Exemple: $user = $authService->authenticate($email, $password);
        
        // Simulation de succès (à remplacer par votre logique d'authentification)
        if ($email === 'test@example.com' && $password === 'password') {
            $_SESSION['user_id'] = 1;
            $_SESSION['user_email'] = $email;
            header('Location: accueil.php');
            exit();
        } else {
            $error = 'Adresse email ou mot de passe incorrect.';
        }
    }
}
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 mb-4 text-center">Connexion</h1>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <form action="connexion.php" method="post" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                Veuillez entrer une adresse email valide.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="password" class="form-label mb-0">Mot de passe</label>
                                <a href="mot-de-passe-oublie.php" class="small">Mot de passe oublié ?</a>
                            </div>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">
                                    Veuillez entrer votre mot de passe.
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                        </div>
                        
                        <div class="text-center">
                            <p class="mb-0">Vous n'avez pas de compte ? 
                                <a href="inscription.php" class="text-decoration-none">S'inscrire</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

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
    'use strict'
    
    const forms = document.querySelectorAll('.needs-validation')
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
