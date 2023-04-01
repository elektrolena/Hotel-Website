<?php
function test_input($data)
{
    $data = trim($data);                //Entfernt unnötige Zeichen des User-Inputs
    $data = stripslashes($data);        //Entfernt alle Backslashes des User-Inputs
    $data = htmlspecialchars($data);    //Wandelt alle Sonderzeichen in HTML-Entitäten um
    return $data;
}
function isBenutzernameExists($db, $tableName, $benutzername) //Überprüft, ob der neu eingegebene Benutzername bereits existiert
{
    // SQL Statement
    $sql = "SELECT * FROM " . $tableName . " WHERE benutzername='" . $benutzername . "'";

    // Process the query
    $results = $db->query($sql);

    // Fetch Associative array
    $row = $results->fetch_assoc();

    // Check if there is a result and response to  1 if email is existing
    return (is_array($row) && count($row) > 0); //Liefert wahr oder falsch zurück
}
function isEmailExists($db, $tableName, $email) //Überprüft ob die email bereits einen account in der datenbank hat
{
    // SQL Statement
    $sql = "SELECT * FROM " . $tableName . " WHERE email='" . $email . "'";

    // Process the query
    $results = $db->query($sql);

    // Fetch Associative array
    $row = $results->fetch_assoc();

    // Check if there is a result and response to  1 if email is existing
    return (is_array($row) && count($row) > 0); // Liefert wahr oder falscg zurück
}

function image_resize($image_type_id, $img_width, $img_height,$width,$height) //Ändert die Größe eines hochgeladen Bildes
{

    $target_width = $width;     //Wir breit soll das Bild werden
    $target_height = $height;   //Wie hoch soll das Bild werden
    $target_layer = imagecreatetruecolor($target_width, $target_height); //gibt ein Bildobjekt zurück, das ein leeres Bild der angegebenen Größe darstellt
    imagecopyresampled($target_layer, $image_type_id, 0, 0, 0, 0, $target_width, $target_height, $img_width, $img_height); //kopiert einen rechteckigen Teil eines Bildes in unser vorher erstelltes leeres Bild in der richtigen Größe
    return $target_layer;       //Gibt das neue Bild in der richtigen Größe zurück
}


function getRow($db, $tableName, $personenid) //Sucht den Datensatz mit der angegebenen PersonID
{
    // SQL Statement
    $sql = "SELECT * FROM " . $tableName . " WHERE personenid='" . $personenid . "'"; //Wählt alle Spalten des Datensatzes aus, mit der übergebenen PersonID

    // Process the query
    $results = $db->query($sql);

    // Fetch Associative array
    $row = $results->fetch_assoc();

    return ($row); //Gibt den ganzen Datensatz zurück
}

function getRowUSER($db, $user) //Sucht die angegebenen Spalten aus der personen und anrede Tabelle aus der Datenbank
{
    // SQL Statement
    $sql = "SELECT Benutzername, Bezeichnung, Vorname, Nachname, Email FROM personen p JOIN anrede a ON p.AnredeID_FK = a.AnredeID WHERE PersonenID ='" . $user . "'";

    // Process the query
    $results = $db->query($sql);

    // Fetch Associative array
    $row = $results->fetch_assoc();

    return ($row); //Gibt den ganzen Datensatz zurück
}
function getRowBenutzername($db, $tableName, $benutzername) //Sucht den Datensatz, wo der eingeloggte Benutzername mit dem Benutzername in der Datenbank übereinstimmt
{
    // SQL Statement
    $sql = "SELECT * FROM " . $tableName . " WHERE benutzername='" . $benutzername . "'";

    // Process the query
    $results = $db->query($sql);

    // Fetch Associative array
    $row = $results->fetch_assoc();

    return ($row); //Gibt den ganzen Datensatz zurück
}
function getAnrede($db, $personenid) //Sucht die Anrede der Person mit der übereinstimmenden PersonID übereinstimmt
{
    $sql = "SELECT Bezeichnung FROM anrede a JOIN personen p ON a.AnredeID = p.AnredeID_FK WHERE p.personenid='" . $personenid . "'";
    $results = $db->query($sql);
    $row = $results->fetch_assoc();
    return ($row["Bezeichnung"]); //Gibt die Bezeichnung der Anrede der Person zurück
}

function getProfilBild($db, $personenid) //Sucht den Pfad des Profilbildes der Person mit übereinstimmenden PersonID
{
    $sql = "SELECT ProfilbildPath FROM personen WHERE PersonenID='" . $personenid . "'";
    $results = $db->query($sql);
    $row = $results->fetch_assoc();
    return ($row); //Gibt den Pfad zurück (es muss nur $row zurückgegeben, da im SELECT-Statement nur eine Spalte abruft)
}
