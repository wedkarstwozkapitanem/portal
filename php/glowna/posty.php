<?php

try {
    include("php/polocz.php");
  global $baza;

    $sesja = (int) mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
    $dane_posta = [];


  $jakieposty = mysqli_query($baza,"SELECT * FROM `powiadomienia` where `powiadomienia`.`id_odbiorcy` = '$sesja' AND `powiadomienia`.`typ` = 1 order by `id` DESC");

  while($ktoreposty = mysqli_fetch_assoc($jakieposty)) {
    $id = mysqli_real_escape_string($baza,htmlspecialchars($ktoreposty['id_tresci']));
    if($zapytanie_post = mysqli_query($baza,"SELECT `posty`.`idp`,`posty`.`iduzytkownika`,`posty`.`tresc`,`posty`.`foty`,`posty`.`datadodania`,`posty`.`publiczny`,`uzytkownicy`.`id`,`uzytkownicy`.`imie`,`uzytkownicy`.`nazwisko`,`uzytkownicy`.`profilowe`,`uzytkownicy`.`folder` FROM `posty` LEFT JOIN `uzytkownicy` ON `posty`.`iduzytkownika` = `uzytkownicy`.`id` where `posty`.`idp` = '$id' AND `posty`.`usunieto` = 0 order by `posty`.`idp` desc")) {
    (int) $i = (int)0;
    while($post = mysqli_fetch_assoc( $zapytanie_post)) {
    $dane_posta[] = $post;
    (int)$id_uzytkownika = (int) mysqli_real_escape_string($baza,htmlspecialchars($dane_posta[$i]["iduzytkownika"]));
    (int)$id_posta = (int) mysqli_real_escape_string($baza, htmlspecialchars($dane_posta[$i]["idp"]));

    
   // $dane_posta[$i] += mysqli_fetch_assoc(mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$id_uzytkownika'"));


    $dane_posta[$i]['licznikpolubien'] = mysqli_num_rows(mysqli_query($baza, "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_posta` = '$id_posta'")) or 0;
    $dane_posta[$i]['licznikomentarzy'] = mysqli_num_rows(mysqli_query($baza, "SELECT * FROM `komentarze` where `idposta` = '$id_posta'")) or 0;
    $dane_posta[$i]['polubiono'] = mysqli_num_rows(mysqli_query($baza, "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND id_posta = '$id_posta'")) === 0 ? false : true or false;
    $dane_posta[$i]['czymoj'] = mysqli_num_rows(mysqli_query($baza,"SELECT * FROM `posty` WHERE `iduzytkownika` = '$sesja' AND `idp`='$id_posta' AND `usunieto` = 0")) === 0 ? false : true or false;
    $i++;
    } 
  } else {
      throw new Exception("Nie udało się uzyskać posta z bazy");
    }
  }


    if($dane_post = json_encode($dane_posta)) {
    echo $dane_post;
    } else {
      throw new Exception("Błąd podczas wczytywania postów");
    }
    if(!mysqli_close($baza)) {
      throw new Exception("Nie można zakończyć połączenia mysql");
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