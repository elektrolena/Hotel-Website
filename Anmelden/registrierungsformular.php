<?php include "../Navbar/navbar.php" ?>
<html>

<head>
    <title>Registrierung</title>
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
    <?php
    // define variables and set to empty values
    $anrede = $vorname = $nachname = $email = $benutzername = $passwort = $passwortwh = "";
    $anredeErr = $vornameErr = $nachnameErr = $emailErr = $benutzernameErr = $passwortErr = $passwortwhErr = "";

    $error = 1;
    if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn der Button am Ende des Formulares geklickt wird
        $error = 0;
        if (empty($_POST["anrede"])) { //wenn keine Anrede ausgewählt wurde
            $anredeErr = "Anrede muss angegeben werden";
            $error = 1;
        } else {
            $anrede = test_input($_POST["anrede"]);
        }

        if (empty($_POST["vorname"])) { //wenn nichts eingegeben wurde
            $vornameErr = "Vorname muss angegeben werden";
            $error = 1;
        } else {
            $vorname = test_input($_POST["vorname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $vorname)) { //wenn unerlaubte Zeichen eingegeben wurden
                $vornameErr = "Nur Buchstaben und Leerzeichen erlaubt";
                $error = 1;
            }
        }

        if (empty($_POST["nachname"])) { //wenn nichts eingegeben wurde
            $nachnameErr = "Nachname muss angegeben werden";
            $error = 1;
        } else {
            $nachname = test_input($_POST["nachname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $nachname)) { //wenn unerlaubte Zeichen eingegeben wurden
                $nachnameErr = "Nur Buchstaben und Leerzeichen erlaubt";
                $error = 1;
            }
        }

        if (empty($_POST["email"])) { //wenn nichts eingegeben wurde
            $emailErr = "E-Mail muss angegeben werden";
            $error = 1;
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //wenn das Format der Email nicht stimmt
                $emailErr = "Ungültiges E-Mail Format";
                $error = 1;
            }

            if (isEmailExists($db_obj, "personen", $email)) { //wenn die Email bereits in der Datenbank existiert -> siehe (funktionen.php)
                $error = 1;
                $emailErr = "Email existiert bereits";
            }
        }

        if (empty($_POST["benutzername"])) { //wenn das Feld leer ist
            $benutzernameErr = "Benutzername muss angegeben werden";
            $error = 1;
        } else {
            $benutzername = test_input($_POST["benutzername"]);

            if (isBenutzernameExists($db_obj, "personen", $benutzername)) { //wenn der Benutzername bereits in der DB existiert -> (funktionen.php)
                $error = 1;
                $benutzernameErr = "Benutzername existiert bereits";
            }
        }

        if (empty($_POST["passwort"])) { //wenn Feld leer ist
            $passwortErr = "Passwort muss zweimal eingegeben werden";
            $error = 1;
        } else {
            $passwort = password_hash(test_input($_POST["passwort"]), PASSWORD_DEFAULT); //passwort wird gehasht
        }

        if (empty($_POST["passwortwh"])) { //leeres Feld
            $passwortwhErr = "Passwort muss zweimal eingegeben werden";
            $error = 1;
        } else {
            $passwortwh = password_hash(test_input($_POST["passwortwh"]), PASSWORD_DEFAULT);
        }

        if (($_POST["passwort"]) != ($_POST["passwortwh"])) { //wenn die eingegebenen Passwörter nicht übereinstimmen
            $passwortwhErr = "Passwörter stimmen nicht überein";
            $error = 1;
        }
    } else {
        $error = 1;
    }

    if ($error == 0) { //wenn keine Errors vorhanden sind
        if ($anrede == 'Divers') { //Abfrage um die gewählte Anrede als Integer in die DB zu speichern, da sie ein Fremdschlüssel ist
            $anredeNum = 1;
        } else if ($anrede == 'Frau') {
            $anredeNum = 2;
        } else {
            $anredeNum = 3;
        }
        $eintrag = "INSERT INTO personen (AnredeID_FK, Vorname, Nachname, Email, Benutzername, Passwort) VALUES ('$anredeNum', '$vorname', '$nachname', '$email', '$benutzername', '$passwort')";
        $eintragen = mysqli_query($db_obj, $eintrag); //Speichern des neuen Nutzers in der DB

    ?>
        <div id="seite" class="container p-3 bg-light">
            <div class="p-3">
                <h2>Ihre Registrierung war erfolgreich. Willkommen, <?php echo $vorname; //Begrüßung des neuen Nutzers
                                                                    echo " ";
                                                                    echo $nachname; ?>!</h2>
            </div>
            <div class="p-3">
                <a href="login.php"><button type="submit">Zum Login</button></a>
            </div>
        </div>
    <?php
    } else {
    ?><div id="seite" class="container p-3 bg-light">
            <div class="p-3">
                <h2>Registrieren Sie sich hier:</h2>
            </div>
            <br>

            <div class="col-12">
                <!--Registrierungsformular-->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="anrede">Anrede: *</label></div>
                        <div class="col-md-2 col-xl-1"><input type="radio" name="anrede" value="Divers"> Divers</div>
                        <div class="col-md-2 col-xl-1"><input type="radio" name="anrede" value="Frau"> Frau</div>
                        <div class="col-md-2 col-xl-1"><input type="radio" name="anrede" value="Mann"> Herr</div>
                        <span class="error text-danger"> <?php echo $anredeErr; ?></span>
                    </div>
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="vorname">Vorname: *</label></div>
                        <div class="col-md-4 col-lg-3"><input type="text" name="vorname" placeholder="Maxine"></div>
                        <div class="col-md-4 col-lg-6"><span class="error text-danger"><?php echo $vornameErr; ?></span></div>
                    </div>
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="nachname">Nachname: *</label></div>
                        <div class="col-md-4 col-lg-3"><input type="text" name="nachname" placeholder="Musterfrau"></div>
                        <div class="col-md-4 col-lg-6"><span class="error text-danger"><?php echo $nachnameErr; ?></span></div>
                    </div>
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="email">E-Mail: *</label></div>
                        <div class="col-md-4 col-lg-3"><input type="email" name="email" placeholder="example@gmx.at"></div>
                        <div class="col-md-4 col-lg-6"><span class="error text-danger"><?php echo $emailErr; ?></span></div>
                    </div>
                    <hr>
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="benutzername">Benutzername: *</label></div>
                        <div class="col-md-4 col-lg-3"><input type="text" name="benutzername"></div>
                        <div class="col-md-4 col-lg-6"><span class="error text-danger"><?php echo $benutzernameErr; ?></span></div>
                    </div>
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="passwort">Passwort: *</label></div>
                        <div class="col-md-4 col-lg-3"><input type="password" name="passwort"></div>
                        <div class="col-md-4 col-lg-6"><span class="error text-danger"><?php echo $passwortErr; ?></span></div>
                    </div>
                    <div class="row col-xs-12 p-3">
                        <div id="th" class="col-md-3 col-xl-2"><label for="passwortwh">Passwort Wiederholung: *</label></div>
                        <div class="col-md-4 col-lg-3"><input type="password" name="passwortwh"></div>
                        <div class="col-md-4 col-lg-6"><span class="error text-danger"><?php echo $passwortwhErr; ?></span></div>
                    </div>
                    <div class="p-3">* Pflichtfeld</div>

                    <div class="p-3">
                        <button type="submit">Registrieren</button>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    ?>
</body>

</html>