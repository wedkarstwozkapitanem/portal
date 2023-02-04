<?php
try {
    include("php/polocz.php");
    $sesja = mysqli_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
    $id_posta = mysqli_escape_string($baza,htmlspecialchars($_POST['tresc']));


    $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND `id_posta` = '$id_posta'";
    $sprawdzanie = mysqli_query($baza, $sprawdz);

    if (mysqli_num_rows($sprawdzanie) === 0) {
        $zapytanie = "INSERT INTO `polubienia` (`id_uzytkownika`,`id_posta`) VALUES ($sesja,$id_posta)";
    } else {
        $zapytanie = "DELETE FROM `polubienia` where `id_uzytkownika` = '$sesja' AND `id_posta` = '$id_posta'";
    }

    mysqli_query($baza, $zapytanie);
    mysqli_free_result($sprawdzanie);
    mysqli_close($baza);
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