<?php
try {
    ?>
<!DOCTYPE html>
<html lang="pl">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/glowne.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../../zdjecia/logo.png">
    <title>Pixi-twoje miejsce do rozmów</title>
    <meta name="description" content="Pixi.Twoje miejsce do rozmów,rozrywki i czatu z kapitanem">
</head>

<body>
    <?php include "trescstrony/menu.php" ?>
    <div id="lewa_burta"></div>
    <main>
        <div id="glowna_tresc">
            <?php include "trescstrony//formularz_dodaj_posta.php"; ?>
            <div id="przeglodaj">

            </div>
            <div class="wszyatkonadzis">To już wszystko na dziś</div>
        </div>

    </main>
    <div id="prawa_burta"></div>
    <div style="display:none" id="dokladneinformacje"></div>
    <script src="/js/glowne.js"></script>
</body>
<?php
}
catch (Exception $blod) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    exit();
  } catch (PDOException $blod) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    exit();
  }
  ?>