<?php
//fichier: dashboard.php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirection vers index.php si l'utilisateur n'est pas connecté
    header("Location: index.php");
    exit();
}

$login =$_SESSION['login'];//echo "Bonjour".$login;
?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="text-align:center">

    <h4>Bienvenue <?php echo "$login"?></h4>
 <h3> Tableau de bord du Relais</h3>



    <!-- Afficher les boutons -->
        <a href="GE.php" class="button enfant-button">Gestion des enfants</a>
    <a href="PA.php" class="button">Aller au programme d'activités</a>
    
    <a href="Ajoutactivite.php" class="button">Ajouter une activité</a>
    <a href="participants.php" class="button">Voir les participations</a>

    <!-- Bouton de déconnexion -->
    <a href="logout.php" class="button logout-button" >Déconnexion</a>

</body>
</html>
