<?php include "../Navbar/navbar.php";
$userid = $_SESSION['personenid'];
?>
<html>

<head>
    <title>Bearbeiten</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php
    $thumb = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error = 0;
        $checkforchange = 0;

        if (!empty($_FILES["thumbnailnews"]["tmp_name"])) { //Wenn der Upload nicht leer ist, wird das Bild geändert
            $checkforchange = 1;
        }

        if ($checkforchange == 0) { //Keine Änderungen
            ?>
            <div id="seite" class="container p-3 bg-light">
                <h2>Es wurden keine Änderungen vorgenommen.</h2>
                <br>
                <a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a>
            </div>
            <?php

        } else if ($checkforchange == 1) {
            ?>
                <div id="seite" class="container p-3 bg-light">
                    <div class="p-3">
                        <h2>Ihr Profilbild wurde erfolgreich geändert.</h2>
                    </div>
                    <div class="p-3"><a href="../ProfilBearbeiten/profil.php"><button type="submit">Zum Profil</button></a></div>
                </div>
            <?php
        }
    } else {
        ?>
        <div id="seite" class="container p-3 bg-light">
            <div class="p-3">
                <h2>Lade ein neues Profilbild hoch:</h2>
            </div>
            <div class="p-3">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data"
                    method="post"> <!--Seite ruft sich nach dem submit selber nocheinmal auf-->
                    <div class="row col-xs-12"><input type="file" name="thumbnailnews" accept=".jpg"
                            onchange="loadFile(event)"><!--Siege script-->
                        <p><img id="output" width="200" rows="5" /></p>
                        <div class="row col-xs-12">
                            <script>
                                //sobald ein Thumbnail ausgewählt wurde (noch nicht hochgeladen), wird eine verkleinerte Form des Bildes mittels JavaScript angezeigt
                                var loadFile = function (event) {
                                    var thumbnailnews = document.getElementById('output'); //Wählt das output-Feld aus
                                    thumbnailnews.src = URL.createObjectURL(event.target.files[0]); //und schickt das ausgewählte Bild in das Feld
                                };
                            </script>
                        </div>
                        <div class="text-danger ">Achtung! Das Thumbnail muss .jpg/.jpeg sein und wird mit einer
                            Auflösung von 200x200 Pixel hochgelden!!</div>
                    </div>
                    <div class="row">
                        <div class="p-3"><button type="submit" name="submit">Ändern</button></div>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } ?>
    <?php
    if (isset($_POST["submit"]) && $checkforchange == 1) { //Wenn submit gedrückt wurde und ein Bild hochgeladen wurde
        //Bild wird verkleinert und die Daten in unserer DB gespeichert
        if (is_array($_FILES)) {//Überprüft, ob das was hochgeladen wurde in Array ist (alle hochgeladenen Files liegen in Form von (associative) Arrays vor)
            $uploaded_file = $_FILES["thumbnailnews"]["tmp_name"]; //Holt sich den (temporären) Namen des hochgeladenen Files (wird automatisch von php generiert und wird am web-server abgelegt)
            $upl_img_properties = getimagesize($uploaded_file);//Holt sich die Bildmaße
            $file_name_id = rand(10, 100);//Holt sich eine Random Zahl für die Namensgebung
            $new_file_name = "Resized Image_" . $file_name_id;//Bildet den neuen Namen aus einem String und der random Zahl
            $folder_path = "../uploads/profilbilder/";//unser upload folder, wo alle Thumbnails hochgeladen werden
            $img_ext = pathinfo($_FILES["thumbnailnews"]["name"], PATHINFO_EXTENSION);// Liefert Informationen über den aktuellen Dateipfad des Bildes
            $image_type = $upl_img_properties[2];//Holt sich die Filetype-Eigenschaft des Bildes

            switch ($image_type) {
                //for JPEG Image
                case IMAGETYPE_JPEG:
                    $image_type_id = imagecreatefromjpeg($uploaded_file);//Erzeugt ein neues Bild
                    $target_layer = image_resize($image_type_id, $upl_img_properties[0], $upl_img_properties[1], 200, 200);//siehe Funktionen.php
                    imagejpeg($target_layer, $folder_path . $new_file_name . "." . $img_ext);//Gibt das Bild in unserem gewählten Ordner aus.
                    //DB Upload
                    $updateBild = "UPDATE personen SET ProfilbildPath ='" . $new_file_name . "' WHERE PersonenID ='" . $userid . "'";
                    $updateBildGo = $db_obj->query($updateBild);
                    break;

                default: //Wenn das Bild kein jpeg ist
                    echo '<script type="text/javascript">';
                    echo 'alert("Bitte laden Sie ein JPEG hoch!");';
                    echo 'window.location.href = "bildbearbeiten.php";';
                    echo '</script>';
                    break;
            }
        }

    }
    ?>
</body>

</html>