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
        $altespasswortErr = $passwortErr = $passwortwhErr = "";
        $checkforchange = 0;
        if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn der Button am Ende des Formulares geklickt wurde
            $error = 0;
            if (!empty($_POST["altespasswort"])) { //wenn das alte Passwort eingegeben wurde
                $altespasswort = test_input($_POST["altespasswort"]);
                $passwortDB = $row["Passwort"];
                if (password_verify($altespasswort, $passwortDB)) { //Vergleich mit dem gehashten Passwort in der DB
                    $error = 0;
                } else {
                    $error = 1;
                    $altespasswortErr = "Altes Passwort ist falsch";
                }

                if (!empty($_POST["altespasswort"]) && (empty($_POST["passwort"]) || empty($_POST["passwortwh"]))) { //wenn das alte, aber nicht 2 mal das neue Passwort eingegeben wurde
                    $passwortwhErr = "Neues Passwort muss zweimal eingegeben werden";
                    $error = 1;
                } else if (test_input($_POST["passwort"]) != test_input($_POST["passwortwh"])) { //wenn die neuen Passwörter nicht übereinstimmen
                    $passwortwhErr = "Neue Passwörter stimmen nicht überein";
                    $error = 1;
                } else {
                    $passwort = password_hash(test_input($_POST["passwort"]), PASSWORD_DEFAULT); //neues Passwort wird gehasht
                    $update = "UPDATE personen SET passwort='" . $passwort . "' WHERE PersonenID='" . $_SESSION["personenid"] . "'";
                    $db_obj->query($update); //Passwort wird in der DB aktualisiert
                    $checkforchange = 1;
                }
            } else if (empty($_POST["altespasswort"]) && (!empty($_POST["passwort"]) || !empty($_POST["passwortwh"]))){ //wenn das alte Passwort nicht eingegeben wurde aber neue schon
                $altespasswortErr = "Altes Passwort wird benötigt";
                $error = 1;
            } else {
                $checkforchange = 0;
            }
        } else {
            $error = 1;
        }

        if ($error == 0 && $checkforchange == 1) { //wenn eine Änderung vorgenommen wurde
        ?>
            <h2>Ihr Passwort wurde erfolgreich geändert.</h2>
            <br>
            <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
        <?php
        } else if ($error == 0 && $checkforchange == 0) { //keine Änderung
        ?>
            <h2>Es wurden keine Änderungen vorgenommen.</h2>
            <br>
            <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
        <?php
        } else {
        ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row col-sm-12 p-4">
                    <div id="th" class="col-md-3"><label for="passwort">Altes Passwort:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="password" name="altespasswort"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $altespasswortErr; ?></span></div>
                </div>
                <div class="row col-sm-12 p-4">
                    <div id="th" class="col-md-3"><label for="passwort">Neues Passwort:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="password" name="passwort"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $passwortErr; ?></span></div>
                </div>
                <div class="row col-sm-12 p-4">
                    <div id="th" class="col-md-3"><label for="passwort">Neues Passwort Wiederholung:</label></div>
                    <div class="col-md-4 col-lg-3"><input type="password" name="passwortwh"></div>
                    <div class="col-md-5 col-lg-6"><span class="error text-danger"><?php echo $passwortwhErr; ?></span></div>
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