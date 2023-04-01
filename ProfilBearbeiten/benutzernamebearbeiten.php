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
    <div id="seite" class="container p-4 bg-light">
        <?php
        $benutzernameErr = $passwortErr = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn der Button am Ende des Formulares geklickt wurde
            $checkforchange = 0;
            $error = 0;
            if (!empty($_POST["passwort"])) { //wenn das Passwort eingegeben wurde
                $passwort = test_input($_POST["passwort"]);
                $passwortDB = $row["Passwort"];
                if (password_verify($passwort, $passwortDB)) { //Vergleich mit dem gehashten Passwort in der DB
                    $error = 0;
                    if (!empty($_POST["benutzername"])) { //wenn ein neuer Benutzername eingegeben wurde
                        $benutzername = $_POST["benutzername"];
                        if (isBenutzernameExists($db_obj, "personen", $benutzername)) { //Check ob der Benutzername in der DB bereits existiert -> (funktionen.php)
                            $error = 1;
                            $benutzernameErr = "Benutzername existiert bereits";
                        } else {
                            $update = "UPDATE personen SET benutzername='" . $benutzername . "' WHERE PersonenID='" . $_SESSION["personenid"] . "'"; //Ändern des Benutzernamens in der DB
                            $db_obj->query($update);
                            $checkforchange = 1;
                        }
                    }
                } else {
                    $error = 1;
                    $passwortErr = "Passwort falsch";
                }
            } else if (!empty($_POST["benutzername"]) && empty($_POST["passwort"])) { //wenn ein neuer Benutzername aber kein Passwort eingegeben wurde
                $passwortErr = "Passwort muss eingegeben werden";
                $error = 1;
            } else {
                $checkforchange = 0;
            }
        } else {
            $error = 1;
        }

        if ($error == 0 && $checkforchange == 1) { //wenn etwas geändert wurde
        ?>
            <h2>Ihr Benutzername wurde erfolgreich geändert.</h2>
            <br>
            <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
        <?php
        } else if ($error == 0 && $checkforchange == 0) { //wenn nichts geändert wurde
        ?>
            <h2>Es wurden keine Änderungen vorgenommen.</h2>
            <br>
            <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
        <?php
        } else {
        ?>
        <!--Formular-->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row col-sm-12 p-4">
                    <div id="th" class="col-md-3"><label for="benutzername">Neuer Benutzername:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="username" name="benutzername"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $benutzernameErr; ?></span></div>
                </div>
                <div class="row col-sm-12 p-4">
                    <div id="th" class="col-md-3"><label for="passwort">Passwort:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="password" name="passwort"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $passwortErr; ?></span></div>
                </div>
                <div class="p-4">
                    <button type="submit">Ändern</button>
                </div>
            </form>
        <?php
        }
        ?>
    </div>
</body>