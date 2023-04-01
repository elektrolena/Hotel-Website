<?php
include "../Navbar/navbar.php";
$rowAnrede = getAnrede($db_obj, $_SESSION['personenid']);
?>
<html>

<head>
    <title>Ihr Profil</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <!--Ausgabe aller Profildaten (bis auf das Passwort)-->
        <div class="p-3">
            <h2>Ihre Stammdaten
                <!--Button zum bearbeiten der Stammdaten-->
                <a id="a" class="social-icon text-xs-center" target="_self" href="../ProfilBearbeiten/profilbearbeiten.php"> <i class="fa fa-pencil"></i></a>
            </h2>
        </div>
        <div class="row col-xs-12 p-3">
            <div class="col-sm-3 col-md-2">
                <p id="th">Anrede:</p>
            </div>
            <div class="col-sm-9 col-md-10"><?php echo $rowAnrede; ?></div>
        </div>
        <div class="row col-xs-12 p-3">
            <div class="col-sm-3 col-md-2">
                <p id="th">Vorname:</p>
            </div>
            <div class="col-sm-9 col-md-10"><?php echo $row['Vorname']; ?></div>
        </div>
        <div class="row col-xs-12 p-3">
            <div class="col-sm-3 col-md-2">
                <p id="th">Nachname:</p>
            </div>
            <div class="col-sm-9 col-md-10"><?php echo $row['Nachname']; ?></div>
        </div>
        <div class="row col-xs-12 p-3">
            <div class="col-sm-3 col-md-2">
                <p id="th">E-Mail:</p>
            </div>
            <div class="col-sm-9 col-md-10"><?php echo $row['Email']; ?></div>
        </div>
        <hr>
        <div class="row col-xs-12 p-3">
            <div class="col-sm-4 col-lg-3 col-xl-2">
                <!--Button zum bearbeiten des Profilbildes-->
                <p id="th">Profilbild: <a id="th" class="social-icon text-xs-center" target="_self" href="../ProfilBearbeiten/bildbearbeiten.php"> <i class="fa fa-pencil"></i></a></p>
            </div>
            <div class="col-sm-8 col-lg-9 col-xl-10"><?php echo "<img class='img-thumbnail w-25 border-2 border border-dark rounded-circle w-10 h-10 ' src='../uploads/profilbilder/".$profilbild.".jpg'></img>"; ?></div>
        </div>
        <div class="row col-xs-12 p-3">
            <div class="col-sm-4 col-lg-3 col-xl-2">
                <!--Button zum bearbeiten des Benutzernamens-->
                <p id="th">Benutzername: <a id="th" class="social-icon text-xs-center" target="_self" href="../ProfilBearbeiten/benutzernamebearbeiten.php"> <i class="fa fa-pencil"></i></a></p>
            </div>
            <div class="col-sm-8 col-lg-9 col-xl-10"><?php echo $row['Benutzername'];
                                                        echo "  "; ?></a></div>
        </div>
        <div class="row p-3">
            <!--Button zum bearbeiten des Passwortes-->
            <div class="col-auto"><a href="../ProfilBearbeiten/passwortbearbeiten.php"><button type="submit">Passwort ändern</button></a></div>
            <div class="col-auto"><a href="../Anmelden/sessiondestroy.php"><button type="submit">Ausloggen</button></a></div>
        </div>
    </div>
</body>