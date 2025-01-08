<?php
//  fichier:fram_Listedesenfants.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login'] ?? null;
if (!$login) {
    die("Erreur : utilisateur non identifié.");
}

// Connexion à la base de données
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971', 'dbs12233763');
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Requête pour récupérer les informations de l'asmat
$sql_asmat = "SELECT Nom, Prenom, Adresse, CommuneResidence, Email FROM utilisateurs WHERE Login = '$login' AND Categorie = 'Asmat'";
$result_asmat = mysqli_query($conn, $sql_asmat);
if (!$result_asmat) {
    die("Erreur SQL (récupération asmat) : " . mysqli_error($conn));
}

if (mysqli_num_rows($result_asmat) > 0) {
    $row_asmat = mysqli_fetch_assoc($result_asmat);

    // Afficher les informations générales
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; background-color: #f9f9f9;'>";
    echo "<h3>Informations générales</h3>";
    echo "<p><strong>Nom : </strong>" . htmlspecialchars($row_asmat['Nom']) . "</p>";
    echo "<p><strong>Prénom : </strong>" . htmlspecialchars($row_asmat['Prenom']) . "</p>";
    echo "<p><strong>Adresse : </strong>" . htmlspecialchars($row_asmat['Adresse']) . "</p>";
    echo "<p><strong>CommuneResidence : </strong>" . htmlspecialchars($row_asmat['CommuneResidence']) . "</p>";
    echo "<p><strong>Email : </strong>" . htmlspecialchars($row_asmat['Email']) . "</p>";

    // Requête pour récupérer les enfants de l'asmat
    $emailAsmat = $row_asmat['Email'];
    $sql_enfants = "SELECT Enfant, D_de_naissance FROM Enfants WHERE Contact_Asmat = '$emailAsmat'";
    $result_enfants = mysqli_query($conn, $sql_enfants);
    if (!$result_enfants) {
        die("Erreur SQL (récupération enfants) : " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_enfants) > 0) {
        echo "<h4>Liste des enfants :</h4>";
        echo "<ul>";
        while ($row_enfant = mysqli_fetch_assoc($result_enfants)) {
            echo "<li>" . htmlspecialchars($row_enfant['Enfant']) . " (Né(e) le : " . htmlspecialchars($row_enfant['D_de_naissance']) . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun enfant enregistré.</p>";
    }

    echo "</div>";
} else {
    echo "Erreur : Aucune assistante maternelle trouvée.";
}

mysqli_close($conn);
?>

