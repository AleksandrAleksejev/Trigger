<?php
require_once('connect.php');
global $yhendus;
// andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare(
            "INSERT INTO Ramaatu(nimi, nimi2 ,dat ) Values (?,?,?)"
    );
    $paring->bind_param("sis", $_REQUEST["nimi"], $_REQUEST["nimi2"], $_REQUEST["dat"]);
    //"s" - string, $_REQUEST["nimi"] - tekstkasti nimega nimi pöördumine
    //sdi, s-string, d-double, i-integer
    $paring->execute();
    //aadressi ribas eemaldatakse php käsk
    header("Location: $_SERVER[PHP_SELF]");

}
//kustutamine
if(isset($_REQUEST["kustuta"])){

    $paring=$yhendus->prepare("DELETE FROM Ramaatu WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    $paring->execute();
    //aadressi ribas eemaldatakse php käsk
    header("Location: $_SERVER[PHP_SELF]");
}

//tabeli sisu näitamine
$paring=$yhendus->prepare("SELECT id, nimi ,dat FROM Ramaatu");
$paring->bind_result($id, $nimi, $nimi2 , $dat);
$paring->execute();



?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Ramaatu</title>
</head>
<body>
<h1>Ramaatu</h1>
<table>
    <tr>
        <th>raamatuID</th>
        <th>raamatuNimi</th>
        <th>autor</th>
        <th>kirjutamiseAasta</th>
        <th>Kustuta</th>
    </tr>
    <?php
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>". htmlspecialchars($id)."</td>";
        //htmlspecialchars($id) - <käsk> - käsk nurksulgudes mis ei loetakse
        echo "<td>". htmlspecialchars($nimi)."</td>";
        echo "<td>". htmlspecialchars($nimi2)."</td>";
        echo "<td>". htmlspecialchars($dat)."</td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<h2>Uue raamat lisamine</h2>
<form name="uusRaamat" method="post" action="?">
    <input type="hidden" name="lisamisvorm">
    <input type="text" name="nimi" placeholder="Raamatu nimi">
    <br>
    <input type="text" name="nimi2"  max="30" placeholder="Autor">
    <br>
    <input type="data" name="dat"  max="30" placeholder="kirjutamiseAasta">
    <input type="submit" value="OK">
</form>

</body>
<?php
$yhendus->close();
//lisa tabelisse veerg silmadeVarv ja täida värvidega inglise keeles
//veebilehel kõik Nimed(tekst) värvida silmadeVärviga
?>
</html>
