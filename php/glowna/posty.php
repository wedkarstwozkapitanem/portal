<?php

try {
    include("php/polocz.php");
    $sesja = (int) mysqli_real_escape_string($baza,htmlentities($_SESSION['uzytkwonik_pixi_id']));
    $dane_posta = [];

    $zapytanie_post = "SELECT * FROM `posty` order by `id` desc";
    $dane_posta[] = mysqli_fetch_assoc(mysqli_query($baza, $zapytanie_post));
    
    (int)$id_uzytkownika = (int) mysqli_real_escape_string($baza,htmlentities($dane_posta[0]["iduzytkownika"]));
    (int)$id_posta = (int) mysqli_real_escape_string($baza, htmlentities($dane_posta[0]["id"]));
    

    $dane_posta[0] += mysqli_fetch_assoc(mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe` FROM `uzytkownicy` where `id` = '$id_uzytkownika'"));
    

    $dane_posta[0]['licznikpolubien'] = mysqli_num_rows(mysqli_query($baza, "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_posta` = '$id_posta'"));
    $dane_posta[0]['licznikomentarzy'] = mysqli_num_rows(mysqli_query($baza, "SELECT * FROM `komentarze` where `idposta` = '$id_posta'"));
    $dane_posta[0]['polubiono'] = mysqli_num_rows(mysqli_query($baza, "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND id_posta = '$id_posta'")) === 0 ? false : true;




    $dane_post = json_encode($dane_posta);



    //testy
    echo $dane_post;
    $plik=fopen("baza_danych.json", "w+");
    fwrite($plik, $dane_post);
   /* */




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