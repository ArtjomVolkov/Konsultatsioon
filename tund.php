<?php
require_once("konf.php");
global $yhendus;
if(isSet($_REQUEST["sise"])){
    $kask=$yhendus->prepare(
        "UPDATE konsultatsioon SET tund=?, klassiruum=? WHERE id=?");
    $kask->bind_param("isi", $_REQUEST["tund"],$_REQUEST["ruum"], $_REQUEST["id"]);
    $kask->execute();
    $yhendus->close();
    header("Location: komment.php");
    exit();
}
$kask=$yhendus->prepare("SELECT id, nimi, perekonnanimi 
     FROM konsultatsioon WHERE periood<=5 AND tund=-1 AND paev>0001-00-00");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html>
<head>
    <title>Tund</title>
    <link href="leht.css" rel="stylesheet"/>
    <link href="nav.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="konsul2.png" type="Image/jpg">
</head>
<header>
    <h1>Konsultatsioon Volkov</h1>
    <nav>
        <a href="lubadeleht.php">Konsultatsiooni leht</a>
        <a href="net_konsul.php">Konsultatsiooni puuduvad</a>
    </nav>
</header>
<body>
<h1>Tund</h1>
<table>
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Tund ja klassiruum</th>
    </tr>
    <?php
    while($kask->fetch()){
        echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perekonnanimi</td>
			  <td>
			    <form action=''>
			  <input type='hidden' name='id' value='$id' />
			    <input type='number'name='tund' placeholder='Tund 1-15' max='15' min='1'>
			    <input type='text' name='ruum' placeholder='Klassiruum'>
			    <input type='submit' name='sise' value='Edasi'>
			    </form>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</body>
</html>
