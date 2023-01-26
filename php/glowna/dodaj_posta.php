<?php
try {
    include("php/polocz.php");
    $sesja = mysqli_real_escape_string($baza,htmlentities($_SESSION['uzytkwonik_pixi_id']));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['tresc_artykulu']) || !empty($_POST['fota_artykulu'])) {
            $tresc =  mysqli_real_escape_string($baza,htmlentities($_POST['tresc_artykulu']));
            $fota = mysqli_real_escape_string($baza, htmlentities($_POST['fota_artykulu']));

            $wyslij = mysqli_query($baza, "INSERT INTO `posty` (`iduzytkownika`,`tresc`,`foty`) VALUES ('$sesja','$tresc','$fota')");
            if (mysqli_error($baza) || mysqli_errno($baza)) {
                echo 'Błąd';
            } else {
                echo 'Dodano';
            }
            mysqli_close($baza); //zamknij połoczenie
        }
    }

    header('Location:/');

    exit();
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
