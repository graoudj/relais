<?php
// fichier : AffCasPost3.php //
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971');

if ($conn) {
    mysqli_select_db($conn, 'dbs12233763');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Modifier'])) {
    foreach ($_POST['Lieu'] as $id => $Lieu) {
        $Lieu = mysqli_real_escape_string($conn, $Lieu);
        $Date = mysqli_real_escape_string($conn, $_POST['Date'][$id]);
        $Theme = mysqli_real_escape_string($conn, $_POST['Theme'][$id]);
        $Jauge = mysqli_real_escape_string($conn, $_POST['Jauge'][$id]);
        $Intervenant = mysqli_real_escape_string($conn, $_POST['Intervenant'][$id]);

        $sql = "UPDATE Activites SET Lieu='$Lieu', Date='$Date', Theme='$Theme', Jauge='$Jauge', Intervenant='$Intervenant' WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            echo "Activité ID $id mise à jour avec succès.<br>";
        } else {
            echo "Erreur lors de la mise à jour de l'activité ID $id: " . mysqli_error($conn) . "<br>";
        }
    }
}
echo "<pre>";
print_r($_POST);
echo "</pre>";
echo "ID: $id<br>";

mysqli_close($conn);
?>
