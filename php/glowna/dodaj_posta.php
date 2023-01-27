<?php
try {
  include("php/polocz.php");



  (int)$sesja = (int)mysqli_real_escape_string($baza, htmlentities($_SESSION['uzytkwonik_pixi_id']));
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['tresc_artykulu']) || !empty($_FILES['fota_artykulu'])) {
      $tresc =  mysqli_real_escape_string($baza, htmlentities($_POST['tresc_artykulu']));

      //upload zdjec
        if (!empty($_FILES['fota_artykulu']) && isset($_FILES['fota_artykulu'])) {
        $mojfolder = mysqli_fetch_array(mysqli_query($baza,"SELECT `folder` FROM `uzytkownicy` where `id`='$sesja'"))[0];


        foreach ($_FILES['fota_artykulu'] as $f) {
          print_r($f);
        }

        $fota_nazwa = mysqli_real_escape_string($baza, htmlentities($_FILES['fota_artykulu']['name']));
        move_uploaded_file($_FILES['fota_artykulu']['tmp_name'], "foty/".$mojfolder."/posty/".$fota_nazwa);
        }

      if (mysqli_query($baza, "INSERT INTO `posty` (`iduzytkownika`,`tresc`,`foty`) VALUES ('$sesja','$tresc','$fota_nazwa')")) {
        if (!mysqli_error($baza) || !mysqli_errno($baza)) {
          echo 'Dodano';
        } else {
          echo 'Błąd';
        }
      }
      mysqli_close($baza); //zamknij połoczenie
    }
  }

    header('Location:/');

  exit();
} catch (Exception $blod) {
  if (!file_exists('bledy.txt')) {
    fopen('bledy/bledy.txt', 'a');
  }
  $plik = fopen('bledy/bledy.txt', 'a');
  fwrite($plik, 'Błąd ' . $blod);
  fclose($plik);
  exit();
} catch (PDOException $blod) {
  if (!file_exists('bledy.txt')) {
    fopen('bledy/bledy.txt', 'a');
  }
  $plik = fopen('bledy/bledy.txt', 'a');
  fwrite($plik, 'Błąd ' . $blod);
  fclose($plik);
  exit();
}
