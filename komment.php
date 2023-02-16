<?php
require_once("konf.php");
global $yhendus;
if(isSet($_REQUEST["sised"])){
    $kask=$yhendus->prepare(
        "UPDATE konsultatsioon SET kommentaar=? WHERE id=?");
    $kask->bind_param("si", $_REQUEST["komment"], $_REQUEST["id"]);
    $kask->execute();
    $yhendus->close();
    header("Location: lubadeleht.php");
    exit();
}
$kask=$yhendus->prepare("SELECT id, nimi, perekonnanimi 
     FROM konsultatsioon WHERE kommentaar=-1 AND paev>0001-00-00");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html>
<head>
    <title>Kommentaar</title>
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
<h1>Kommentaar</h1>
<table>
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Kommentaar</th>
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
			    <input type='text'name='komment' placeholder='Kommentaar'>
			    <input type='submit' name='sised' value='Edasi'>
			    </form>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</body>
</html>
