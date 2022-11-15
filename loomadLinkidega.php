<?php
require_once ('connect.php');
global $yhendus;
//andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST['raamatu'])){
    $paring=$yhendus->prepare('INSERT INTO loomadevarjupaik(raamatuNimi,kirjutamiseAasta,autor) Values(?,?,?)');
    $paring->bind_param('sis',$_REQUEST['nimi'],$_REQUEST['kirjutamiseAasta'],$_REQUEST['autor']);
    $paring->execute();
}


//kustutamine
if(isset($_REQUEST['kustutusid'])) {
    $paring = $yhendus->prepare('DELETE FROM loomadevarjupaik WHERE raamatuID=?');
    $paring->bind_param('i', $_REQUEST['kustutusid']);
    $paring->execute();
}

$paring=$yhendus->prepare('SELECT raamatuID, raamatuNimi,kirjutamiseAasta,autor FROM raamatu');
$paring->bind_result($raamatuID, $raamatuNimi, $kirjutamiseAasta,$autor);
$paring->execute();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Raamatukogu</title>
</head>
<body>

<h1>Loomade tabel</h1>
<table>
    <tr>
        <th>RaamatuID</th>
        <th>Raamatu nimi</th>
        <th>kirjutamiseAasta</th>
        <th>autor</th>
        <th>Kustuta</th>
    </tr>
    <?php
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>". htmlspecialchars($raamatuID)."</td>";
        echo "<td>". htmlspecialchars($raamatuNimi)."</td>";
        echo "<td>". htmlspecialchars($kirjutamiseAasta)."</td>";
        echo "<td>". htmlspecialchars($autor)."</td>";

        echo "<td><a href='$_SERVER[PHP_SELF]?kustutusid=$raamatuID'>kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<h2>Uue raamat lisamine</h2>
<form name="uusloom" method="post" action="?">
    <input type="hidden" name="lisamisvorm">
    <input type="text" name="raamatuNimi" placeholder="raamatu Nimi">
    <br>
    <br>
    <input type="text" name="kirjutamiseAasta" placeholder="kirjutamise Aasta">
    <br>
    <br>
    <input type="text" name="autor" placeholder="autor">
    <br>
    <br>
    <input type="submit" value="OK">
</form>
</body>
<?php
$yhendus->close();
?>
</html>

