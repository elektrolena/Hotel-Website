<?php include "../Navbar/navbar.php";
$userid = $_SESSION["personenid"]; ?>
<html>

<head>
    <title>Meine Reservierungen</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="navbarDONE/navbar.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>
    <div id="seite" class="container p-3 bg-light">
        <div class="p-3">
            <h2>Reservierungen </h2>
        </div>
        <div class="p-3">
            <div class="table-responsive">
                <?php
                $sql = "SELECT AnreiseDatum, AbreiseDatum, Zimmer, Frühstück, Parkplatz, Haustiere, Preis, Bezeichnung FROM reservierungen r JOIN status s ON r.StatusID_FK = s.StatusID WHERE PersonenID_FK ='" . $userid . "' ORDER BY ResID desc";
                $stmt = $db_obj->prepare($sql);
                $stmt->execute(); //holt Reservierungen des eingeloggten Users aus der DB
                $stmt->bind_result($anreise, $abreise, $zimmer, $frühstück, $parkplatz, $haustiere, $preis, $status);
                
                if ($stmt->fetch() == NULL) { //wenn keine Reservierungen des Users existieren
                    echo "<h4>Sie haben noch keine Reservierungen</h4>";
                } else { ?>


                    <table class="table table-striped">
                        <tr>
                            <th scope="col">Anreisedatum</th>
                            <th scope="col">Abreisedatum</th>
                            <th scope="col">Zimmer</th>
                            <th scope="col">Frühstück</th>
                            <th scope="col">Parkplatz</th>
                            <th scope="col">Haustiere</th>
                            <th scope="col">Status</th>
                            <th scope="col">Preis</th>
                        </tr>
                        
                        <?php
                        do { //Schleife zum Ausgeben aller Reservierungen
                            if ($status == 'neu') { //Zeile der Reservierung wird je nach Status eingefärbt
                                $color = "orange";
                            } else if ($status == 'bestätigt') {
                                $color = "greenyellow";
                            } else {
                                $color = "red";
                            }
                            echo "<tr style='background-color:" . $color . "'>";
                            echo "<td>" . $anreise . "</td>";
                            echo "<td>" . $abreise . "</td>";
                            echo "<td>" . $zimmer . "</td>";
                            echo "<td>" . $frühstück . "</td>";
                            echo "<td>" . $parkplatz . "</td>";
                            echo "<td>" . $haustiere . "</td>";
                            echo "<td>" . $status . "</td>";
                            echo "<td>" . $preis . " €</td>";
                            echo "</tr>";
                        }
                        while ($stmt->fetch());
                }
                ?>
                </table>
            </div>
        </div>

        <div class="p-3">
            <!--Button um neue Reservierung zu erstellen-->
            <a href="reservieren.php"><button type="button">Neue Reservierung</button></a>
        </div>

    </div>
</body>

</html>