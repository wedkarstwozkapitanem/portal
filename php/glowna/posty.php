<?php

try {
    include("php/polocz.php");
    $sesja = (int) mysqli_real_escape_string($baza,htmlentities($_SESSION['uzytkwonik_pixi_id']));
    $dane_posta = [];


    $zapytanie_post = mysqli_query($baza,"SELECT * FROM `posty` order by `id` desc");
  (int) $i = (int)0;
    while($post = mysqli_fetch_assoc( $zapytanie_post)) {
    $dane_posta[] = $post;
    (int)$id_uzytkownika = (int) mysqli_real_escape_string($baza,htmlentities($dane_posta[$i]["iduzytkownika"]));
    (int)$id_posta = (int) mysqli_real_escape_string($baza, htmlentities($dane_posta[$i]["id"]));
    
    $dane_posta[$i] += mysqli_fetch_assoc(mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$id_uzytkownika'"));


    $dane_posta[$i]['licznikpolubien'] = mysqli_num_rows(mysqli_query($baza, "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_posta` = '$id_posta'"));
    $dane_posta[$i]['licznikomentarzy'] = mysqli_num_rows(mysqli_query($baza, "SELECT * FROM `komentarze` where `idposta` = '$id_posta'"));
    $dane_posta[$i]['polubiono'] = mysqli_num_rows(mysqli_query($baza, "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND id_posta = '$id_posta'")) === 0 ? false : true;

    $i++;
    }



    $dane_post = json_encode($dane_posta);
    echo $dane_post;
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