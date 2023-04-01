<?php include "../Navbar/navbar.php";
$back = 0;
?>
<html>

<head>
    <title>Hotel Helena</title>
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
    <?php
    $preis = 0;

    $anreise = $abreise = $anrdate = $abrdate = $zimmer = $breakf = $parkpl = $haustiere = "";
    $anrdateErr = $abrdateErr = $zimmerErr = $breakfErr = $parkplErr = $haustErr = $freiErr = "";
    $breakfastpreis = $parkplatzpreis = $haustierpreis = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn Button am Ende des Formulares geklickt wurde

        $error = 0;
        if (empty($_POST["anreisedate"])) { //wenn kein Anreisedatum angegeben wurde
            $anrdateErr = "Anreisedatum muss angegeben werden";
            $error = 1;
        } else {
            $anreise = test_input($_POST["anreisedate"]);
            $_SESSION["anreisedate"] = $anreise;
        }

        if (empty($_POST["abreisedate"])) { //wenn kein Abreisedatum angegeben wurde
            $abrdateErr = "Abreisedatum muss angegeben werden";
            $error = 1;
        } else {
            if ($_POST["anreisedate"] == $_POST["abreisedate"]) { //wenn Anreise- und Abreisedatum gleich sind
                $error = 1;
                $abrdateErr = "Anreisedatum kann nicht gleich Abreisedatum sein";
            } else if($_POST["anreisedate"] > $_POST["abreisedate"]) {
                $error = 1;
                $abrdateErr = "Abreisedatum darf nicht vor dem Anreisedatum sein";
            } else {
                $abreise = test_input($_POST["abreisedate"]);
                $_SESSION["abreisedate"] = $abreise;
            }
        }


        if (empty($_POST["zimmer"])) { //wenn keine Zimmer gewählt wurden
            $zimmerErr = "Bitte geben Sie mind. ein Zimmer an!";
            $error = 1;
        } else {
            $zimmer = test_input($_POST["zimmer"]);
            $_SESSION["zimmer"] = $zimmer;
            //Verfügbarkeit 
            $sql = "SELECT Zimmer FROM reservierungen WHERE 
                    ('".$anreise."' BETWEEN Anreisedatum AND Abreisedatum)
                    OR
                    ('".$abreise."' BETWEEN Anreisedatum AND Abreisedatum)
                    OR
                    ('".$anreise."' <= Anreisedatum AND '".$abreise."' >= Abreisedatum)
                    AND StatusID_FK != 3"; //stornierte Reservierungen werden nicht berücksichtigt
            $summe = 0;
            $stmt = $db_obj->prepare($sql);
            $stmt->execute(); //holt alle zu dem Zeitraum gebuchten Zimmer aus der DB
            $stmt->bind_result($gebZimmer);
            while ($stmt->fetch()) {
                $summe = $summe + $gebZimmer; //rechnet alle gebuchten Zimmer aus der DB zusammen
            }
            $summe = $summe + (int)$zimmer; //rechnet die gewählte Anzahl an Zimmern aus dem Formular dazu
            if ($summe + 1 > 20){ //wenn es insgesamt mehr als 20 Zimmer sind
                $error = 1;
                $freiErr = "Leider sind die gewünschten Zimmer in Ihrem gewählten Zeitraum nicht verfügbar";
            } 
        }

        if (empty($_POST["breakfast"])) { //wenn kein Frühstück angegeben wurde
            $breakfErr = "Bitte angeben!";
            $error = 1;
        } else {
            $breakfast = test_input($_POST["breakfast"]);
            $_SESSION["breakfast"] = $breakfast;
        }

        if (empty($_POST["parkplatz"])) { //wenn keine Parkplatzoption gewählt wurde
            $parkplErr = "Bitte angeben!";
            $error = 1;
        } else {
            $parkplatz = test_input($_POST["parkplatz"]);
            $_SESSION["parkplatz"] = $parkplatz;
        }

        if (empty($_POST["haustiere"])) { //wenn keine Haustieroption gewählt wurde
            $haustErr = "Bitte angeben!";
            $error = 1;
        } else {
            $haustiere = test_input($_POST["haustiere"]);
            $_SESSION["haustiere"] = $haustiere;
        }
    } else {
        $error = 1;
    }
    if ($error == 0) { //keine Errors
        $userid = $_SESSION["personenid"];

        // Creates DateTime objects
        $datetime1 = date_create($anreise);
        $datetime2 = date_create($abreise);

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);
        $interval = (int) $interval->format('%a');

        //Berechnen des Gesamtpreises
        $preis = ($zimmer * $interval) * 95.20 + (2.20 * $interval * $zimmer);
        if ($breakfast == 'ja') {
            $preis = $preis + (15 * $interval * $zimmer);
        }
        if ($parkplatz == 'ja') {
            $preis = $preis + (5 * $interval * $zimmer);
        }
        if ($haustiere == 'ja') {
            $preis = $preis + 30;
        }

        $buttonclicked = 0;
        if ($buttonclicked == 0) {
    ?>
            <div id="seite" class="container p-3 bg-light">
                <!--Preisübersicht-->
                <div class="p-3">
                    <h2>Preisübersicht:</h2>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-3 col-xl-2">Anreise:</div>
                    <div class="col-md-3 col-xl-2"><?php echo $anreise ?></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-3 col-xl-2">Abreise:</div>
                    <div class="col-md-3 col-xl-2"><?php echo $abreise ?></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-3 col-xl-2">Anzahl Zimmer:</div>
                    <div class="col-md-2 col-xl-1"><?php echo $zimmer ?></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-3 col-xl-2">Anzahl Nächte:</div>
                    <div class="col-md-2 col-xl-1"><?php echo $interval ?></div>
                </div>
                <hr>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Preis pro Zimmer/Nacht:</div>
                    <div class="col-md-4 col-xl-4">95.20€</div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Nächtigungstaxe pro Zimmer/Nacht:</div>
                    <div class="col-md-4 col-xl-4">2.20€</div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Zwischensumme:</div>
                    <div class="col-md-4 col-xl-4 fw-bold"><?php echo $interval * 95.20 * $zimmer + $interval * 2.20 * $zimmer ?> €</div>
                </div>
                <hr>
                
            <?php }
        if ($breakfast == 'ja') { //wenn ein Frühstück gewählt wurde wird der Preis angezeigt und dazu gerechnet
            ?>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Frühstück pro Zimmer/Nacht:</div>
                    <div class="col-md-2 col-xl-1">15€</div>
                </div>
            <?php

            $breakfastpreis = $interval * 15 * $zimmer;
        }
        if ($parkplatz == 'ja') { //siehe Frühstück
            ?>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Parkplatz pro Zimmer/Nacht:</div>
                    <div class="col-md-2 col-xl-1">5€</div>
                </div>
            <?php

            $parkplatzpreis = $interval * 5 * $zimmer;
        }
        if ($haustiere == 'ja') { //siehe Frühstück
            ?>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Mitnahme eines Haustieres:</div>
                    <div class="col-md-2 col-xl-1">30€</div>
                </div>
            <?php

            $haustierpreis = 30;
        }
        if ($breakfast == 'ja' || $parkplatz == 'ja' || $haustiere == 'ja') {
            //wenn mindestens eine der drei optionalen Zusatzleistungen gewählt wurden wird eine Zwischensumme ausgegeben
            ?>

                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-5 col-xl-4">Zwischensumme:</div>
                    <div class="col-md-4 col-xl-4 fw-bold"><?php echo $breakfastpreis + $parkplatzpreis + $haustierpreis ?> €</div>
                </div>
                <hr>

            <?php }
            ?>
            <div class="row col-xs-12 p-3">
                <div id="th" class="col-md-5 col-xl-4">Gesamtsumme:</div>
                <div class="col-md-4 col-xl-4 text-danger fw-bold"><?php echo $preis ?> €</div>
            </div>

            <div class="row p-3">
                <?php
                //Button zum Anfragen der Reservierung -> schickt alle Reservierungsdaten an (erfolgreicheReservierung.php) weiter
                echo "<div class='col-auto'><a href='erfolgreicheReservierung.php?userid=" . $userid . "&anreise=" . $anreise . "&abreise=" . $abreise . "&breakfast=" . $breakfast . "&parkplatz=" . $parkplatz . "&haustiere=" . $haustiere . "&preis=" . $preis . "&zimmer=" . $zimmer . "
                        '><button type='button'>Anfragen</button></a></div>" ?>
                <?php 
                //Button zum Abbrechen der Reservierung und Zurückkehren zum Formular
                echo "<div class='col-auto'><a href='reservieren.php
                            '><button type='button'>Zurück</button></a></div>";
                ?>
            </div>
            </div>
        <?php

    } else {
        ?>
            <div id="seite" class="container p-3 bg-light">
                <div class="p-3">
                    <h1>Neue Reservierung erstellen: </h1>
                </div>

                <div class="col-12">
                    <!--Reservierungsformular-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" method="post">
                        <div class="p-3">
                            <h4>Geben Sie den gewünschten Zeitraum Ihres Aufenthaltes an: </h4>
                        </div>
                        <div class="row col-xs-12 p-3">
                            <div id="th" class="col-md-3 col-xl-2"><label for="anreisedate">Anreise: *</label></div>
                            <div class="col-md-2 col-xl-1"><input type="date" name="anreisedate" min="<?= date('Y-m-d'); ?>"></div>
                            <span class="error text-danger"><?php echo $anrdateErr; ?></span>
                        </div>
                        <div class="row col-xs-12 p-3">
                            <div id="th" class="col-md-3 col-xl-2"><label for="anreisedate">Abreise: *</label></div>
                            <div class="col-md-2 col-xl-1"><input type="date" name="abreisedate" min="<?= date('Y-m-d'); ?>"></div>
                            <span class="error text-danger"><?php echo $abrdateErr; ?></span><span class="error text-danger"><?php echo $freiErr; ?></span>
                        </div>
                        <hr>
                        <div class="p-3">
                            <h4>Geben Sie die gewünschte Anzahl der Zimmer an: </h4>
                        </div>
                        <div class="row col-xs-12 p-3">
                            <div id="th" class="col-md-3 col-xl-2"><label for="zimmer">Zimmer: *</label></div>
                            <div class="col-md-2 col-xl-1"><input type="number" name="zimmer" min="0" max="20" step="1" value="0"></div>
                            <span class="error text-danger"><?php echo $zimmerErr; ?></span>
                        </div>
                        <hr>
                        <div class="p-3">
                            <h4>Möchten Sie unsere optionalen Zusatzleistungen in Anspruch nehmen? </h4>
                        </div>
                        <div class="row col-xs-12 p-3">
                            <div id="th" class="col-md-3 col-xl-2"><label for="frühstück">Frühstück: *</label></div>
                            <div class="col-md-2 col-xl-1"><input type="radio" name="breakfast" value="ja"> Ja</div>
                            <div class="col-md-2 col-xl-1"><input type="radio" name="breakfast" value="nein"> Nein</div>
                            <span class="error text-danger"> <?php echo $breakfErr; ?></span>
                        </div>
                        <div class="row col-xs-12 p-3">
                            <div id="th" class="col-md-3 col-xl-2"><label for="parkplatz">Parkplatz: *</label></div>
                            <div class="col-md-2 col-xl-1"><input type="radio" name="parkplatz" value="ja"> Ja</div>
                            <div class="col-md-2 col-xl-1"><input type="radio" name="parkplatz" value="nein"> Nein</div>
                            <span class="error text-danger"> <?php echo $parkplErr; ?></span>
                        </div>
                        <hr>
                        <div class="p-3">
                            <h4>Bringen Sie ein Haustier? *</h4>
                            <span class="error text-danger"> <?php echo $haustErr; ?></span>
                        </div>
                        <div class="row col-xs-12 p-3">
                            
                            <div class="col-md-2 col-xl-1"><input type="radio" name="haustiere" value="ja"> Ja</div>
                            <div class="col-md-2 col-xl-1"><input type="radio" name="haustiere" value="nein"> Nein</div>
                        </div>
                        <div class="p-3">* Pflichtfeld</div>
                        <div class="p-3">
                            <a href="#"><button name='preisrechner' type="submit">Preis berechnen</button></a>
                        </div>
                    </form>
                </div>
            </div>
        <?php
    }
        ?>
</body>

</html>