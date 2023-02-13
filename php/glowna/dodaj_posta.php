<?php
try {
  if (!include("php/polocz.php")) {
    throw new Exception("Brak danych połączenia bazy");
  }
  global $baza;

  if (!(int)$sesja = (int)mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']))) {
    throw new Exception("Brak sesji");
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['tresc_artykulu']) || !empty($_FILES['fota_artykulu'])) {
      (string)$tresc =  mysqli_real_escape_string($baza, htmlspecialchars($_POST['tresc_artykulu']));
      (string)$fota_nazwa = "";
      //upload zdjec

      if (!empty($_FILES['fota_artykulu']) && isset($_FILES['fota_artykulu']) && $_FILES['fota_artykulu']['tmp_name'][0] !== "") {
        (string)$mojfolder = mysqli_fetch_array(mysqli_query($baza, "SELECT `folder` FROM `uzytkownicy` where `id`='$sesja'"))[0];

        $zdjecie = $_FILES['fota_artykulu']['tmp_name'];
        for ((int) $i = 0; $i < (int)count($zdjecie); $i++) {
          if (is_uploaded_file($_FILES['fota_artykulu']['tmp_name'][$i])) {
            if ((int)htmlspecialchars($_FILES['fota_artykulu']['error'][$i]) === (int)0) {
              if ((string)htmlspecialchars($_FILES['fota_artykulu']['type'][$i]) === (string)'image/jpeg' || (string)htmlspecialchars($_FILES['fota_artykulu']['type'][$i]) === (string)'image/jpg' || (string)htmlspecialchars($_FILES['fota_artykulu']['type'][$i]) === (string)'image/png' || (string)htmlspecialchars($_FILES['fota_artykulu']['type'][$i]) === (string)'image/gif') {
                if ((int)htmlspecialchars($_FILES['fota_artykulu']['size'][$i]) <= (int)5000000) {

                  (string) $fota_nazwap = mysqli_real_escape_string($baza, htmlspecialchars(uniqid() . '' . htmlspecialchars(basename($_FILES['fota_artykulu']['name'][$i]))));
                  move_uploaded_file(htmlspecialchars($_FILES['fota_artykulu']['tmp_name'][$i]), "foty/" . $mojfolder . "/posty/" . $fota_nazwap);


                  if (mysqli_query($baza, "INSERT INTO `posty` (`iduzytkownika`,`tresc`,`foty`) VALUES ('$sesja','$tresc','$fota_nazwap')")) {
                    if (!mysqli_error($baza) && !mysqli_errno($baza)) {

                      $id_tresci = (int) mysqli_insert_id($baza);
                      $typ = (int)1;


                      $sqlczyznaj = "SELECT * FROM `znajomi` where `iduzytkownika` = '$sesja' OR `iduzytkownik` = '$sesja'";
                      $czyznaj = mysqli_query($baza, $sqlczyznaj);
                      if (mysqli_num_rows($czyznaj) > 0) {
                        while ($czyznajomy = $czyznaj->fetch_assoc()) {
                          if ($czyznajomy['czyprzyjeto'] == 1) {
                            $czyznajomy['iduzytkownika'] == $sesja ?  $id_znajomego = $czyznajomy['iduzytkownik'] : $id_znajomego = $czyznajomy['iduzytkownika'];
                            if (!include 'php/powiadomienia/dodajpowiadomienie.php') throw new Exception("Nie udało się wysłać");
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
                } else {
                  echo "Załoczony plik jest za duży";
                }
              } else {
                echo "Nie prawidłowy plik";
              }
            } else {
              echo "Błąd podczas przesyłania pliku";
            }
          } else {
            throw new Exception("Nie można przesłać pliku");
          }
        }
      } else {
        if (mysqli_query($baza, "INSERT INTO `posty` (`iduzytkownika`,`tresc`,`foty`) VALUES ('$sesja','$tresc','$fota_nazwa')")) {
          if (!mysqli_error($baza) && !mysqli_errno($baza)) {
            $id_tresci = (int) mysqli_insert_id($baza);
            $typ = (int)1;


            $sqlczyznaj = "SELECT * FROM `znajomi` where `iduzytkownika` = '$sesja' OR `iduzytkownik` = '$sesja'";
            $czyznaj = mysqli_query($baza, $sqlczyznaj);
            if (mysqli_num_rows($czyznaj) > 0) {
              while ($czyznajomy = $czyznaj->fetch_assoc()) {
                if ($czyznajomy['czyprzyjeto'] == 1) {
                  $czyznajomy['iduzytkownika'] == $sesja ?  $id_znajomego = $czyznajomy['iduzytkownik'] : $id_znajomego = $czyznajomy['iduzytkownika'];
                  if (!include 'php/powiadomienia/dodajpowiadomienie.php') {
                    throw new Exception("Nie udało się wysłać powiadomień");
                  }
                }
              }
            }

            $id_znajomego = (int)$sesja;
            if (!include 'php/powiadomienia/dodajpowiadomienie.php') {
              throw new Exception("Nie udało wysłać powiadomień");
            }

            echo 'Dodano';
          } else {
            echo 'Błąd';
            throw new Exception("Wystąpił błąd podczas dodawania");
          }
        } else {
          throw new Exception("Nie udało się dodać posta do bazy");
        }
      }



      if (!mysqli_close($baza)) {
        throw new Exception("Nie udało się zamknąć połączenia");
      } //zamknij połoczenie
    }
  } else {
    throw new Exception("Nie prawidłowe żądanie");
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
