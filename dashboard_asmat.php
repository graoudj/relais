<?php
// fichier: dashboard_asmat.php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login'];
$isAsmat = isset($_SESSION['categorie']) && $_SESSION['categorie'] === 'Asmat';

$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971', 'dbs12233763');

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupérer les informations des enfants pour les assistantes maternelles
$enfants = [];
if ($isAsmat) {
    $sql = "SELECT * FROM Enfants WHERE AssMat = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $enfants[] = $row;
    }
}
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

    <h4>Bienvenue <?php echo htmlspecialchars($login); ?></h4>
    <h3>Tableau de bord du Relais</h3>

    <?php if ($isAsmat): ?>
        <!-- Contenu spécifique pour les assistantes maternelles -->
        <h2>Mes Enfants</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Parent 1</th>
                <th>Parent 2</th>
                <th>Commune</th>
            </tr>
            <?php foreach ($enfants as $enfant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($enfant['Enfant']); ?></td>
                    <td><?php echo htmlspecialchars($enfant['D_de_naissance']); ?></td>
                    <td><?php echo htmlspecialchars($enfant['Parent1']); ?></td>
                    <td><?php echo htmlspecialchars($enfant['Parent2']); ?></td>
                    <td><?php echo htmlspecialchars($enfant['Commune']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="PA_asmat.php" class="button">Voir le programme d'activités</a>
        <a href="Accueil_asmat.php" class="button">Voir mes participations</a>
    <?php else: ?>
        <!-- Contenu pour l'administrateur -->
        <a href="GE.php" class="button enfant-button">Gestion des enfants</a>
        <a href="PA.php" class="button">Aller au programme d'activités</a>
        <a href="Ajoutactivite.php" class="button">Ajouter une activité</a>
        <a href="Accueil.php" class="button">Voir les participations</a>
    <?php endif; ?>

    <!-- Bouton de déconnexion commun -->
    <a href="logout.php" class="button logout-button">Déconnexion</a>

</body>
</html>

<?php
mysqli_close($conn);
?>

