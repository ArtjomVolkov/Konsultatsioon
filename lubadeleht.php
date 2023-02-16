<?php
require_once("konf.php");
global $yhendus;
if (isset($_REQUEST["kustuta"])) {
        $kask = $yhendus->prepare("DELETE FROM konsultatsioon WHERE id=?");
        $kask->bind_param('i', $_REQUEST["kustuta"]);
        $kask->execute();
}
if (isset($_REQUEST["muuda"])) {
    $kask = $yhendus->prepare("UPDATE konsultatsioon SET periood=-1,paev='01-01-0001',tund=-1,klassiruum=-1,kommentaar=-1 WHERE id=?");
    $kask->bind_param('i', $_REQUEST["muuda"]);
    $kask->execute();
    header("Location: periood.php");
    exit();
}
if (isset($_REQUEST["lisa"])) {
    header("Location: registreerimine.php");
    exit();
}
if(!empty($_REQUEST["vormistamine_id"])){
    $kask=$yhendus->prepare(
        "UPDATE konsultatsioon SET luba=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vormistamine_id"]);
    $kask->execute();
}
$kask=$yhendus->prepare(
    "SELECT id,nimi,perekonnanimi,paev,tund,klassiruum,periood,kommentaar FROM konsultatsioon WHERE tund>0 AND nimi=nimi+nimi;");
$kask->bind_result($id, $nimi,$perekonnanimi, $paev, $tund,
    $klassiruum, $periood, $kommentaar);
$kask->execute();

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konsultatsioon</title>
    <link href="leht.css" rel="stylesheet"/>
    <link href="nav.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="konsul2.png" type="Image/jpg">
    <style>
        label{
            color:white;
        }
    </style>
</head>
<header>
    <h1>Konsultatsioon Volkov</h1>
    <nav>
        <a href="lubadeleht.php">Konsultatsiooni leht</a>
        <a href="net_konsul.php">Konsultatsiooni puuduvad</a>
    </nav>
    <label for="col">Veerg :</label>
    <select id="col">
        <option>Eesnimi</option>
        <option>Perekonnanimi</option>
        <option>Päev</option>
        <option>Tund</option>
        <option>Klassiruum</option>
        <option>Periood</option>
    </select>
    <label for="val">Filter :</label>
    <input type="text" id="val" onkeyup="search()" />
</header>
<body>
<h1>Konsultatsioon</h1>
<table id="tab">
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Päev</th>
        <th>Tund</th>
        <th>Klassiruum</th>
        <th>Periood</th>
        <th>Kommentaar</th>
        <th>Muuda andmed</th>
        <th>Kustuta andmed</th>
    </tr>
    <?php
    while($kask->fetch()){
        $loalahter=".";
        echo "
            <tbody>
		     <tr>
			   <td>$nimi</td>
			   <td>$perekonnanimi</td>
			   <td>$paev</td>
			   <td>$tund</td>
			   <td>$klassiruum</td>
			   <td>$periood</td>
			   <td>$kommentaar</td>
			   <td><a href='?muuda=$id'>Muuda</a></td>
			   <td><a href='?kustuta=$id'>Kustuta</a></td>
			 </tr>
			 </tbody>
		   ";
    }
    ?>
    <a href='?lisa='>Lisa uus õpetaja</a>
</table>
<script>
    var table = document.getElementById('tab'),
        col = document.getElementById('col'),
        val = document.getElementById('val');
    col.max = table.rows[0].cells.length - 1;

    function search() {
        var regex = new RegExp(val.value || '', 'i');
        for (var i = table.rows.length; i-- > 1;) {
            if (regex.test(table.rows[i].cells[col.selectedIndex].innerHTML)) {
                table.rows[i].style.display = 'table-row';
            } else
                table.rows[i].style.display = 'none';
        }
    }
</script>
</body>
</html>
