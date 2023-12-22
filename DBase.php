<?php
//DBase.php

function ConnecterBaseDeDonnees(){
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
    return $BDConn;
}
function DeconnecterBaseDeDonnees($BDConn){
    mysqli_close($BDConn);
}
?>