<?php
$titre = 'Inscription';
$description = 'Créez votre compte pour accéder à toutes les fonctionnalités';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?> - Nuit2Info</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Créer un compte
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ou 
                    <a href="/connexion" class="font-medium text-indigo-600 hover:text-indigo-500">
                        connectez-vous à votre compte existant
                    </a>
                </p>
            </div>

            <?php if (isset($_SESSION['erreur'])): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <?= htmlspecialchars($_SESSION['erreur']) ?>
                                <?php unset($_SESSION['erreur']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['succes'])): ?>
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                <?= htmlspecialchars($_SESSION['succes']) ?>
                                <?php unset($_SESSION['succes']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" action="/inscription" method="POST">
                <div class="rounded-md shadow-sm space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input id="prenom" name="prenom" type="text" required 
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   value="<?= htmlspecialchars($_SESSION['donnees']['prenom'] ?? '') ?>"
                                   <?= isset($_SESSION['erreurs']['prenom']) ? 'aria-invalid="true" aria-describedby="prenom-error"' : '' ?>>
                            <?php if (isset($_SESSION['erreurs']['prenom'])): ?>
                                <p class="mt-1 text-sm text-red-600" id="prenom-error"><?= htmlspecialchars($_SESSION['erreurs']['prenom']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input id="nom" name="nom" type="text" required 
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   value="<?= htmlspecialchars($_SESSION['donnees']['nom'] ?? '') ?>">
                            <?php if (isset($_SESSION['erreurs']['nom'])): ?>
                                <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($_SESSION['erreurs']['nom']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               value="<?= htmlspecialchars($_SESSION['donnees']['email'] ?? '') ?>">
                        <?php if (isset($_SESSION['erreurs']['email'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($_SESSION['erreurs']['email']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="mdp" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input id="mdp" name="mdp" type="password" autocomplete="new-password" required 
                               class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <?php if (isset($_SESSION['erreurs']['mdp'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($_SESSION['erreurs']['mdp']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="confirmation_mdp" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                        <input id="confirmation_mdp" name="confirmation_mdp" type="password" autocomplete="new-password" required 
                               class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <?php if (isset($_SESSION['erreurs']['confirmation_mdp'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($_SESSION['erreurs']['confirmation_mdp']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-900">Adresse (optionnel)</h3>
                        <div class="mt-4 grid grid-cols-1 gap-y-4">
                            <div>
                                <label for="rue" class="block text-sm font-medium text-gray-700">Rue</label>
                                <input id="rue" name="rue" type="text" 
                                       class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                       value="<?= htmlspecialchars($_SESSION['donnees']['rue'] ?? '') ?>">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="cd" class="block text-sm font-medium text-gray-700">Code postal</label>
                                    <input id="cd" name="cd" type="text" 
                                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                           value="<?= htmlspecialchars($_SESSION['donnees']['cd'] ?? '') ?>">
                                </div>
                                <div>
                                    <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                                    <input id="ville" name="ville" type="text" 
                                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                           value="<?= htmlspecialchars($_SESSION['donnees']['ville'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="conditions" name="conditions" type="checkbox" required
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="conditions" class="ml-2 block text-sm text-gray-700">
                        J'accepte les <a href="/conditions" class="text-indigo-600 hover:text-indigo-500">conditions d'utilisation</a>
                    </label>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php 
    // Nettoyage des erreurs après affichage
    if (isset($_SESSION['erreurs'])) {
        unset($_SESSION['erreurs']);
    }
    if (isset($_SESSION['donnees'])) {
        unset($_SESSION['donnees']);
    }
    ?>
</body>
</html>
