<?php
// fichier : AffCasPost4.php //
// Connexion à la base de données
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971');

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

mysqli_select_db($conn, 'dbs12233763');

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Modifier'])) {
    foreach ($_POST['Enfant'] as $Id => $NPE) {
        // Validation des champs et échappement pour la sécurité
        $NPE = mysqli_real_escape_string($conn, $NPE ?? '');
        $DDN = mysqli_real_escape_string($conn, $_POST['D_de_naissance'][$Id] ?? '');
        $Parent1 = mysqli_real_escape_string($conn, $_POST['Parent1'][$Id] ?? '');
        $Parent2 = mysqli_real_escape_string($conn, $_POST['Parent2'][$Id] ?? '');
        $Commune = mysqli_real_escape_string($conn, $_POST['Commune'][$Id] ?? '');
        $Contact_parent = mysqli_real_escape_string($conn, $_POST['Contact_parent'][$Id] ?? '');
        $AssMat = mysqli_real_escape_string($conn, $_POST['AssMat'][$Id] ?? '');
        $Commune_Asmat = mysqli_real_escape_string($conn, $_POST['Commune_Asmat'][$Id] ?? '');
        $Contact_Asmat = mysqli_real_escape_string($conn, $_POST['Contact_Asmat'][$Id] ?? '');
        $RPE1 = mysqli_real_escape_string($conn, $_POST['RPE1'][$Id] ?? '');
        $RPE2 = mysqli_real_escape_string($conn, $_POST['RPE2'][$Id] ?? '');

        // Mise à jour des données dans la table Enfants
        $sql = "UPDATE Enfants SET 
                    Enfant = '$NPE',
                    D_de_naissance = '$DDN',
                    Parent1 = '$Parent1',
                    Parent2 = '$Parent2',
                    Commune = '$Commune',
                    Contact_parent = '$Contact_parent',
                    AssMat = '$AssMat',
                    Commune_Asmat = '$Commune_Asmat',
                    Contact_Asmat = '$Contact_Asmat',
                    RPE1 = '$RPE1',
                    RPE2 = '$RPE2'
                WHERE Id = $Id";

        if (mysqli_query($conn, $sql)) {
            echo "Enfant ID $Id mis à jour avec succès.<br>";
        } else {
            echo "Erreur lors de la mise à jour de l'enfant ID $Id: " . mysqli_error($conn) . "<br>";
        }
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>

