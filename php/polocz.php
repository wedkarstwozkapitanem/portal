<?php

try {
  if(!$baza = mysqli_connect('localhost', 'root', '', 'serwis_kapitana')) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    exit();
  }

  if (mysqli_error($baza) || mysqli_errno($baza)) {
    $plik = fopen('php/bazadanych/bledy_mysql.txt', 'a');
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