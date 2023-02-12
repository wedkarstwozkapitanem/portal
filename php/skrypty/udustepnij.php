
<?php

include("php/polocz.php");
  global $baza;



    if (!empty($_POST['tresc'])) {
    (int)$sesja = mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
    (int)$id_posta = mysqli_real_escape_string($baza,htmlspecialchars($_POST['tresc']));


    $zapytanie = "INSERT INTO `posty` (iduzytkownika, udustepniono) VALUES ('$sesja','$id_posta')";

            if(mysqli_query($baza, $zapytanie)) {
       /*       $id_tresci = (int) $id_posta;
              $typ = (int)6;
              $odbiorca = mysqli_fetch_assoc(mysqli_query($baza,"SELECT iduzytkownika FROM `posty` where `idp` = '$id_posta'"));
              $id_odbiorcy = (int)$odbiorca['iduzytkownika'];
              $id_znajomego = $id_odbiorcy;
              include 'php/powiadomienia/dodajpowiadomienie.php';*/
            }
    }

    

    ?>