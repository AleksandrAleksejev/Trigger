<?php
require_once('connect.php');
global $yhendus;
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}
// andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare(
        "INSERT INTO loomad(loomanimi, vanus, pilt) Values (?,?,?)"
    );
    $paring->bind_param("sis", $_REQUEST["nimi"], $_REQUEST["vanus"], $_REQUEST["pilt"]);
    //"s" - string, $_REQUEST["nimi"] - tekstkasti nimega nimi pöördumine
    //sdi, s-string, d-double, i-integer
    $paring->execute();
    //aadressi ribas eemaldatakse php käsk
    header("Location: $_SERVER[PHP_SELF]");

}
// kustutamine tabelist



?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Ramaatu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Ramaatu</h1>
<div id="meny">
    <ul>
    <?php
    //näitab loomade loetelu tabelist loomad
    $paring=$yhendus->prepare("SELECT id, nimi FROM Ramaatu");
    $paring->bind_result($id, $nimi);
    $paring->execute();

        while($paring->fetch()) {
        echo "<li><a href='?id=$id'>$nimi</a></li>";
        }
        echo "</ul>";
        echo "<a href='?lisaloom=jah'>Lisa Loom</a>";
    ?>

</div>
<div id="sisu">

    <?php
    if(isset($_REQUEST["id"])){
        $paring=$yhendus->prepare("
SELECT nimi, nimi2, dat,FROM Ramaatu WHERE id=?");
        $paring->bind_param("i", $_REQUEST["id"]);
        //? küsimärki asemel aadressiribalt tuleb id
        $paring->bind_result($nimi, $nimi2, $dat);
        $paring->execute();
        if($paring->fetch()){
            echo "<div><strong>".htmlspecialchars($nimi)."</strong>, vanus ";
            echo htmlspecialchars(nimi2). "";
            echo htmlspecialchars(dat). " date.";
            echo "</div>";

        }
        echo "<a href='?kustuta=$id'>Kustuta</a>";
    }


        if(isset($_REQUEST["lisaraamat"])){
            ?>
    <h2>Uue looma lisamine</h2>
    <form name="uusloom" method="post" action="?">
    <input type="hidden" name="lisamisvorm" value="jah">
    <input type="text" name="nimi" placeholder="Raamat nimi">
    <br>
    <input type="text" name="nimi"  max="30" placeholder="Autor">
    <br>
    <input type="number" name="date"  max="30" placeholder="kirjutamiseAasta">
    <br>
    <input type="submit" value="OK">
    </form>
<?php
        }
        else {
            echo " <h3>Siia tuleb loomade info...</h3>";
        }
    $yhendus->close();
    ?>
</div>
</body>
</html>
