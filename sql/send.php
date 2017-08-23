<?php
//on inclut la connection a la DB
include ("conect.php");

$pseudo = $_POST['pseudo'];
$com = $_POST['message'];

// -----ecriture des com dans la table-----
$req = $pdo->prepare("INSERT INTO commentaire (pseudo, com)
VALUES (:pseudo, :com)");

$req->execute(array(
    'pseudo' => $pseudo,
    'com' => $com
));
//on met le dernier pseudo rentré par l'utilisateur en cookie pour le réafficher a la prochaine saisie'
setcookie('pseudo', $pseudo, (time() + 3600));

print_r($pdo->errorInfo());
//retour automatique vers l'index pour afficher les com'
header('location: ../index.php?pseudo='.$pseudo.'');
?>

