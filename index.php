<?php
//Connection a la DB
include ('./sql/conect.php');

//condition si on recup le pseudo via l'url de la page de traitement
if (isset($_GET['pseudo'])) {
    $pseudosave = $_GET['pseudo'];
}
else{
    $pseudosave = "";
}
?>

<!--header-->
<!DOCTYPE>
<html>

<head>
    <title>MiniChat Project II - The Return</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Material Design Light -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.indigo-pink.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>


    <div class="mdl-layout mdl-js-layout">
        <main class="mdl-layout__content">
            <div class="page-content">

            <?php

            //  requete sql  pour definir les com pour la page souhaité et le nombre de page
            $req = $pdo->query('SELECT COUNT(com) AS total FROM commentaire');
            $totalcom = $req->fetch();
            $nombrecom=$totalcom->total;

            $nbpages = ceil($nombrecom / 10);
            //condition pour determiner la page visible
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }
            else{
                $page = 1;
            }

            $firstcom = ($page -1) * 10;
            //on cloture la requete pour en faire une nouvelle
            $req->closeCursor();

            ?>
            <!--affichage dans la structure du framework des commentaires-->
                <div class="blur">
                <ul class="demo-list-item mdl-list" id="conversation">

                <?php
                //  requete SQL pour afficher les 10 com contenue de la page cliqué
                $req = $pdo->query('SELECT pseudo, com, date FROM commentaire ORDER BY id DESC LIMIT '.$firstcom.', 10');
                while ($data = $req->fetch())
                {


                    ?>
                    <!--injection dans le dom-->
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <?php

//                          on converti certaines chaines de caracteres pour afficher des emoji
                            $message = $data->com;
                            $message = str_replace(":smile_cat:", " <img style='width: 30px; height: 30px;' src=\"img/smile_cat.png\"> ", $message);
                            $message = str_replace(":smile:", " <img style='width: 30px; height: 30px;' src=\"img/smile.png\"> ", $message);
                            $message = str_replace(":stuck_out_tongue:", " <img style='width: 30px; height: 30px;' src=\"img/langue.png\"> ", $message);
                            $message = str_replace(":rage:", " <img style='width: 30px; height: 30px;' src=\"img/angry.png\"> ", $message);
                            $message = str_replace(":sob:", " <img style='width: 30px; height: 30px;' src=\"img/cry.png\"> ", $message);
                            $message = str_replace(":sunglasses:", " <img style='width: 40px; height: 33px;' src=\"img/glass.png\"> ", $message);
                            $message = str_replace(":laughing:", " <img style='width: 30px; height: 30px;' src=\"img/mdr.png\"> ", $message);
                            $message = str_replace(":worried:", " <img style='width: 30px; height: 30px;' src=\"img/sad.png\"> ", $message);
                            $message = str_replace(":scream:", " <img style='width: 30px; height: 30px;' src=\"img/fear.png\"> ", $message);

                            echo '<i>'.$data->date.'</i> ';?> &nbsp<strong><?php echo htmlspecialchars($data->pseudo).': &nbsp'; ?></strong> <?php echo ($message);?>
                        </span>
                    </li>

                    <?php
                }
                $req->closeCursor();
                //on cloture la requete finale
                ?>

                <!--formulaire de commentaires-->
                <div class="formulaire">
                    <form action="./sql/send.php" class="mdl-grid" method="POST">
                        <div class="mdl-cell mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="pseudo" id="pseudo" value="<?php echo $pseudosave; ?>" required="required">
                            <label class="mdl-textfield__label" for="sample3">Pseudo</label>
                        </div>
                        <div class="mdl-cell mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="message" id="message" required="required">
                            <label class="mdl-textfield__label" for="sample3">Message</label>
                        </div>
                        <button id="send" class="mdl-cell mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                            <i class="material-icons">send</i>
                        </button>
                    </form>
                </div>
                <div class="control">
                <?php
                //on affiche la pagination en dessous du form, (nbre de page défini dans la premiere requete)


//              si on est sur les pages au dessus de un, met un bouton precedent
                if($page > 1){
                    ?><a href="?page=<?= $page -1; ?>">page précedente</a>&nbsp; <?php
                }
                // boucle pour afficher le numéro de page sous forme de lien
                for ($i = 1 ; $i <= $nbpages ; $i++) {
//                  si on est sur la page selectionné, mettre en gras le numero de page
                    if($page == $i){
                      ?><a href="?page=<?= $i; ?>"><strong><?= $i ?></strong></a>&nbsp; <?php
                    }
//                  sinon laisser normal
                    else{
                        ?><a href="?page=<?= $i; ?>"><?= $i ?></a>&nbsp; <?php
                    }
                }
//               si on est au dessous de la derniere page, on met bouton suivant
                if($page < $nbpages){
                    ?>&nbsp; <a href="?page=<?= $page +1; ?>">page suivante</a><?php
                }

                ?>
                <!--bouton pour rafraichir la page-->
                <button class=" reset mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="document.location.reload(false)">Refresh</button>
                </div>
                </div>
            </ul>
        </main>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
</body>

</html>
