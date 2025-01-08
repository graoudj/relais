<?php
//fichier: Ajoutactivite.php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Connexion à la base de données
$host = 'db5014723397.hosting-data.io';
$dbname = 'dbs12233763';
$user = 'dbu1172053';
$password = 'Bruxelle19671971';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$successMessage = "";

// Si la méthode POST est utilisée (soumission du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données du formulaire
    $lieu = filter_input(INPUT_POST, 'inputlieu', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'inputdate', FILTER_SANITIZE_STRING);
    $theme = filter_input(INPUT_POST, 'inputtheme', FILTER_SANITIZE_STRING);
    $intervenant = filter_input(INPUT_POST, 'inputintervenant', FILTER_SANITIZE_STRING);
    $jauge = filter_input(INPUT_POST, 'inputjauge', FILTER_SANITIZE_NUMBER_INT);

    // Vérification que les données ne sont pas vides
    if (!empty($lieu) && !empty($date) && !empty($theme) && !empty($jauge)) {
        try {
            // Préparer la requête d'insertion avec les nouveaux champs
            $query = "INSERT INTO Activites (Lieu, Date, Theme, Jauge, Intervenant) VALUES (:lieu, :date, :theme, :jauge, :intervenant)";
            $pdostmt = $pdo->prepare($query);
            $pdostmt->execute([
                'lieu' => $lieu,
                'date' => $date,
                'theme' => $theme,
                'intervenant' => $intervenant,
                'jauge' => $jauge
            ]);

            // Message de succès
            $successMessage = "Activité ajoutée avec succès !";

        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'activité : " . $e->getMessage();
        }
    } else {
        // Si les champs sont vides, afficher un message d'erreur
        echo "<p class='text-danger'>Veuillez remplir tous les champs.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une activité</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="container">
        
        <a href="dashboard.php" title="Retour au menu principal">
    <img src="RPE.png" alt="Logo RPE" class="logo"></a>
    
        <h3>Ajouter une activité du RPE</h3>

        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="inputlieu">Lieu</label>
                    <input type="text" id="inputlieu" name="inputlieu" required>
                </div>
                
                <div class="form-group">
                    <label for="inputdate">Date</label>
                    <input type="date" id="inputdate" name="inputdate" min="2023-01-01" max="2027-12-31" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="inputtheme">Thème</label>
                    <input type="text" id="inputtheme" name="inputtheme" required>
                </div>
                <div class="form-group">
                    <label for="inputintervenant">Intervenant</label>
                    <input type="text" id="inputintervenant" name="inputintervenant">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="inputjauge">Jauge</label>
                    <input type="number" id="inputjauge" name="inputjauge" required>
                </div>
            </div>

            <div class="button-group">
                <button type="submit">Ajouter</button>
               <!-- <a href="reserv.php" class="btn">Voir les activités</a> -->
            </div>
        </form>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
    </div>
    <br>
    <?php 
    // Requête pour récupérer toutes les activités
$query = "SELECT * FROM Activites ORDER BY Date ASC";
$statement = $pdo->prepare($query);
$statement->execute();
$activites = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
    
    <div class="container">
         <link rel="stylesheet" href="style.css">
        <h3>Liste des Activitées</h3>
     <table><table style="width:100%">

        <thead>
            <tr>
                <th>Id</th>
                <th>Lieu</th>
                <th>Date</th>
                <th>Thème</th>
                <th>Jauge</th>
                <th>Intervenant</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($activites): ?>
                <?php foreach ($activites as $activite): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($activite['id']); ?></td>
                        <td><?php echo htmlspecialchars($activite['Lieu']); ?></td>
                        <td><?php echo htmlspecialchars($activite['Date']); ?></td>
                        <td><?php echo htmlspecialchars($activite['Theme']); ?></td>
                        <td><?php echo htmlspecialchars($activite['Jauge']); ?></td>
                        <td><?php echo htmlspecialchars($activite['Intervenant']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune activité trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
</body>
</html>

