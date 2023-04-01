<?php include "../Navbar/navbar.php";
//Daten von (reservieren.php) holen
$userid = $_GET['userid'];
$anreise = $_GET['anreise'];
$abreise = $_GET['abreise'];
$breakfast = $_GET['breakfast'];
$parkplatz = $_GET['parkplatz'];
$haustiere = $_GET['haustiere'];
$preis = $_GET['preis'];
$zimmer = $_GET['zimmer'];
$eintrag = "INSERT INTO reservierungen (AnreiseDatum, AbreiseDatum, Frühstück, Parkplatz, Haustiere, Preis, Zimmer, PersonenID_FK) VALUES ('$anreise', '$abreise', '$breakfast', '$parkplatz', '$haustiere', '$preis', '$zimmer','$userid')";
$eintragen = mysqli_query($db_obj, $eintrag); //Eintrag der Reservierung in die DB
?>
<html>

<head>
    <title>Erfolgreiche Registrierung</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="navbarDONE/navbar.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div id="seite" class="container p-3 bg-light">
        <div class="p-3">
            <h2>Ihre Reservierung war erfolgreich.</h2>
        </div>
        <div class="p-3">
            <a href="zimmerreservierung.php"><button type="submit">Zur Reservierungsübersicht</button></a>
        </div>
    </div>

</body>

</html>