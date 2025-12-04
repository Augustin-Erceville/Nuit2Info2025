<?php
// Démarrer la session
session_start();

// Charger l'autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Charger la configuration de la base de données
$config = require __DIR__ . '/../src/config/database.php';

// Créer une instance de PDO
$dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset={$config['db']['charset']}";
$pdo = new PDO($dsn, $config['db']['username'], $config['db']['password'], $config['db']['options']);

// Initialiser le contrôleur d'authentification
$authController = new \controleur\AuthController();

// Vérifier la connexion automatique
$authController->verifierConnexionAuto();

// Récupérer l'URL demandée
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/programmes/Nuit2Info2025/public';
$path = str_replace($base_path, '', $request_uri);

// Définir les routes
$routes = [
    '/' => function() {
        require __DIR__ . '/../src/vue/accueil.php';
    },
    '/connexion' => function() use ($authController) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->connecter();
        } else {
            $authController->afficherFormulaireConnexion();
        }
    },
    '/inscription' => function() use ($authController) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->inscrire();
        } else {
            $authController->afficherFormulaireInscription();
        }
    },
    '/deconnexion' => function() use ($authController) {
        $authController->deconnecter();
    },
    '/profil' => function() use ($authController) {
        $authController->redirigerSiNonConnecte();
        require __DIR__ . '/../src/vue/profil.php';
    },
    // Ajoutez d'autres routes ici
];

// Gérer la requête
if (array_key_exists($path, $routes)) {
    $routes[$path]();
} else {
    // Gestion des erreurs 404
    header("HTTP/1.0 404 Not Found");
    require __DIR__ . '/../src/vue/404.php';
}
