<?php
require_once("konf.php");
global $yhendus;
if(isSet($_REQUEST["sisestusnupp"])){
    $kask=$yhendus->prepare(
        "INSERT INTO konsultatsioon(nimi, perekonnanimi) VALUES (?, ?)");
    $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
    $kask->execute();
    $yhendus->close();
    header("Location: periood.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <title>Kasutaja Registreerimise</title>
    <link href="nav.css" rel="stylesheet"/>
    <link href="reg.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="konsul2.png" type="Image/jpg">
    <script>
        function noDigits(event) {
            if ("1234567890!#¤%&/()=?*".indexOf(event.key) != -1)
                event.preventDefault();
        }
    </script>
</head>
<header>
    <h1>Konsultatsioon Volkov</h1>
</header>
<nav>
    <a href="lubadeleht.php">Konsultatsiooni leht</a>
    <a href="net_konsul.php">Konsultatsiooni puuduvad</a>
</nav>
<body>
<?php
if(isSet($_REQUEST["lisatudeesnimi"])){
    echo "Lisati $_REQUEST[lisatudeesnimi]";
}
?>
<img src="Konsultatsiya.jpg" alt="Jalgratta" style="width:400px; position:absolute; top:35%; left:17%">
<img src="Konsultatsiya.jpg" alt="Jalgratta2" style="width:400px; position:absolute; top:35%; left:62%">
<div class="login-box">
    <h1>Registreerimise konsultatsioon</h1>
<form action="?">
    <dl>
        <div class="user-box">
        <dt>Eesnimi:</dt>
        <dd><input type="text" name="eesnimi" onkeypress="noDigits(event)" /></dd>
            </div>
            <div class="user-box">
        <dt>Perekonnanimi:</dt>
        <dd><input type="text" name="perekonnanimi" onkeypress="noDigits(event)" /></dd>
            </div>
        <dt><input type="submit" name="sisestusnupp" value="sisesta" /></dt>
    </dl>
</form>
</div>
</body>
</html>
