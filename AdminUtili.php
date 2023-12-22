<?php
require("DBase.php");
require("session.php");

// Check if the user is not logged in, redirect to login page
if (!isLoggedIn()) {
    header("location: login.php");
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list_users';

//1..se connecter a la base de donnees
$BDConn = ConnecterBaseDeDonnees();

//2..selectionner tous les utilisateurs
$sSQL = "SELECT * FROM TUtilisateur;";
if(!$Resultat = mysqli_query($BDConn,$sSQL)){
    $sMsg="Erreur :".mysqli_error($BDConn);
    header("location:erreur.php?msg=$sMsg");
}
// 2. switch pour different actions
switch ($action) {
    case 'affichierList':
        $sSQL = "SELECT * FROM TUtilisateur;";
        if (!$Resultat = mysqli_query($BDConn, $sSQL)) {
            $sMsg = "Erreur :" . mysqli_error($BDConn);
            header("location:erreur.php?msg=$sMsg");
        }
        break;

    case 'fomulaireVide':
        
        break;

    case 'insertUtili':
       
        break;

    case 'affichierFormDonnees':
        
        break;

    case 'update':
        
        break;

    case 'delete':
        
        break;

    default:
        $sMsg = "Invalid action specified.";
        header("location:erreur.php?msg=$sMsg");
        break;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        < <?php
        switch ($action) {
            case 'affichierList':
                echo '<h3>Administration des utilisateurs / Liste des utilisateurs</h3>';
                echo '<table>';
                echo '<tr><th>Nom et prénom</th><th>Email</th><th>Droits</th><th></th><th></th></tr>';
                while ($rLigne = mysqli_fetch_assoc($Resultat)) {
                    echo "
                    <tr>
                    <td>" . $rLigne['Nom'] . "</td>
                    <td>" . $rLigne['Email'] . "</td>
                    <td>" . $rLigne['Droits'] . "</td>";
                    echo '
                    <td><a href="AdminUtiliModif.php?Email=' . $rLigne['Email'] . '">modifier</a></td>';
                    echo '
                   <td><a href="AdminUtiliSupp.php?Email=' . $rLigne['Email'] . '">supprimer</a></td>
                   </tr>';
                }
                echo '</table>';
                break;
            case 'fomulaireVide':
                echo '<h3>Afficher le formulaire d\'ajout d\'utilisateur</h3>';
                echo '
                <form method="post" action="AdminUtili.php?action=insert_user">
                <label for="Nom">Nom et Prénom:</label>
                <input name="Nom" type="text" value=""></br>
                <label for="Email">Email:</label>
                <input name="Email" type="text" value=""></br>
                <label for="MotDePasse">Mot de passe:</label>
                <input name="MotDePasse" type="password" value=""></br>
                <label for="Droit">Droit:</label>
                <div class="radio-group">
                    <input name="Droit" type="radio" value="admin">administrateur
                    <input name="Droit" type="radio" value="utili" checked >utilisateur</br>
                </div>
                <input name="Soumettre" type="submit" value="Soumettre">
                </form>';
                break;
            case 'insertUtili':
                echo '<h3>Insertion d\'un nouvel utilisateur</h3>';
                $sNom = isset($_POST['Nom']) ? $_POST['Nom'] : '';
                $sEmail = isset($_POST['Email']) ? $_POST['Email'] : '';
                $sMotDePasse = isset($_POST['MotDePasse']) ? $_POST['MotDePasse'] : '';
                $sDroits = isset($_POST['Droit']) ? $_POST['Droit'] : '';
                $BDConn = ConnecterBaseDeDonnees();
                $sSQL = "INSERT INTO TUtilisateur(Nom, Email, MotDePasse, Droits)
                VALUES ('$sNom', '$sEmail', '$sMotDePasse', '$sDroits')";
                if (!mysqli_query($BDConn, $sSQL)) {
                    $sMsg = "Erreur :" . mysqli_error($BDConn);
                    header("location:erreur.php?msg=$sMsg");
                } else {
                    $sMsg = "Nouvel utilisateur ajouté avec succès";
                }
                DeconnecterBaseDeDonnees($BDConn);
                echo "<p>$sMsg</p>";
                break;
            case 'affichierFormDonnees':
                echo '<h3>Afficher le formulaire de modification d\'utilisateur</h3>';
                $editEmail = isset($_GET['editEmail']) ? $_GET['editEmail'] : '';
                $BDConn = ConnecterBaseDeDonnees();
                $sSQL = "SELECT * FROM TUtilisateur WHERE Email = '$editEmail'";
                $result = mysqli_query($BDConn, $sSQL);
                $userData = mysqli_fetch_assoc($result);
                if (!$userData) {
                    $sMsg = "Utilisateur non trouvé.";
                    header("location:erreur.php?msg=$sMsg");
                } else {
                    echo '
                    <form method="post" action="AdminUtili.php?action=update_user">
                    <label for="Nom">Nom et Prénom:</label>
                    <input name="Nom" type="text" value="' . $userData['Nom'] . '"></br>

                    <label for="Email">Email:</label>

                    <input name="Email" type="text" value="' . $userData['Email'] . '" readonly></br>


                    <label for="MotDePasse">Mot de passe:</label>

                    <input name="MotDePasse" type="password" value="' . $userData['MotDePasse'] . '"></br>


                    <label for="Droit">Droit:</label>

                    <div class="radio-group">
                    <input name="Droit" type="radio" value="admin" ' . ($userData['Droits'] == 'admin' ? 'checked' : '') . '>administrateur
                    <input name="Droit" type="radio" value="utili" ' . ($userData['Droits'] == 'utili' ? 'checked' : '') . '>utilisateur</br>

    
                    </div>

                    <input name="Soumettre" type="submit" value="Mettre à jour">
                    </form>';
                }
                DeconnecterBaseDeDonnees($BDConn);
                break;
            case 'update':
                echo '<h3>Mise à jour de l\'utilisateur</h3>';
                $sNom = isset($_POST['Nom']) ? $_POST['Nom'] : '';
                $sEmail = isset($_POST['Email']) ? $_POST['Email'] : '';
                $sMotDePasse = isset($_POST['MotDePasse']) ? $_POST['MotDePasse'] : '';
                $sDroits = isset($_POST['Droit']) ? $_POST['Droit'] : '';
                $BDConn = ConnecterBaseDeDonnees();
                $sSQL = "UPDATE TUtilisateur
                SET Nom='$sNom', MotDePasse='$sMotDePasse', Droits='$sDroits'
                WHERE Email='$sEmail'";
                if (!mysqli_query($BDConn, $sSQL)) {
                    $sMsg = "Erreur :" . mysqli_error($BDConn);
                    header("location:erreur.php?msg=$sMsg");
                } else {
                    $sMsg = "Mise à jour de l'utilisateur réussie";
                }
                DeconnecterBaseDeDonnees($BDConn);
                echo "<p>$sMsg</p>";
                break;
            case 'delete':
                echo '<h3>Suppression d\'utilisateur</h3>';
                $deleteEmail = isset($_GET['deleteEmail']) ? $_GET['deleteEmail'] :'' ;
                $BDConn = ConnecterBaseDeDonnees();$sSQL = "DELETE FROM TUtilisateur WHERE Email='$deleteEmail'";
                if (!mysqli_query($BDConn, $sSQL)) {
                    $sMsg = "Erreur :" . mysqli_error($BDConn);
                    header("location:erreur.php?msg=$sMsg");
                } else {
                    $sMsg = "Utilisateur supprimé avec succès";
                }
                DeconnecterBaseDeDonnees($BDConn);
                echo "<p>$sMsg</p>";
                break;
            default:
                echo '<p>Invalid action specified.</p>';
                break;
    }
    ?>
    </body>
</html>
