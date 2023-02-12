<?php
try {
  include("php/polocz.php");
  global $baza;

    (int)$sesja = mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));

    if (!empty($_POST['id'])) {
        (int)$id_posta = mysqli_real_escape_string($baza,htmlspecialchars($_POST['id']));
        if (!empty($_POST['tresc']) || !empty($_POST['fota'])) {
            (string)$komentarz_tresc = mysqli_real_escape_string($baza,htmlspecialchars($_POST['tresc']));

            $zapytanie = "INSERT INTO `komentarze` (`iduzytkownika`,`idposta`,`tresc`) VALUES ('$sesja','$id_posta','$komentarz_tresc')";

            if(mysqli_query($baza, $zapytanie)) {
              $id_tresci = (int) $id_posta;
              $typ = (int)2;
              $odbiorca = mysqli_fetch_assoc(mysqli_query($baza,"SELECT iduzytkownika FROM `posty` where `idp` = '$id_posta'"));
              $id_odbiorcy = (int)$odbiorca['iduzytkownika'];
              $id_znajomego = $id_odbiorcy;
              include 'php/powiadomienia/dodajpowiadomienie.php';
            }
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