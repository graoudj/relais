<?php
// traiter_participation.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Connexion à la base de données
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971', 'dbs12233763');
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enfantsSelectionnes = $_POST['enfants'] ?? [];

    // Traiter les inscriptions
    foreach ($enfantsSelectionnes as $enfantActivite) {
        list($NPEnfant, $Lieu, $Date, $Theme, $Jauge, $IdActivite) = explode('|', $enfantActivite);

        $sql_check = "SELECT * FROM Participations WHERE NPEnfant = '$NPEnfant' AND IDActivité = '$IdActivite'";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) == 0) {
            // Inscrire si non déjà présent
            $sql_insert = "INSERT INTO Participations (NPEnfant, LieuActiv, DateActiv, Theme, Jauge, IDActivité) 
                           VALUES ('$NPEnfant', '$Lieu', '$Date', '$Theme', '$Jauge', '$IdActivite')";

            if (mysqli_query($conn, $sql_insert)) {
                echo "Inscription de $NPEnfant à l'activité $Theme réussie.<br>";
            } else {
                echo "Erreur lors de l'inscription de $NPEnfant : " . mysqli_error($conn) . "<br>";
            }
        }
    }

    // Désinscrire les enfants décochés
    $sql_get_all = "SELECT * FROM Participations";
    $result_all = mysqli_query($conn, $sql_get_all);

    while ($row = mysqli_fetch_assoc($result_all)) {
        $NPEnfant = $row['NPEnfant'];
        $IdActivite = $row['IDActivité'];

        $enfantActivite = "$NPEnfant|$row[LieuActiv]|$row[DateActiv]|$row[Theme]|$row[Jauge]|$IdActivite";
        if (!in_array($enfantActivite, $enfantsSelectionnes)) {
            $sql_delete = "DELETE FROM Participations WHERE NPEnfant = '$NPEnfant' AND IDActivité = '$IdActivite'";
            if (mysqli_query($conn, $sql_delete)) {
                echo "Désinscription de $NPEnfant de l'activité $row[Theme] réussie.<br>";
            } else {
                echo "Erreur lors de la désinscription de $NPEnfant : " . mysqli_error($conn) . "<br>";
            }
        }
    }
}

mysqli_close($conn);
?>
