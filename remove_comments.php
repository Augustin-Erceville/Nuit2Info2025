<?php
$directories = [
    __DIR__ . '/src/modele',
    __DIR__ . '/src/repository'
];

function removeComments($content) {
    $tokens = token_get_all($content);
    $output = '';
    $inComment = false;
    
    foreach ($tokens as $token) {
        if (is_array($token)) {
            list($id, $text) = $token;
            
            if ($id === T_COMMENT || $id === T_DOC_COMMENT) {
                continue;
            }
            
            $output .= $text;
        } else {
            $output .= $token;
        }
    }
    
    // Supprimer les commentaires restants (au cas où)
    $output = preg_replace('/\/\*.*?\*\//s', '', $output);
    $output = preg_replace('/\/\/.*$/m', '', $output);
    
    // Supprimer les espaces et sauts de ligne inutiles
    $output = preg_replace("/^[\s\t]*[\r\n]+/m", "\n", $output);
    $output = preg_replace("/[\r\n]{3,}/", "\n\n", $output);
    
    return trim($output);
}

foreach ($directories as $directory) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filePath = $file->getRealPath();
            $content = file_get_contents($filePath);
            
            $newContent = removeComments($content);
            
            if ($content !== $newContent) {
                file_put_contents($filePath, $newContent);
                echo "Commentaires supprimés de : " . $file->getFilename() . "\n";
            }
        }
    }
}

echo "Nettoyage des commentaires terminé.\n";
