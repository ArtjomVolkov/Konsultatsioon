<?php
require_once("konf.php");
global $yhendus;
if (isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM konsultatsioon WHERE id=?");
    $kask->bind_param('i', $_REQUEST["kustuta"]);
    $kask->execute();
}
$kask=$yhendus->prepare(
    "SELECT id,nimi,perekonnanimi,periood FROM konsultatsioon WHERE paev=0000-00-00;");
$kask->bind_result($id, $nimi,$perekonnanimi, $periood);
$kask->execute();

?>
<!doctype html>
<html>
<head>
    <title>Konsultatsioon puudub</title>
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
    </select>
    <label for="val">Filter :</label>
    <input type="text" id="val" onkeyup="search()" />
</header>
<body>
<h1>Konsultatsioon puudub</h1>
<table id="tab">
    <tr>
        <th style='color: red;'>Eesnimi</th>
        <th style='color: red;'>Perekonnanimi</th>
        <th>Periood</th>
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
			   <td>$periood</td>
			   <td><a href='?kustuta=$id'>Kustuta</a></td>
			 </tr>
			 </tbody>
		   ";
    }
    ?>
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
