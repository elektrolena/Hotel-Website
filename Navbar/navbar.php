<?php
/*Es wird eine neue Session gestartet, wenn nicht schon eine vorhanden ist*/
if (!isset($_SESSION)) {
    session_start();
}
/*Verbindung mit unserer DB*/
if (basename($_SERVER['SCRIPT_NAME'] , $suffix = ".php") == 'index') {
    include "DBconnect/dbConnect.php";
    include "Funktionen/funktionen.php";
    $parentdirectory = "";
    $parentdirectorypicture = "uploads";
} else {
    include "../DBconnect/dbConnect.php";
    include "../Funktionen/funktionen.php";
    $parentdirectory = "../";
    $parentdirectorypicture = "../uploads";
}
if (isset($_SESSION["personenid"])) { //wenn ein User/Admin eingeloggt ist -> Session Variable wird beim Login gesetzt und beim Logout destroyed
    $row = getRow($db_obj, "personen", $_SESSION["personenid"]); //Sucht den Datensatz mit der zugehörigen PersonenID in der DB
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="<?php echo $parentdirectory;?>CSS/hotelhelenastylesheetsfinal.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Navbar-->
    <div class="w3-top ">
        <div class="w3-bar w3-white w3-card w3-pale-yellow w3-text-brown" id="myNavbar">
            <div class="mr-2">
                <a id="TEXTLOGO" href="<?php echo $parentdirectory;?>index.php"
                    class="w3-hide-medium w3-hide-small w3-bar-item w3-button w3-pale-yellow w3-text-brown"><img
                        class="LOGO" src="<?php echo $parentdirectory;?>HotelHelenaImages/logo.png" alt="Hotel Helena">
                    <p id="TEXT" class="w3-show-inline-block"><span class="firstletter">H</span>OTEL <span
                            class="firstletter">H</span>ELENA</p>
                </a>
                <a href="<?php echo $parentdirectory;?>index.php" class="w3-hide-large w3-bar-item w3-button w3-pale-yellow w3-text-brown"><img
                        class="LOGOsmall" src="<?php echo $parentdirectory;?>HotelHelenaImages/logo.png" alt="Logo"></a>
            </div>
            <!-- Right-sided navbar links -->
            <div id="mynav" class="w3-right w3-hide-small w3-hide-medium w3-pale-yellow w3-text-brown">
                <ul class="list-inline mt-5">
                    <?php
                    if (isset($_SESSION["personenid"])) {
                        //implode — Verbindet Array-Elemente zu einem String
                        $profilbild = implode(getProfilBild($db_obj, $_SESSION['personenid']));
                    }
                    if (isset($_SESSION['usertyp']) && ($_SESSION['usertyp']) != '1') { //Navbar-Ansicht, wenn ein USER eingeloggt ist
                        ?>
                        <li class="list-inline-item navbar-item"><a id="a" class="social-icon text-xs-center" target="_self"
                                href="<?php echo $parentdirectory;?>UserReservieren/zimmerreservierung.php"><i class="fa fa-bed"></i>
                                RESERVIERUNGEN</a></li>
                        <?php
                    }
                    if (isset($_SESSION['usertyp']) && ($_SESSION['usertyp']) == '1') { //Navbar-Ansicht, wenn ein ADMIN eingeloggt ist
                        ?>
                        <li class="list-inline-item navbar-item"><a id="a" class="social-icon text-xs-center" target="_self"
                                href="<?php echo $parentdirectory;?>News/newsbeitragFormular.php"><i class="fa fa-pencil"></i> NEUER BEITRAG</a></li>
                        <li class="list-inline-item navbar-item"><a id="a" class="social-icon text-xs-center" target="_self"
                                href="<?php echo $parentdirectory;?>AdminAnsicht/einsicht.php"><i class="fa fa-address-book"></i> EINSICHT</a></li>
                        <?php
                    }
                    ?>
                    <!--Wird immer angezeigt (ANONYM, USER, ADMIN)-->
                    <li class="list-inline-item navbar-item"><a id="a" class="social-icon text-xs-center" target="_self"
                            href="<?php echo $parentdirectory;?>News/newsPost.php"><i class="fa fa-bullhorn"></i> NEWS</a></li>
                    <li class="list-inline-item navbar-item"><a id="a" class="social-icon text-xs-center" target="_self"
                            href="<?php echo $parentdirectory;?>Seiten/hilfeseite.php"><i class="fa fa-question-circle"></i> HILFE</a></li>
                    <li class="list-inline-item navbar-item"><a id="a" class="social-icon text-xs-center" target="_self"
                            href="<?php echo $parentdirectory;?>Seiten/impressum.php"><i class="fa fa-info-circle"></i> IMPRESSUM</a></li>
                    <?php
                    //Wenn jemand eingeloggt ist (USER oder ADMIN), wird das Profilbild und der Benutzername in kleiner Form rechts oben angezeigt
                    if (isset($_SESSION['usertyp'])) { ?>
                        <li class="list-inline-item navbar-item"><button id="button3" class="social-icon text-xs-center"
                                target="_self" onclick="window.location.href='<?php echo $parentdirectory;?>ProfilBearbeiten/profil.php'"><?php echo "<img alt=' ' width='22' class='border rounded-circle' src='$parentdirectorypicture/profilbilder/$profilbild.jpg'></img>"; ?>
                                <?php echo " ";
                                echo $row['Benutzername']; ?>
                            </button></li>
                        <?php
                        //Wenn niemand eingeloggt ist (ANONYM), wird der Login-Button angezeigt
                    } else { ?>
                        <li class="list-inline-item navbar-item"><button id="button3" class="social-icon text-xs-center"
                                target="_self" onclick="window.location.href='<?php echo $parentdirectory;?>Anmelden/login.php'"><i
                                    class="fa fa-user"></i>
                                LOGIN</button></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <!--hamburger dropdown für die Mobile-Ansicht -->
            <div id="mynavhidden" class="w3-right w3-hide-large w3-pale-yellow w3-text-brown">
                <ul id="ulhidden" class="">
                    <?php
                    if (isset($_SESSION['usertyp']) && ($_SESSION['usertyp']) != '1') { //Navbar-Ansicht, wenn ein USER eingeloggt ist in Mobiler-Ansicht
                        ?>
                        <li class="list-inline-item navbar-item"><a id="ahidden" class="social-icon text-xs-center"
                                target="_self" href="<?php echo $parentdirectory;?>UserReservieren/zimmerreservierung.php"><i class="fa fa-bed"></i>
                                RESERVIERUNG</a></li>
                        <?php
                    }
                    if (isset($_SESSION['usertyp']) && ($_SESSION['usertyp']) == '1') { //Navbar-Ansicht, wenn ein ADMIN eingeloggt ist in Mobiler-Ansicht
                        ?>
                        <li class="list-inline-item navbar-item"><a id="ahidden" class="social-icon text-xs-center"
                                target="_self" href="<?php echo $parentdirectory;?>News/newsbeitragFormular.php"><i class="fa fa-pencil"></i> NEUER
                                BEITRAG</a>
                        </li>
                        <li class="list-block-item navbar-item"><a id="ahidden" class="social-icon text-xs-center"
                                target="_self" href="<?php echo $parentdirectory;?>AdminAnsicht/einsicht.php"><i class="fa fa-address-book"></i>
                                EINSICHT</a></li>
                        <?php
                    }
                    ?>
                    <!--Wird immer angezeigt (ANONYM, USER, ADMIN) in Mobil-Ansicht -->
                    <li class="list-block-item navbar-item"><a id="ahidden" class="social-icon text-xs-center"
                            target="_self" href="<?php echo $parentdirectory;?>News/newsPost.php"><i class="fa fa-bullhorn"></i> NEWS</a></li>
                    <li class="list-block-item navbar-item"><a id="ahidden" class="social-icon text-xs-center"
                            target="_self" href="<?php echo $parentdirectory;?>Seiten/hilfeseite.php"><i class="fa fa-question-circle"></i>
                            HILFE</a></li>
                    <li class="list-block-item navbar-item"><a id="ahidden" class="social-icon text-xs-center"
                            target="_self" href="<?php echo $parentdirectory;?>Seiten/impressum.php"><i class="fa fa-info-circle"></i>
                            IMPRESSUM</a></li>
                    <?php
                    //Wenn jemand eingeloggt ist (USER oder ADMIN), wird das Profilbild und der Benutzername in kleiner Form rechts oben angezeigt in Mobiler-Ansicht
                    if (isset($_SESSION['usertyp'])) { ?>
                        <li class="list-inline-item navbar-item"><button id="button3" class="social-icon text-xs-center"
                                target="_self" onclick="window.location.href='<?php echo $parentdirectory;?>ProfilBearbeiten/profil.php'"><?php echo "<img width='22' class='border rounded-circle' src='$parentdirectorypicture/profilbilder/$profilbild.jpg'></img>"; ?>
                                <?php echo " ";
                                echo $row['Benutzername']; ?>
                            </button></li>
                        <?php
                        //Wenn niemand eingeloggt ist (ANONYM), wird der Login-Button angezeigt in Mobiler-Ansicht
                    } else { ?>
                        <li class="list-inline-item navbar-item"><button id="button3" class="social-icon text-xs-center"
                                target="_self" onclick="window.location.href='<?php echo $parentdirectory;?>Anmelden/login.php'"><i
                                    class="fa fa-user"></i>
                                LOGIN</button></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <script>
                function myFunction() {
                    var x = document.getElementById("mynavhidden");
                    if (x.style.display === "block") {
                        x.style.display = "none";
                    } else {
                        x.style.display = "block";
                    }
                }
            </script>
            <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
            <a href="javascript:void(0);" id="ham-bars" class="icon w3-bar-item w3-button w3-right w3-hide-large"
                onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
    <!--Navbar-->
</head>