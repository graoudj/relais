<?php
//fichier: index.php //
session_start(); // Démarrer la session

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971', 'dbs12233763');

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Initialiser le message d'erreur
$error_message = "";

// Si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['Login'] ?? '';  
    $password = $_POST['Motdepasse'] ?? ''; 

    // Condition spéciale pour login et mot de passe "Relais46"
    if ($login === 'Relais46' && $password === 'Relais46') {
        // Rediriger vers dashboard.php
        $_SESSION['logged_in'] = true;
        $_SESSION['login'] = $login;
        header("Location: dashboard.php");
        exit(); // Toujours utiliser exit() après une redirection
    }

    // Vérification des identifiants dans la base de données
    if (!empty($login) && !empty($password)) {
        $sql = "SELECT * FROM utilisateurs WHERE Login = ? AND Motdepasse = ? AND Categorie = 'Asmat'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $login, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Utilisateur trouvé, on enregistre son login dans la session
            $_SESSION['logged_in'] = true;
            $_SESSION['login'] = $login;
            header("Location: Listedesenfants.php"); // Redirection vers la page des enfants
            exit();
        } else {
            $error_message = "Login ou mot de passe incorrect.";
        }
    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="myDiv">
        <center>
            <table style="width: 545px;" border="0">
                <tbody>
                    <tr align="center">
                        <td style="width: 398.217px; height: 181.933px;">
                            <img src="RPE.png" alt="LEBILBOQUET" title="relais RPE" style="width: 251px; height: 180px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 24.75px;">
                            <h5>
                                <i><cite><b><span style="font-family: monospace;">
                                    Bienvenue sur l'espace dédié à la petite enfance sur le territoire de la communauté de communes. Le relais est animé par l'association Le Bilboquet, avec l'aide des assistantes maternelles, de la CAF, et des parents et enfants de notre territoire.
                                </span></b></cite></i>
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>
                                <span style="font-family: monospace;">
                                    <form method="post" action="">
                                        <b>Login : </b>
                                        <input name="Login" size="10" type="text">
                                        <b>Mot de passe: </b>
                                        <input type="password" name="Motdepasse" size="10">
                                        <br><br>
                                        <input name="connexion" value="Connexion" type="submit">
                                    </form>
                                </span>
                            </h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>

        <!-- Affichage du message d'erreur uniquement si nécessaire -->
        <?php if (!empty($error_message)) : ?>
            <p style="color:red; text-align: center;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

    <br>

    <div class="myDiv2">
    <h5>
        <i><cite><b><span style="font-family: monospace;">
            Si vous êtes nouveau sur notre territoire et que vous souhaitez inscrire vos enfants aux activités du relais, <a href="https://www.lebilboquet.org/relais-petite-enfance/">vous inscrire ici</a>, ou <a href="mailto:relais@exemple.com">nous écrire</a> au Relais.
        </span></b></cite></i>
    </h5>
</div>
   

</body>
</html>
