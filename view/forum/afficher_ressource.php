<?php
require "config.php";

// ID de la ressource
$ressource_id = $_GET['id'];

// Charger la ressource
$req_ress = $pdo->prepare("SELECT * FROM ressources_contenu WHERE id = ?");
$req_ress->execute([$ressource_id]);
$ressource = $req_ress->fetch();

// Charger tous les commentaires
$req_com = $pdo->prepare("SELECT * FROM commentaires WHERE ressource_id = ? ORDER BY date_commentaire ASC");
$req_com->execute([$ressource_id]);
$commentaires = $req_com->fetchAll(PDO::FETCH_ASSOC);

// Fonction récursive pour afficher les commentaires
function afficherCommentaires($list, $parent = null, $niveau = 0)
{
    foreach ($list as $c) {
        if ($c["parent_id"] == $parent) {
            echo "<div style='margin-left:".($niveau*25)."px; padding:10px; border-left:1px solid #ccc;'>";

            echo "<b>Utilisateur #".$c['auteur_id']."</b><br>";
            echo "<p>".htmlspecialchars($c['contenu'])."</p>";
            echo "<small>".$c['date_commentaire']."</small><br>";

            // Formulaire de réponse
            echo "
            <form action='poster_commentaire.php' method='POST'>
                <input type='hidden' name='ressource_id' value='{$c['ressource_id']}'>
                <input type='hidden' name='parent_id' value='{$c['id']}'>
                <textarea name='contenu' placeholder='Votre réponse...' required></textarea>
                <button type='submit'>Répondre</button>
            </form>";

            echo "</div>";

            afficherCommentaires($list, $c["id"], $niveau + 1);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $ressource["titre"] ?></title>
</head>
<body>

<h1><?= $ressource["titre"] ?></h1>
<div><?= $ressource["contenu"] ?></div>

<hr>

<h2>Commentaires</h2>

<!-- Formulaire commentaire principal -->
<form action="poster_commentaire.php" method="POST">
    <input type="hidden" name="ressource_id" value="<?= $ressource_id ?>">
    <textarea name="contenu" placeholder="Votre commentaire..." required></textarea>
    <button type="submit">Envoyer</button>
</form>

<hr>

<?php afficherCommentaires($commentaires); ?>

</body>
</html>
