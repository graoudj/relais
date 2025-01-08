<!--fichier: PA.php -->
<title>Le programme d'activités</title>
<a href="index.php">Revenir à la page d'accueil</a> | <a href="dashboard.php">Retour au choix de l'administrateur</a>
<center><h1>Programme des activités</h1>

<?php
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971');

if ($conn) {
    mysqli_select_db($conn, 'dbs12233763');
}

$sql = "SELECT * FROM Activites";
?>

<form method="post" action="AffCasePost3.php">
    <caption>MODIFICATION DES ACTIVITÉS DU RPE</caption><br><br>

    <?php
    if ($result = mysqli_query($conn, $sql)) {
        echo "<table >
        <tr>
        <th>Lieu</th>
        <th>Date</th>
        <th>Thème</th>
        <th>Jauge</th>
        <th>Itervenant</th
        </tr>";
        
        while ($data = mysqli_fetch_array($result)) {
            $Lieu = $data['Lieu'];
            $Date = $data['Date'];
            $Theme = $data['Theme'];
            $Jauge = $data['Jauge'];
             $Intervenant = $data['Intervenant'];
            $id = $data['id']; // Assumes each activity has a unique id
            
            echo "<tr>
                <td><input type='text' name='Lieu[$id]' value='" . htmlspecialchars($Lieu) . "'></td>
                <td><input type='text' name='Date[$id]' value='" . htmlspecialchars($Date) . "'></td>
                <td><input type='text' name='Theme[$id]' value='" . htmlspecialchars($Theme) . "'></td>
                <td><input type='text' name='Jauge[$id]' value='" . htmlspecialchars($Jauge) . "'></td> 
                <td><input type='text' name='Intervenant[$id]' value='" . htmlspecialchars($Intervenant) . "'></td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "Erreur lors de la récupération des activités.";
    }

    mysqli_close($conn);
    ?>

    <br>
    <input type="submit" name="Modifier" value="Modifier">
</form>
<br>
<a href="Ajoutactivite.php">Inscrire une nouvelle Activité</a>
