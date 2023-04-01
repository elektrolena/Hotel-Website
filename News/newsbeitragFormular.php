<?php include "../Navbar/navbar.php";
$admin = $_SESSION['personenid'];
?>
<html>

<head>
  <title>News-Beitrag erstellen</title>
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
  $titlenews = $textnews = $thumb = $uploaded_file = $titlenewsErr = $textnewsErr = $thumbErr = ""; //Mögliche Fehlermeldungen

  if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn der Button am Ende des Formulares geklickt wurde
    $error = 0;

    if (empty($_POST["titlenews"])) { //wenn kein Titel angegegen wurde
      $titlenewsErr = "Dein News-Beitrag muss einen Titel haben";
      $error = 1;
    } else {
      $titlenews = test_input($_POST["titlenews"]);
    }

    if (empty($_POST["textnews"])) { //wenn kein Text eingegeben wurde
      $textnewsErr = "Dein News-Beitrag muss einen Text haben";
      $error = 1;
    } else {
      $textnews = test_input($_POST["textnews"]);
    }
    if (empty($_FILES["thumbnailnews"]["tmp_name"])) { //wenn kein Bild hochgeladen wurde
      $thumbErr = "Dein News-Beitrag muss eine Thumbnail haben";
      $error = 1;
    }
  } else {
    $error = 1;
  }

  if ($error == 0) { //wenn keine Errors vorhanden sind
  ?>
    <div id="seite" class="container p-3 bg-light">
      <div class="p-3">
        <h2>Ihr News-Beitrag wurde erfolgreich gepostet.</h2>
      </div>
      <div class="p-3">
        <a href="../index.php"><button type="submit">Zurück zur Startseite</button></a>
      </div>
    </div>
  <?php

  } else { ?>
    <div id="seite" class="container p-3 bg-light">
      <div class="p-3">
        <h1>Erstelle einen neuen News-Beitrag: </h1>
      </div>
      <!--Formular-->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" method="post"> <!--Formular ruft sich nach dem submit selber nocheinmal auf-->
        <div class="p-3">
          <div id="th" class="row col-xs-12"><label for="titlenews">Titel des Beitrags: *</label></div>
          <div class="row col-xs-12"><span class="error text-danger"><?php echo $titlenewsErr; ?></span></div>
          <br>
          <div class="row col-xs-12"><input class="form-control input-md" placeholder="Dein Titel..." type="text" name="titlenews" maxlength="100"></div>
        </div>
        <div class="p-3">
          <div id="th" class="row col-xs-12"><label for="titlenews">Text: *</label></div>
          <div class="row col-xs-12"><span class="error text-danger"> <?php echo $textnewsErr; ?></span></div>
          <br>
          <!--Textbox zum schreiben des neuen Beitrags (powered by https://charactercounttool.com)-->
          <div id="cct_embed_counts" class="row col-xs-12"><textarea id="cct_embed_input_text" placeholder="Schreibe deinen Beitrag hier...." class="form-control input-lg" name="textnews" autofocus rows="10"></textarea></div>
          <div id="cct_embed_result"></div>
          <div id="cct_powered_by"><a href="https://charactercounttool.com"></a></div>
          <script type="text/javascript" src="https://charactercounttool.com/cct_embed.min.js"></script>
        </div>
        <div class="p-3">
          <div id="th" class="row col-xs-12"><label for="thumbnailnews">Lade dein Thumbnail hier hoch: *</label></div>
          <div class="row col-xs-12"><span class="error text-danger"><?php echo $thumbErr; ?></span></div>
          <br>
          <div class="row col-xs-12"><input type="file" name="thumbnailnews" accept=".jpg" onchange="loadFile(event)"></div> <!--Siehe script-->
          <div class="row col-xs-12"><img id="output" width="200" rows="5" /></div>
          <div class="p-3">
            <div class="row col-xs-12 text-danger">Achtung! Das Thumbnail muss .jpg/.jpeg sein und wird mit einer Auflösung von 720x480 Pixel hochgelden!!</div>
          </div>
          <div class="row col-xs-12">
            <script>
              //sobald ein Thumbnail ausgewählt wurde (noch nicht hochgeladen), wird eine verkleinerte Form des Bildes mittels JavaScript angezeigt
              var loadFile = function(event) {
                var thumbnailnews = document.getElementById('output'); //Wählt das output-Feld aus
                thumbnailnews.src = URL.createObjectURL(event.target.files[0]); //und schickt das ausgewählte Bild in das Feld
              };
            </script>
          </div>
        </div>
        <div class="p-3">* Pflichtfeld</div>
        <div class="p-3"><button type="submit" name="submit">Posten</button></div>
    </div>
    </form>
  <?php
  } ?>
  <?php
  //Bild wird verkleinert und die Daten in unserer DB gespeichert
  $time = date("Y-m-d h:i:s", time()); //der aktuelle Zeitstempel wird im Format Y-m-d h:i:s umgewandelt und zugewiesen
  if (isset($_POST["submit"]) && $error == 0) { //Es gibt keine Errors nach dem Submit
    if (is_array($_FILES)) { //Überprüft, ob das was hochgeladen wurde in Array ist (alle hochgeladenen Files liegen in Form von (associative) Arrays vor)
      $uploaded_file = $_FILES["thumbnailnews"]["tmp_name"]; //Holt sich den (temporären) Namen des hochgeladenen Files (wird automatisch von php generiert und wird am web-server abgelegt)
      $upl_img_properties = getimagesize($uploaded_file); //Holt sich die Bildmaße
      $file_name_id = rand(10, 100); //Holt sich eine Random Zahl für die Namensgebung
      $new_file_name = "Resized Image_" . $file_name_id; //Bildet den neuen Namen aus einem String und der random Zahl
      $folder_path = "../uploads/news/"; //unser upload folder, wo alle Thumbnails hochgeladen werden
      $img_ext = pathinfo($_FILES["thumbnailnews"]["name"], PATHINFO_EXTENSION); // Liefert Informationen über den aktuellen Dateipfad des Bildes
      $image_type = $upl_img_properties[2]; //Holt sich die Filetype-Eigenschaft des Bildes

      switch ($image_type) {
          //for JPEG Image
        case IMAGETYPE_JPEG: //Wenn es ein jpeg ist
          $image_type_id = imagecreatefromjpeg($uploaded_file); //Erzeugt ein neues Bild
          $target_layer = image_resize($image_type_id, $upl_img_properties[0], $upl_img_properties[1],740,480); //siehe Funktionen.php
          imagejpeg($target_layer, $folder_path . $new_file_name . "." . $img_ext); //Gibt das Bild in unserem gewählten Ordner aus.
          //DB Upload
          $eintrag = "INSERT INTO newsbeitraege (Datum, AutorID_FK, Titel, Text, Thumbnail) VALUES ('$time', '$admin', '$titlenews', '$textnews', '$new_file_name')";
          $eintragen = $db_obj->query($eintrag);
          break;

        default: //Wenn das Bild kein jpeg ist
          echo '<script type="text/javascript">';
          echo 'alert("Bitte laden Sie ein JPEG hoch!");';
          echo 'window.location.href = "newsbeitragFormular.php";';
          echo '</script>';
          break;
      }
    }

  }
  ?>
  </div>
</body>

</html>