<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <h3>administration des utilisateurs / Ajout d'un nouvel utilisateur:</h3>
        <div class="container">
            <form method="GET" action="AdminUtiliAjout.php">
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
                
            </form>
        </div>
        
    </body>
</html>

