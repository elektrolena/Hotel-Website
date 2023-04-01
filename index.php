<?php include "Navbar/navbar.php" ?>
<html>

<head>
  <title>Hotel Helena</title>
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

  <div id="seite" class="container p-3 bg-light">

    <div class="row col-md-12 p-4">
      <div class="col-lg-7 order-lg-2"><img class="col-12" src="HotelHelenaImages/haus.jpg" alt="Hotel"></div>
      <div class="col-lg-5 order-lg-1">
        <h2>Willkommen im Hotel Helena!</h2>
        <p>Ankommen und sich gleich Wohlfühlen.</p>
        <p>Mit der faszinierenden Salzburger Bergkulisse und dem Schimmern des kristallblauen Fuschlsees direkt vor der Haustüre, ist jeder Moment einzigartig. Ganz gleich, ob beim Sport in der Natur, beim Entspannen in der großflächigen Wellnesslandschaft oder beim Verkosten traditioneller Schmankerl – im Hotel Helena findet von Groß bis Klein jeder sein persönliches Urlaubsglück!</p>
      </div>
    </div>

    <div class="row col-md-12 p-4">
      <div class="col-lg-7"><img class="col-12" src="HotelHelenaImages/zimmer.jpg" alt="Zimmer"></div>
      <div class="col-lg-5">
        <h2>Unsere Zimmer</h2>
        <p>Reservieren Sie Ihr Zimmer


          <?php
          if (isset($_SESSION['personenid'])) {
          ?>
            <a href="UserReservieren/zimmerreservierung.php">hier</a>!
        </p>
      <?php
          } else {
      ?>
        <a href="Anmelden/login.php">hier</a>!</p>
      <?php
          }
      ?>
      </div>
    </div>

    <div class="row col-md-12 p-4">
      <div class="col-lg-7 order-lg-2"><img class="col-12" src="HotelHelenaImages/sauna.jpg" alt="Sauna"></div>
      <div class="col-lg-5 order-lg-1">
        <h2>Wellnessangebote</h2>
        <p>Lassen Sie sich fallen und tauchen Sie ein in die großzügige Wellness- und Relax-Welt des Hotel Helena.</p>
        <p>Auf 500 m² erwartet Sie eine einmalige Pool- und Saunalandschaft. Im exklusiven SPA-Bereich wird Erholung großgeschrieben – bei entspannenden Massagen und vitalisierenden Beauty-Anwendungen bleiben keine Wünsche offen.</p>
      </div>
    </div>

    <div class="row col-md-12 p-4">
      <div class="col-lg-7"><img class="col-12" src="HotelHelenaImages/fuschlsee.jpg" alt="Fuschlsee"></div>
      <div class="col-lg-5">
        <h2>Der Fuschlsee</h2>
        <p>Als einen der kleineren Salzkammergut-Seen umgibt den Fuschlee einen besonderen Charme. Wenig Ufer-Verbauungen, Motorboot-Verbot und türkisblaues Wasser machen den See zu einem besonderen Naturjuwel.</p>
        <p>Glasklares Wasser mit Trinkwasserqualität macht den See zu einem der saubersten im gesamten Salzkammergut und Salzburgerland. Auf dem Fuschlsee ist absolutes Motorboot Verbot. Das führt in Verbindung mit dem sorgsamen Umgang der Einheimischen führt dazu, dass über Jahre die Wasserqualität und die Sauberkeit auf höchstem Niveau bleibt.</p>
        <a href="https://www.salzburgerland.com/de/magazin/traumausflug-an-den-fuschlsee/">Mehr zum Fuschlsee</a>
      </div>
    </div>

    <div class="row col-md-12 p-4">
      <div class="col-md-7 order-lg-2"><img class="col-12" src="HotelHelenaImages/skifamilie.jpg" alt="Skigebiet"></div>
      <div class="col-md-5 order-lg-1">
        <h2>Skigebiet Gaissau-Hintersee</h2>
        <p>Inmitten der malerischen Bergwelt des Salzburger Landes befindet sich das charmante Skigebiet Gaissau-Hintersee. 30 bestens präparierte Pistenkilometer aller Schwierigkeitsgrade verlaufen 8 Liftanlagen entlang und überzeugen winterbegeisterte Sportler mit abwechslungsreichen Abfahrten.</p>
        <a href="https://www.bergfex.at/gaissauhintersee/">Nähere Informationen</a>
      </div>
    </div>
    
    <div class="row col-md-12 p-5">
      <h2 class="text-center">Anreise</h2>
      <ul class="p-3">
        <li>Mit dem Auto: Die Autobahnauffahrt "274-Thalgau" auf die A1 ist nur 7 Minuten von Hof bei Salzburg entfernt.</li>
        <li>Mit den Öffis: Vom Salzburger Hauptbahnhof fährt die Buslinie 150 bis zur Station "Hof bei Salzburg Ortsmitte", die 410 Meter vom Hotel Helena entfernt ist.</li>
      </ul>

      <center>
        <iframe src="https://maps.google.com/maps?q=Schwarzm%C3%BChlstra%C3%9Fe%205,%20Salzburg&t=k&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </center>
    </div>

</body>