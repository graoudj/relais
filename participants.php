<?php
// fichier: participants.php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données avec MySQLi
$host = 'db5014723397.hosting-data.io';  // Hôte
$username = 'dbu1172053';  // Nom d'utilisateur
$password = 'Bruxelle19671971';  // Mot de passe
$dbname = 'dbs12233763';  // Nom de la base de données

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupérer le lieu et le nom/prénom de l'enfant à filtrer à partir du formulaire GET
$lieu = isset($_GET['lieu']) ? mysqli_real_escape_string($conn, $_GET['lieu']) : '';
$npEnfant = isset($_GET['npEnfant']) ? mysqli_real_escape_string($conn, $_GET['npEnfant']) : '';

// Préparer la requête SQL en fonction du lieu et du nom/prénom de l'enfant
$sql = "SELECT IDParticipation, NPEnfant, LieuActiv, DateActiv, Theme, Jauge, IDActivité FROM Participations WHERE 1=1"; // "1=1" est une condition toujours vraie pour faciliter l'ajout de clauses

if (!empty($lieu)) {
    $sql .= " AND LieuActiv = '$lieu'";
}

if (!empty($npEnfant)) {
    $sql .= " AND NPEnfant LIKE '%$npEnfant%'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
}

// Stocker les résultats dans un tableau
$participations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fermer la connexion à la base de données
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Participations</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
   
    <h1>Liste des Participations</h1>


    <!-- Ajouter le formulaire de sélection des lieux et de recherche par nom/prénom -->
    <form method="GET" action="">
        <label for="lieu">Choisir un lieu :</label>
        <select name="lieu" id="lieu">
            <option value="">Tous les lieux</option>
            <option value="Luzech" <?= ($lieu == 'Luzech') ? 'selected' : '' ?>>Luzech</option>
            <option value="Cahors" <?= ($lieu == 'Cahors') ? 'selected' : '' ?>>Cahors</option>
            <option value="Puy-lessac" <?= ($lieu == 'Puy-lessac') ? 'selected' : '' ?>>Puy-l'éveque</option>
        </select>

        <label for="npEnfant">Nom et prénom de l'enfant :</label>
        <input type="text" name="npEnfant" id="npEnfant" value="<?= htmlspecialchars($npEnfant) ?>">

        <button type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>IDParticipation</th>
                <th>NPEnfant</th>
                <th>LieuActiv</th>
                <th>DateActiv</th>
                <th>Theme</th>
                <th>Jauge</th>
                <th>IDActivité</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Vérifier si des participations ont été trouvées
            if (!empty($participations)) {
                // Parcourir et afficher les données dans les lignes du tableau
                foreach ($participations as $participation) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($participation['IDParticipation']) . "</td>";
                    echo "<td>" . htmlspecialchars($participation['NPEnfant']) . "</td>";
                    echo "<td>" . htmlspecialchars($participation['LieuActiv']) . "</td>";
                    echo "<td>" . htmlspecialchars($participation['DateActiv']) . "</td>";
                    echo "<td>" . htmlspecialchars($participation['Theme']) . "</td>";
                    echo "<td>" . htmlspecialchars($participation['Jauge']) . "</td>";
                    echo "<td>" . htmlspecialchars($participation['IDActivité']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // Message si aucune participation n'est trouvée
                echo "<tr><td colspan='7'>Aucune participation trouvée</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
