<?php
//AdminUtiliAjout.php
    $sNom = isset($_GET['Nom']) ? $_GET['Nom'] : '';
    $sEmail = isset($_GET['Email']) ? $_GET['Email'] : '';
    $sMotDePasse = isset($_GET['MotDePasse']) ? $_GET['MotDePasse'] : '';
    $sDroits = isset($_GET['Droits']) ? $_GET['Droits'] : '';


    //parametre de connexion a la base de donnees
    $BDServeur="127.0.0.1";
    $BDLogin="root";
    $BDMotDePasse="";
    $BDNom="mabiblio";

    //1..se connecter a la base de donnees
    $BDConn= mysqli_connect($BDServeur, $BDLogin,$BDMotDePasse,$BDNom);
    if(!$BDConn){
        $sMsg="Erreur :".mysqli_connect_error();
        header("location:erreur.php?msg=$sMsg");
    }
    $emailToCheck = mysqli_real_escape_string($BDConn, $sEmail);



    //2..ecrire les donnees dans la base de donnees
    $sSQL = "INSERT INTO TUtilisateur(Nom, Email, MotDePasse, Droits)
             VALUES ('$sNom', '$sEmail', '$sMotDePasse', '$sDroits')";
    if(!mysqli_query($BDConn,$sSQL))
        $sMsg="Erreur :".mysqli_error($BDConn);
    else
        $sMsg="Ajout d'un nouvel utilisateur ok";
    //3..se connecter de la base de donnees
    mysqli_close($BDConn);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <?php
            echo"<h3>$sMsg </h3>";
        ?>
    </body>
</html>