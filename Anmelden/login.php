<?php
include "../Navbar/navbar.php"
?>
<html>

<head>
    <title>Login</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php

    $benutzernameErr = $passwortErr = "";
    $error = 1;
    if ($_SERVER["REQUEST_METHOD"] == "POST") { //wird ausgeführt wenn der Button am Ende des Formulars geklickt wird
        $error = 0; //Errors am Anfang 0
        $benutzernameLogin = $_POST["benutzername"]; //eingegebene Daten werden in Variablen gespeichert
        $passwortLogin = $_POST["passwort"];

        if (
            isset($_POST["benutzername"]) && !empty($_POST["benutzername"]) //wenn beide Felder ausgefüllt wurden
            && isset($_POST["passwort"]) && !empty($_POST["passwort"])
        ) {
            if (isBenutzernameExists($db_obj, "personen", $_POST["benutzername"])) { //wenn Benutzername in der Datenbank existiert (siehe funktionen.php)
                $row = getRowBenutzername($db_obj, "personen", $benutzernameLogin); //alle Daten des Benutzers werden aus der Datenbank geholt
                $passwortDB = $row['Passwort']; 
                if (password_verify($passwortLogin, $passwortDB)) { //eingegebenes Passwort wird mit dem gehashten Passwort des Users verglichen
                    $error = 0;
                    if ($row["AktivID_FK"] == 2) { //Aktivitätsstatus des Users wird abefragt
                        $error = 1;
                        $benutzernameErr = "Dieser Benutzer wurde deaktiviert";
                    }
                } else {
                    $error = 1;
                    $passwortErr = "Passwort falsch";
                }
            } else {
                $error = 1;
                $benutzernameErr = "Benutzer existiert nicht";
            }
        } else if (!isset($_POST["benutzername"]) || empty($_POST["benutzername"])) { //wenn kein Benutzername eingegeben wurde
            $error = 1;
            $benutzernameErr = "Feld muss ausgefüllt werden";
        } else if (!isset($_POST["passwort"]) || empty($_POST["passwort"])) { //wenn kein Passwort eingegeben wurde
            $error = 1;
            $passwortErr = "Feld muss ausgefüllt werden";
        } else {
            $error = 1;
        }
    }

    if ($error == 0) { //wenn die Anmeldung erfolgreich war
        $_SESSION['personenid'] = $row['PersonenID']; //PersonenID und Usertyp werden in Session Variablen gespeichert -> Abfragen in anderen Files
        $_SESSION['usertyp'] = $row['Usertyp_FK'];
    ?>
        <div id="seite" class="container p-3 bg-light text-center">
            <div class="p-3">
                <?php //User wird begrüßt
                echo "<h2>Willkommen, ";
                echo $row['Vorname'];
                echo " ";
                echo $row['Nachname'];
                echo "!</h2>";
                ?>
            </div>
            <div class="p-3">
                <a href="../index.php"><button class="">Zur Startseite</button></a>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div id="seite" class="container p-3 bg-light">
            <div class="p-3">
                <h2>Anmeldung</h2>
            </div>
            <!--Formular zum Anmelden-->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-3 col-lg-2"><label for="benutzername">Benutzername:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="text" name="benutzername"></div>
                    <div class="col-md-5 col-lg-7"><span class="error text-danger"><?php echo $benutzernameErr; ?></span></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-3 col-lg-2"><label for="passwort">Passwort:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="password" name="passwort"></div>
                    <div class="col-md-5 col-lg-7"><span class="error text-danger"><?php echo $passwortErr; ?></span></div>
                </div>

                <div class="p-3">
                    <button type="submit">Anmelden</button>
                </div>
            </form>
            <div class="p-3">
                <h3>Sie haben noch kein Konto?</h3>
                <p>Registrieren Sie sich <a href="registrierungsformular.php">hier</a>.</p>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>