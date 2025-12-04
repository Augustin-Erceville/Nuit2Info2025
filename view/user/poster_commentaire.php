<?php
$conn = new mysqli("localhost", "root", "", "forum_db");

$auteur = $_POST['auteur'];
$contenu = $_POST['contenu'];
$parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : "NULL";

$sql = "INSERT INTO messages (auteur, contenu, parent_id)
        VALUES ('$auteur', '$contenu', $parent_id)";

$conn->query($sql);

header("Location: ../accueil.php");
exit;
?>
