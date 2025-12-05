<?php
namespace controleur;

require_once __DIR__ . '/../Bdd/Bdd.php';
require_once __DIR__ . '/../modele/Utilisateur.php';
require_once __DIR__ . '/../repository/UtilisateurRepository.php';

use PDO;
use PDOException;
use Utilisateur;
use repository\UtilisateurRepository;

class AuthController
{
    private $utilisateurRepository;
    private $bdd;

    public function __construct()
    {
        try {
            $this->bdd = new \PDO(
                'mysql:host=localhost;dbname=nuit2info;charset=utf8',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            $this->utilisateurRepository = new UtilisateurRepository($this->bdd);
        } catch (PDOException $e) {
            error_log('Erreur de connexion à la base de données : ' . $e->getMessage());
            $this->afficherErreur('Erreur de connexion à la base de données');
        }
    }

    public function afficherFormulaireInscription()
    {
        require_once __DIR__ . '/../vue/inscription.php';
    }

    public function inscrire()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /inscription');
            exit();
        }

        // Validation des données
        $erreurs = [];
        $donnees = [
            'prenom' => trim($_POST['prenom'] ?? ''),
            'nom' => trim($_POST['nom'] ?? ''),
            'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL),
            'mdp' => $_POST['mdp'] ?? '',
            'confirmation_mdp' => $_POST['confirmation_mdp'] ?? '',
            'rue' => trim($_POST['rue'] ?? ''),
            'cd' => !empty($_POST['cd']) ? (int)$_POST['cd'] : null,
            'ville' => trim($_POST['ville'] ?? '')
        ];

        // Validation
        if (empty($donnees['prenom'])) {
            $erreurs['prenom'] = 'Le prénom est obligatoire';
        }

        if (empty($donnees['nom'])) {
            $erreurs['nom'] = 'Le nom est obligatoire';
        }

        if (!$donnees['email']) {
            $erreurs['email'] = 'Email invalide';
        } elseif ($this->utilisateurRepository->emailExiste($donnees['email'])) {
            $erreurs['email'] = 'Cet email est déjà utilisé';
        }

        if (strlen($donnees['mdp']) < 8) {
            $erreurs['mdp'] = 'Le mot de passe doit contenir au moins 8 caractères';
        }

        if ($donnees['mdp'] !== $donnees['confirmation_mdp']) {
            $erreurs['confirmation_mdp'] = 'Les mots de passe ne correspondent pas';
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['donnees'] = $donnees;
            header('Location: /inscription');
            exit();
        }

        try {
            // Création de l'utilisateur
            $utilisateur = new Utilisateur(
                null,
                $donnees['prenom'],
                $donnees['nom'],
                $donnees['email'],
                password_hash($donnees['mdp'], PASSWORD_DEFAULT),
                'utilisateur', // Rôle par défaut
                $donnees['rue'],
                $donnees['cd'],
                $donnees['ville'],
                'actif' // Statut par défaut
            );

            $utilisateur = $this->utilisateurRepository->create($utilisateur);

            if ($utilisateur) {
                // Connexion automatique après inscription
                $this->connecterUtilisateur($utilisateur);
                
                // Redirection vers la page d'accueil ou de profil
                $_SESSION['succes'] = 'Inscription réussie ! Bienvenue ' . htmlspecialchars($utilisateur->getPrenom());
                header('Location: /');
                exit();
            } else {
                throw new \Exception('Erreur lors de la création du compte');
            }
        } catch (\Exception $e) {
            error_log('Erreur lors de l\'inscription : ' . $e->getMessage());
            $_SESSION['erreur'] = 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.';
            header('Location: /inscription');
            exit();
        }
    }

    public function afficherFormulaireConnexion()
    {
        require_once __DIR__ . '/../vue/connexion.php';
    }

    public function connecter()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /connexion');
            exit();
        }

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $mdp = $_POST['mdp'] ?? '';
        $seSouvenir = isset($_POST['se_souvenir']);

        if (!$email) {
            $_SESSION['erreur'] = 'Email invalide';
            header('Location: /connexion');
            exit();
        }

        try {
            $utilisateur = $this->utilisateurRepository->findByEmail($email);

            if (!$utilisateur || !password_verify($mdp, $utilisateur->getMdp())) {
                $_SESSION['erreur'] = 'Email ou mot de passe incorrect';
                header('Location: /connexion');
                exit();
            }

            if ($utilisateur->getStatus() !== 'actif') {
                $_SESSION['erreur'] = 'Votre compte n\'est pas actif. Veuillez contacter l\'administrateur.';
                header('Location: /connexion');
                exit();
            }

            $this->connecterUtilisateur($utilisateur, $seSouvenir);

            // Redirection vers la page demandée ou la page d'accueil
            $redirect = $_SESSION['redirect_after_login'] ?? '/';
            unset($_SESSION['redirect_after_login']);
            
            $_SESSION['succes'] = 'Connexion réussie ! Bienvenue ' . htmlspecialchars($utilisateur->getPrenom());
            header('Location: ' . $redirect);
            exit();

        } catch (\Exception $e) {
            error_log('Erreur lors de la connexion : ' . $e->getMessage());
            $_SESSION['erreur'] = 'Une erreur est survenue lors de la connexion';
            header('Location: /connexion');
            exit();
        }
    }

    public function deconnecter()
    {
        // Suppression des variables de session
        $_SESSION = [];
        
        // Suppression du cookie de session
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        
        // Destruction de la session
        session_destroy();
        
        // Suppression du cookie "se souvenir de moi"
        setcookie('souvenir', '', time() - 3600, '/', '', true, true);
        
        header('Location: /');
        exit();
    }

    private function connecterUtilisateur(Utilisateur $utilisateur, bool $seSouvenir = false)
    {
        // Régénération de l'ID de session pour éviter les attaques par fixation de session
        session_regenerate_id(true);
        
        // Stockage des informations de l'utilisateur en session
        $_SESSION['user_id'] = $utilisateur->getIdUtilisateur();
        $_SESSION['user_email'] = $utilisateur->getEmail();
        $_SESSION['user_role'] = $utilisateur->getRole();
        $_SESSION['user_prenom'] = $utilisateur->getPrenom();
        
        // Si l'utilisateur a coché "Se souvenir de moi"
        if ($seSouvenir) {
            // Génération d'un jeton unique
            $token = bin2hex(random_bytes(32));
            $expiration = time() + (86400 * 30); // 30 jours
            
            // Enregistrement du jeton en base de données
            $this->utilisateurRepository->enregistrerJetonConnexion(
                $utilisateur->getIdUtilisateur(),
                $token,
                date('Y-m-d H:i:s', $expiration)
            );
            
            // Création d'un cookie sécurisé
            setcookie(
                'souvenir',
                $utilisateur->getIdUtilisateur() . ':' . $token,
                [
                    'expires' => $expiration,
                    'path' => '/',
                    'domain' => '',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]
            );
        }
        
        // Dernière connexion
        $this->utilisateurRepository->enregistrerDerniereConnexion($utilisateur->getIdUtilisateur());
    }

    public function verifierConnexionAuto()
    {
        if (isset($_COOKIE['souvenir']) && !isset($_SESSION['user_id'])) {
            list($userId, $token) = explode(':', $_COOKIE['souvenir']);
            
            if ($this->utilisateurRepository->verifierJetonConnexion($userId, $token)) {
                $utilisateur = $this->utilisateurRepository->findById($userId);
                if ($utilisateur) {
                    $this->connecterUtilisateur($utilisateur);
                }
            }
        }
    }

    public function estConnecte(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function estAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public function redirigerSiNonConnecte(string $url = '/connexion')
    {
        if (!$this->estConnecte()) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . $url);
            exit();
        }
    }

    public function redirigerSiNonAdmin(string $url = '/')
    {
        $this->redirigerSiNonConnecte();
        
        if (!$this->estAdmin()) {
            $_SESSION['erreur'] = 'Accès refusé. Vous devez être administrateur pour accéder à cette page.';
            header('Location: ' . $url);
            exit();
        }
    }

    private function afficherErreur(string $message)
    {
        // Vous pouvez personnaliser cette méthode pour afficher une belle page d'erreur
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Erreur</title>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; color: #333; }
                .container { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; margin-top: 50px; }
                h1 { color: #d32f2f; }
                .btn { display: inline-block; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px; }
                .btn:hover { background: #45a049; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Une erreur est survenue</h1>
                <p>' . htmlspecialchars($message) . '</p>
                <p>Veuillez réessayer plus tard ou contacter l\'administrateur si le problème persiste.</p>
                <p><a href="/" class="btn">Retour à l\'accueil</a></p>
            </div>
        </body>
        </html>';
        exit();
    }
}
