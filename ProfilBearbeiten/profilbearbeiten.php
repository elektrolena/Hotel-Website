<?php
include "../Navbar/navbar.php";
?>
<html>

<head>
    <title>Bearbeiten</title>
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
    <div id="seite" class="container p-3 bg-light">
        <?php
        // define variables and set to empty values
        $anrede = $vorname = $nachname = $email = $passwort = "";
        $vornameErr = $nachnameErr = $emailErr = $passwortErr = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn der Button am Ende des Formulares geklickt wurde
            $error = 0;
            $checkforchange = 0;

            if (!empty($_POST["passwort"])) { //wenn ein Passwort eingegeben wurde
                $passwort = test_input($_POST["passwort"]);
                $passwortDB = $row["Passwort"];
                if (password_verify($passwort, $passwortDB)) { //Vergleich mit gehashtem Passwort aus DB
                    $error = 0;

                    if (!empty($_POST["anrede"])) { //wenn eine Anrede ausgewählt wurde
                        $anrede = test_input($_POST["anrede"]);
                        if ($anrede == 'Divers') { //Abfrage um die gewählte Anfrage in einen Integer umzuwandeln -> FK in der DB
                            $anredeNum = 1;
                        } else if ($anrede == 'Frau') {
                            $anredeNum = 2;
                        } else {
                            $anredeNum = 3;
                        }
                        $update = "UPDATE personen SET AnredeID_FK='" . $anredeNum . "' WHERE PersonenID='" . $_SESSION["personenid"] . "'";
                        $db_obj->query($update); //Neue Anrede in DB speichern
                        $checkforchange = 1;
                    }

                    if (!empty($_POST["vorname"])) { //wenn Vorname eingegeben wurde
                        $vorname = test_input($_POST["vorname"]);
                        if (!preg_match("/^[a-zA-Z-' ]*$/", $vorname)) { //wenn unerlaubte Zeichen eingegeben wurden
                            $vornameErr = "Nur Buchstaben und Leerzeichen erlaubt";
                            $error = 1;
                        } else {
                            $update = "UPDATE personen SET Vorname='" . $vorname . "' WHERE PersonenID='" . $_SESSION["personenid"] . "'";
                            $db_obj->query($update); //speichern des Vornamens in DB
                            $checkforchange = 1;
                        }
                    }

                    if (!empty($_POST["nachname"])) { //siehe Vorname
                        $nachname = test_input($_POST["nachname"]);
                        if (!preg_match("/^[a-zA-Z-' ]*$/", $nachname)) {
                            $nachnameErr = "Nur Buchstaben und Leerzeichen erlaubt";
                            $error = 1;
                        } else {
                            $update = "UPDATE personen SET Nachname='" . $nachname . "' WHERE PersonenID='" . $_SESSION["personenid"] . "'";
                            $db_obj->query($update);
                            $checkforchange = 1;
                        }
                    }

                    if (!empty($_POST["email"])) { //wenn eine Mail eingegeben wurde
                        $email = test_input($_POST["email"]);
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Formatcheck
                            $emailErr = "Ungültiges E-Mail Format";
                            $error = 1;
                        } elseif (isEmailExists($db_obj, "personen", $email)) { //Check ob Mail in DB bereits existiert
                            $error = 1;
                            $emailErr = "Email existiert bereits";
                        } else {
                            $update = "UPDATE personen SET Email='" . $email . "' WHERE PersonenID='" . $_SESSION["personenid"] . "'";
                            $db_obj->query($update); //Aktualisieren der Mail in DB
                            $checkforchange = 1;
                        }
                    }
                } else {
                    $error = 1;
                    $passwortErr = "Passwort falsch";
                }
            } else if ((!empty($_POST["anrede"]) || !empty($_POST["vorname"]) || !empty($_POST["nachname"]) || !empty($_POST["email"])) && empty($_POST["passwort"])) { //wenn irgendetwas ausgefüllt wurde aber das Passwort nicht
                $passwortErr = "Passwort muss eingegeben werden";
                $error = 1;
            } else {
                $checkforchange = 0;
            }
        } else {
            $error = 1;
        }

        if ($error == 0 && $checkforchange == 1) { //wenn Änderungen vorgenommen wurden
        ?>
            <h2>Ihre Änderung war erfolgreich.</h2>
            <br>
            <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
        <?php
        } else if ($error == 0 && $checkforchange == 0) { //keine Änderungen
        ?>
            <h2>Es wurden keine Änderungen vorgenommen.</h2>
            <br>
            <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
        <?php
        } else {
        ?>
        <!--Formular um Stammdaten zu bearbeiten-->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-2 col-xl-2"><label for="passwort">Anrede:</label></div>
                    <div class="col-md-2 col-xl-1"><input type="radio" name="anrede" value="Divers"> Divers</div>
                    <div class="col-md-2 col-xl-1"><input type="radio" name="anrede" value="Frau"> Frau</div>
                    <div class="col-md-2 col-xl-1"><input type="radio" name="anrede" value="Mann"> Mann</div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-2 col-xl-2"><label for="vorname">Vorname:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="text" name="vorname" placeholder="<?php echo $row['Vorname']; ?>"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $vornameErr; ?></span></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-2 col-xl-2"><label for="nachname">Nachname:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="text" name="nachname" placeholder="<?php echo $row['Nachname']; ?>"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $nachnameErr; ?></span></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-2 col-xl-2"><label for="email">E-Mail:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="email" name="email" placeholder="<?php echo $row['Email']; ?>"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $emailErr; ?></span></div>
                </div>
                <div class="row col-xs-12 p-3">
                    <div id="th" class="col-md-2 col-xl-2"><label for="passwort">Passwort:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="password" name="passwort"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $passwortErr; ?></span></div>
                </div>
                <div class="p-3">
                    <button type="submit">Ändern</button>
                </div>
    </div>

<?php
        }
?>

</form>
</div>
</body>