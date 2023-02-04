<?php
try {
    include("php/polocz.php");

    (int)$sesja = mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));

    if (!empty($_POST['id'])) {
        (int)$id_posta = mysqli_real_escape_string($baza,htmlspecialchars($_POST['id']));
        if (!empty($_POST['tresc']) || !empty($_POST['fota'])) {
            (string)$komentarz_tresc = mysqli_real_escape_string($baza,htmlspecialchars($_POST['tresc']));

            $zapytanie = "INSERT INTO `komentarze` (`iduzytkownika`,`idposta`,`tresc`)
 VALUES ('$sesja','$id_posta','$komentarz_tresc')";

            mysqli_query($baza, $zapytanie);
        }
    }
} catch (Exception $blod) {
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