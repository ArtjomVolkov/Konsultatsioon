<?php
require_once("konf.php");
global $yhendus;
if(isSet($_REQUEST["sises"])){
    $kask=$yhendus->prepare(
        "UPDATE konsultatsioon SET paev=? WHERE id=?");
    $kask->bind_param("si", $_REQUEST["dates"], $_REQUEST["id"]);
    $kask->execute();
    $yhendus->close();
    header("Location: tund.php");
    exit();
}
$kask=$yhendus->prepare("SELECT id, nimi, perekonnanimi 
     FROM konsultatsioon WHERE periood<=5 AND paev='01-01-0001'");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html>
<head>
    <title>Kuupäev</title>
    <link href="leht.css" rel="stylesheet"/>
    <link href="nav.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="konsul2.png" type="Image/jpg">
    <style>
        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            opacity: 1;
            transition: opacity 0.6s;
            margin-bottom: 15px;
        }

        .alert.info {
            position: absolute;
            top: 90%;
            left: 40%;
            background-color: #b40b0b;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
</head>
<header>
    <h1>Konsultatsioon Volkov</h1>
    <nav>
        <a href="lubadeleht.php">Konsultatsiooni leht</a>
        <a href="net_konsul.php">Konsultatsiooni puuduvad</a>
    </nav>
</header>
<body>
<div class="alert info">
    <span class="closebtn">&times;</span>
    <strong>Info!</strong> Kui sul pole konsultatsiooni, minne edasi!!!
</div>
<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function(){
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function(){ div.style.display = "none"; }, 600);
        }
    }
</script>
<h1>Kuupäev</h1>
<table>
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Päev</th>
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
			    <input type='date'name='dates' placeholder='dd.mm.yyyy'>
			    <input type='submit' name='sises' value='Edasi'>
			    </form>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</body>
</html>
