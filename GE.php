<!--fichier: GE.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des enfants</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="text-align:center">

    <h4> <?php echo "$login"?></h4>
 <h3> Tableau de bord du Relais</h3>
  <a href="dashboard.php" title="Retour au menu principal">
    <img src="RPE.png" alt="Logo RPE" class="logo"></a>
 <div>
 
<center><h1>Les Enfants du relais</h1>

<?php
$conn = mysqli_connect('db5014723397.hosting-data.io', 'dbu1172053', 'Bruxelle19671971');

if ($conn) {
    mysqli_select_db($conn, 'dbs12233763');
}

$sql = "SELECT * FROM Enfants";
?>

<form method="post" action="AffCasePost4.php">
    <caption>MODIFICATION DES ENFANTS INSCRIS</caption><br><br>

    <?php
    if ($result = mysqli_query($conn, $sql)) {
    //    echo "<table ><tr><th>Lieu</th><th>Date</th><th>Thème</th>><th>Jauge</th><th>Itervenant</th</tr>";
        echo "<table >
        <tr>
        <th>Enfant</th>
        <th>D_de_naissance</th>
        <th>Parent1</th>
        <th>Parent2</th>
        <th>Commune</th>
        <th>Contact_parent</th>
        <th>AssMat</th>
        <th>Commune_Asmat</th>
        <th>Contact_Asmat</th>
        <th>RPE1</th>
        <th>RPE2</th>
        
              </tr>";
      
          while ($data = mysqli_fetch_array($result)) {
            $NPE = $data['Enfant'];
            $DDN = $data['D_de_naissance'];
            $Parent1 = $data['Parent1'];
            $Parent2 = $data['Parent2'];
            $Commune = $data['Commune'];
            $Contact_parent = $data['Contact_parent'];
            $AssMat = $data['AssMat'];
            $Commune_Asmat = $data['Commune_Asmat'];
            $Contact_Asmat = $data['Contact_Asmat'];
            $RPE1 = $data['RPE1'];
             $RPE2 = $data['RPE2'];
           
            $Id = $data['Id']; // Assumes each activity has a unique id
            
            echo "<tr>
                <td><input type='text' name='Enfant[$Id]' value='" . htmlspecialchars($NPE) . "'></td>
                <td><input type='text' name='D_de_naissance[$Id]' value='" . htmlspecialchars($DDN) . "'></td>
                <td><input type='text' name='Parent1[$Id]' value='" . htmlspecialchars($Parent1) . "'></td>
                <td><input type='text' name='Parent2[$Id]' value='" . htmlspecialchars($Parent2) . "'></td> 
                <td><input type='text' name='Commune[$Id]' value='" . htmlspecialchars($Commune) . "'></td>
                <td><input type='text' name='Contact_parent[$Id]' value='" . htmlspecialchars($Contact_parent) . "'></td>
                <td><input type='text' name='AssMat[$Id]' value='" . htmlspecialchars($AssMat) . "'></td>
                <td><input type='text' name='Commune_Asmat[$Id]' value='" . htmlspecialchars($Commune_Asmat) . "'></td> 
                <td><input type='text' name='Contact_Asmat[$Id]' value='" . htmlspecialchars($Contact_Asmat) . "'></td>
                <td><input type='text' name='RPE1[$Id]' value='" . htmlspecialchars($RPE1) . "'></td>
                <td><input type='text' name='RPE2[$Id]' value='" . htmlspecialchars($RPE2) . "'></td>
              
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
</div>
