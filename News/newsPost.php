<?php include "../Navbar/navbar.php";
?>

<html>

<head>
    <title>News</title>
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
            <h2>Das gibt es Neues:</h2>
        </div>
        <?php
        //Newsbeiträge aus der DB holen
        $sql = "SELECT Datum,Titel,Text,Thumbnail,Vorname,Nachname FROM newsbeitraege n JOIN personen p ON n.AutorID_FK=p.PersonenID ORDER BY Datum desc";
        $stmt = $db_obj->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($datum, $titel, $text, $thumb, $name, $lastname);

        ?>
        <div class="table">
            <?php
            while ($stmt->fetch()) { //Schleife um die Beiträge nacheinander auszugeben
                echo "<div class='row col-s-12 p-3' style='background-color: beige'>";
                echo "<div class='row col-xs-12'><center><text style='font-family:Segoe UI, Arial,sans-serif; color:#71591A'; class='mt-3 fs-1'>" . $titel . "</text></center></div>";
                echo "<div class='col-md-5'><center><img class='col-12 border-4 border border-dark rounded mt-3' src='../uploads/news/$thumb.jpg' alt='Foto'></img></div>";
                echo "<div class='col-md-7 p-1'><center><em><text class='fs-5'>" . $text . "</text></center></em></div>";
                $d = strtotime($datum);
                $datum = date("D, d.M. Y H:i", $d);
                echo "<div class='blockquote-footer mt-3'>" . $name . " " . $lastname . ", " . $datum . "</div>";
                echo "</div>";
                echo "<hr>";
            }
            ?>
            </table>
        </div>


</body>

</html>