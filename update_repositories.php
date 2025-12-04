<?php
$repositories = [
    'CommentaireRepository.php',
    'DefiRepository.php',
    'EtablissementRepository.php',
    'IdeeRepository.php',
    'MaterielRepository.php',
    'ParcoursChoixRepository.php',
    'ParcoursEtapeRepository.php',
    'ReonditionnementRepository.php',
    'RepondreRepository.php',
    'UtilisateurRepository.php',
    'RessourceContenuRepository.php'
];

$directory = __DIR__ . '/src/repository/';
$count = 0;

foreach ($repositories as $repo) {
    $filePath = $directory . $repo;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $newContent = str_replace(
            [
                "require_once __DIR__ . '/../bdd/Bdd.php';",
                "require_once __DIR__ . '/../bdd/config.php';",
                "require_once __DIR__ . '/../bdd/confi.php';"
            ],
            "require_once __DIR__ . '/../bdd/config.php';",
            $content
        );
        
        if ($content !== $newContent) {
            file_put_contents($filePath, $newContent);
            $count++;
            echo "Mise à jour de : $repo\n";
        }
    }
}

echo "\nMise à jour terminée. $count fichiers modifiés.\n";
