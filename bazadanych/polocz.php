<?php

try {
  $baza = mysqli_connect('localhost', 'root', '', 'serwis_kapitana');
//  $baza = mysqli_connect('pma.ct8.pl', 'm32573_kapitan', 'Dominik.2006', 'm32573_wedkarstwozkapitanem');

  if (mysqli_error($baza) || mysqli_errno($baza)) {
    $plik = fopen('bledy.txt', 'w');
    $zawartosc = mysqli_error($baza);
    fwrite($plik, $zawartosc);
    fclose($plik);
    //    echo '<script>alert("Błąd")</script>';
  } else {
    //  echo '<script>alert("prawidłowe połączenie")</script>';
  }
} catch (Exception $blod) {
  if (!file_exists('bledy.txt')) {
    fopen('bledy/bledy.txt','a');
  }
  $plik = fopen('bledy/bledy.txt','a');
  fwrite($plik, 'Błąd ' . $blod);
} catch (PDOException $blod) {
  if (!file_exists('bledy.txt')) {
    fopen('bledy/bledy.txt','a');
  }
  $plik = fopen('bledy/bledy.txt','a');
  fwrite($plik, 'Błąd ' . $blod);
}

?>