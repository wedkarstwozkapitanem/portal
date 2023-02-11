<?php
try {
  include("php/polocz.php");
  global $baza;

  (int)$sesja = (int)mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['tresc_artykulu']) || !empty($_FILES['fota_artykulu'])) {
      (string)$tresc =  mysqli_real_escape_string($baza, htmlspecialchars($_POST['tresc_artykulu']));
      (string)$fota_nazwa = "";
      //upload zdjec

      if (!empty($_FILES['fota_artykulu']) && isset($_FILES['fota_artykulu']) && $_FILES['fota_artykulu']['tmp_name'][0] !== "") {
        (string)$mojfolder = mysqli_fetch_array(mysqli_query($baza, "SELECT `folder` FROM `uzytkownicy` where `id`='$sesja'"))[0];

        $zdjecie = $_FILES['fota_artykulu']['tmp_name'];
        for ((int) $i = 0; $i < count($zdjecie); $i++) {
          (string) $fota_nazwap = uniqid() . '' . mysqli_real_escape_string($baza, htmlspecialchars(basename($_FILES['fota_artykulu']['name'][$i])));
          move_uploaded_file($_FILES['fota_artykulu']['tmp_name'][$i], "foty/" . $mojfolder . "/posty/" . $fota_nazwap);


          if (mysqli_query($baza, "INSERT INTO `posty` (`iduzytkownika`,`tresc`,`foty`) VALUES ('$sesja','$tresc','$fota_nazwap')")) {
            if (!mysqli_error($baza) || !mysqli_errno($baza)) {

              $id_tresci = (int) mysqli_insert_id($baza);
              $typ = (int)1;
  
  
              $sqlczyznaj = "SELECT * FROM `znajomi` where `iduzytkownika` = '$sesja' OR `iduzytkownik` = '$sesja'";
              $czyznaj = mysqli_query($baza, $sqlczyznaj);
              if (mysqli_num_rows($czyznaj) > 0) {
                while ($czyznajomy = $czyznaj->fetch_assoc()) {
                  if ($czyznajomy['czyprzyjeto'] == 1) {
                    $czyznajomy['iduzytkownika'] == $sesja ?  $id_znajomego = $czyznajomy['iduzytkownik']: $id_znajomego = $czyznajomy['iduzytkownika'];
                    include 'php/powiadomienia/dodajpowiadomienie.php';
                  }
                }
              }
              $id_znajomego = (int)$sesja;
              include 'php/powiadomienia/dodajpowiadomienie.php';
              echo 'Dodano';
            } else {
              echo 'Błąd';
            }
          }
        }
      } else {
        if (mysqli_query($baza, "INSERT INTO `posty` (`iduzytkownika`,`tresc`,`foty`) VALUES ('$sesja','$tresc','$fota_nazwa')")) {
          if (!mysqli_error($baza) || !mysqli_errno($baza)) {
            $id_tresci = (int) mysqli_insert_id($baza);
            $typ = (int)1;


            $sqlczyznaj = "SELECT * FROM `znajomi` where `iduzytkownika` = '$sesja' OR `iduzytkownik` = '$sesja'";
            $czyznaj = mysqli_query($baza, $sqlczyznaj);
            if (mysqli_num_rows($czyznaj) > 0) {
              while ($czyznajomy = $czyznaj->fetch_assoc()) {
                if ($czyznajomy['czyprzyjeto'] == 1) {
                  $czyznajomy['iduzytkownika'] == $sesja ?  $id_znajomego = $czyznajomy['iduzytkownik']: $id_znajomego = $czyznajomy['iduzytkownika'];
                  include 'php/powiadomienia/dodajpowiadomienie.php';
                }
              }
            }

            $id_znajomego = (int)$sesja;
            include 'php/powiadomienia/dodajpowiadomienie.php';




            echo 'Dodano';
          } else {
            echo 'Błąd';
          }
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
