<?php
// Listedesenfants.php
session_start();

// Connexion à la base de données
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971', 'dbs12233763');
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login']; // Récupérer le login de la session

// Récupérer l'email de l'assistante maternelle
$sql_asmat = "SELECT Email FROM utilisateurs WHERE Login = '$login' AND Categorie = 'Asmat'";
$result_asmat = mysqli_query($conn, $sql_asmat);

if ($result_asmat && mysqli_num_rows($result_asmat) > 0) {
    $row_asmat = mysqli_fetch_assoc($result_asmat);
    $emailAsmat = $row_asmat['Email'];

    // Récupérer les activités
    $sql_activites = "SELECT * FROM Activites ORDER BY Date ASC";
    $result_activites = mysqli_query($conn, $sql_activites);

    if (!$result_activites) {
        die("Erreur lors de la récupération des activités : " . mysqli_error($conn));
    }
} else {
    die("Erreur : Assistante maternelle non identifiée ou email non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        nav a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bonjour <?php echo htmlspecialchars($login); ?> !</h1>
            <h3>Tableau de bord du Relais</h3>
        </div>
        <nav>
            <a href="dashboard.php">Accueil</a>
            <a href="GE.php">Gestion des enfants</a>
            <a href="PA.php">Programme d'activités</a>
            <a href="Ajoutactivite.php">Ajouter une activité</a>
            <a href="Accueil.php">Voir les participations</a>
            <a href="logout.php" class="logout-button">Déconnexion</a>
        </nav>
        <h4>Liste des Activités</h4>
        <form method="post" action="traiter_participation.php">
            <table>
                <thead>
                    <tr>
                        <th>Lieu</th>
                        <th>Date</th>
                        <th>Thème</th>
                        <th>Jauge</th>
                        <th>Enfants</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data_activites = mysqli_fetch_assoc($result_activites)): ?>
                        <?php
                        $IdActivite = $data_activites['id'];
                        $Lieu = htmlspecialchars($data_activites['Lieu']);
                        $Date = htmlspecialchars($data_activites['Date']);
                        $Theme = htmlspecialchars($data_activites['Theme']);
                        $Jauge = htmlspecialchars($data_activites['Jauge']);

                        // Récupérer les enfants inscrits
                        $sql_enfants_inscrits = "SELECT NPEnfant FROM Participations WHERE IDActivité = '$IdActivite'";
                        $result_enfants_inscrits = mysqli_query($conn, $sql_enfants_inscrits);
                        $enfantsInscrits = [];
                        while ($row = mysqli_fetch_assoc($result_enfants_inscrits)) {
                            $enfantsInscrits[] = $row['NPEnfant'];
                        }

                        // Récupérer les enfants de l'assistante maternelle
                        $sql_enfants = "SELECT Enfant FROM Enfants WHERE Contact_Asmat = '$emailAsmat'";
                        $result_enfants = mysqli_query($conn, $sql_enfants);
                        ?>
                        <tr>
                            <td><?php echo $Lieu; ?></td>
                            <td><?php echo $Date; ?></td>
                            <td><?php echo $Theme; ?></td>
                            <td><?php echo $Jauge; ?></td>
                            <td>
                                <?php while ($data_enfants = mysqli_fetch_assoc($result_enfants)): ?>
                                    <?php
                                    $nomPrenomEnfant = htmlspecialchars($data_enfants['Enfant']);
                                    $checked = in_array($nomPrenomEnfant, $enfantsInscrits) ? "checked" : "";
                                    ?>
                                    <label>
                                        <input type="checkbox" name="enfants[]" value="<?php echo "$nomPrenomEnfant|$Lieu|$Date|$Theme|$Jauge|$IdActivite"; ?>" <?php echo $checked; ?>>
                                        <?php echo $nomPrenomEnfant; ?>
                                    </label><br>
                                <?php endwhile; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit">Mettre à jour les inscriptions</button>
        </form>
    </div>
</body>
</html>

