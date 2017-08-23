<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=minichat','root','root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    // echo 'connecté';
}
catch(PDOException $e){
    echo 'Connexion impossible';
}